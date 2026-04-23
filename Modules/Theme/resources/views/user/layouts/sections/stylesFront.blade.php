@php
    // Theme settings come from ThemeSettingsComposer on the "website" scope.
    $tsFontFamily        = isset($themeSettings) ? ($themeSettings->font_family ?? null) : null;
    $tsHeadingFontFamily = isset($themeSettings) ? ($themeSettings->headings_font_family ?? null) : null;
    $tsRtlFontFamily     = isset($themeSettings) ? ($themeSettings->rtl_font_family ?? null) : null;
    $tsRtlHeadingFamily  = isset($themeSettings) ? ($themeSettings->rtl_headings_font_family ?? null) : null;
    $tsGoogleFontUrl     = null;
    $tsExtraFontUrls     = [];

    // Optional custom CSS variables may carry extra fields we use for fonts:
    //   google_font_url  => full Google Fonts URL (css/css2)
    //   google_font_urls => array of URLs
    if (isset($themeSettings) && is_array($themeSettings->custom_css_variables ?? null)) {
        $ccv = $themeSettings->custom_css_variables;
        if (!empty($ccv['google_font_url'])) {
            $tsGoogleFontUrl = $ccv['google_font_url'];
        }
        if (!empty($ccv['google_font_urls']) && is_array($ccv['google_font_urls'])) {
            $tsExtraFontUrls = array_filter($ccv['google_font_urls']);
        }
    }

    // Build a default Google Fonts URL from the chosen font family if no explicit URL was saved.
    $buildGoogleFontUrl = function (?string $family): ?string {
        if (!$family) return null;
        // Take only the first family if a comma-list was saved ("Inter, sans-serif" -> "Inter")
        $first = trim(explode(',', $family)[0]);
        // Strip quotes
        $first = trim($first, "'\" ");
        if ($first === '') return null;
        // Spaces become +, keep standard weights so the whole weight range is available
        $qs = urlencode($first).':ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700';
        $qs = str_replace('%20', '+', $qs);
        return 'https://fonts.googleapis.com/css2?family='.$qs.'&display=swap';
    };

    if (!$tsGoogleFontUrl) {
        $tsGoogleFontUrl = $buildGoogleFontUrl($tsFontFamily);
    }
    $tsHeadingGoogleFontUrl    = $buildGoogleFontUrl($tsHeadingFontFamily);
    $tsRtlGoogleFontUrl        = $buildGoogleFontUrl($tsRtlFontFamily);
    $tsRtlHeadingGoogleFontUrl = $buildGoogleFontUrl($tsRtlHeadingFamily);

    // Deduplicate so repeating a family across LTR/RTL slots doesn't
    // fetch the same CSS twice.
    $fontLinks = array_values(array_unique(array_filter([
        $tsGoogleFontUrl,
        $tsHeadingGoogleFontUrl,
        $tsRtlGoogleFontUrl,
        $tsRtlHeadingGoogleFontUrl,
    ])));
@endphp

<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

{{-- Always load Public Sans as the safe fallback --}}
<link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"/>

{{-- All theme-driven Google Fonts (LTR + RTL, body + headings), deduped. --}}
@foreach($fontLinks as $fontUrl)
    <link href="{{ $fontUrl }}" rel="stylesheet"/>
@endforeach

{{-- Any extra Google Font URLs the admin registered --}}
@foreach($tsExtraFontUrls as $extraUrl)
    <link href="{{ $extraUrl }}" rel="stylesheet"/>
@endforeach

@vite(['resources/assets/vendor/fonts/iconify/iconify.css'], 'build/modules/theme')

@if (!empty($configData['hasCustomizer']))
    @vite(['resources/assets/vendor/libs/pickr/pickr-themes.scss'], 'build/modules/theme')
@endif

<!-- Vendor Styles -->
@yield('vendor-style')
@vite(['resources/assets/vendor/libs/node-waves/node-waves.scss'], 'build/modules/theme')

<!-- Core CSS -->
@vite(['resources/assets/vendor/scss/core.scss', 'resources/assets/css/demo.css', 'resources/assets/vendor/scss/pages/front-page.scss'], 'build/modules/theme')

<!-- Page Styles -->
@yield('page-style')

<!-- Stacked Styles (panels, carousels, etc.) -->
@stack('styles')

<!-- Codliy brand layer + custom CSS variables (must load LAST to override vendor defaults) -->
@vite(['resources/css/app.css'], 'build/modules/theme')

{{-- Runtime font-family overrides from ThemeSetting. LTR stack applies by
     default; RTL stack kicks in only when the page is rendered in a
     right-to-left locale (dir="rtl" or html[lang] set to ar/he/fa). --}}
@if($tsFontFamily || $tsHeadingFontFamily || $tsRtlFontFamily || $tsRtlHeadingFamily)
    @php
        $ltrStack = fn($f) => "{$f}, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif";
        $rtlStack = fn($f) => "{$f}, 'Segoe UI', Tahoma, Arial, sans-serif";
        // When no RTL override is set, fall back to LTR (matches previous behavior).
        $rtlBody     = $tsRtlFontFamily    ?: $tsFontFamily;
        $rtlHeadings = $tsRtlHeadingFamily ?: ($tsRtlFontFamily ?: $tsHeadingFontFamily);
    @endphp
    <style id="codliy-font-overrides">
        /* LTR (default) font stack */
        :root {
            @if($tsFontFamily)
            --bs-body-font-family: {{ $ltrStack($tsFontFamily) }};
            --codliy-font-family:  {{ $ltrStack($tsFontFamily) }};
            @endif
            @if($tsHeadingFontFamily)
            --bs-heading-font-family:    {{ $ltrStack($tsHeadingFontFamily) }};
            --codliy-heading-font-family: {{ $ltrStack($tsHeadingFontFamily) }};
            @endif
        }
        @if($tsFontFamily)
        body, .codliy-card, .codliy-card__body, .codliy-section__sub {
            font-family: var(--codliy-font-family);
        }
        @endif
        @if($tsHeadingFontFamily)
        h1, h2, h3, h4, h5, h6,
        .codliy-hero__title, .codliy-section__title, .codliy-card__title {
            font-family: var(--codliy-heading-font-family);
        }
        @endif

        /* RTL overrides — only active on Arabic / Hebrew / Persian pages. */
        @if($rtlBody)
        [dir="rtl"],
        html[lang="ar"], html[lang="he"], html[lang="fa"] {
            --bs-body-font-family: {{ $rtlStack($rtlBody) }};
            --codliy-font-family:  {{ $rtlStack($rtlBody) }};
        }
        [dir="rtl"] body,
        [dir="rtl"] .codliy-card,
        [dir="rtl"] .codliy-card__body,
        [dir="rtl"] .codliy-section__sub,
        html[lang="ar"] body, html[lang="he"] body, html[lang="fa"] body {
            font-family: var(--codliy-font-family) !important;
        }
        @endif
        @if($rtlHeadings)
        [dir="rtl"],
        html[lang="ar"], html[lang="he"], html[lang="fa"] {
            --bs-heading-font-family:    {{ $rtlStack($rtlHeadings) }};
            --codliy-heading-font-family: {{ $rtlStack($rtlHeadings) }};
        }
        [dir="rtl"] h1, [dir="rtl"] h2, [dir="rtl"] h3,
        [dir="rtl"] h4, [dir="rtl"] h5, [dir="rtl"] h6,
        [dir="rtl"] .codliy-hero__title,
        [dir="rtl"] .codliy-section__title,
        [dir="rtl"] .codliy-card__title,
        html[lang="ar"] h1, html[lang="ar"] h2, html[lang="ar"] h3,
        html[lang="ar"] h4, html[lang="ar"] h5, html[lang="ar"] h6 {
            font-family: var(--codliy-heading-font-family) !important;
        }
        @endif
    </style>
@endif
