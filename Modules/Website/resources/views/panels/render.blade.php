{{--
    Unified Panel Dispatcher
    -------------------------------------------------------------------
    Renders ANY CMS panel on ANY page (landing `/` or `/page/{slug}`)
    using a consistent Eloquent-model contract.

    Usage:
        @include('website::panels.render', ['panel' => $panel])

    `$panel` must be a `Modules\CMS\Models\Panel` Eloquent model with
    `activeItems` eager-loaded. All canonical partials live at
    `Modules/Website/resources/views/panels/{type}.blade.php` and expect
    the Eloquent model so they can call `$panel->getTranslation(...)`,
    `$panel->getFirstMediaUrl(...)`, `$panel->activeItems`, etc.

    If the partial for a given type doesn't exist, the dispatcher
    renders an HTML comment marker (silent in prod) and, in debug
    mode, a small warning card so the gap is visible.
--}}
@php
    $type = $panel->type->value ?? ($panel->type ?? 'custom');
    $candidate = 'website::panels.' . $type;
    $rendered  = view()->exists($candidate) ? $candidate : null;
@endphp

@if($rendered)
    @include($rendered, ['panel' => $panel])
@else
    <!-- [panel dispatcher] no template for panel type="{{ $type }}" -->
    @if(config('app.debug'))
        <div class="container py-4">
            <div class="alert alert-warning small mb-0">
                <i class="ti tabler-alert-triangle me-1"></i>
                <strong>Panel type <code>{{ $type }}</code> has no template.</strong>
                Create one at
                <code>Modules/Website/resources/views/panels/{{ $type }}.blade.php</code>.
            </div>
        </div>
    @endif
@endif
