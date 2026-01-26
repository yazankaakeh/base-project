@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
    $buttonText = $panel->settings['button_text'][$locale] ?? null;
    $buttonUrl = $panel->settings['button_url'] ?? null;
    $buttonSecondaryText = $panel->settings['button_secondary_text'][$locale] ?? null;
    $buttonSecondaryUrl = $panel->settings['button_secondary_url'] ?? null;
    $backgroundImage = $panel->getFirstMediaUrl('panel_image');
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

<section class="panel-section panel-gradient-primary position-relative" id="panel-{{ $panel->id }}"
         style="min-height: 85vh; display: flex; align-items: center;" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

    {{-- Animated Background Shapes --}}
    <div class="panel-shape panel-shape-1"></div>
    <div class="panel-shape panel-shape-2"></div>
    <div class="panel-pattern"></div>

    @if($backgroundImage)
        <div class="position-absolute w-100 h-100 top-0 start-0"
             style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center; opacity: 0.12;">
        </div>
    @endif

    <div class="container position-relative py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8 text-center">
                @if($badge)
                    <span class="panel-badge bg-white text-primary mb-4" style="color: var(--panel-primary) !important;">
                        {{ $badge }}
                    </span>
                @endif

                @if($title)
                    <h1 class="panel-title text-white mb-4" style="font-size: clamp(2.5rem, 6vw, 4rem);">
                        {{ $title }}
                    </h1>
                @endif

                @if($description)
                    <p class="panel-description mb-5" style="color: rgba(255,255,255,0.85); max-width: 700px;">
                        {{ $description }}
                    </p>
                @endif

                @if($buttonText || $buttonSecondaryText)
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                        @if($buttonText && $buttonUrl)
                            <a href="{{ $buttonUrl }}" class="panel-btn panel-btn-primary">
                                {{ $buttonText }}
                                <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if($buttonSecondaryText && $buttonSecondaryUrl)
                            <a href="{{ $buttonSecondaryUrl }}" class="panel-btn panel-btn-outline">
                                <i class="ti tabler-player-play"></i>
                                {{ $buttonSecondaryText }}
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Scroll Indicator --}}
                <div class="mt-5 pt-4">
                    <a href="#" class="text-white opacity-50 d-inline-block" style="animation: float 2s ease-in-out infinite;">
                        <i class="ti tabler-chevrons-down fs-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
