@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);

    $settings = $panel->settings ?? [];
    $carouselStyle = $settings['carousel_style'] ?? 'default';
    $slidesPerView = $settings['slides_per_view'] ?? 1;
    $autoplay = $settings['autoplay'] ?? true;
    $autoplayDelay = $settings['autoplay_delay'] ?? 5000;
    $loop = $settings['loop'] ?? true;
    $effect = $settings['effect'] ?? 'slide';
    $showNavigation = $settings['show_navigation'] ?? true;
    $showPagination = $settings['show_pagination'] ?? true;
    $spaceBetween = $settings['space_between'] ?? 24;
    $height = $settings['height'] ?? 'medium';

    $heightClass = match($height) {
        'small' => 'carousel-sm',
        'medium' => 'carousel-md',
        'large' => 'carousel-lg',
        'fullscreen' => 'carousel-full',
        default => 'carousel-auto',
    };

    $carouselId = 'carousel-' . $panel->id;
    $title = $panel->getTranslation('title', $locale);
    $badge = $settings['badge'][$locale] ?? null;
    $description = $settings['description'][$locale] ?? null;
    $items = $panel->activeItems ?? collect();
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

<section class="panel-section {{ in_array($carouselStyle, ['hero', 'fullwidth']) ? 'p-0' : 'panel-bg-white' }}"
         id="panel-{{ $panel->id }}"
         dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

    {{-- Section Header (for non-hero styles) --}}
    @if(($title || $badge || $description) && !in_array($carouselStyle, ['hero', 'fullwidth']))
        <div class="container">
            <div class="panel-header">
                @if($badge)
                    <span class="panel-badge">{{ $badge }}</span>
                @endif
                @if($title)
                    <h2 class="panel-title">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="panel-description">{{ $description }}</p>
                @endif
            </div>
        </div>
    @endif

    <div class="{{ in_array($carouselStyle, ['hero', 'fullwidth']) ? '' : 'container' }}">
        <div class="carousel-wrapper carousel-style-{{ $carouselStyle }} {{ $heightClass }}">
            <div class="swiper" id="{{ $carouselId }}">
                <div class="swiper-wrapper">
                    @forelse($items as $index => $item)
                        @php
                            $itemData = $item->data ?? [];
                            $subtitle = $itemData['subtitle'] ?? '';
                            $buttonText = $itemData['button_text'] ?? '';
                            $buttonUrl = $itemData['button_url'] ?? '#';
                            $imageUrl = $item->getFirstMediaUrl('item_image') ?: 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&q=80';
                            $itemTitle = $item->getTranslation('title', $locale);
                            $itemContent = $item->getTranslation('content', $locale);
                        @endphp
                        <div class="swiper-slide">
                            @if(in_array($carouselStyle, ['hero', 'fullwidth']))
                                {{-- Hero/Fullwidth Style --}}
                                <div class="carousel-hero-slide">
                                    <div class="carousel-hero-bg" style="background-image: url('{{ $imageUrl }}');"></div>
                                    <div class="carousel-hero-overlay"></div>
                                    <div class="carousel-hero-content">
                                        <div class="container">
                                            @if($subtitle)
                                                <span class="carousel-hero-subtitle">{{ $subtitle }}</span>
                                            @endif
                                            @if($itemTitle)
                                                <h2 class="carousel-hero-title">{{ $itemTitle }}</h2>
                                            @endif
                                            @if($itemContent)
                                                <p class="carousel-hero-desc">{{ $itemContent }}</p>
                                            @endif
                                            @if($buttonText)
                                                <a href="{{ $buttonUrl }}" class="panel-btn panel-btn-white panel-btn-lg">
                                                    {{ $buttonText }}
                                                    <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif($carouselStyle === 'cards')
                                {{-- Cards Style --}}
                                <div class="carousel-card-slide">
                                    <div class="panel-card h-100">
                                        <div style="height: 200px; overflow: hidden;">
                                            <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}" class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                        <div class="panel-card-body">
                                            @if($subtitle)
                                                <span class="panel-badge" style="font-size: 0.7rem; padding: 4px 12px; margin-bottom: 12px;">{{ $subtitle }}</span>
                                            @endif
                                            @if($itemTitle)
                                                <h4 style="font-size: 1.125rem; font-weight: 700; color: var(--panel-text); margin-bottom: 10px;">{{ $itemTitle }}</h4>
                                            @endif
                                            @if($itemContent)
                                                <p style="color: var(--panel-text-muted); font-size: 0.9375rem; line-height: 1.6; margin-bottom: 16px;">{{ Str::limit($itemContent, 100) }}</p>
                                            @endif
                                            @if($buttonText)
                                                <a href="{{ $buttonUrl }}" style="color: var(--panel-primary); font-weight: 600; text-decoration: none; font-size: 0.9375rem;">
                                                    {{ $buttonText }} <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Default Style --}}
                                <div class="carousel-default-slide">
                                    <div class="carousel-default-image">
                                        <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}">
                                        <div class="carousel-default-overlay"></div>
                                    </div>
                                    <div class="carousel-default-content">
                                        @if($subtitle)
                                            <span class="carousel-default-badge">{{ $subtitle }}</span>
                                        @endif
                                        @if($itemTitle)
                                            <h3 class="carousel-default-title">{{ $itemTitle }}</h3>
                                        @endif
                                        @if($itemContent)
                                            <p class="carousel-default-desc">{{ Str::limit($itemContent, 120) }}</p>
                                        @endif
                                        @if($buttonText)
                                            <a href="{{ $buttonUrl }}" class="panel-btn panel-btn-white panel-btn-sm">
                                                {{ $buttonText }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="d-flex align-items-center justify-content-center h-100" style="min-height: 300px; background: var(--panel-bg-muted);">
                                <div class="text-center" style="color: var(--panel-text-light);">
                                    <i class="ti tabler-photo-off" style="font-size: 3rem; opacity: 0.5;"></i>
                                    <p class="mt-3 mb-0">{{ __('No slides available') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($showPagination)
                    <div class="swiper-pagination"></div>
                @endif
            </div>

            {{-- Navigation --}}
            @if($showNavigation && $items->count() > 1)
                <button type="button" class="carousel-nav-btn carousel-prev" id="{{ $carouselId }}-prev">
                    <i class="ti tabler-chevron-{{ $isRtl ? 'right' : 'left' }}"></i>
                </button>
                <button type="button" class="carousel-nav-btn carousel-next" id="{{ $carouselId }}-next">
                    <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>
            @endif
        </div>
    </div>
</section>

<style>
/* Carousel Wrapper */
.carousel-wrapper {
    position: relative;
}

/* Height Classes */
.carousel-sm .swiper { height: 350px; }
.carousel-md .swiper { height: 500px; }
.carousel-lg .swiper { height: 650px; }
.carousel-full .swiper { height: 100vh; min-height: 500px; }
.carousel-auto .swiper { height: auto; }

.carousel-style-cards .swiper { height: auto; padding: 16px 0 60px; }

/* Hero Style */
.carousel-hero-slide {
    position: relative;
    height: 100%;
}

.carousel-hero-bg,
.carousel-hero-overlay {
    pointer-events: none;
}

.carousel-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
}

.carousel-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(var(--panel-secondary-rgb), 0.85) 0%, rgba(var(--panel-secondary-rgb), 0.6) 100%);
}

.carousel-hero-content {
    position: relative;
    z-index: 1;
    height: 100%;
    display: flex;
    align-items: center;
    padding: 60px 0;
}

.carousel-hero-subtitle {
    display: inline-block;
    padding: 8px 20px;
    background: rgba(255,255,255,0.15);
    border-radius: 50px;
    color: #fff;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 20px;
}

.carousel-hero-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
    margin-bottom: 20px;
    max-width: 700px;
}

.carousel-hero-desc {
    font-size: 1.0625rem;
    color: rgba(255,255,255,0.8);
    line-height: 1.7;
    margin-bottom: 32px;
    max-width: 550px;
}

/* Default Style */
.carousel-default-slide {
    position: relative;
    height: 100%;
    border-radius: var(--panel-radius-lg);
    overflow: hidden;
}

.carousel-default-image {
    position: absolute;
    inset: 0;
}

.carousel-default-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.carousel-default-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
}

.carousel-default-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 32px;
    color: #fff;
}

.carousel-default-badge {
    display: inline-block;
    padding: 6px 14px;
    background: var(--panel-primary);
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.carousel-default-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 12px;
}

.carousel-default-desc {
    font-size: 0.9375rem;
    color: rgba(255,255,255,0.8);
    line-height: 1.6;
    margin-bottom: 20px;
}

/* Cards Style */
.carousel-card-slide {
    padding: 8px;
    height: 100%;
}

/* Navigation Buttons */
.carousel-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 20;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--panel-bg);
    border: 1px solid var(--panel-border);
    border-radius: 50%;
    color: var(--panel-text);
    font-size: 1.25rem;
    cursor: pointer;
    transition: var(--panel-transition);
    pointer-events: auto;
}

.carousel-nav-btn:hover {
    background: var(--panel-primary);
    border-color: var(--panel-primary);
    color: #fff;
}

.carousel-prev { left: 16px; }
.carousel-next { right: 16px; }

/* RTL Navigation Positions */
[dir="rtl"] .carousel-prev { left: auto; right: 16px; }
[dir="rtl"] .carousel-next { right: auto; left: 16px; }

.carousel-style-hero .carousel-nav-btn,
.carousel-style-fullwidth .carousel-nav-btn {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.2);
    color: #fff;
}

.carousel-style-hero .carousel-nav-btn:hover,
.carousel-style-fullwidth .carousel-nav-btn:hover {
    background: #fff;
    color: var(--panel-text);
}

/* Pagination */
.carousel-wrapper .swiper-pagination {
    position: absolute;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
}

.carousel-wrapper .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: var(--panel-border);
    opacity: 1;
    transition: var(--panel-transition);
}

.carousel-wrapper .swiper-pagination-bullet-active {
    width: 28px;
    border-radius: 5px;
    background: var(--panel-primary);
}

.carousel-style-hero .swiper-pagination-bullet,
.carousel-style-fullwidth .swiper-pagination-bullet {
    background: rgba(255,255,255,0.4);
}

.carousel-style-hero .swiper-pagination-bullet-active,
.carousel-style-fullwidth .swiper-pagination-bullet-active {
    background: #fff;
}

/* Responsive */
@media (max-width: 768px) {
    .carousel-lg .swiper { height: 500px; }
    .carousel-nav-btn { width: 40px; height: 40px; font-size: 1rem; }
    .carousel-prev { left: 8px; }
    .carousel-next { right: 8px; }
    .carousel-hero-content { padding: 40px 0; }
    .carousel-default-content { padding: 24px; }
}
</style>

<script>
(function() {
    'use strict';

    function initCarousel() {
        if (typeof Swiper === 'undefined') {
            setTimeout(initCarousel, 100);
            return;
        }

        var el = document.getElementById('{{ $carouselId }}');
        if (!el) return;

        var config = {
            slidesPerView: {{ $carouselStyle === 'cards' ? 1 : $slidesPerView }},
            spaceBetween: {{ $spaceBetween }},
            loop: {{ $loop ? 'true' : 'false' }},
            speed: 600,
            grabCursor: true,

            navigation: {
                nextEl: '#{{ $carouselId }}-next',
                prevEl: '#{{ $carouselId }}-prev'
            },

            pagination: {
                el: '#{{ $carouselId }} .swiper-pagination',
                clickable: true
            }
        };

        @if($autoplay)
        config.autoplay = {
            delay: {{ $autoplayDelay }},
            disableOnInteraction: false,
            pauseOnMouseEnter: true
        };
        @endif

        @if($effect !== 'slide')
        config.effect = '{{ $effect }}';
        @if($effect === 'fade')
        config.fadeEffect = { crossFade: true };
        @endif
        @endif

        @if($carouselStyle === 'cards')
        config.breakpoints = {
            576: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            992: { slidesPerView: 3 },
            1200: { slidesPerView: {{ min($slidesPerView, 4) }} }
        };
        @endif

        // RTL Support
        @if($isRtl)
        config.rtl = true;
        @endif

        new Swiper(el, config);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        initCarousel();
    }
})();
</script>
