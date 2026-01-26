@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

<section class="panel-section position-relative" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
         style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">

    {{-- Decorative Elements --}}
    <div class="panel-shape" style="width: 200px; height: 200px; top: 20%; {{ $isRtl ? 'right' : 'left' }}: -80px; background: rgba(var(--panel-primary-rgb), 0.04);"></div>
    <div class="panel-shape" style="width: 150px; height: 150px; bottom: 10%; {{ $isRtl ? 'left' : 'right' }}: 5%; background: rgba(var(--panel-primary-rgb), 0.06);"></div>

    <div class="container position-relative">
        {{-- Section Header --}}
        <div class="panel-header">
            @if($badge)
                <span class="panel-badge">{{ $badge }}</span>
            @endif
            @if($title)
                <h2 class="panel-title">{{ $title }}</h2>
            @endif
            @if($description)
                <p class="panel-description">{{ $description }}</p>
            @endif
        </div>

        {{-- Reviews Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4">
                @foreach($panel->activeItems as $index => $item)
                    @php
                        $name = $item->getTranslation('title', $locale);
                        $content = $item->getTranslation('content', $locale);
                        $role = $item->data['role_' . $locale] ?? $item->data['role'] ?? '';
                        $rating = $item->data['rating'] ?? 5;
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp
                    <div class="col-md-6 col-lg-4 panel-animate" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="panel-review-card">
                            {{-- Quote Icon --}}
                            <span class="panel-review-quote">"</span>

                            {{-- Rating Stars --}}
                            <div class="panel-stars mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating)
                                        <i class="ti tabler-star-filled"></i>
                                    @else
                                        <i class="ti tabler-star" style="opacity: 0.3;"></i>
                                    @endif
                                @endfor
                            </div>

                            {{-- Review Content --}}
                            <p class="panel-review-content">{{ $content }}</p>

                            {{-- Author --}}
                            <div class="panel-review-author">
                                @if($itemImage)
                                    <img src="{{ $itemImage }}" alt="{{ $name }}" class="panel-avatar">
                                @else
                                    <div class="panel-avatar panel-avatar-placeholder" style="width: 55px; height: 55px; font-size: 1.25rem;">
                                        {{ mb_strtoupper(mb_substr($name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1" style="color: var(--panel-secondary); font-weight: 600;">{{ $name }}</h6>
                                    @if($role)
                                        <small style="color: var(--panel-gray);">{{ $role }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
