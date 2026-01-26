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

        {{-- Reviews Carousel/Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4">
                @foreach($panel->activeItems as $item)
                    @php
                        $name = $item->getTranslation('title', $locale);
                        $content = $item->getTranslation('content', $locale);
                        $role = $item->data['role_' . $locale] ?? $item->data['role'] ?? '';
                        $rating = $item->data['rating'] ?? 5;
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                {{-- Rating Stars --}}
                                <div class="mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="ti tabler-star{{ $i <= $rating ? '-filled' : '' }} text-warning"></i>
                                    @endfor
                                </div>

                                {{-- Quote --}}
                                <div class="position-relative mb-4">
                                    <i class="ti tabler-quote position-absolute text-primary opacity-25"
                                       style="font-size: 3rem; top: -10px; left: -10px;"></i>
                                    <p class="text-muted mb-0 ps-4">{{ $content }}</p>
                                </div>

                                {{-- Author --}}
                                <div class="d-flex align-items-center mt-auto">
                                    @if($itemImage)
                                        <img src="{{ $itemImage }}" alt="{{ $name }}"
                                             class="rounded-circle me-3"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-label-primary rounded-circle me-3 d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px;">
                                            <span class="fw-bold text-primary">
                                                {{ strtoupper(substr($name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $name }}</h6>
                                        @if($role)
                                            <small class="text-muted">{{ $role }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
