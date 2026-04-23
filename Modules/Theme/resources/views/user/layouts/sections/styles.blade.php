@php
    // Theme settings come from ThemeSettingsComposer (admin or website scope).
    $tsFontFamily = isset($themeSettings) ? ($themeSettings->font_family ?? null) : null;
    $tsHeadingFontFamily = isset($themeSettings) ? ($themeSettings->headings_font_family ?? null) : null;
    $tsGoogleFontUrl = null;
    $tsExtraFontUrls = [];

    if (isset($themeSettings) && is_array($themeSettings->custom_css_variables ?? null)) {
        $ccv = $themeSettings->custom_css_variables;
        if (!empty($ccv['google_font_url'])) {
            $tsGoogleFontUrl = $ccv['google_font_url'];
        }
        if (!empty($ccv['google_font_urls']) && is_array($ccv['google_font_urls'])) {
            $tsExtraFontUrls = array_filter($ccv['google_font_urls']);
        }
    }

    $buildGoogleFontUrl = function (?string $family): ?string {
        if (!$family) return null;
        $first = trim(explode(',', $family)[0]);
        $first = trim($first, "'\" ");
        if ($first === '') return null;
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
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"/>

@if($tsGoogleFontUrl)
    <link href="{{ $tsGoogleFontUrl }}" rel="stylesheet"/>
@endif
@if($tsHeadingGoogleFontUrl && $tsHeadingGoogleFontUrl !== $tsGoogleFontUrl)
    <link href="{{ $tsHeadingGoogleFontUrl }}" rel="stylesheet"/>
@endif
@foreach($tsExtraFontUrls as $extraUrl)
    <link href="{{ $extraUrl }}" rel="stylesheet"/>
@endforeach

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Fonts Icons -->
@vite(['resources/assets/vendor/fonts/iconify/iconify.css'], 'build/modules/theme')

<!-- BEGIN: Vendor CSS-->
@vite(['resources/assets/vendor/libs/node-waves/node-waves.scss'], 'build/modules/theme')

@if ($configData['hasCustomizer'])
    @vite(['resources/assets/vendor/libs/pickr/pickr-themes.scss'], 'build/modules/theme')
@endif

<!-- Core CSS -->
@vite(['resources/assets/vendor/scss/core.scss',
'resources/assets/css/demo.css',
'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss'], 'build/modules/theme')

<!-- Vendor Styles -->
@vite(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss',
'resources/assets/vendor/libs/typeahead-js/typeahead.scss'], 'build/modules/theme')
@yield('vendor-style')

<!-- Page Styles -->
@yield('page-style')

<!-- app CSS -->
@vite(['resources/css/app.css'], 'build/modules/theme')
<!-- END: app CSS-->

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
        body {
            font-family: var(--codliy-font-family);
        }
        @endif
        @if($tsHeadingFontFamily)
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--codliy-heading-font-family);
        }
        @endif
    </style>
@endif
