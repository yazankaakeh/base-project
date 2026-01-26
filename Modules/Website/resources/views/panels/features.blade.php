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

<section class="panel-section bg-white position-relative" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    {{-- Decorative Shapes --}}
    <div class="panel-shape panel-shape-1" style="background: rgba(var(--panel-primary-rgb), 0.05);"></div>

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

        {{-- Features Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4">
                @foreach($panel->activeItems as $index => $item)
                    @php
                        $itemTitle = $item->getTranslation('title', $locale);
                        $itemDescription = $item->getTranslation('content', $locale);
                        $icon = $item->data['icon'] ?? 'tabler-star';
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp
                    <div class="col-md-6 col-lg-4 panel-animate" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="panel-card">
                            @if($itemImage)
                                <div class="overflow-hidden">
                                    <img src="{{ $itemImage }}" class="w-100" alt="{{ $itemTitle }}"
                                         style="height: 200px; object-fit: cover; transition: var(--panel-transition);">
                                </div>
                            @endif
                            <div class="panel-card-body">
                                <div class="panel-icon-box">
                                    <i class="ti {{ $icon }}"></i>
                                </div>
                                <h4 class="mb-3" style="color: var(--panel-secondary); font-weight: 700;">
                                    {{ $itemTitle }}
                                </h4>
                                @if($itemDescription)
                                    <p class="mb-0" style="color: var(--panel-gray); line-height: 1.7;">
                                        {{ $itemDescription }}
                                    </p>
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
    #panel-{{ $panel->id }} .panel-card:hover img {
        transform: scale(1.08);
    }
</style>
