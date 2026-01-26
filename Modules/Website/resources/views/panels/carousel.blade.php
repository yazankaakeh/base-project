{{--
@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);

    $settings = $panel->settings ?? [];
    $carouselStyle = $settings['carousel_style'] ?? 'hero';
    $autoplay = $settings['autoplay'] ?? true;
    $autoplayDelay = $settings['autoplay_delay'] ?? 5000;
    $loop = $settings['loop'] ?? true;
    $showNavigation = $settings['show_navigation'] ?? true;
    $showPagination = $settings['show_pagination'] ?? true;

    $carouselId = 'carousel-' . $panel->id;
    $title = $panel->getTranslation('title', $locale);
    $badge = $settings['badge'][$locale] ?? null;
    $description = $settings['description'][$locale] ?? null;
    $items = $panel->activeItems ?? collect();
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

--}}
{{-- HERO STYLE --}}{{--

@if($carouselStyle === 'hero')
<section class="carousel-hero-section" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="swiper carousel-hero-swiper" id="{{ $carouselId }}">
        <div class="swiper-wrapper">
            @forelse($items as $index => $item)
                @php
                    $itemData = $item->data ?? [];
                    $subtitle = is_array($itemData['subtitle'] ?? null)
                        ? ($itemData['subtitle'][$locale] ?? '')
                        : ($itemData['subtitle'] ?? '');
                    $buttonText = is_array($itemData['button_text'] ?? null)
                        ? ($itemData['button_text'][$locale] ?? '')
                        : ($itemData['button_text'] ?? '');
                    $buttonUrl = $itemData['button_url'] ?? '#';
                    $imageUrl = $item->getFirstMediaUrl('item_image');
                    $itemTitle = $item->getTranslation('title', $locale);
                    $itemContent = $item->getTranslation('content', $locale);
                @endphp
                <div class="swiper-slide">
                    <div class="carousel-hero-slide">
                        --}}
{{-- Background Image --}}{{--

                        @if($imageUrl)
                            <div class="carousel-hero-bg">
                                <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}">
                            </div>
                        @endif
                        <div class="carousel-hero-overlay"></div>

                        --}}
{{-- Content --}}{{--

                        <div class="carousel-hero-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-8 col-xl-7">
                                        @if($subtitle)
                                            <span class="carousel-hero-subtitle" data-swiper-parallax="-100" data-swiper-parallax-opacity="0">
                                                {{ $subtitle }}
                                            </span>
                                        @endif
                                        @if($itemTitle)
                                            <h1 class="carousel-hero-title" data-swiper-parallax="-200" data-swiper-parallax-opacity="0">
                                                {{ $itemTitle }}
                                            </h1>
                                        @endif
                                        @if($itemContent)
                                            <p class="carousel-hero-desc" data-swiper-parallax="-300" data-swiper-parallax-opacity="0">
                                                {{ $itemContent }}
                                            </p>
                                        @endif
                                        @if($buttonText)
                                            <div data-swiper-parallax="-400" data-swiper-parallax-opacity="0">
                                                <a href="{{ $buttonUrl }}" class="carousel-hero-btn">
                                                    <span>{{ $buttonText }}</span>
                                                    <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        --}}
{{-- Slide Number --}}{{--

                        <div class="carousel-hero-number">
                            <span class="current">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="separator"></span>
                            <span class="total">{{ str_pad($items->count(), 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide">
                    <div class="carousel-hero-slide carousel-hero-empty">
                        <div class="carousel-hero-overlay"></div>
                        <div class="carousel-hero-content">
                            <div class="container text-center">
                                <i class="ti tabler-photo-off" style="font-size: 4rem; opacity: 0.3;"></i>
                                <p class="mt-3" style="opacity: 0.6;">{{ __('No slides available') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        --}}
{{-- Navigation --}}{{--

        @if($showNavigation && $items->count() > 1)
            <div class="carousel-hero-nav">
                <button type="button" class="carousel-hero-nav-btn prev" id="{{ $carouselId }}-prev">
                    <i class="ti tabler-chevron-{{ $isRtl ? 'right' : 'left' }}"></i>
                </button>
                <button type="button" class="carousel-hero-nav-btn next" id="{{ $carouselId }}-next">
                    <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>
            </div>
        @endif

        --}}
{{-- Pagination --}}{{--

        @if($showPagination && $items->count() > 1)
            <div class="carousel-hero-pagination">
                <div class="swiper-pagination" id="{{ $carouselId }}-pagination"></div>
            </div>
        @endif

        --}}
{{-- Progress Bar --}}{{--

        @if($autoplay && $items->count() > 1)
            <div class="carousel-hero-progress">
                <div class="carousel-hero-progress-bar"></div>
            </div>
        @endif
    </div>
</section>

--}}
{{-- CARDS STYLE --}}{{--

@elseif($carouselStyle === 'cards')
<section class="panel-section panel-bg-subtle" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="container">
        --}}
{{-- Header --}}{{--

        @if($title || $badge || $description)
            <div class="carousel-cards-header">
                <div class="carousel-cards-header-content">
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
                @if($showNavigation && $items->count() > 3)
                    <div class="carousel-cards-nav d-none d-lg-flex">
                        <button type="button" class="carousel-cards-nav-btn" id="{{ $carouselId }}-prev">
                            <i class="ti tabler-chevron-{{ $isRtl ? 'right' : 'left' }}"></i>
                        </button>
                        <button type="button" class="carousel-cards-nav-btn" id="{{ $carouselId }}-next">
                            <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                        </button>
                    </div>
                @endif
            </div>
        @endif

        --}}
{{-- Carousel --}}{{--

        <div class="swiper carousel-cards-swiper" id="{{ $carouselId }}">
            <div class="swiper-wrapper">
                @forelse($items as $index => $item)
                    @php
                        $itemData = $item->data ?? [];
                        $subtitle = is_array($itemData['subtitle'] ?? null)
                            ? ($itemData['subtitle'][$locale] ?? '')
                            : ($itemData['subtitle'] ?? '');
                        $buttonText = is_array($itemData['button_text'] ?? null)
                            ? ($itemData['button_text'][$locale] ?? '')
                            : ($itemData['button_text'] ?? '');
                        $buttonUrl = $itemData['button_url'] ?? '#';
                        $imageUrl = $item->getFirstMediaUrl('item_image');
                        $itemTitle = $item->getTranslation('title', $locale);
                        $itemContent = $item->getTranslation('content', $locale);
                    @endphp
                    <div class="swiper-slide">
                        <article class="carousel-card">
                            @if($imageUrl)
                                <div class="carousel-card-image">
                                    <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}" loading="lazy">
                                    <div class="carousel-card-image-overlay"></div>
                                </div>
                            @endif
                            <div class="carousel-card-body">
                                @if($subtitle)
                                    <span class="carousel-card-tag">{{ $subtitle }}</span>
                                @endif
                                @if($itemTitle)
                                    <h3 class="carousel-card-title">{{ $itemTitle }}</h3>
                                @endif
                                @if($itemContent)
                                    <p class="carousel-card-text">{{ Str::limit($itemContent, 100) }}</p>
                                @endif
                                @if($buttonText)
                                    <a href="{{ $buttonUrl }}" class="carousel-card-link">
                                        {{ $buttonText }}
                                        <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                    </a>
                                @endif
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="carousel-card carousel-card-empty">
                            <div class="text-center py-5">
                                <i class="ti tabler-photo-off" style="font-size: 3rem; color: var(--panel-text-light);"></i>
                                <p class="mt-3 mb-0" style="color: var(--panel-text-muted);">{{ __('No items available') }}</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        --}}
{{-- Pagination (Mobile) --}}{{--

        @if($showPagination && $items->count() > 1)
            <div class="carousel-cards-pagination d-lg-none">
                <div class="swiper-pagination" id="{{ $carouselId }}-pagination"></div>
            </div>
        @endif
    </div>
</section>

--}}
{{-- DEFAULT/SHOWCASE STYLE --}}{{--

@else
<section class="panel-section panel-bg-white" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="container">
        --}}
{{-- Header --}}{{--

        @if($title || $badge || $description)
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
        @endif

        --}}
{{-- Carousel --}}{{--

        <div class="carousel-showcase-wrapper">
            <div class="swiper carousel-showcase-swiper" id="{{ $carouselId }}">
                <div class="swiper-wrapper">
                    @forelse($items as $index => $item)
                        @php
                            $itemData = $item->data ?? [];
                            $subtitle = is_array($itemData['subtitle'] ?? null)
                                ? ($itemData['subtitle'][$locale] ?? '')
                                : ($itemData['subtitle'] ?? '');
                            $buttonText = is_array($itemData['button_text'] ?? null)
                                ? ($itemData['button_text'][$locale] ?? '')
                                : ($itemData['button_text'] ?? '');
                            $buttonUrl = $itemData['button_url'] ?? '#';
                            $imageUrl = $item->getFirstMediaUrl('item_image');
                            $itemTitle = $item->getTranslation('title', $locale);
                            $itemContent = $item->getTranslation('content', $locale);
                        @endphp
                        <div class="swiper-slide">
                            <div class="carousel-showcase-slide">
                                <div class="carousel-showcase-image">
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}">
                                    @endif
                                    <div class="carousel-showcase-overlay"></div>
                                </div>
                                <div class="carousel-showcase-content">
                                    @if($subtitle)
                                        <span class="carousel-showcase-tag">{{ $subtitle }}</span>
                                    @endif
                                    @if($itemTitle)
                                        <h3 class="carousel-showcase-title">{{ $itemTitle }}</h3>
                                    @endif
                                    @if($itemContent)
                                        <p class="carousel-showcase-desc">{{ Str::limit($itemContent, 150) }}</p>
                                    @endif
                                    @if($buttonText)
                                        <a href="{{ $buttonUrl }}" class="carousel-showcase-btn">
                                            {{ $buttonText }}
                                            <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="carousel-showcase-slide carousel-showcase-empty">
                                <div class="text-center">
                                    <i class="ti tabler-photo-off" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="mt-3 mb-0">{{ __('No slides available') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            --}}
{{-- Navigation --}}{{--

            @if($showNavigation && $items->count() > 1)
                <button type="button" class="carousel-showcase-nav prev" id="{{ $carouselId }}-prev">
                    <i class="ti tabler-chevron-{{ $isRtl ? 'right' : 'left' }}"></i>
                </button>
                <button type="button" class="carousel-showcase-nav next" id="{{ $carouselId }}-next">
                    <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                </button>
            @endif
        </div>

        --}}
{{-- Pagination --}}{{--

        @if($showPagination && $items->count() > 1)
            <div class="carousel-showcase-pagination">
                <div class="swiper-pagination" id="{{ $carouselId }}-pagination"></div>
            </div>
        @endif
    </div>
</section>
@endif

<style>
/* ================================================
   HERO CAROUSEL STYLES
   ================================================ */
.carousel-hero-section {
    position: relative;
    background: var(--panel-secondary);
    overflow: hidden;
}

.carousel-hero-swiper {
    width: 100%;
    height: 100vh;
    min-height: 600px;
    max-height: 900px;
}

.carousel-hero-swiper .swiper-slide {
    height: 100%;
    overflow: hidden;
}

.carousel-hero-slide {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.carousel-hero-empty {
    background: linear-gradient(135deg, var(--panel-secondary) 0%, #1a1a2e 100%);
}

.carousel-hero-bg {
    position: absolute;
    inset: 0;
    z-index: 1;
}

.carousel-hero-bg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: scale(1.05);
    transition: transform 8s ease-out;
}

.swiper-slide-active .carousel-hero-bg img {
    transform: scale(1);
}

.carousel-hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 2;
    background: linear-gradient(
        to right,
        rgba(0, 0, 0, 0.8) 0%,
        rgba(0, 0, 0, 0.5) 50%,
        rgba(0, 0, 0, 0.3) 100%
    );
    pointer-events: none;
}

[dir="rtl"] .carousel-hero-overlay {
    background: linear-gradient(
        to left,
        rgba(0, 0, 0, 0.8) 0%,
        rgba(0, 0, 0, 0.5) 50%,
        rgba(0, 0, 0, 0.3) 100%
    );
}

.carousel-hero-content {
    position: relative;
    z-index: 3;
    width: 100%;
    padding: 120px 0 80px;
}

.carousel-hero-subtitle {
    display: inline-block;
    padding: 10px 24px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 50px;
    color: #fff;
    font-size: 0.875rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 24px;
}

.carousel-hero-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 24px;
    letter-spacing: -0.02em;
}

.carousel-hero-desc {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.8;
    margin-bottom: 40px;
    max-width: 500px;
}

.carousel-hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 18px 36px;
    background: #fff;
    color: var(--panel-secondary);
    font-size: 1rem;
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.carousel-hero-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    color: var(--panel-primary);
}

.carousel-hero-btn i {
    transition: transform 0.3s ease;
}

.carousel-hero-btn:hover i {
    transform: translateX({{ $isRtl ? '-4px' : '4px' }});
}

/* Hero Navigation */
.carousel-hero-nav {
    position: absolute;
    bottom: 80px;
    {{ $isRtl ? 'left' : 'right' }}: 5%;
    z-index: 10;
    display: flex;
    gap: 12px;
}

.carousel-hero-nav-btn {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    color: #fff;
    font-size: 1.25rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-hero-nav-btn:hover {
    background: #fff;
    color: var(--panel-secondary);
    transform: scale(1.1);
}

/* Hero Pagination */
.carousel-hero-pagination {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

.carousel-hero-pagination .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: rgba(255, 255, 255, 0.3);
    border: 2px solid transparent;
    opacity: 1;
    margin: 0 6px;
    transition: all 0.3s ease;
}

.carousel-hero-pagination .swiper-pagination-bullet-active {
    background: transparent;
    border-color: #fff;
    transform: scale(1.2);
}

/* Hero Progress Bar */
.carousel-hero-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: rgba(255, 255, 255, 0.1);
    z-index: 10;
}

.carousel-hero-progress-bar {
    height: 100%;
    background: var(--panel-primary);
    width: 0;
    transition: width 0.1s linear;
}

/* Hero Slide Number */
.carousel-hero-number {
    position: absolute;
    bottom: 80px;
    {{ $isRtl ? 'right' : 'left' }}: 5%;
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 12px;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.875rem;
    font-weight: 500;
}

.carousel-hero-number .current {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
}

.carousel-hero-number .separator {
    width: 40px;
    height: 1px;
    background: rgba(255, 255, 255, 0.3);
}

/* ================================================
   CARDS CAROUSEL STYLES
   ================================================ */
.carousel-cards-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 48px;
    gap: 24px;
}

.carousel-cards-header-content {
    max-width: 600px;
}

.carousel-cards-header-content .panel-badge {
    margin-bottom: 16px;
}

.carousel-cards-header-content .panel-title {
    margin-bottom: 12px;
}

.carousel-cards-nav {
    display: flex;
    gap: 12px;
    flex-shrink: 0;
}

.carousel-cards-nav-btn {
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
    transition: all 0.3s ease;
}

.carousel-cards-nav-btn:hover {
    background: var(--panel-primary);
    border-color: var(--panel-primary);
    color: #fff;
}

.carousel-cards-swiper {
    overflow: visible;
    width: 100%;
}

.carousel-cards-swiper .swiper-slide {
    height: auto;
}

.carousel-card {
    background: var(--panel-bg);
    border-radius: var(--panel-radius-xl);
    overflow: hidden;
    box-shadow: var(--panel-shadow);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.carousel-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--panel-shadow-lg);
}

.carousel-card-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.carousel-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.carousel-card:hover .carousel-card-image img {
    transform: scale(1.08);
}

.carousel-card-image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.3) 0%, transparent 50%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.carousel-card:hover .carousel-card-image-overlay {
    opacity: 1;
}

.carousel-card-body {
    padding: 28px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.carousel-card-tag {
    display: inline-block;
    padding: 6px 14px;
    background: rgba(var(--panel-primary-rgb), 0.1);
    color: var(--panel-primary);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 50px;
    margin-bottom: 16px;
    align-self: flex-start;
}

.carousel-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--panel-text);
    margin-bottom: 12px;
    line-height: 1.3;
}

.carousel-card-text {
    font-size: 0.9375rem;
    color: var(--panel-text-muted);
    line-height: 1.7;
    margin-bottom: 20px;
    flex-grow: 1;
}

.carousel-card-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--panel-primary);
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    transition: gap 0.3s ease;
    margin-top: auto;
}

.carousel-card-link:hover {
    gap: 12px;
}

.carousel-cards-pagination {
    margin-top: 32px;
    text-align: center;
}

.carousel-cards-pagination .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: var(--panel-border);
    opacity: 1;
    margin: 0 5px;
    transition: all 0.3s ease;
}

.carousel-cards-pagination .swiper-pagination-bullet-active {
    width: 32px;
    border-radius: 5px;
    background: var(--panel-primary);
}

/* ================================================
   SHOWCASE CAROUSEL STYLES
   ================================================ */
.carousel-showcase-wrapper {
    position: relative;
}

.carousel-showcase-swiper {
    width: 100%;
    border-radius: var(--panel-radius-xl);
    overflow: hidden;
}

.carousel-showcase-swiper .swiper-slide {
    height: auto;
}

.carousel-showcase-slide {
    position: relative;
    height: 500px;
    display: flex;
    align-items: flex-end;
}

.carousel-showcase-empty {
    background: var(--panel-bg-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--panel-text-light);
}

.carousel-showcase-image {
    position: absolute;
    inset: 0;
}

.carousel-showcase-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
}

.swiper-slide-active .carousel-showcase-image img {
    transform: scale(1.02);
}

.carousel-showcase-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0, 0, 0, 0.85) 0%,
        rgba(0, 0, 0, 0.4) 40%,
        rgba(0, 0, 0, 0.1) 100%
    );
}

.carousel-showcase-content {
    position: relative;
    z-index: 2;
    padding: 48px;
    width: 100%;
    max-width: 600px;
}

.carousel-showcase-tag {
    display: inline-block;
    padding: 8px 18px;
    background: var(--panel-primary);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 50px;
    margin-bottom: 20px;
}

.carousel-showcase-title {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 700;
    color: #fff;
    margin-bottom: 16px;
    line-height: 1.2;
}

.carousel-showcase-desc {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.7;
    margin-bottom: 28px;
}

.carousel-showcase-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: #fff;
    color: var(--panel-text);
    font-size: 0.9375rem;
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.carousel-showcase-btn:hover {
    background: var(--panel-primary);
    color: #fff;
    transform: translateY(-2px);
}

.carousel-showcase-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--panel-bg);
    border: none;
    border-radius: 50%;
    color: var(--panel-text);
    font-size: 1.25rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--panel-shadow);
}

.carousel-showcase-nav:hover {
    background: var(--panel-primary);
    color: #fff;
    transform: translateY(-50%) scale(1.1);
}

.carousel-showcase-nav.prev {
    {{ $isRtl ? 'right' : 'left' }}: -26px;
}

.carousel-showcase-nav.next {
    {{ $isRtl ? 'left' : 'right' }}: -26px;
}

.carousel-showcase-pagination {
    margin-top: 32px;
    text-align: center;
}

.carousel-showcase-pagination .swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: var(--panel-border);
    opacity: 1;
    margin: 0 5px;
    transition: all 0.3s ease;
}

.carousel-showcase-pagination .swiper-pagination-bullet-active {
    width: 32px;
    border-radius: 5px;
    background: var(--panel-primary);
}

/* ================================================
   RESPONSIVE
   ================================================ */
@media (max-width: 991px) {
    .carousel-hero-swiper {
        height: 80vh;
        min-height: 500px;
    }

    .carousel-hero-nav {
        bottom: 40px;
        {{ $isRtl ? 'left' : 'right' }}: 20px;
    }

    .carousel-hero-nav-btn {
        width: 48px;
        height: 48px;
    }

    .carousel-hero-number {
        display: none;
    }

    .carousel-showcase-nav {
        display: none;
    }
}

@media (max-width: 768px) {
    .carousel-hero-swiper {
        height: 100vh;
        min-height: 550px;
        max-height: none;
    }

    .carousel-hero-content {
        padding: 100px 0 60px;
    }

    .carousel-hero-subtitle {
        padding: 8px 16px;
        font-size: 0.75rem;
    }

    .carousel-hero-btn {
        padding: 14px 28px;
        font-size: 0.9375rem;
    }

    .carousel-hero-nav {
        bottom: 30px;
    }

    .carousel-hero-pagination {
        bottom: 30px;
    }

    .carousel-cards-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .carousel-showcase-slide {
        height: 400px;
    }

    .carousel-showcase-content {
        padding: 28px;
    }
}

/* ================================================
   DARK MODE
   ================================================ */
[data-bs-theme="dark"] .carousel-card {
    background: var(--panel-bg-subtle);
}

[data-bs-theme="dark"] .carousel-showcase-btn {
    background: var(--panel-bg);
    color: var(--panel-text);
}

[data-bs-theme="dark"] .carousel-showcase-btn:hover {
    background: var(--panel-primary);
    color: #fff;
}

[data-bs-theme="dark"] .carousel-showcase-nav {
    background: var(--panel-bg-subtle);
}

/* ================================================
   RTL SUPPORT
   ================================================ */
[dir="rtl"] .carousel-hero-nav {
    left: 5%;
    right: auto;
}

[dir="rtl"] .carousel-hero-number {
    right: 5%;
    left: auto;
}

[dir="rtl"] .carousel-showcase-nav.prev {
    right: -26px;
    left: auto;
}

[dir="rtl"] .carousel-showcase-nav.next {
    left: -26px;
    right: auto;
}

@media (max-width: 991px) {
    [dir="rtl"] .carousel-hero-nav {
        left: 20px;
        right: auto;
    }
}
</style>

<script>
(function() {
    'use strict';

    var carouselId = '{{ $carouselId }}';
    var panelId = '{{ $panel->id }}';
    var style = '{{ $carouselStyle }}';
    var isRtl = {{ $isRtl ? 'true' : 'false' }};
    var totalSlides = {{ $items->count() }};
    var shouldLoop = {{ $loop && $items->count() > 1 ? 'true' : 'false' }};
    var shouldAutoplay = {{ $autoplay && $items->count() > 1 ? 'true' : 'false' }};
    var autoplayDelay = {{ $autoplayDelay }};

    function initCarousel() {
        if (typeof Swiper === 'undefined') {
            setTimeout(initCarousel, 100);
            return;
        }

        var el = document.getElementById(carouselId);
        if (!el) return;

        // Destroy existing instance if any
        if (el.swiper) {
            el.swiper.destroy(true, true);
        }

        var config = {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: shouldLoop,
            speed: 800,
            grabCursor: totalSlides > 1,
            watchSlidesProgress: true,
            observer: true,
            observeParents: true,
            navigation: {
                nextEl: '#' + carouselId + '-next',
                prevEl: '#' + carouselId + '-prev'
            },
            pagination: {
                el: '#' + carouselId + '-pagination',
                clickable: true
            }
        };

        if (isRtl) {
            config.rtl = true;
        }

        if (shouldAutoplay) {
            config.autoplay = {
                delay: autoplayDelay,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            };
        }

        if (style === 'hero') {
            config.slidesPerView = 1;
            config.spaceBetween = 0;
            config.speed = 1000;

            if (shouldAutoplay) {
                config.on = {
                    init: function() {
                        updateProgress();
                    },
                    slideChange: function() {
                        updateProgress();
                    },
                    autoplayTimeLeft: function(swiper, time, progress) {
                        var progressBar = document.querySelector('#panel-' + panelId + ' .carousel-hero-progress-bar');
                        if (progressBar) {
                            progressBar.style.width = ((1 - progress) * 100) + '%';
                        }
                    }
                };
            }
        } else if (style === 'cards') {
            config.slidesPerView = 1;
            config.spaceBetween = 24;
            // Only use breakpoints if we have enough slides
            if (totalSlides > 1) {
                config.breakpoints = {
                    576: { slidesPerView: Math.min(1.2, totalSlides), spaceBetween: 20 },
                    768: { slidesPerView: Math.min(2, totalSlides), spaceBetween: 24 },
                    992: { slidesPerView: Math.min(3, totalSlides), spaceBetween: 28 },
                    1200: { slidesPerView: Math.min(3, totalSlides), spaceBetween: 32 }
                };
            }
            // Loop requires at least slidesPerView + 1 slides for cards style
            config.loop = shouldLoop && totalSlides > 3;
        } else {
            // Showcase/default style
            config.slidesPerView = 1;
            config.spaceBetween = 0;
        }

        new Swiper(el, config);
    }

    function updateProgress() {
        var progressBar = document.querySelector('#panel-' + panelId + ' .carousel-hero-progress-bar');
        if (progressBar) {
            progressBar.style.width = '0%';
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        // Small delay to ensure Swiper is loaded
        setTimeout(initCarousel, 50);
    }
})();
</script>
--}}

{{--
@php
    /**
     * Modern Carousel Panel Component (Array-based data)
     *
     * @var array $panel - Panel data array from controller
     * @var \Illuminate\Support\Collection $items - Collection of item arrays
     */

    $settings = $panel['settings'] ?? [];
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
        --}}
{{-- Section Header --}}{{--

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

        --}}
{{-- Modern Carousel --}}{{--

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
                                --}}
{{-- For card style --}}{{--

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

                                    --}}
{{-- For minimal style --}}{{--

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

                                    --}}
{{-- For fullwidth/modern hero style --}}{{--

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

                                    --}}
{{-- Default style --}}{{--

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

                --}}
{{-- Pagination --}}{{--

                @if($showPagination)
                    <div class="swiper-pagination carousel-pagination"></div>
                @endif
            </div>

            --}}
{{-- Navigation Buttons --}}{{--

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
--}}
@php
    /**
     * Modern Carousel Panel Component (Array-based data)
     *
     * @var array $panel
     * @var Collection $items
     */

    use Illuminate\Support\Collection;$settings = $panel['settings'] ?? [];
    $carouselStyle = $settings['carousel_style'] ?? 'default';
    $slidesPerView = (int) ($settings['slides_per_view'] ?? 1);
    $autoplay = (bool) ($settings['autoplay'] ?? true);
    $autoplayDelay = (int) ($settings['autoplay_delay'] ?? 5000);
    $loop = (bool) ($settings['loop'] ?? true);
    $effect = $settings['effect'] ?? 'slide';
    $showNavigation = (bool) ($settings['show_navigation'] ?? true);
    $showPagination = (bool) ($settings['show_pagination'] ?? true);
    $spaceBetween = (int) ($settings['space_between'] ?? 30);
    $height = $settings['height'] ?? 'medium';

    $heightClass = match($height) {
        'small' => 'carousel-height-sm',
        'medium' => 'carousel-height-md',
        'large' => 'carousel-height-lg',
        'fullscreen' => 'carousel-height-full',
        default => 'carousel-height-auto',
    };

    $carouselId = 'carousel-' . ($panel['id'] ?? uniqid());
    $jsSafeId = str_replace('-', '_', $carouselId);

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
            <div class="swiper modern-carousel {{ $heightClass }}"
                 id="{{ $carouselId }}-swiper"
                 data-carousel-id="{{ $carouselId }}"
                 data-slides-per-view="{{ $slidesPerView }}"
                 data-autoplay="{{ $autoplay ? 'true' : 'false' }}"
                 data-autoplay-delay="{{ $autoplayDelay }}"
                 data-loop="{{ ($loop && $items->count() > 1) ? 'true' : 'false' }}"
                 data-effect="{{ $effect }}"
                 data-space-between="{{ $spaceBetween }}"
                 data-total-slides="{{ $items->count() }}"
                 data-show-pagination="{{ $showPagination ? 'true' : 'false' }}"
                 data-show-navigation="{{ ($showNavigation && $items->count() > 1) ? 'true' : 'false' }}">
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
                                {{-- Cards --}}
                                @if($carouselStyle === 'cards')
                                    <div class="card carousel-card h-100 border-0 shadow-lg overflow-hidden">
                                        <div class="carousel-card-img-wrapper">
                                            <img src="{{ $imageUrl }}" alt="{{ $title }}" class="carousel-card-img">
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

                                    {{-- Minimal --}}
                                @elseif($carouselStyle === 'minimal')
                                    <div class="carousel-minimal-slide">
                                        <div class="carousel-minimal-img-wrapper rounded-4 overflow-hidden">
                                            <img src="{{ $imageUrl }}" alt="{{ $title }}" class="carousel-minimal-img">
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

                                    {{-- Fullwidth/Modern --}}
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

                                    {{-- Default --}}
                                @else
                                    <div class="carousel-default-slide position-relative rounded-4 overflow-hidden">
                                        <img src="{{ $imageUrl }}" alt="{{ $title }}"
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

            {{-- Navigation --}}
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

@push('page-script')
    <script>
        (function () {
            'use strict';

            const ID = @json($carouselId);
            const swiperSelector = `#${ID}-swiper`;

            function whenSwiperReady(cb) {
                if (typeof window.Swiper !== 'undefined') {
                    cb();
                    return;
                }
                let tries = 0;
                const timer = setInterval(() => {
                    tries++;
                    if (typeof window.Swiper !== 'undefined') {
                        clearInterval(timer);
                        cb();
                    }
                    if (tries > 80) { // ~8s max
                        clearInterval(timer);
                    }
                }, 100);
            }

            function destroySwiper(el) {
                if (!el) return;

                // Clear init flag so it can be re-initialized later if needed
                el.dataset.initialized = 'false';

                if (el.swiper && typeof el.swiper.destroy === 'function') {
                    el.swiper.destroy(true, true);
                }
            }

            function initSwiper() {
                const el = document.querySelector(swiperSelector);
                if (!el) return;

                // Hard guard against duplicate init
                if (el.dataset.initialized === 'true') return;
                el.dataset.initialized = 'true';

                // If a previous Swiper instance exists, destroy it first (SPA/Livewire safety)
                if (el.swiper) {
                    el.swiper.destroy(true, true);
                }

                const slidesPerView = parseInt(el.dataset.slidesPerView || '1', 10);
                const autoplay = el.dataset.autoplay === 'true';
                const autoplayDelay = parseInt(el.dataset.autoplayDelay || '5000', 10);
                const loop = el.dataset.loop === 'true';
                const effect = el.dataset.effect || 'slide';
                const spaceBetween = parseInt(el.dataset.spaceBetween || '30', 10);
                const totalSlides = parseInt(el.dataset.totalSlides || '0', 10);
                const showPagination = el.dataset.showPagination === 'true';
                const showNavigation = el.dataset.showNavigation === 'true';

                // Loop only when there are enough slides to loop safely
                const canLoop = loop && totalSlides > Math.max(1, slidesPerView);

                const config = {
                    effect,
                    loop: canLoop,
                    speed: 800,
                    spaceBetween,
                    grabCursor: totalSlides > 1,
                    watchSlidesProgress: true,

                    // IMPORTANT: disable observers to prevent re-cloning/duplication
                    observer: false,
                    observeParents: false,

                    // Responsive breakpoints
                    slidesPerView: 1,
                    breakpoints: {
                        576: {slidesPerView: Math.min(slidesPerView, 1)},
                        768: {slidesPerView: Math.min(slidesPerView, 2)},
                        992: {slidesPerView: Math.min(slidesPerView, 3)},
                        1200: {slidesPerView: slidesPerView}
                    },
                };

                // Navigation (only if enabled + elements exist)
                if (showNavigation) {
                    const nextEl = document.querySelector(`#${ID}-next`);
                    const prevEl = document.querySelector(`#${ID}-prev`);
                    if (nextEl && prevEl) {
                        config.navigation = {
                            nextEl: `#${ID}-next`,
                            prevEl: `#${ID}-prev`,
                        };
                    }
                }

                // Pagination (only if enabled + element exists)
                if (showPagination) {
                    const paginationEl = el.querySelector('.swiper-pagination');
                    if (paginationEl) {
                        config.pagination = {
                            el: paginationEl,
                            clickable: true,
                            dynamicBullets: slidesPerView === 1,
                        };
                    }
                }

                // Autoplay (only if enabled + more than one slide)
                if (autoplay && totalSlides > 1) {
                    config.autoplay = {
                        delay: autoplayDelay,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    };
                }

                // Effect-specific settings
                if (effect === 'fade') {
                    config.fadeEffect = {crossFade: true};
                    config.slidesPerView = 1;
                    delete config.breakpoints;
                    config.loop = canLoop && totalSlides > 1;
                }

                if (effect === 'cube') {
                    config.cubeEffect = {
                        shadow: true,
                        slideShadows: true,
                        shadowOffset: 20,
                        shadowScale: 0.94,
                    };
                    config.slidesPerView = 1;
                    delete config.breakpoints;
                    config.loop = canLoop && totalSlides > 1;
                }

                if (effect === 'coverflow') {
                    config.coverflowEffect = {
                        rotate: 30,
                        stretch: 0,
                        depth: 100,
                        modifier: 1,
                        slideShadows: true,
                    };
                    config.centeredSlides = true;
                }

                if (effect === 'flip') {
                    config.flipEffect = {
                        slideShadows: true,
                        limitRotation: true,
                    };
                    config.slidesPerView = 1;
                    delete config.breakpoints;
                    config.loop = canLoop && totalSlides > 1;
                }

                if (effect === 'cards') {
                    config.cardsEffect = {
                        perSlideOffset: 8,
                        perSlideRotate: 2,
                        rotate: true,
                        slideShadows: true,
                    };
                    config.slidesPerView = 1;
                    delete config.breakpoints;
                    config.loop = canLoop && totalSlides > 1;
                }

                new window.Swiper(el, config);
            }

            // Standard DOM load init (single path only)
            function boot() {
                whenSwiperReady(initSwiper);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', boot, {once: true});
            } else {
                boot();
            }

            // Optional: if you use Livewire 3 navigate, re-init cleanly (won't hurt if not used)
            document.addEventListener('livewire:navigated', () => {
                const el = document.querySelector(swiperSelector);
                destroySwiper(el);
                whenSwiperReady(initSwiper);
            });

            // Optional: if you use Turbo, re-init cleanly (won't hurt if not used)
            document.addEventListener('turbo:load', () => {
                const el = document.querySelector(swiperSelector);
                destroySwiper(el);
                whenSwiperReady(initSwiper);
            });

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
