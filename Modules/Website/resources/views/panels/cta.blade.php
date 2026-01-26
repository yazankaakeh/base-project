@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
    $buttonText = $panel->settings['button_text'][$locale] ?? null;
    $buttonUrl = $panel->settings['button_url'] ?? '#';
    $backgroundImage = $panel->getFirstMediaUrl('panel_image');
@endphp

<section class="section-py position-relative overflow-hidden" id="panel-{{ $panel->id }}"
         style="background: linear-gradient(135deg, #092C4C 0%, #0d3a5c 50%, #1EAAE7 100%);">
    {{-- Background Pattern --}}
    <div class="position-absolute w-100 h-100 top-0 start-0"
         style="background: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
    </div>

    @if($backgroundImage)
        <div class="position-absolute w-100 h-100 top-0 start-0"
             style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center; opacity: 0.1;">
        </div>
    @endif

    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center text-white">
                @if($badge)
                    <span class="badge bg-white text-primary rounded-pill px-4 py-2 mb-4">
                        {{ $badge }}
                    </span>
                @endif

                @if($title)
                    <h2 class="display-5 fw-bold mb-4">{{ $title }}</h2>
                @endif

                @if($description)
                    <p class="lead opacity-75 mb-5">{{ $description }}</p>
                @endif

                @if($buttonText)
                    <a href="{{ $buttonUrl }}" class="btn btn-primary btn-lg px-5 py-3">
                        {{ $buttonText }}
                        <i class="ti tabler-arrow-right ms-2"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
