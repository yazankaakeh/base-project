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
    {{-- Swiper CSS --}}
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @endpush
@endonce

{{-- HERO STYLE --}}
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
                            {{-- Background Image --}}
                            @if($imageUrl)
                                <div class="carousel-hero-bg">
                                    <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}">
                                </div>
                            @endif
                            <div class="carousel-hero-overlay"></div>

                            {{-- Content --}}
                            <div class="carousel-hero-content">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-8 col-xl-7">
                                            @if($subtitle)
                                                <span class="carousel-hero-subtitle" data-swiper-parallax="-100"
                                                      data-swiper-parallax-opacity="0">
                                                {{ $subtitle }}
                                            </span>
                                            @endif
                                            @if($itemTitle)
                                                <h1 class="carousel-hero-title" data-swiper-parallax="-200"
                                                    data-swiper-parallax-opacity="0">
                                                    {{ $itemTitle }}
                                                </h1>
                                            @endif
                                            @if($itemContent)
                                                <p class="carousel-hero-desc" data-swiper-parallax="-300"
                                                   data-swiper-parallax-opacity="0">
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

                            {{-- Slide Number --}}
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

            {{-- Navigation --}}
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

            {{-- Pagination --}}
            @if($showPagination && $items->count() > 1)
                <div class="carousel-hero-pagination">
                    <div class="swiper-pagination" id="{{ $carouselId }}-pagination"></div>
                </div>
            @endif

            {{-- Progress Bar --}}
            @if($autoplay && $items->count() > 1)
                <div class="carousel-hero-progress">
                    <div class="carousel-hero-progress-bar"></div>
                </div>
            @endif
        </div>
    </section>

    {{-- CARDS STYLE --}}
@elseif($carouselStyle === 'cards')
    <section class="panel-section panel-bg-subtle" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
        <div class="container">
            {{-- Header --}}
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

            {{-- Carousel --}}
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
                                    <i class="ti tabler-photo-off"
                                       style="font-size: 3rem; color: var(--panel-text-light);"></i>
                                    <p class="mt-3 mb-0"
                                       style="color: var(--panel-text-muted);">{{ __('No items available') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pagination (Mobile) --}}
            @if($showPagination && $items->count() > 1)
                <div class="carousel-cards-pagination d-lg-none">
                    <div class="swiper-pagination" id="{{ $carouselId }}-pagination"></div>
                </div>
            @endif
        </div>
    </section>

    {{-- DEFAULT/SHOWCASE STYLE --}}
@else
    <section class="panel-section panel-bg-white" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
        <div class="container">
            {{-- Header --}}
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

            {{-- Carousel --}}
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

                {{-- Navigation --}}
                @if($showNavigation && $items->count() > 1)
                    <button type="button" class="carousel-showcase-nav prev" id="{{ $carouselId }}-prev">
                        <i class="ti tabler-chevron-{{ $isRtl ? 'right' : 'left' }}"></i>
                    </button>
                    <button type="button" class="carousel-showcase-nav next" id="{{ $carouselId }}-next">
                        <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                    </button>
                @endif
            </div>

            {{-- Pagination --}}
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
       SWIPER ESSENTIAL STYLES (ensures proper display before JS loads)
       ================================================ */
    .swiper {
        overflow: hidden;
        position: relative;
    }

    .swiper-wrapper {
        display: flex;
        transition-property: transform;
        box-sizing: content-box;
    }

    .swiper-slide {
        flex-shrink: 0;
        width: 100%;
        position: relative;
    }

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
        overflow: hidden;
    }

    .carousel-hero-swiper .swiper-wrapper {
        display: flex;
        height: 100%;
    }

    .carousel-hero-swiper .swiper-slide {
        height: 100%;
        overflow: hidden;
        flex-shrink: 0;
        width: 100%;
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
        pointer-events: none; /* Allow clicks to pass through to header */
    }

    .carousel-hero-content .container {
        pointer-events: auto; /* Re-enable clicks on actual content */
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
        pointer-events: auto;
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
    {{ $isRtl ? 'left' : 'right' }}: 5 %;
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
    {{ $isRtl ? 'right' : 'left' }}: 5 %;
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
        background: linear-gradient(to top, rgba(0, 0, 0, 0.3) 0%, transparent 50%);
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
    {{ $isRtl ? 'right' : 'left' }}: - 26 px;
    }

    .carousel-showcase-nav.next {
    {{ $isRtl ? 'left' : 'right' }}: - 26 px;
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
        {{ $isRtl ? 'left' : 'right' }}: 20 px;
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

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        (function () {
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
                    loop: shouldLoop && totalSlides > 1, // Double-check: never loop with single slide
                    speed: 800,
                    grabCursor: totalSlides > 1,
                    watchSlidesProgress: true,
                    observer: true,
                    observeParents: true,
                    allowTouchMove: totalSlides > 1, // Disable touch/drag for single slide
                    navigation: totalSlides > 1 ? {
                        nextEl: '#' + carouselId + '-next',
                        prevEl: '#' + carouselId + '-prev'
                    } : false,
                    pagination: totalSlides > 1 ? {
                        el: '#' + carouselId + '-pagination',
                        clickable: true
                    } : false
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
                    // Use rewind instead of loop when we have few slides to avoid duplicates
                    if (totalSlides > 1 && !shouldLoop) {
                        config.rewind = true;
                    }

                    if (shouldAutoplay && totalSlides > 1) {
                        config.on = {
                            init: function () {
                                updateProgress();
                            },
                            slideChange: function () {
                                updateProgress();
                            },
                            autoplayTimeLeft: function (swiper, time, progress) {
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
                            576: {slidesPerView: Math.min(1.2, totalSlides), spaceBetween: 20},
                            768: {slidesPerView: Math.min(2, totalSlides), spaceBetween: 24},
                            992: {slidesPerView: Math.min(3, totalSlides), spaceBetween: 28},
                            1200: {slidesPerView: Math.min(3, totalSlides), spaceBetween: 32}
                        };
                    }
                    // Loop requires at least slidesPerView + 1 slides for cards style
                    var cardsLoop = shouldLoop && totalSlides > 3;
                    config.loop = cardsLoop;
                    // Use rewind instead of loop when we have few slides to avoid duplicates
                    if (totalSlides > 1 && !cardsLoop) {
                        config.rewind = true;
                    }
                } else {
                    // Showcase/default style
                    config.slidesPerView = 1;
                    config.spaceBetween = 0;
                    // Use rewind instead of loop when we have few slides to avoid duplicates
                    if (totalSlides > 1 && !shouldLoop) {
                        config.rewind = true;
                    }
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
@endpush
