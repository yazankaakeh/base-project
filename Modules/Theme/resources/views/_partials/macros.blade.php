{{--
    Brand logo macro — used by sidebar, top navbar, front navbar, footer, etc.

    Behaviour:
      - If the admin uploaded a logo in Theme Settings, render it as <img>.
        Dark-mode variant (`logo_dark`) is preferred when the page is in
        dark mode, falling back to the light logo if only one is uploaded.
      - Otherwise render the inline Codliy SVG wordmark. The SVG is sized
        via the optional $height prop so callers can tweak it per context.

    The `$themeSettings` variable is injected globally by ThemeSettingsComposer
    and is scope-aware (admin vs website), so the dashboard and the public
    site can each carry their own brand.
--}}
@php
    $logoHeight = $height ?? 40;

    // Scope-aware logo URLs (light + dark variants).
    $logoLight = isset($themeSettings) ? $themeSettings?->getLogoUrl(false) : null;
    $logoDark  = isset($themeSettings) ? $themeSettings?->getLogoUrl(true)  : null;

    $brandLabel = trim((string) ($themeSettings->site_title ?? config('variables.templateName', 'Codliy')));
@endphp

@if($logoLight || $logoDark)
    {{--
        Render light + dark images side-by-side and let CSS swap them based
        on the <html data-bs-theme> attribute. That way a single <img> tag
        works across instant theme toggles without a page reload.
    --}}
    @if($logoLight)
        <img src="{{ $logoLight }}"
             alt="{{ $brandLabel }}"
             class="brand-logo-img brand-logo-light"
             style="max-height: {{ $logoHeight }}px; width: auto;">
    @endif
    @if($logoDark)
        <img src="{{ $logoDark }}"
             alt="{{ $brandLabel }}"
             class="brand-logo-img brand-logo-dark"
             style="max-height: {{ $logoHeight }}px; width: auto;">
    @endif

    @once
        <style>
            /* Only one variant visible at a time, driven by theme mode. */
            .brand-logo-img { display: inline-block; }
            [data-bs-theme="dark"] .brand-logo-light,
            [data-layout-mode="dark_mode"] .brand-logo-light { display: none; }
            [data-bs-theme="dark"] .brand-logo-dark,
            [data-layout-mode="dark_mode"] .brand-logo-dark { display: inline-block; }
            /* When only light OR only dark is uploaded, show whichever exists. */
            .brand-logo-light:only-child,
            .brand-logo-dark:only-child { display: inline-block !important; }
            /* If both are present, light is the default, dark hides until dark mode. */
            [data-bs-theme="light"] .brand-logo-dark,
            [data-layout-mode="light_mode"] .brand-logo-dark { display: none; }
        </style>
    @endonce
@else
    {{-- Default Codliy wordmark (inline SVG so it scales cleanly and inherits color). --}}
    <svg width="{{ $logoHeight * 2.15 }}" height="{{ $logoHeight }}" viewBox="0 0 82 38" fill="none"
         xmlns="http://www.w3.org/2000/svg" role="img" aria-label="{{ $brandLabel }}">
        <path d="M17.9063 11.2461H0V15.7194H6.14667V32.015H11.6993V15.7194H17.9063V11.2461Z"
              fill="currentColor"/>
        <path d="M31.5358 17.305C30.3082 16.288 28.5761 15.7795 26.3396 15.7795C25.4684 15.7795 24.6178 15.8431 23.7862 15.9719C22.9546 16.1008 22.1282 16.2983 21.3069 16.5646C20.4856 16.8309 19.6488 17.1521 18.7983 17.5283L20.2531 21.0843C21.1244 20.6703 21.9801 20.3542 22.822 20.136C23.664 19.9196 24.4198 19.8096 25.093 19.8096C26.083 19.8096 26.8303 20.0226 27.3347 20.447C27.8392 20.8713 28.0923 21.4588 28.0923 22.2095V22.3864H23.9653C21.9663 22.407 20.4357 22.8365 19.3768 23.6748C18.3179 24.5148 17.7876 25.7036 17.7876 27.2445C17.7876 28.2134 18.0045 29.0774 18.4401 29.8367C18.8757 30.5978 19.5042 31.1904 20.3255 31.6147C21.1467 32.039 22.1316 32.252 23.28 32.252C24.666 32.252 25.8334 31.96 26.7838 31.3777C27.2986 31.0616 27.7325 30.6733 28.0906 30.2147V32.015H33.4057V21.5859C33.385 19.7495 32.7617 18.322 31.5341 17.305H31.5358ZM27.4828 27.6602C27.1763 27.9763 26.8096 28.2237 26.3843 28.4006C25.9591 28.5793 25.489 28.6669 24.9742 28.6669C24.301 28.6669 23.781 28.5037 23.416 28.1773C23.0493 27.8509 22.8668 27.4111 22.8668 26.858C22.8668 26.3048 23.0458 25.8651 23.4005 25.5988C23.7569 25.3325 24.2907 25.1985 25.0035 25.1985H28.0923V26.5917C27.9925 26.9868 27.791 27.3424 27.4828 27.6585V27.6602Z"
              fill="currentColor"/>
        <path d="M46.9766 17.8668C46.6185 17.415 46.2035 17.0285 45.73 16.7124C44.8003 16.0906 43.6708 15.7899 42.3451 15.8088C41.0193 15.8088 39.8502 16.1249 38.8413 16.7571C37.8323 17.3893 37.0403 18.2688 36.4652 19.394C35.8902 20.5192 35.6044 21.8522 35.6044 23.3931C35.6044 24.9341 35.8953 26.286 36.4807 27.4524C37.0644 28.6189 37.8771 29.5225 38.9153 30.1632C39.9553 30.8057 41.1381 31.1269 42.4639 31.1269C43.7896 31.1269 44.8795 30.816 45.7903 30.1941C46.2397 29.8866 46.6357 29.5156 46.9783 29.0775V30.7421C46.9783 31.3554 46.8302 31.8931 46.5324 32.3569C46.2345 32.8207 45.8041 33.1763 45.241 33.4237C44.6763 33.6711 43.9997 33.7948 43.2077 33.7948C42.3364 33.7948 41.4704 33.6556 40.6095 33.3808C39.7486 33.1042 38.9618 32.7297 38.249 32.2556L36.3774 35.8991C37.2882 36.4918 38.3626 36.9848 39.5989 37.3799C40.8351 37.775 42.1763 37.9726 43.6226 37.9726C45.365 37.9726 46.8888 37.672 48.1956 37.069C49.5024 36.466 50.5217 35.6122 51.2534 34.5059C51.9852 33.3997 52.3519 32.0958 52.3519 30.5944V15.9875H46.9766V17.8685V17.8668ZM46.5754 25.4821C46.3085 26.0455 45.9366 26.4801 45.4614 26.7859C44.9862 27.0917 44.4422 27.2446 43.8275 27.2446C43.2128 27.2446 42.6395 27.0917 42.1643 26.7859C41.6891 26.4801 41.3172 26.0455 41.0503 25.4821C40.7834 24.9186 40.6491 24.2727 40.6491 23.5409C40.6491 22.8091 40.7834 22.134 41.0503 21.5705C41.3172 21.0071 41.6891 20.5741 42.1643 20.2667C42.6395 19.9609 43.1939 19.808 43.8275 19.808C44.4611 19.808 44.9862 19.9609 45.4614 20.2667C45.9366 20.5724 46.3068 21.0071 46.5754 21.5705C46.844 22.134 46.9766 22.7902 46.9766 23.5409C46.9766 24.2916 46.8423 24.9186 46.5754 25.4821Z"
              fill="currentColor"/>
        <path d="M61.5288 15.9875H56.1534V32.0151H61.5288V15.9875Z" fill="currentColor"/>
        <path d="M75.8109 15.9875L72.4844 26.3874L68.6828 15.9875H63.1301L69.7813 31.6303L69.4249 32.3415C69.2269 32.7555 68.9686 33.063 68.6535 33.2606C68.3367 33.4581 67.9597 33.556 67.5258 33.556C66.813 33.556 66.1002 33.2692 65.3873 32.6971L63.1301 36.3407C63.8825 36.9127 64.6453 37.3336 65.4166 37.5999C66.188 37.8661 67.0402 38.0001 67.97 38.0001C69.4937 38.0001 70.7816 37.6342 71.8302 36.9041C72.8787 36.1741 73.7103 35.0678 74.325 33.5853L81.1845 15.9875H75.8092H75.8109Z"
              fill="currentColor"/>
        <path d="M58.8548 7.89294C59.6657 7.89294 60.3389 8.15921 60.8744 8.69347C61.4081 9.226 61.6767 9.90799 61.6767 10.7377C61.6767 11.5674 61.4099 12.2185 60.8744 12.7528C60.3407 13.2853 59.6675 13.5533 58.8548 13.5533C58.0421 13.5533 57.3396 13.287 56.8059 12.7528C56.2721 12.2202 56.0035 11.5485 56.0035 10.7377C56.0035 9.92688 56.2704 9.226 56.8059 8.69347C57.3396 8.16093 58.0232 7.89294 58.8548 7.89294Z"
              fill="var(--codliy-primary, #FF6248)"/>
    </svg>
@endif
