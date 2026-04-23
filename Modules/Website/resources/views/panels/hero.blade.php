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

<section class="panel-section panel-section-lg panel-bg-gradient position-relative" id="panel-{{ $panel->id }}"
         style="min-height: 90vh; display: flex; align-items: center;" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

    {{-- Background Image --}}
    @if($backgroundImage)
        <div class="position-absolute w-100 h-100 top-0 start-0" style="opacity: 0.08;">
            <img src="{{ $backgroundImage }}" alt="" class="w-100 h-100" style="object-fit: cover;">
        </div>
    @endif

    {{-- Subtle Pattern --}}
    <div class="panel-decoration panel-dot-pattern" style="inset: 0; opacity: 0.3;"></div>

    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8 text-center">
                {{-- Badge --}}
                @if($badge)
                    <span class="panel-badge" style="background: rgba(255,255,255,0.15); color: #fff; margin-bottom: 24px;">
                        {{ $badge }}
                    </span>
                @endif

                {{-- Title --}}
                @if($title)
                    <h1 class="panel-title panel-title-white" style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 24px;">
                        {{ $title }}
                    </h1>
                @endif

                {{-- Description --}}
                @if($description)
                    <p class="panel-description panel-description-white mx-auto" style="max-width: 640px; margin-bottom: 40px;">
                        {{ $description }}
                    </p>
                @endif

                {{-- Buttons --}}
                @if($buttonText || $buttonSecondaryText)
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        @if($buttonText && $buttonUrl)
                            <a href="{{ $buttonUrl }}" class="panel-btn panel-btn-white panel-btn-lg">
                                {{ $buttonText }}
                                <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if($buttonSecondaryText && $buttonSecondaryUrl)
                            <a href="{{ $buttonSecondaryUrl }}" class="panel-btn panel-btn-ghost panel-btn-lg">
                                <i class="ti tabler-player-play-filled"></i>
                                {{ $buttonSecondaryText }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="position-absolute start-50 translate-middle-x" style="bottom: 40px;">
        <a href="#" class="d-flex flex-column align-items-center text-white text-decoration-none" style="opacity: 0.6;">
            <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px;">{{ __('Scroll') }}</span>
            <i class="ti tabler-chevron-down" style="animation: bounce 2s infinite;"></i>
        </a>
    </div>
</section>

<style>
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(6px); }
    }

    /* Ensure decorative elements don't block interactions */
    #panel-{{ $panel->id }} .panel-decoration {
        pointer-events: none;
    }

    /* Ensure hero section has proper z-index below navbar */
    #panel-{{ $panel->id }} {
        z-index: 1;
    }
</style>
