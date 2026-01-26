@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
@endphp

<section class="section-py bg-light" id="panel-{{ $panel->id }}">
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

        {{-- Team Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($panel->activeItems as $item)
                    @php
                        $name = $item->getTranslation('title', $locale);
                        $bio = $item->getTranslation('content', $locale);
                        $role = $item->data['role_' . $locale] ?? $item->data['role'] ?? '';
                        $itemImage = $item->getFirstMediaUrl('item_image');
                        $socialLinks = $item->data['social_links'] ?? [];
                    @endphp
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="card h-100 border-0 shadow-sm text-center">
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    @if($itemImage)
                                        <img src="{{ $itemImage }}" alt="{{ $name }}"
                                             class="rounded-circle"
                                             style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="bg-label-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                             style="width: 120px; height: 120px;">
                                            <span class="fs-1 text-primary fw-bold">
                                                {{ strtoupper(substr($name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <h5 class="card-title mb-1">{{ $name }}</h5>
                                @if($role)
                                    <p class="text-primary mb-3">{{ $role }}</p>
                                @endif
                                @if($bio)
                                    <p class="text-muted small mb-3">{{ Str::limit($bio, 100) }}</p>
                                @endif
                                @if(is_array($socialLinks) && count($socialLinks) > 0)
                                    <div class="d-flex justify-content-center gap-2">
                                        @foreach($socialLinks as $platform => $url)
                                            @if($url)
                                                <a href="{{ $url }}" target="_blank"
                                                   class="btn btn-icon btn-sm btn-label-primary rounded-circle">
                                                    <i class="ti tabler-brand-{{ $platform }}"></i>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
