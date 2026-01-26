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
         style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">

    {{-- Decorative Elements --}}
    <div class="panel-shape" style="width: 250px; height: 250px; top: -50px; {{ $isRtl ? 'left' : 'right' }}: 10%; background: rgba(var(--panel-primary-rgb), 0.05);"></div>

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

        {{-- Team Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($panel->activeItems as $index => $item)
                    @php
                        $name = $item->getTranslation('title', $locale);
                        $bio = $item->getTranslation('content', $locale);
                        $role = $item->data['role_' . $locale] ?? $item->data['role'] ?? '';
                        $itemImage = $item->getFirstMediaUrl('item_image');
                        $socialLinks = $item->data['social_links'] ?? [];
                    @endphp
                    <div class="col-sm-6 col-lg-4 col-xl-3 panel-animate" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="panel-team-card">
                            <div class="panel-team-avatar">
                                @if($itemImage)
                                    <img src="{{ $itemImage }}" alt="{{ $name }}"
                                         class="panel-avatar panel-avatar-lg">
                                @else
                                    <div class="panel-avatar panel-avatar-lg panel-avatar-placeholder">
                                        {{ mb_strtoupper(mb_substr($name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <h5 class="panel-team-name">{{ $name }}</h5>
                            @if($role)
                                <p class="panel-team-role">{{ $role }}</p>
                            @endif
                            @if($bio)
                                <p class="panel-team-bio">{{ Str::limit($bio, 120) }}</p>
                            @endif
                            @if(is_array($socialLinks) && count($socialLinks) > 0)
                                <div class="panel-social-links">
                                    @foreach($socialLinks as $platform => $url)
                                        @if($url)
                                            <a href="{{ $url }}" target="_blank" rel="noopener"
                                               class="panel-social-link" title="{{ ucfirst($platform) }}">
                                                <i class="ti tabler-brand-{{ $platform }}"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
