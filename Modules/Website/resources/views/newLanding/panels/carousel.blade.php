@php
    /**
     * Modern Carousel Panel Component (Array-based data)
     *
     * @var array $panel - Panel data array from controller
     * @var Collection $items - Collection of item arrays
     */

    use Illuminate\Support\Collection;$settings = $panel['settings'] ?? [];
    $carouselStyle = $settings['carousel_style'] ?? 'default';
    $slidesPerView = $settings['slides_per_view'] ?? 1;
    $autoplay = $settings['autoplay'] ?? true;
    $autoplayDelay = $settings['autoplay_delay'] ?? 5000;
    $loop = $settings['loop'] ?? true;
    $effect = $settings['effect'] ?? 'slide';
    $showNavigation = $settings['show_navigation'] ?? true;
    $showPagination = $settings['show_pagination'] ?? true;
    $spaceBetween = $settings['space_between'] ?? 30;
    $height = $settings['height'] ?? 'medium';

    $heightClass = match($height) {
        'small' => 'carousel-height-sm',
        'medium' => 'carousel-height-md',
        'large' => 'carousel-height-lg',
        'fullscreen' => 'carousel-height-full',
        default => 'carousel-height-auto',
    };

    $carouselId = 'carousel-' . ($panel['id'] ?? uniqid());
    $locale = app()->getLocale();
    $fallbackLocale = config('app.fallback_locale', 'en');

    $panelTitle = $panel['title'][$locale] ?? $panel['title'][$fallbackLocale] ?? null;
    $badge = $settings['badge'][$locale] ?? $settings['badge'][$fallbackLocale] ?? null;
    $description = $settings['description'][$locale] ?? $settings['description'][$fallbackLocale] ?? null;
@endphp

<section id="{{ $carouselId }}"
         class="section-py carousel-panel carousel-style-{{ $carouselStyle }} {{ $heightClass }}">
    <div class="{{ $carouselStyle === 'fullwidth' ? 'container-fluid px-0' : 'container' }}">
        {{-- Section Header --}}
        @if($panelTitle || $badge || $description)
            <div class="text-center mb-4 pb-2">
                @if($badge)
                    <span class="badge bg-label-primary rounded-pill px-3 py-2 mb-3">{{ $badge }}</span>
                @endif
                @if($panelTitle)
                    <h2 class="h1 mb-3">
                        <span class="position-relative fw-bold z-1">
                            {{ $panelTitle }}
                            <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                                 alt="decoration"
                                 class="section-title-img position-absolute object-fit-contain bottom-0 z-n1"/>
                        </span>
                    </h2>
                @endif
                @if($description)
                    <p class="text-muted lead mx-auto" style="max-width: 600px;">{{ $description }}</p>
                @endif
            </div>
        @endif

        {{-- Modern Carousel --}}
        <div class="carousel-wrapper position-relative">
            <div class="swiper modern-carousel {{ $heightClass }}" id="{{ $carouselId }}-swiper"
                 data-slides-per-view="{{ $slidesPerView }}"
                 data-autoplay="{{ $autoplay ? 'true' : 'false' }}"
                 data-autoplay-delay="{{ $autoplayDelay }}"
                 data-loop="{{ ($loop && $items->count() > 1) ? 'true' : 'false' }}"
                 data-effect="{{ $effect }}"
                 data-space-between="{{ $spaceBetween }}"
                 data-total-slides="{{ $items->count() }}">
                <div class="swiper-wrapper">
                    @forelse($items as $item)
                        @php
                            $itemData = $item['data'] ?? [];
                            $overlayColor = $itemData['overlay_color'] ?? '';
                            $subtitle = $itemData['subtitle'] ?? '';
                            $buttonText = $itemData['button_text'] ?? '';
                            $buttonUrl = $itemData['button_url'] ?? '#';
                            $imageUrl = $item['media']['item_image'] ?? asset('assets/img/placeholders/carousel-placeholder.jpg');
                            $title = $item['title'][$locale] ?? $item['title'][$fallbackLocale] ?? '';
                            $content = $item['content'][$locale] ?? $item['content'][$fallbackLocale] ?? '';

                            $overlayClass = match($overlayColor) {
                                'dark' => 'overlay-dark',
                                'light' => 'overlay-light',
                                'primary' => 'overlay-primary',
                                'gradient' => 'overlay-gradient',
                                default => '',
                            };
                        @endphp
                        <div class="swiper-slide">
                            <div class="carousel-slide-content {{ $overlayClass }}"
                                 @if($carouselStyle === 'fullwidth' || $carouselStyle === 'modern')
                                     style="background-image: url('{{ $imageUrl }}');"
                                @endif
                            >
                                {{-- For card style --}}
                                @if($carouselStyle === 'cards')
                                    <div class="card carousel-card h-100 border-0 shadow-lg overflow-hidden">
                                        <div class="carousel-card-img-wrapper">
                                            <img src="{{ $imageUrl }}"
                                                 alt="{{ $title }}"
                                                 class="carousel-card-img">
                                            @if($overlayColor)
                                                <div class="carousel-card-overlay {{ $overlayClass }}"></div>
                                            @endif
                                        </div>
                                        <div class="card-body p-4">
                                            @if($subtitle)
                                                <span class="badge bg-label-primary mb-2">{{ $subtitle }}</span>
                                            @endif
                                            @if($title)
                                                <h4 class="card-title mb-2">{{ $title }}</h4>
                                            @endif
                                            @if($content)
                                                <p class="card-text text-muted mb-3">{{ Str::limit($content, 120) }}</p>
                                            @endif
                                            @if($buttonText)
                                                <a href="{{ $buttonUrl }}" class="btn btn-primary btn-sm">
                                                    {{ $buttonText }}
                                                    <i class="ti tabler-arrow-right ms-1"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- For minimal style --}}
                                @elseif($carouselStyle === 'minimal')
                                    <div class="carousel-minimal-slide">
                                        <div class="carousel-minimal-img-wrapper rounded-4 overflow-hidden">
                                            <img src="{{ $imageUrl }}"
                                                 alt="{{ $title }}"
                                                 class="carousel-minimal-img">
                                        </div>
                                        <div class="carousel-minimal-content mt-4 text-center">
                                            @if($title)
                                                <h4 class="mb-2">{{ $title }}</h4>
                                            @endif
                                            @if($content)
                                                <p class="text-muted">{{ Str::limit($content, 100) }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- For fullwidth/modern hero style --}}
                                @elseif($carouselStyle === 'fullwidth' || $carouselStyle === 'modern')
                                    <div
                                        class="carousel-hero-content d-flex align-items-center justify-content-center text-center text-white h-100">
                                        <div class="carousel-hero-inner px-4">
                                            @if($subtitle)
                                                <span
                                                    class="carousel-hero-badge badge bg-white bg-opacity-25 text-white px-3 py-2 mb-3 animate-fadeInUp">
                                                    {{ $subtitle }}
                                                </span>
                                            @endif
                                            @if($title)
                                                <h1 class="carousel-hero-title display-4 fw-bold mb-3 animate-fadeInUp animation-delay-1">
                                                    {{ $title }}
                                                </h1>
                                            @endif
                                            @if($content)
                                                <p class="carousel-hero-description lead mb-4 mx-auto animate-fadeInUp animation-delay-2"
                                                   style="max-width: 700px;">
                                                    {{ $content }}
                                                </p>
                                            @endif
                                            @if($buttonText)
                                                <div class="carousel-hero-cta animate-fadeInUp animation-delay-3">
                                                    <a href="{{ $buttonUrl }}"
                                                       class="btn btn-primary btn-lg px-5 shadow-lg">
                                                        {{ $buttonText }}
                                                        <i class="ti tabler-arrow-right ms-2"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Default style --}}
                                @else
                                    <div class="carousel-default-slide position-relative rounded-4 overflow-hidden">
                                        <img src="{{ $imageUrl }}"
                                             alt="{{ $title }}"
                                             class="carousel-default-img w-100 h-100 object-fit-cover">
                                        @if($overlayColor)
                                            <div class="carousel-overlay {{ $overlayClass }}"></div>
                                        @endif
                                        @if($title || $content || $buttonText)
                                            <div
                                                class="carousel-default-caption position-absolute bottom-0 start-0 end-0 p-4 text-white">
                                                @if($subtitle)
                                                    <span class="badge bg-primary mb-2">{{ $subtitle }}</span>
                                                @endif
                                                @if($title)
                                                    <h3 class="mb-2">{{ $title }}</h3>
                                                @endif
                                                @if($content)
                                                    <p class="mb-3 opacity-90">{{ Str::limit($content, 150) }}</p>
                                                @endif
                                                @if($buttonText)
                                                    <a href="{{ $buttonUrl }}" class="btn btn-light">
                                                        {{ $buttonText }}
                                                        <i class="ti tabler-arrow-right ms-1"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="carousel-empty-state text-center py-5">
                                <i class="ti tabler-photo-off display-1 text-muted opacity-50"></i>
                                <p class="text-muted mt-3">No slides available</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($showPagination)
                    <div class="swiper-pagination carousel-pagination"></div>
                @endif
            </div>

            {{-- Navigation Buttons --}}
            @if($showNavigation && $items->count() > 1)
                <div class="carousel-navigation">
                    <button type="button"
                            class="carousel-nav-btn carousel-nav-prev btn btn-icon btn-primary rounded-circle shadow-lg"
                            id="{{ $carouselId }}-prev">
                        <i class="ti tabler-chevron-left ti-md"></i>
                    </button>
                    <button type="button"
                            class="carousel-nav-btn carousel-nav-next btn btn-icon btn-primary rounded-circle shadow-lg"
                            id="{{ $carouselId }}-next">
                        <i class="ti tabler-chevron-right ti-md"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>

@push('scripts')
    <script>
        (function () {
            'use strict';

            function initCarousel_{{ str_replace('-', '_', $carouselId) }}() {
                if (typeof Swiper === 'undefined') {
                    setTimeout(initCarousel_{{ str_replace('-', '_', $carouselId) }}, 100);
                    return;
                }

                const carouselEl = document.getElementById('{{ $carouselId }}-swiper');
                if (!carouselEl) return;

                // Destroy existing instance if any
                if (carouselEl.swiper) {
                    carouselEl.swiper.destroy(true, true);
                }

                const slidesPerView = parseInt(carouselEl.dataset.slidesPerView) || 1;
                const autoplay = carouselEl.dataset.autoplay === 'true';
                const autoplayDelay = parseInt(carouselEl.dataset.autoplayDelay) || 5000;
                const loop = carouselEl.dataset.loop === 'true';
                const effect = carouselEl.dataset.effect || 'slide';
                const spaceBetween = parseInt(carouselEl.dataset.spaceBetween) || 30;
                const totalSlides = parseInt(carouselEl.dataset.totalSlides) || 0;

                // Only enable loop if there are enough slides (more than slidesPerView)
                const canLoop = loop && totalSlides > slidesPerView;

                const swiperConfig = {
                    effect: effect,
                    loop: canLoop,
                    speed: 800,
                    spaceBetween: spaceBetween,
                    grabCursor: totalSlides > 1,
                    watchSlidesProgress: true,
                    observer: true,
                    observeParents: true,

                    // Responsive breakpoints
                    slidesPerView: 1,
                    breakpoints: {
                        576: {slidesPerView: Math.min(slidesPerView, 1)},
                        768: {slidesPerView: Math.min(slidesPerView, 2)},
                        992: {slidesPerView: Math.min(slidesPerView, 3)},
                        1200: {slidesPerView: slidesPerView}
                    },

                    // Navigation
                    navigation: {
                        nextEl: '#{{ $carouselId }}-next',
                        prevEl: '#{{ $carouselId }}-prev',
                    },

                    // Pagination
                    pagination: {
                        el: '#{{ $carouselId }}-swiper .swiper-pagination',
                        clickable: true,
                        dynamicBullets: slidesPerView === 1,
                    },
                };

                // Add autoplay if enabled and more than one slide
                if (autoplay && totalSlides > 1) {
                    swiperConfig.autoplay = {
                        delay: autoplayDelay,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    };
                }

                // Effect-specific settings
                if (effect === 'fade') {
                    swiperConfig.fadeEffect = {crossFade: true};
                    swiperConfig.slidesPerView = 1;
                    delete swiperConfig.breakpoints;
                    // Fade effect requires loop to be false if only 1 slide
                    swiperConfig.loop = canLoop && totalSlides > 1;
                } else if (effect === 'cube') {
                    swiperConfig.cubeEffect = {
                        shadow: true,
                        slideShadows: true,
                        shadowOffset: 20,
                        shadowScale: 0.94,
                    };
                    swiperConfig.slidesPerView = 1;
                    delete swiperConfig.breakpoints;
                    swiperConfig.loop = canLoop && totalSlides > 1;
                } else if (effect === 'coverflow') {
                    swiperConfig.coverflowEffect = {
                        rotate: 30,
                        stretch: 0,
                        depth: 100,
                        modifier: 1,
                        slideShadows: true,
                    };
                    swiperConfig.centeredSlides = true;
                } else if (effect === 'flip') {
                    swiperConfig.flipEffect = {
                        slideShadows: true,
                        limitRotation: true,
                    };
                    swiperConfig.slidesPerView = 1;
                    delete swiperConfig.breakpoints;
                    swiperConfig.loop = canLoop && totalSlides > 1;
                } else if (effect === 'cards') {
                    swiperConfig.cardsEffect = {
                        perSlideOffset: 8,
                        perSlideRotate: 2,
                        rotate: true,
                        slideShadows: true,
                    };
                    swiperConfig.slidesPerView = 1;
                    delete swiperConfig.breakpoints;
                    swiperConfig.loop = canLoop && totalSlides > 1;
                }

                new Swiper(carouselEl, swiperConfig);
            }

            // Initialize on DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCarousel_{{ str_replace('-', '_', $carouselId) }});
            } else {
                setTimeout(initCarousel_{{ str_replace('-', '_', $carouselId) }}, 50);
            }
        })();
    </script>
@endpush

@push('page-style')
    <style>
        /* Carousel Panel Base Styles */
        .carousel-panel {
            overflow: hidden;
        }

        /* Height variations */
        .carousel-height-sm .modern-carousel,
        .carousel-height-sm .carousel-slide-content,
        .carousel-height-sm .carousel-default-slide {
            height: 300px;
        }

        .carousel-height-md .modern-carousel,
        .carousel-height-md .carousel-slide-content,
        .carousel-height-md .carousel-default-slide {
            height: 450px;
        }

        .carousel-height-lg .modern-carousel,
        .carousel-height-lg .carousel-slide-content,
        .carousel-height-lg .carousel-default-slide {
            height: 600px;
        }

        .carousel-height-full .modern-carousel,
        .carousel-height-full .carousel-slide-content,
        .carousel-height-full .carousel-default-slide {
            height: 100vh;
            min-height: 500px;
        }

        .carousel-height-auto .carousel-default-slide {
            height: auto;
            min-height: 400px;
        }

        /* Carousel wrapper */
        .carousel-wrapper {
            position: relative;
        }

        /* Navigation buttons */
        .carousel-navigation {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            z-index: 10;
            pointer-events: none;
            display: flex;
            justify-content: space-between;
            padding: 0 1rem;
        }

        .carousel-nav-btn {
            pointer-events: auto;
            width: 48px;
            height: 48px;
            transition: all 0.3s ease;
            opacity: 0.9;
        }

        .carousel-nav-btn:hover {
            transform: scale(1.1);
            opacity: 1;
        }

        .carousel-wrapper:hover .carousel-nav-prev {
            transform: translateX(0);
        }

        .carousel-wrapper:hover .carousel-nav-next {
            transform: translateX(0);
        }

        /* Pagination */
        .carousel-pagination {
            position: relative;
            margin-top: 1.5rem;
        }

        .carousel-pagination .swiper-pagination-bullet {
            width: 10px;
            height: 10px;
            background: var(--bs-primary);
            opacity: 0.3;
            transition: all 0.3s ease;
        }

        .carousel-pagination .swiper-pagination-bullet-active {
            opacity: 1;
            width: 24px;
            border-radius: 5px;
        }

        /* Fullwidth/Hero style */
        .carousel-style-fullwidth .carousel-slide-content,
        .carousel-style-modern .carousel-slide-content {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .carousel-style-fullwidth .carousel-navigation {
            padding: 0 2rem;
        }

        .carousel-style-fullwidth .carousel-nav-btn,
        .carousel-style-modern .carousel-nav-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .carousel-style-fullwidth .carousel-nav-btn:hover,
        .carousel-style-modern .carousel-nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .carousel-style-fullwidth .carousel-pagination,
        .carousel-style-modern .carousel-pagination {
            position: absolute;
            bottom: 2rem;
            margin-top: 0;
        }

        .carousel-style-fullwidth .swiper-pagination-bullet,
        .carousel-style-modern .swiper-pagination-bullet {
            background: white;
        }

        /* Hero content animations */
        .carousel-hero-content {
            position: relative;
            z-index: 2;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
        }

        .animation-delay-1 {
            animation-delay: 0.2s;
        }

        .animation-delay-2 {
            animation-delay: 0.4s;
        }

        .animation-delay-3 {
            animation-delay: 0.6s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Overlay styles */
        .overlay-dark::before,
        .carousel-card-overlay.overlay-dark,
        .carousel-overlay.overlay-dark {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0.2) 100%);
        }

        .overlay-light::before,
        .carousel-card-overlay.overlay-light,
        .carousel-overlay.overlay-light {
            background: linear-gradient(to top, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.5) 50%, rgba(255, 255, 255, 0.2) 100%);
        }

        .overlay-primary::before,
        .carousel-card-overlay.overlay-primary,
        .carousel-overlay.overlay-primary {
            background: linear-gradient(to top, rgba(var(--bs-primary-rgb), 0.8) 0%, rgba(var(--bs-primary-rgb), 0.4) 50%, rgba(var(--bs-primary-rgb), 0.1) 100%);
        }

        .overlay-gradient::before,
        .carousel-card-overlay.overlay-gradient,
        .carousel-overlay.overlay-gradient {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        }

        .carousel-style-fullwidth .carousel-slide-content::before,
        .carousel-style-modern .carousel-slide-content::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .carousel-overlay {
            position: absolute;
            inset: 0;
        }

        /* Card style */
        .carousel-style-cards .swiper-slide {
            height: auto;
        }

        .carousel-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .carousel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .carousel-card-img-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .carousel-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .carousel-card:hover .carousel-card-img {
            transform: scale(1.05);
        }

        .carousel-card-overlay {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .carousel-card:hover .carousel-card-overlay {
            opacity: 0.3;
        }

        /* Minimal style */
        .carousel-minimal-img-wrapper {
            aspect-ratio: 16/10;
            overflow: hidden;
        }

        .carousel-minimal-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .carousel-minimal-slide:hover .carousel-minimal-img {
            transform: scale(1.03);
        }

        /* Default style */
        .carousel-default-slide {
            position: relative;
            overflow: hidden;
        }

        .carousel-default-img {
            transition: transform 0.5s ease;
        }

        .carousel-default-slide:hover .carousel-default-img {
            transform: scale(1.05);
        }

        .carousel-default-caption {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
            padding-top: 100px !important;
        }

        /* Modern gradient style */
        .carousel-style-modern .carousel-slide-content {
            border-radius: 1rem;
        }

        .carousel-style-modern .carousel-hero-title {
            text-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        /* RTL Support */
        [dir="rtl"] .carousel-nav-prev {
            left: auto;
            right: 1rem;
        }

        [dir="rtl"] .carousel-nav-next {
            right: auto;
            left: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .carousel-height-lg .modern-carousel,
            .carousel-height-lg .carousel-slide-content,
            .carousel-height-lg .carousel-default-slide {
                height: 400px;
            }

            .carousel-height-full .modern-carousel,
            .carousel-height-full .carousel-slide-content,
            .carousel-height-full .carousel-default-slide {
                height: 70vh;
                min-height: 400px;
            }

            .carousel-hero-title {
                font-size: 2rem !important;
            }

            .carousel-nav-btn {
                width: 40px;
                height: 40px;
            }

            .carousel-navigation {
                padding: 0 0.5rem;
            }
        }
    </style>
@endpush
