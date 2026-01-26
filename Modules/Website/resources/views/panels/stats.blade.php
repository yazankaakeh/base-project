@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
@endphp

<section class="section-py position-relative" id="panel-{{ $panel->id }}"
         style="background: linear-gradient(135deg, #092C4C 0%, #1EAAE7 100%);">
    <div class="container">
        {{-- Section Header --}}
        @if($title || $badge || $description)
            <div class="text-center mb-5 text-white">
                @if($badge)
                    <span class="badge bg-white text-primary rounded-pill px-3 py-2 mb-3">{{ $badge }}</span>
                @endif
                @if($title)
                    <h2 class="display-6 fw-bold mb-3">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="opacity-75 mx-auto" style="max-width: 600px;">{{ $description }}</p>
                @endif
            </div>
        @endif

        {{-- Stats Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($panel->activeItems as $item)
                    @php
                        $label = $item->getTranslation('title', $locale);
                        $number = $item->data['number'] ?? $item->data['value'] ?? '0';
                        $suffix = $item->data['suffix'] ?? '';
                        $icon = $item->data['icon'] ?? 'tabler-chart-bar';
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="text-center text-white">
                            <div class="mb-3">
                                <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                     style="width: 70px; height: 70px;">
                                    <i class="ti {{ $icon }} fs-2"></i>
                                </div>
                            </div>
                            <h2 class="display-5 fw-bold mb-1">
                                <span class="counter" data-target="{{ $number }}">{{ $number }}</span>{{ $suffix }}
                            </h2>
                            <p class="opacity-75 mb-0">{{ $label }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
