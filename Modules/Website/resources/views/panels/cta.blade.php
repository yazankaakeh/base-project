@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
    $buttonText = $panel->settings['button_text'][$locale] ?? null;
    $buttonUrl = $panel->settings['button_url'] ?? '#';
    $buttonSecondaryText = $panel->settings['button_secondary_text'][$locale] ?? null;
    $buttonSecondaryUrl = $panel->settings['button_secondary_url'] ?? '#';
    $backgroundImage = $panel->getFirstMediaUrl('panel_image');
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

<section class="panel-section panel-gradient-primary position-relative overflow-hidden" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    {{-- Background Pattern --}}
    <div class="panel-pattern"></div>

    {{-- Animated Shapes --}}
    <div class="panel-shape" style="width: 300px; height: 300px; top: -100px; {{ $isRtl ? 'left' : 'right' }}: -100px; background: rgba(255,255,255,0.05);"></div>
    <div class="panel-shape" style="width: 200px; height: 200px; bottom: -50px; {{ $isRtl ? 'right' : 'left' }}: 10%; background: rgba(255,255,255,0.08); animation-delay: 3s;"></div>
    <div class="panel-shape" style="width: 100px; height: 100px; top: 30%; {{ $isRtl ? 'right' : 'left' }}: 5%; background: rgba(255,255,255,0.04); animation-delay: 1.5s;"></div>

    @if($backgroundImage)
        <div class="position-absolute w-100 h-100 top-0 start-0"
             style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center; opacity: 0.1;">
        </div>
    @endif

    <div class="container position-relative panel-cta-content">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8 text-center text-white">
                @if($badge)
                    <span class="panel-badge bg-white mb-4" style="color: var(--panel-primary) !important;">
                        {{ $badge }}
                    </span>
                @endif

                @if($title)
                    <h2 class="panel-title text-white mb-4" style="font-size: clamp(2rem, 5vw, 3rem);">
                        {{ $title }}
                    </h2>
                @endif

                @if($description)
                    <p class="panel-description mb-5" style="color: rgba(255,255,255,0.85); max-width: 600px;">
                        {{ $description }}
                    </p>
                @endif

                @if($buttonText || $buttonSecondaryText)
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        @if($buttonText)
                            <a href="{{ $buttonUrl }}" class="panel-btn panel-btn-primary" style="background: #fff; color: var(--panel-primary);">
                                {{ $buttonText }}
                                <i class="ti tabler-arrow-{{ $isRtl ? 'left' : 'right' }}"></i>
                            </a>
                        @endif
                        @if($buttonSecondaryText)
                            <a href="{{ $buttonSecondaryUrl }}" class="panel-btn panel-btn-outline">
                                {{ $buttonSecondaryText }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
