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

<section class="panel-section panel-bg-subtle" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="container">
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
                        // Handle role as array or string
                        $roleData = $item->data['role'] ?? $item->data['role_' . $locale] ?? '';
                        $role = is_array($roleData) ? ($roleData[$locale] ?? $roleData[config('app.fallback_locale')] ?? '') : $roleData;
                        $rating = $item->data['rating'] ?? 5;
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp
                    <div class="col-md-6 col-lg-4 panel-animate">
                        <div class="panel-review-card">
                            {{-- Rating Stars --}}
                            <div class="panel-stars mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="ti tabler-star{{ $i <= $rating ? '-filled' : '' }}" @if($i > $rating) style="opacity: 0.3;" @endif></i>
                                @endfor
                            </div>

                            {{-- Review Content --}}
                            <p class="panel-review-content">"{{ $content }}"</p>

                            {{-- Author --}}
                            <div class="panel-review-author">
                                @if($itemImage)
                                    <img src="{{ $itemImage }}" alt="{{ $name }}" class="panel-avatar">
                                @else
                                    <div class="panel-avatar panel-avatar-placeholder">
                                        {{ mb_strtoupper(mb_substr($name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="panel-review-author-info">
                                    <h6>{{ $name }}</h6>
                                    @if($role)
                                        <span>{{ $role }}</span>
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
