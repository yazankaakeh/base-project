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

<section class="panel-section panel-gradient-primary position-relative" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    {{-- Background Pattern --}}
    <div class="panel-pattern"></div>
    <div class="panel-shape panel-shape-1" style="background: rgba(255,255,255,0.05);"></div>
    <div class="panel-shape panel-shape-2" style="background: rgba(255,255,255,0.08);"></div>

    <div class="container position-relative">
        {{-- Section Header --}}
        @if($title || $badge || $description)
            <div class="panel-header text-white">
                @if($badge)
                    <span class="panel-badge bg-white" style="color: var(--panel-primary) !important;">{{ $badge }}</span>
                @endif
                @if($title)
                    <h2 class="panel-title text-white">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="panel-description" style="color: rgba(255,255,255,0.8);">{{ $description }}</p>
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
                    <div class="col-6 col-md-4 col-lg-3 panel-animate" style="animation-delay: {{ $index * 0.15 }}s;">
                        <div class="panel-stat">
                            <div class="panel-stat-icon">
                                <i class="ti {{ $icon }}"></i>
                            </div>
                            <div class="panel-stat-number">
                                {{ $prefix }}<span class="counter" data-target="{{ $number }}">{{ $number }}</span>{{ $suffix }}
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
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('#panel-{{ $panel->id }} .counter');
    const speed = 200;

    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-target'));
        let current = 0;
        const increment = target / speed;

        const updateCount = () => {
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

    // Intersection Observer for animation on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                counters.forEach(counter => animateCounter(counter));
                observer.disconnect();
            }
        });
    }, { threshold: 0.3 });

    const section = document.querySelector('#panel-{{ $panel->id }}');
    if (section) observer.observe(section);
});
</script>
