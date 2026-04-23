{{--
    Alias for `_partials.macros` used by layout includes that use the
    `theme::user/_partials.macros` path (admin sidebar, top navbar, front
    navbar, footer-front, auth screens).

    Historically some templates pointed here expecting the file to exist,
    and when it didn't Laravel silently rendered nothing — which meant
    admin-uploaded logos wouldn't appear in the dashboard or front site.
    Forwarding to the canonical partial keeps a single source of truth for
    the logo/SVG fallback logic.
--}}
@include('theme::_partials.macros', [
    'height'  => $height  ?? null,
    'withbg'  => $withbg  ?? null,
])
