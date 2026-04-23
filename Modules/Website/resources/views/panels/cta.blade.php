@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;

    // Primary Button
    $buttonText = $panel->settings['button_text'][$locale] ?? null;
    $buttonUrl = $panel->settings['button_url'] ?? '#';

    // Secondary Link
    $linkText = $panel->settings['link_text'][$locale] ?? $panel->settings['button_secondary_text'][$locale] ?? null;
    $linkUrl = $panel->settings['link_url'] ?? $panel->settings['button_secondary_url'] ?? '#';

    // Image
    $image = $panel->getFirstMediaUrl('panel_image');

    // Layout style: 'split' (image + content side by side) or 'overlay' (image as background)
    $layoutStyle = $panel->settings['layout_style'] ?? ($image ? 'split' : 'overlay');

    // Image position for split layout
    $imagePosition = $panel->settings['image_position'] ?? 'right';
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

@if($layoutStyle === 'split' && $image)
    {{-- Split Layout: Image + Content side by side --}}
    <section class="panel-section panel-bg-white" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
        <div class="container">
            <div class="row g-5 align-items-center">
                {{-- Content --}}
                <div class="col-lg-6 {{ $imagePosition === 'left' ? 'order-lg-2' : 'order-lg-1' }} panel-animate">
                    @if($badge)
                        <span class="panel-badge">{{ $badge }}</span>
                    @endif

                    @if($title)
                        <h2 class="panel-title" style="font-size: clamp(1.75rem, 4vw, 2.5rem); margin-bottom: 20px;">
                            {{ $title }}
                        </h2>
                    @endif

                    @if($description)
                        <p class="panel-description" style="margin-bottom: 32px;">
                            {{ $description }}
                        </p>
                    @endif

                    @if($buttonText || $linkText)
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            @if($buttonText)
                                <a href="{{ $buttonUrl }}" class="panel-btn panel-btn-primary panel-btn-lg">
                                    {{ $buttonText }}
                                    <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                </a>
                            @endif
                            @if($linkText)
                                <a href="{{ $linkUrl }}" class="panel-cta-link">
                                    {{ $linkText }}
                                    <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Image --}}
                <div class="col-lg-6 {{ $imagePosition === 'left' ? 'order-lg-1' : 'order-lg-2' }} panel-animate" style="animation-delay: 0.1s;">
                    <div class="panel-cta-image-wrapper">
                        <img src="{{ $image }}" alt="{{ $title }}" class="panel-cta-image">
                        <div class="panel-cta-image-decoration"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    {{-- Overlay Layout: Full width with gradient background --}}
    <section class="panel-section panel-bg-gradient position-relative" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
        @if($image)
            <div class="position-absolute w-100 h-100 top-0 start-0" style="opacity: 0.15; pointer-events: none;">
                <img src="{{ $image }}" alt="" class="w-100 h-100" style="object-fit: cover;">
            </div>
        @endif

        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8 text-center">
                    @if($badge)
                        <span class="panel-badge" style="background: rgba(255,255,255,0.15); color: #fff; margin-bottom: 24px;">
                            {{ $badge }}
                        </span>
                    @endif

                    @if($title)
                        <h2 class="panel-title panel-title-white" style="font-size: clamp(2rem, 5vw, 3rem); margin-bottom: 20px;">
                            {{ $title }}
                        </h2>
                    @endif

                    @if($description)
                        <p class="panel-description panel-description-white mx-auto" style="max-width: 600px; margin-bottom: 32px;">
                            {{ $description }}
                        </p>
                    @endif

                    @if($buttonText || $linkText)
                        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                            @if($buttonText)
                                <a href="{{ $buttonUrl }}" class="panel-btn panel-btn-white panel-btn-lg">
                                    {{ $buttonText }}
                                    <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                                </a>
                            @endif
                            @if($linkText)
                                <a href="{{ $linkUrl }}" class="panel-cta-link panel-cta-link-white">
                                    {{ $linkText }}
                                    <i class="ti tabler-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif

<style>
    /* CTA Image Styles */
    .panel-cta-image-wrapper {
        position: relative;
    }

    .panel-cta-image {
        width: 100%;
        height: auto;
        border-radius: var(--panel-radius-xl);
        box-shadow: var(--panel-shadow-lg);
        position: relative;
        z-index: 2;
    }

    .panel-cta-image-decoration {
        position: absolute;
        top: 24px;
        {{ $isRtl ? 'right' : 'left' }}: 24px;
        width: 100%;
        height: 100%;
        background: rgba(var(--panel-primary-rgb), 0.1);
        border-radius: var(--panel-radius-xl);
        z-index: 1;
    }

    /* CTA Link Styles */
    .panel-cta-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--panel-primary);
        font-weight: 600;
        font-size: 0.9375rem;
        text-decoration: none;
        transition: var(--panel-transition);
    }

    .panel-cta-link:hover {
        color: var(--panel-primary);
        gap: 10px;
    }

    .panel-cta-link-white {
        color: rgba(255, 255, 255, 0.9);
    }

    .panel-cta-link-white:hover {
        color: #fff;
    }

    /* RTL Support */
    [dir="rtl"] .panel-cta-image-decoration {
        left: auto;
        right: 24px;
    }

    /* Dark Mode */
    [data-bs-theme="dark"] .panel-cta-image-decoration {
        background: rgba(var(--panel-primary-rgb), 0.15);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .panel-cta-image-decoration {
            top: 16px;
            {{ $isRtl ? 'right' : 'left' }}: 16px;
        }
    }
</style>
