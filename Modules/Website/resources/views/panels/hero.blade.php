@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
    $buttonText = $panel->settings['button_text'][$locale] ?? null;
    $buttonUrl = $panel->settings['button_url'] ?? null;
    $buttonSecondaryText = $panel->settings['button_secondary_text'][$locale] ?? null;
    $buttonSecondaryUrl = $panel->settings['button_secondary_url'] ?? null;
    $backgroundImage = $panel->getFirstMediaUrl('panel_image');
@endphp

<section class="hero-section position-relative overflow-hidden" id="panel-{{ $panel->id }}"
         style="min-height: 70vh; display: flex; align-items: center;
                background: linear-gradient(135deg, #092C4C 0%, #0d3a5c 50%, #1EAAE7 100%);">
    {{-- Background Pattern --}}
    <div class="position-absolute w-100 h-100" style="background: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%231EAAE7\' fill-opacity=\'0.08\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    @if($backgroundImage)
        <div class="position-absolute w-100 h-100"
             style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center; opacity: 0.15;">
        </div>
    @endif

    <div class="container position-relative py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center text-white">
                @if($badge)
                    <span class="badge bg-white text-primary rounded-pill px-4 py-2 mb-4 fs-6">
                        {{ $badge }}
                    </span>
                @endif

                @if($title)
                    <h1 class="display-3 fw-bold mb-4">{{ $title }}</h1>
                @endif

                @if($description)
                    <p class="lead opacity-75 mb-5 mx-auto" style="max-width: 700px; font-size: 1.25rem;">
                        {{ $description }}
                    </p>
                @endif

                @if($buttonText || $buttonSecondaryText)
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        @if($buttonText && $buttonUrl)
                            <a href="{{ $buttonUrl }}" class="btn btn-primary btn-lg px-5 py-3">
                                {{ $buttonText }}
                                <i class="ti tabler-arrow-right ms-2"></i>
                            </a>
                        @endif
                        @if($buttonSecondaryText && $buttonSecondaryUrl)
                            <a href="{{ $buttonSecondaryUrl }}" class="btn btn-outline-light btn-lg px-5 py-3">
                                {{ $buttonSecondaryText }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
