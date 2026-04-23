@php
    // Theme settings come from ThemeSettingsComposer on the "website" scope.
    $tsFontFamily = isset($themeSettings) ? ($themeSettings->font_family ?? null) : null;
    $tsHeadingFontFamily = isset($themeSettings) ? ($themeSettings->headings_font_family ?? null) : null;
    $tsGoogleFontUrl = null;
    $tsExtraFontUrls = [];

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
    $tsHeadingGoogleFontUrl = $buildGoogleFontUrl($tsHeadingFontFamily);
@endphp

<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

{{-- Always load Public Sans as the safe fallback --}}
<link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"/>

{{-- Chosen body Google Font from theme settings --}}
@if($tsGoogleFontUrl)
    <link href="{{ $tsGoogleFontUrl }}" rel="stylesheet"/>
@endif

{{-- Chosen heading Google Font from theme settings (if different) --}}
@if($tsHeadingGoogleFontUrl && $tsHeadingGoogleFontUrl !== $tsGoogleFontUrl)
    <link href="{{ $tsHeadingGoogleFontUrl }}" rel="stylesheet"/>
@endif

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

{{-- Runtime font-family overrides from ThemeSetting so the chosen font actually applies. --}}
@if($tsFontFamily || $tsHeadingFontFamily)
    <style id="codliy-font-overrides">
        :root {
            @if($tsFontFamily)
            --bs-body-font-family: {{ $tsFontFamily }}, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
            --codliy-font-family: {{ $tsFontFamily }}, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
            @endif
            @if($tsHeadingFontFamily)
            --bs-heading-font-family: {{ $tsHeadingFontFamily }}, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
            --codliy-heading-font-family: {{ $tsHeadingFontFamily }}, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
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
    </style>
@endif
