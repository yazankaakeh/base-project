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

<section class="panel-section panel-bg-white" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
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
                    <div class="col-md-6 col-lg-4 panel-animate">
                        <div class="panel-card">
                            @if($itemImage)
                                <div style="overflow: hidden;">
                                    <img src="{{ $itemImage }}"
                                         class="w-100"
                                         alt="{{ $itemTitle }}"
                                         style="height: 180px; object-fit: cover; transition: var(--panel-transition);">
                                </div>
                            @endif
                            <div class="panel-card-body">
                                <div class="panel-icon-box">
                                    <i class="ti {{ $icon }}"></i>
                                </div>
                                <h4 style="font-size: 1.125rem; font-weight: 700; color: var(--panel-text); margin-bottom: 12px;">
                                    {{ $itemTitle }}
                                </h4>
                                @if($itemDescription)
                                    <p style="color: var(--panel-text-muted); line-height: 1.7; margin: 0; font-size: 0.9375rem;">
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
        transform: scale(1.05);
    }
</style>
