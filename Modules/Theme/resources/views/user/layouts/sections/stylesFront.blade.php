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

{{-- Runtime font-family overrides. CSS variables are ALWAYS emitted (with
     sensible defaults) so `var(--codliy-font-family)` and
     `var(--codliy-heading-font-family)` are never undefined, even when the
     admin hasn't chosen custom fonts yet. --}}
@php
    // Wrap the primary family name in quotes so multi-word names like
    // "Google Sans Flex" or "Noto Kufi Arabic" never split on the space.
    $q = fn(string $f) => (str_contains($f, ' ') && !str_starts_with($f, "'")) ? "'{$f}'" : $f;

    $ltrStack = fn(string $f) => "{$q($f)}, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif";
    // RTL stack always chains through several Arabic-capable fonts so Arabic
    // glyphs render even if the primary family fails to load.
    $rtlStack = fn(string $f) => "{$q($f)}, 'Noto Kufi Arabic', 'IBM Plex Sans Arabic', 'Cairo', 'Tajawal', 'Segoe UI', Tahoma, Arial, sans-serif";

    $bodyFont    = $tsFontFamily        ?: 'Public Sans';
    $headingFont = $tsHeadingFontFamily ?: $bodyFont;

    // When the admin hasn't saved an RTL font yet (fresh install or
    // migration hasn't run), default to Noto Kufi Arabic instead of
    // the LTR body font — an English-only font has no Arabic glyphs.
    $rtlBody     = $tsRtlFontFamily     ?: 'Noto Kufi Arabic';
    $rtlHeadings = $tsRtlHeadingFamily  ?: $rtlBody;

    $hasLtrOverride = (bool) ($tsFontFamily || $tsHeadingFontFamily);
    // Always force RTL selectors so Arabic pages reliably pick up Arabic fonts,
    // even when the admin never touched the RTL field.
    $hasRtlOverride = true;
@endphp

{{-- Always preload the default Arabic Google Font so RTL pages have a
     real Arabic glyph set — even if the admin hasn't configured the
     RTL font in Theme Settings yet. --}}
<link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@300;400;500;600;700&display=swap"
      rel="stylesheet" crossorigin>
<style id="codliy-font-overrides">
    /* LTR defaults — always emitted. */
    :root {
        --codliy-font-family:         {{ $ltrStack($bodyFont) }};
        --codliy-heading-font-family: {{ $ltrStack($headingFont) }};
        @if($tsFontFamily)
        --bs-body-font-family: {{ $ltrStack($tsFontFamily) }};
        @endif
        @if($tsHeadingFontFamily)
        --bs-heading-font-family: {{ $ltrStack($tsHeadingFontFamily) }};
        @endif
    }

    @if($hasLtrOverride)
    body, .codliy-card, .codliy-card__body, .codliy-section__sub {
        font-family: var(--codliy-font-family, var(--bs-body-font-family, system-ui, sans-serif));
    }
    h1, h2, h3, h4, h5, h6,
    .codliy-hero__title, .codliy-section__title, .codliy-card__title {
        font-family: var(--codliy-heading-font-family, var(--codliy-font-family, inherit));
    }
    @endif

    /* RTL overrides — always define the vars (falling back to LTR) so
       downstream var() refs resolve; force-apply only when admin set RTL
       fonts explicitly. */
    [dir="rtl"],
    html[lang="ar"], html[lang="he"], html[lang="fa"] {
        --codliy-font-family:         {{ $rtlStack($rtlBody) }};
        --codliy-heading-font-family: {{ $rtlStack($rtlHeadings) }};
        @if($rtlBody)
        --bs-body-font-family: {{ $rtlStack($rtlBody) }};
        @endif
        @if($rtlHeadings)
        --bs-heading-font-family: {{ $rtlStack($rtlHeadings) }};
        @endif
    }

    @if($hasLtrOverride || $hasRtlOverride)
    [dir="rtl"] body,
    [dir="rtl"] .codliy-card,
    [dir="rtl"] .codliy-card__body,
    [dir="rtl"] .codliy-section__sub,
    html[lang="ar"] body, html[lang="he"] body, html[lang="fa"] body {
        font-family: var(--codliy-font-family, system-ui, sans-serif) !important;
    }
    [dir="rtl"] h1, [dir="rtl"] h2, [dir="rtl"] h3,
    [dir="rtl"] h4, [dir="rtl"] h5, [dir="rtl"] h6,
    [dir="rtl"] .codliy-hero__title,
    [dir="rtl"] .codliy-section__title,
    [dir="rtl"] .codliy-card__title,
    html[lang="ar"] h1, html[lang="ar"] h2, html[lang="ar"] h3,
    html[lang="ar"] h4, html[lang="ar"] h5, html[lang="ar"] h6 {
        font-family: var(--codliy-heading-font-family, var(--codliy-font-family, inherit)) !important;
    }
    @endif
</style>
