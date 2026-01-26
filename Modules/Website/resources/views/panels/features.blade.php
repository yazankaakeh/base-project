@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
@endphp

<section class="section-py bg-body" id="panel-{{ $panel->id }}">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-5">
            @if($badge)
                <span class="badge bg-label-primary rounded-pill px-3 py-2 mb-3">{{ $badge }}</span>
            @endif
            @if($title)
                <h2 class="display-6 fw-bold mb-3">{{ $title }}</h2>
            @endif
            @if($description)
                <p class="text-muted mx-auto" style="max-width: 600px;">{{ $description }}</p>
            @endif
        </div>

        {{-- Features Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4">
                @foreach($panel->activeItems as $item)
                    @php
                        $itemTitle = $item->getTranslation('title', $locale);
                        $itemDescription = $item->getTranslation('content', $locale);
                        $icon = $item->data['icon'] ?? 'tabler-star';
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all"
                             style="transition: all 0.3s ease;">
                            @if($itemImage)
                                <img src="{{ $itemImage }}" class="card-img-top" alt="{{ $itemTitle }}"
                                     style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body p-4">
                                <div class="feature-icon bg-label-primary rounded-3 mb-3 d-inline-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px;">
                                    <i class="ti {{ $icon }} fs-3 text-primary"></i>
                                </div>
                                <h4 class="card-title mb-3">{{ $itemTitle }}</h4>
                                @if($itemDescription)
                                    <p class="card-text text-muted mb-0">{{ $itemDescription }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(9, 44, 76, 0.15) !important;
    }
</style>
