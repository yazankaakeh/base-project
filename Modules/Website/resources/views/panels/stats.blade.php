@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

<section class="panel-section panel-bg-gradient" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="container">
        {{-- Section Header --}}
        @if($title || $badge || $description)
            <div class="panel-header">
                @if($badge)
                    <span class="panel-badge" style="background: rgba(255,255,255,0.15); color: #fff;">{{ $badge }}</span>
                @endif
                @if($title)
                    <h2 class="panel-title panel-title-white">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="panel-description panel-description-white">{{ $description }}</p>
                @endif
            </div>
        @endif

        {{-- Stats Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($panel->activeItems as $index => $item)
                    @php
                        $label = $item->getTranslation('title', $locale);
                        $number = $item->data['number'] ?? $item->data['value'] ?? '0';
                        $suffix = $item->data['suffix'] ?? '';
                        $prefix = $item->data['prefix'] ?? '';
                        $icon = $item->data['icon'] ?? 'tabler-chart-bar';
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3 panel-animate">
                        <div class="panel-stat">
                            <div class="panel-stat-icon">
                                <i class="ti {{ $icon }}"></i>
                            </div>
                            <div class="panel-stat-number">
                                {{ $prefix }}<span class="counter" data-target="{{ $number }}">0</span>{{ $suffix }}
                            </div>
                            <p class="panel-stat-label mb-0">{{ $label }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<script>
(function() {
    'use strict';

    function initCounters() {
        var counters = document.querySelectorAll('#panel-{{ $panel->id }} .counter');
        var speed = 150;

        var animateCounter = function(counter) {
            var target = parseInt(counter.getAttribute('data-target'));
            var current = 0;
            var increment = target / speed;

            var updateCount = function() {
                if (current < target) {
                    current += increment;
                    counter.innerText = Math.ceil(current);
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        };

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    counters.forEach(function(counter) {
                        animateCounter(counter);
                    });
                    observer.disconnect();
                }
            });
        }, { threshold: 0.3 });

        var section = document.querySelector('#panel-{{ $panel->id }}');
        if (section) observer.observe(section);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCounters);
    } else {
        initCounters();
    }
})();
</script>
