@php
    /**
     * Modern Carousel Panel Component
     * Features: Glassmorphism, Ken Burns effect, Progress bar, Multiple styles
     *
     * @var \Modules\CMS\Models\Panel $panel
     */

    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);

    $settings = $panel->settings ?? [];
    $carouselStyle = $settings['carousel_style'] ?? 'hero';
    $slidesPerView = $settings['slides_per_view'] ?? 1;
    $autoplay = $settings['autoplay'] ?? true;
    $autoplayDelay = $settings['autoplay_delay'] ?? 5000;
    $loop = $settings['loop'] ?? true;
    $effect = $settings['effect'] ?? 'fade';
    $showNavigation = $settings['show_navigation'] ?? true;
    $showPagination = $settings['show_pagination'] ?? true;
    $spaceBetween = $settings['space_between'] ?? 30;
    $height = $settings['height'] ?? 'large';

    $heightClass = match($height) {
        'small' => 'carousel-h-sm',
        'medium' => 'carousel-h-md',
        'large' => 'carousel-h-lg',
        'fullscreen' => 'carousel-h-full',
        default => 'carousel-h-auto',
    };

    $carouselId = 'carousel-' . $panel->id;
    $title = $panel->getTranslation('title', $locale);
    $badge = $settings['badge'][$locale] ?? $settings['badge'][config('app.fallback_locale')] ?? null;
    $description = $settings['description'][$locale] ?? $settings['description'][config('app.fallback_locale')] ?? null;
    $items = $panel->activeItems ?? collect();
@endphp

<section id="panel-{{ $panel->id }}"
         class="modern-carousel-section carousel-style-{{ $carouselStyle }} {{ $heightClass }}"
         dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

    {{-- Section Header (for non-hero styles) --}}
    @if(($title || $badge || $description) && !in_array($carouselStyle, ['hero', 'fullwidth']))
        <div class="container">
            <div class="carousel-section-header text-center mb-5">
                @if($badge)
                    <span class="carousel-section-badge">
                        <span class="badge-dot"></span>
                        {{ $badge }}
                    </span>
                @endif
                @if($title)
                    <h2 class="carousel-section-title">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="carousel-section-desc">{{ $description }}</p>
                @endif
            </div>
        </div>
    @endif

    {{-- Carousel Container --}}
    <div class="{{ in_array($carouselStyle, ['hero', 'fullwidth']) ? '' : 'container' }}">
        <div class="carousel-main-wrapper">
            <div class="swiper modern-swiper-carousel" id="{{ $carouselId }}"
                 data-slides="{{ $slidesPerView }}"
                 data-autoplay="{{ $autoplay ? 'true' : 'false' }}"
                 data-delay="{{ $autoplayDelay }}"
                 data-loop="{{ $loop ? 'true' : 'false' }}"
                 data-effect="{{ $effect }}"
                 data-space="{{ $spaceBetween }}"
                 data-style="{{ $carouselStyle }}">
                <div class="swiper-wrapper">
                    @forelse($items as $index => $item)
                        @php
                            $itemData = $item->data ?? [];
                            $overlayColor = $itemData['overlay_color'] ?? 'gradient';
                            $subtitle = $itemData['subtitle'] ?? '';
                            $buttonText = $itemData['button_text'] ?? '';
                            $buttonUrl = $itemData['button_url'] ?? '#';
                            $imageUrl = $item->getFirstMediaUrl('item_image') ?: 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&q=80';
                            $itemTitle = $item->getTranslation('title', $locale);
                            $itemContent = $item->getTranslation('content', $locale);
                        @endphp
                        <div class="swiper-slide">
                            @switch($carouselStyle)
                                {{-- HERO STYLE --}}
                                @case('hero')
                                @case('fullwidth')
                                    <div class="carousel-hero-slide" style="--slide-bg: url('{{ $imageUrl }}');">
                                        <div class="hero-bg-image"></div>
                                        <div class="hero-overlay hero-overlay-{{ $overlayColor }}"></div>
                                        <div class="hero-particles">
                                            @for($i = 0; $i < 5; $i++)
                                                <div class="particle particle-{{ $i + 1 }}"></div>
                                            @endfor
                                        </div>
                                        <div class="hero-content-wrapper">
                                            <div class="container">
                                                <div class="hero-content">
                                                    @if($subtitle)
                                                        <div class="hero-subtitle-wrapper animate-item" data-delay="0">
                                                            <span class="hero-subtitle">
                                                                <i class="ti tabler-sparkles"></i>
                                                                {{ $subtitle }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if($itemTitle)
                                                        <h1 class="hero-title animate-item" data-delay="1">
                                                            {!! $itemTitle !!}
                                                        </h1>
                                                    @endif
                                                    @if($itemContent)
                                                        <p class="hero-description animate-item" data-delay="2">
                                                            {{ $itemContent }}
                                                        </p>
                                                    @endif
                                                    @if($buttonText)
                                                        <div class="hero-cta animate-item" data-delay="3">
                                                            <a href="{{ $buttonUrl }}" class="hero-btn-primary">
                                                                <span>{{ $buttonText }}</span>
                                                                <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                                            </a>
                                                            <a href="#learn-more" class="hero-btn-secondary">
                                                                <i class="ti tabler-player-play"></i>
                                                                <span>{{ __('Learn More') }}</span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Slide Number --}}
                                        <div class="slide-counter">
                                            <span class="current">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                            <span class="separator">/</span>
                                            <span class="total">{{ str_pad($items->count(), 2, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </div>
                                    @break

                                {{-- SHOWCASE STYLE (Split Layout) --}}
                                @case('showcase')
                                    <div class="carousel-showcase-slide">
                                        <div class="row g-0 align-items-center h-100">
                                            <div class="col-lg-6 order-lg-{{ $index % 2 == 0 ? '1' : '2' }}">
                                                <div class="showcase-image-wrapper">
                                                    <div class="showcase-image-frame">
                                                        <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}" class="showcase-image">
                                                        <div class="showcase-image-glow"></div>
                                                    </div>
                                                    <div class="showcase-floating-badge">
                                                        <i class="ti tabler-award"></i>
                                                        <span>{{ $subtitle ?: 'Featured' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 order-lg-{{ $index % 2 == 0 ? '2' : '1' }}">
                                                <div class="showcase-content">
                                                    @if($itemTitle)
                                                        <h3 class="showcase-title">{{ $itemTitle }}</h3>
                                                    @endif
                                                    @if($itemContent)
                                                        <p class="showcase-description">{{ $itemContent }}</p>
                                                    @endif
                                                    @if($buttonText)
                                                        <a href="{{ $buttonUrl }}" class="showcase-btn">
                                                            {{ $buttonText }}
                                                            <span class="btn-arrow">
                                                                <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                                            </span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break

                                {{-- CARDS STYLE --}}
                                @case('cards')
                                    <div class="carousel-card-slide">
                                        <div class="modern-card">
                                            <div class="card-image-container">
                                                <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}" class="card-image">
                                                <div class="card-image-overlay"></div>
                                                @if($subtitle)
                                                    <span class="card-badge">{{ $subtitle }}</span>
                                                @endif
                                            </div>
                                            <div class="card-content">
                                                @if($itemTitle)
                                                    <h4 class="card-title">{{ $itemTitle }}</h4>
                                                @endif
                                                @if($itemContent)
                                                    <p class="card-description">{{ Str::limit($itemContent, 100) }}</p>
                                                @endif
                                                @if($buttonText)
                                                    <a href="{{ $buttonUrl }}" class="card-link">
                                                        {{ $buttonText }}
                                                        <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="card-shine"></div>
                                        </div>
                                    </div>
                                    @break

                                {{-- MINIMAL STYLE --}}
                                @case('minimal')
                                    <div class="carousel-minimal-slide">
                                        <div class="minimal-image-wrapper">
                                            <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}" class="minimal-image">
                                        </div>
                                        <div class="minimal-content">
                                            @if($subtitle)
                                                <span class="minimal-tag">{{ $subtitle }}</span>
                                            @endif
                                            @if($itemTitle)
                                                <h4 class="minimal-title">{{ $itemTitle }}</h4>
                                            @endif
                                            @if($buttonText)
                                                <a href="{{ $buttonUrl }}" class="minimal-link">
                                                    {{ $buttonText }} <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @break

                                {{-- DEFAULT STYLE --}}
                                @default
                                    <div class="carousel-default-slide">
                                        <div class="default-slide-inner">
                                            <img src="{{ $imageUrl }}" alt="{{ $itemTitle }}" class="default-image">
                                            <div class="default-overlay"></div>
                                            <div class="default-content">
                                                @if($subtitle)
                                                    <span class="default-badge">{{ $subtitle }}</span>
                                                @endif
                                                @if($itemTitle)
                                                    <h3 class="default-title">{{ $itemTitle }}</h3>
                                                @endif
                                                @if($itemContent)
                                                    <p class="default-description">{{ Str::limit($itemContent, 120) }}</p>
                                                @endif
                                                @if($buttonText)
                                                    <a href="{{ $buttonUrl }}" class="default-btn">
                                                        {{ $buttonText }}
                                                        <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                            @endswitch
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="carousel-empty">
                                <div class="empty-icon">
                                    <i class="ti tabler-photo-off"></i>
                                </div>
                                <p>{{ __('No slides available') }}</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Progress Bar --}}
                @if($autoplay && in_array($carouselStyle, ['hero', 'fullwidth']))
                    <div class="carousel-progress">
                        <div class="carousel-progress-bar" id="{{ $carouselId }}-progress"></div>
                    </div>
                @endif

                {{-- Pagination --}}
                @if($showPagination)
                    <div class="carousel-pagination-wrapper">
                        <div class="swiper-pagination carousel-pagination" id="{{ $carouselId }}-pagination"></div>
                    </div>
                @endif
            </div>

            {{-- Navigation --}}
            @if($showNavigation && $items->count() > 1)
                <div class="carousel-nav">
                    <button type="button" class="carousel-nav-btn carousel-prev" id="{{ $carouselId }}-prev" aria-label="Previous">
                        <span class="nav-btn-bg"></span>
                        <i class="ti tabler-chevron-{{ $isRtl ? 'right' : 'left' }}"></i>
                    </button>
                    <button type="button" class="carousel-nav-btn carousel-next" id="{{ $carouselId }}-next" aria-label="Next">
                        <span class="nav-btn-bg"></span>
                        <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Scroll Indicator (Hero only) --}}
    @if(in_array($carouselStyle, ['hero', 'fullwidth']))
        <div class="scroll-indicator">
            <div class="mouse">
                <div class="wheel"></div>
            </div>
            <span>{{ __('Scroll Down') }}</span>
        </div>
    @endif
</section>

<style>
/* ============================================
   MODERN CAROUSEL - PREMIUM DESIGN SYSTEM
   ============================================ */

/* CSS Variables */
.modern-carousel-section {
    --carousel-primary: #6366f1;
    --carousel-primary-dark: #4f46e5;
    --carousel-secondary: #0f172a;
    --carousel-accent: #f97316;
    --carousel-text: #ffffff;
    --carousel-text-muted: rgba(255, 255, 255, 0.7);
    --carousel-glass: rgba(255, 255, 255, 0.1);
    --carousel-glass-border: rgba(255, 255, 255, 0.2);
    --carousel-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --carousel-radius: 1.5rem;
    --carousel-transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);

    position: relative;
    overflow: hidden;
}

/* Height Variants */
.carousel-h-sm .modern-swiper-carousel,
.carousel-h-sm .carousel-hero-slide { height: 400px; }

.carousel-h-md .modern-swiper-carousel,
.carousel-h-md .carousel-hero-slide { height: 550px; }

.carousel-h-lg .modern-swiper-carousel,
.carousel-h-lg .carousel-hero-slide { height: 700px; }

.carousel-h-full .modern-swiper-carousel,
.carousel-h-full .carousel-hero-slide { height: 100vh; min-height: 600px; }

.carousel-h-auto .modern-swiper-carousel { height: auto; min-height: 450px; }

/* ============================================
   SECTION HEADER
   ============================================ */
.carousel-section-header {
    max-width: 680px;
    margin-left: auto;
    margin-right: auto;
    padding-top: 3rem;
}

.carousel-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(249, 115, 22, 0.1) 100%);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--carousel-primary);
    margin-bottom: 1rem;
}

.badge-dot {
    width: 8px;
    height: 8px;
    background: var(--carousel-accent);
    border-radius: 50%;
    animation: pulseDot 2s ease-in-out infinite;
}

@keyframes pulseDot {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.5); opacity: 0.5; }
}

.carousel-section-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    color: var(--carousel-secondary);
    line-height: 1.2;
    margin-bottom: 1rem;
}

.carousel-section-desc {
    font-size: 1.125rem;
    color: #64748b;
    line-height: 1.7;
}

/* ============================================
   MAIN WRAPPER
   ============================================ */
.carousel-main-wrapper {
    position: relative;
}

.carousel-style-hero .carousel-main-wrapper,
.carousel-style-fullwidth .carousel-main-wrapper {
    margin: 0;
}

/* ============================================
   HERO STYLE
   ============================================ */
.carousel-hero-slide {
    position: relative;
    overflow: hidden;
}

.hero-bg-image {
    position: absolute;
    inset: 0;
    background-image: var(--slide-bg);
    background-size: cover;
    background-position: center;
    animation: kenBurns 20s ease-in-out infinite alternate;
}

@keyframes kenBurns {
    0% { transform: scale(1); }
    100% { transform: scale(1.1); }
}

.hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
}

.hero-overlay-dark {
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.7) 50%, rgba(15, 23, 42, 0.8) 100%);
}

.hero-overlay-gradient {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.85) 0%, rgba(79, 70, 229, 0.75) 50%, rgba(249, 115, 22, 0.6) 100%);
}

.hero-overlay-light {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
}

.hero-overlay-primary {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.9) 0%, rgba(79, 70, 229, 0.85) 100%);
}

/* Hero Particles */
.hero-particles {
    position: absolute;
    inset: 0;
    z-index: 2;
    pointer-events: none;
    overflow: hidden;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    animation: floatParticle 15s linear infinite;
}

.particle-1 { left: 10%; animation-delay: 0s; }
.particle-2 { left: 30%; animation-delay: 3s; }
.particle-3 { left: 50%; animation-delay: 6s; }
.particle-4 { left: 70%; animation-delay: 9s; }
.particle-5 { left: 90%; animation-delay: 12s; }

@keyframes floatParticle {
    0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
}

/* Hero Content */
.hero-content-wrapper {
    position: relative;
    z-index: 3;
    display: flex;
    align-items: center;
    height: 100%;
    padding: 2rem 0;
}

.hero-content {
    max-width: 800px;
}

.hero-subtitle-wrapper {
    margin-bottom: 1.5rem;
}

.hero-subtitle {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--carousel-glass);
    backdrop-filter: blur(10px);
    border: 1px solid var(--carousel-glass-border);
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--carousel-text);
}

.hero-subtitle i {
    color: var(--carousel-accent);
}

.hero-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 800;
    color: var(--carousel-text);
    line-height: 1.1;
    margin-bottom: 1.5rem;
    letter-spacing: -0.02em;
}

.hero-description {
    font-size: clamp(1rem, 2vw, 1.25rem);
    color: var(--carousel-text-muted);
    line-height: 1.7;
    margin-bottom: 2.5rem;
    max-width: 600px;
}

.hero-cta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}

.hero-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, var(--carousel-primary) 0%, var(--carousel-primary-dark) 100%);
    color: white;
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    transition: var(--carousel-transition);
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
}

.hero-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(99, 102, 241, 0.5);
    color: white;
}

.hero-btn-primary i {
    transition: transform 0.3s ease;
}

.hero-btn-primary:hover i {
    transform: translateX(5px);
}

[dir="rtl"] .hero-btn-primary:hover i {
    transform: translateX(-5px);
}

.hero-btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    background: var(--carousel-glass);
    backdrop-filter: blur(10px);
    border: 1px solid var(--carousel-glass-border);
    color: var(--carousel-text);
    font-weight: 500;
    border-radius: 50px;
    text-decoration: none;
    transition: var(--carousel-transition);
}

.hero-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.hero-btn-secondary i {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--carousel-accent);
    border-radius: 50%;
    font-size: 0.875rem;
}

/* Slide Counter */
.slide-counter {
    position: absolute;
    bottom: 3rem;
    right: 3rem;
    z-index: 10;
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    font-family: 'Inter', sans-serif;
}

.slide-counter .current {
    font-size: 3rem;
    font-weight: 700;
    color: var(--carousel-text);
    line-height: 1;
}

.slide-counter .separator {
    font-size: 1.5rem;
    color: var(--carousel-text-muted);
    margin: 0 0.25rem;
}

.slide-counter .total {
    font-size: 1.25rem;
    color: var(--carousel-text-muted);
}

/* Animation Classes */
.animate-item {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.swiper-slide-active .animate-item {
    opacity: 1;
    transform: translateY(0);
}

.animate-item[data-delay="1"] { transition-delay: 0.15s; }
.animate-item[data-delay="2"] { transition-delay: 0.3s; }
.animate-item[data-delay="3"] { transition-delay: 0.45s; }

/* ============================================
   SHOWCASE STYLE
   ============================================ */
.carousel-showcase-slide {
    height: 100%;
    padding: 2rem 0;
}

.showcase-image-wrapper {
    position: relative;
    padding: 2rem;
}

.showcase-image-frame {
    position: relative;
    border-radius: var(--carousel-radius);
    overflow: hidden;
    box-shadow: var(--carousel-shadow);
}

.showcase-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.showcase-image-frame:hover .showcase-image {
    transform: scale(1.05);
}

.showcase-image-glow {
    position: absolute;
    inset: -20%;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, transparent 70%);
    z-index: -1;
    animation: glowPulse 3s ease-in-out infinite;
}

@keyframes glowPulse {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}

.showcase-floating-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: white;
    border-radius: 50px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    font-weight: 600;
    color: var(--carousel-primary);
    z-index: 10;
}

.showcase-floating-badge i {
    color: var(--carousel-accent);
}

.showcase-content {
    padding: 2rem;
}

.showcase-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--carousel-secondary);
    margin-bottom: 1rem;
    line-height: 1.3;
}

.showcase-description {
    font-size: 1.1rem;
    color: #64748b;
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.showcase-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.75rem;
    background: var(--carousel-secondary);
    color: white;
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    transition: var(--carousel-transition);
}

.showcase-btn:hover {
    background: var(--carousel-primary);
    color: white;
}

.showcase-btn .btn-arrow {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transition: transform 0.3s ease;
}

.showcase-btn:hover .btn-arrow {
    transform: translateX(5px);
}

/* ============================================
   CARDS STYLE
   ============================================ */
.carousel-style-cards .modern-swiper-carousel {
    padding: 2rem 0 4rem;
}

.carousel-card-slide {
    padding: 1rem;
    height: auto;
}

.modern-card {
    position: relative;
    background: white;
    border-radius: var(--carousel-radius);
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    transition: var(--carousel-transition);
}

.modern-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.card-image-container {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.modern-card:hover .card-image {
    transform: scale(1.1);
}

.card-image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15, 23, 42, 0.8) 0%, transparent 60%);
}

.card-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.5rem 1rem;
    background: var(--carousel-primary);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-radius: 50px;
}

.card-content {
    padding: 1.5rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--carousel-secondary);
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.card-description {
    font-size: 0.9rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.card-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--carousel-primary);
    text-decoration: none;
    transition: gap 0.3s ease;
}

.card-link:hover {
    gap: 0.75rem;
    color: var(--carousel-primary-dark);
}

.card-shine {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, transparent 40%, rgba(255, 255, 255, 0.1) 50%, transparent 60%);
    transform: translateX(-100%);
    transition: transform 0.6s ease;
    pointer-events: none;
}

.modern-card:hover .card-shine {
    transform: translateX(100%);
}

/* ============================================
   MINIMAL STYLE
   ============================================ */
.carousel-style-minimal .modern-swiper-carousel {
    padding: 2rem 0 4rem;
}

.carousel-minimal-slide {
    text-align: center;
    padding: 1rem;
}

.minimal-image-wrapper {
    position: relative;
    border-radius: var(--carousel-radius);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.minimal-image {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.carousel-minimal-slide:hover .minimal-image {
    transform: scale(1.03);
}

.minimal-content {
    padding: 0 1rem;
}

.minimal-tag {
    display: inline-block;
    padding: 0.375rem 1rem;
    background: rgba(99, 102, 241, 0.1);
    color: var(--carousel-primary);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border-radius: 50px;
    margin-bottom: 0.75rem;
}

.minimal-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--carousel-secondary);
    margin-bottom: 0.5rem;
}

.minimal-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: var(--carousel-primary);
    text-decoration: none;
}

.minimal-link:hover {
    text-decoration: underline;
}

/* ============================================
   DEFAULT STYLE
   ============================================ */
.carousel-default-slide {
    padding: 1rem;
    height: 100%;
}

.default-slide-inner {
    position: relative;
    height: 100%;
    min-height: 400px;
    border-radius: var(--carousel-radius);
    overflow: hidden;
}

.default-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.default-slide-inner:hover .default-image {
    transform: scale(1.05);
}

.default-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.3) 50%, transparent 100%);
}

.default-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 2rem;
    color: white;
}

.default-badge {
    display: inline-block;
    padding: 0.375rem 1rem;
    background: var(--carousel-primary);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: 50px;
    margin-bottom: 1rem;
}

.default-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.default-description {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    margin-bottom: 1.25rem;
}

.default-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    color: var(--carousel-secondary);
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    transition: var(--carousel-transition);
}

.default-btn:hover {
    background: var(--carousel-primary);
    color: white;
}

/* ============================================
   NAVIGATION
   ============================================ */
.carousel-nav {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    z-index: 20;
    display: flex;
    justify-content: space-between;
    padding: 0 1rem;
    pointer-events: none;
}

.carousel-style-hero .carousel-nav,
.carousel-style-fullwidth .carousel-nav {
    padding: 0 2rem;
}

.carousel-nav-btn {
    position: relative;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--carousel-glass);
    backdrop-filter: blur(10px);
    border: 1px solid var(--carousel-glass-border);
    border-radius: 50%;
    color: white;
    font-size: 1.25rem;
    cursor: pointer;
    pointer-events: auto;
    transition: var(--carousel-transition);
    overflow: hidden;
}

.carousel-style-cards .carousel-nav-btn,
.carousel-style-minimal .carousel-nav-btn,
.carousel-style-showcase .carousel-nav-btn,
.carousel-style-default .carousel-nav-btn {
    background: white;
    border: 1px solid #e2e8f0;
    color: var(--carousel-secondary);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.nav-btn-bg {
    position: absolute;
    inset: 0;
    background: var(--carousel-primary);
    border-radius: 50%;
    transform: scale(0);
    transition: transform 0.3s ease;
}

.carousel-nav-btn:hover .nav-btn-bg {
    transform: scale(1);
}

.carousel-nav-btn i {
    position: relative;
    z-index: 1;
    transition: color 0.3s ease;
}

.carousel-nav-btn:hover i {
    color: white;
}

.carousel-nav-btn:hover {
    transform: scale(1.1);
    border-color: transparent;
}

/* ============================================
   PAGINATION
   ============================================ */
.carousel-pagination-wrapper {
    position: relative;
    display: flex;
    justify-content: center;
    padding: 1.5rem 0;
}

.carousel-style-hero .carousel-pagination-wrapper,
.carousel-style-fullwidth .carousel-pagination-wrapper {
    position: absolute;
    bottom: 2rem;
    left: 0;
    right: 0;
    z-index: 10;
}

.carousel-pagination {
    display: flex;
    gap: 0.5rem;
}

.carousel-pagination .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: var(--carousel-glass);
    border: 2px solid var(--carousel-glass-border);
    border-radius: 50%;
    opacity: 1;
    transition: var(--carousel-transition);
}

.carousel-style-cards .carousel-pagination .swiper-pagination-bullet,
.carousel-style-minimal .carousel-pagination .swiper-pagination-bullet,
.carousel-style-showcase .carousel-pagination .swiper-pagination-bullet,
.carousel-style-default .carousel-pagination .swiper-pagination-bullet {
    background: #e2e8f0;
    border: none;
}

.carousel-pagination .swiper-pagination-bullet-active {
    width: 32px;
    border-radius: 6px;
    background: var(--carousel-primary);
    border-color: var(--carousel-primary);
}

/* ============================================
   PROGRESS BAR
   ============================================ */
.carousel-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: rgba(255, 255, 255, 0.2);
    z-index: 20;
}

.carousel-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--carousel-primary) 0%, var(--carousel-accent) 100%);
    width: 0%;
    transition: width 0.1s linear;
}

/* ============================================
   SCROLL INDICATOR
   ============================================ */
.scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: var(--carousel-text-muted);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    animation: bounce 2s infinite;
}

.mouse {
    width: 26px;
    height: 40px;
    border: 2px solid var(--carousel-glass-border);
    border-radius: 15px;
    position: relative;
}

.wheel {
    width: 4px;
    height: 8px;
    background: var(--carousel-text);
    border-radius: 2px;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    animation: scroll 2s infinite;
}

@keyframes scroll {
    0% { opacity: 1; transform: translateX(-50%) translateY(0); }
    100% { opacity: 0; transform: translateX(-50%) translateY(12px); }
}

@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(-5px); }
}

/* ============================================
   EMPTY STATE
   ============================================ */
.carousel-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 400px;
    color: #94a3b8;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */
@media (max-width: 991.98px) {
    .carousel-h-lg .modern-swiper-carousel,
    .carousel-h-lg .carousel-hero-slide { height: 550px; }

    .carousel-h-full .modern-swiper-carousel,
    .carousel-h-full .carousel-hero-slide { height: 80vh; min-height: 500px; }

    .hero-title { font-size: 2.5rem; }
    .hero-description { font-size: 1rem; }

    .showcase-image { height: 300px; }
    .showcase-content { padding: 1.5rem; }
    .showcase-title { font-size: 1.75rem; }

    .slide-counter { bottom: 1.5rem; right: 1.5rem; }
    .slide-counter .current { font-size: 2rem; }
}

@media (max-width: 767.98px) {
    .carousel-h-md .modern-swiper-carousel,
    .carousel-h-md .carousel-hero-slide { height: 450px; }

    .carousel-h-lg .modern-swiper-carousel,
    .carousel-h-lg .carousel-hero-slide { height: 480px; }

    .carousel-h-full .modern-swiper-carousel,
    .carousel-h-full .carousel-hero-slide { height: 70vh; min-height: 450px; }

    .hero-content { text-align: center; }
    .hero-cta { justify-content: center; }
    .hero-btn-secondary span { display: none; }

    .carousel-nav-btn { width: 44px; height: 44px; }
    .carousel-nav { padding: 0 0.5rem; }

    .slide-counter { display: none; }
    .scroll-indicator { display: none; }

    .showcase-image-wrapper { padding: 1rem; }
    .showcase-content { text-align: center; }
}

/* ============================================
   RTL SUPPORT
   ============================================ */
[dir="rtl"] .hero-btn-primary:hover i { transform: translateX(-5px); }
[dir="rtl"] .showcase-btn:hover .btn-arrow { transform: translateX(-5px); }
[dir="rtl"] .slide-counter { right: auto; left: 3rem; }
</style>

<script>
(function() {
    'use strict';

    function initCarousel() {
        if (typeof Swiper === 'undefined') {
            setTimeout(initCarousel, 100);
            return;
        }

        var carouselEl = document.getElementById('{{ $carouselId }}');
        if (!carouselEl) return;

        var slidesPerView = parseInt(carouselEl.dataset.slides) || 1;
        var autoplay = carouselEl.dataset.autoplay === 'true';
        var delay = parseInt(carouselEl.dataset.delay) || 5000;
        var loop = carouselEl.dataset.loop === 'true';
        var effect = carouselEl.dataset.effect || 'fade';
        var spaceBetween = parseInt(carouselEl.dataset.space) || 30;
        var style = carouselEl.dataset.style || 'hero';

        var config = {
            effect: effect,
            loop: loop,
            speed: 1000,
            spaceBetween: spaceBetween,
            grabCursor: true,
            watchSlidesProgress: true,
            slidesPerView: 1,

            navigation: {
                nextEl: '#{{ $carouselId }}-next',
                prevEl: '#{{ $carouselId }}-prev'
            },

            pagination: {
                el: '#{{ $carouselId }}-pagination',
                clickable: true
            },

            on: {
                init: function() {
                    updateProgress(this);
                },
                slideChange: function() {
                    updateProgress(this);
                },
                autoplayTimeLeft: function(swiper, time, progress) {
                    var progressBar = document.getElementById('{{ $carouselId }}-progress');
                    if (progressBar) {
                        progressBar.style.width = ((1 - progress) * 100) + '%';
                    }
                }
            }
        };

        // Responsive breakpoints for multi-slide styles
        if (['cards', 'minimal', 'default'].includes(style) && slidesPerView > 1) {
            config.breakpoints = {
                576: { slidesPerView: Math.min(slidesPerView, 1) },
                768: { slidesPerView: Math.min(slidesPerView, 2) },
                992: { slidesPerView: Math.min(slidesPerView, 3) },
                1200: { slidesPerView: slidesPerView }
            };
        }

        // Autoplay configuration
        if (autoplay) {
            config.autoplay = {
                delay: delay,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            };
        }

        // Effect-specific settings
        if (effect === 'fade') {
            config.fadeEffect = { crossFade: true };
        } else if (effect === 'cube') {
            config.cubeEffect = {
                shadow: true,
                slideShadows: true,
                shadowOffset: 20,
                shadowScale: 0.94
            };
        } else if (effect === 'coverflow') {
            config.coverflowEffect = {
                rotate: 30,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true
            };
            config.centeredSlides = true;
        } else if (effect === 'flip') {
            config.flipEffect = {
                slideShadows: true,
                limitRotation: true
            };
        } else if (effect === 'cards') {
            config.cardsEffect = {
                perSlideOffset: 8,
                perSlideRotate: 2,
                rotate: true,
                slideShadows: true
            };
        }

        new Swiper(carouselEl, config);

        function updateProgress(swiper) {
            var progressBar = document.getElementById('{{ $carouselId }}-progress');
            if (progressBar && autoplay) {
                progressBar.style.width = '0%';
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        initCarousel();
    }
})();
</script>
