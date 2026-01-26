@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
    $htmlContent = $panel->settings['html_content'][$locale] ?? $panel->settings['html_content'] ?? null;
    $cssClass = $panel->settings['css_class'] ?? '';
    $backgroundColor = $panel->settings['background_color'] ?? '';
    $backgroundStyle = $panel->settings['background_style'] ?? 'light'; // light, dark, gradient, custom
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

@php
    // Determine section classes based on background style
    $sectionClasses = 'panel-section position-relative ' . $cssClass;
    $textClasses = '';

    switch($backgroundStyle) {
        case 'dark':
            $sectionClasses .= ' panel-gradient-secondary';
            $textClasses = 'text-white';
            break;
        case 'gradient':
            $sectionClasses .= ' panel-gradient-primary';
            $textClasses = 'text-white';
            break;
        case 'light':
            $sectionClasses .= ' panel-bg-gradient-light';
            break;
        default:
            $sectionClasses .= ' panel-bg-white';
    }
@endphp

<section class="{{ $sectionClasses }}" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
         @if($backgroundColor && $backgroundStyle === 'custom') style="background-color: {{ $backgroundColor }};" @endif>

    {{-- Decorative Elements --}}
    @if($backgroundStyle === 'gradient' || $backgroundStyle === 'dark')
        <div class="panel-pattern"></div>
        <div class="panel-shape panel-shape-1" style="background: rgba(255,255,255,0.05);"></div>
    @else
        <div class="panel-shape" style="width: 200px; height: 200px; top: -50px; {{ $isRtl ? 'left' : 'right' }}: -50px; background: rgba(var(--panel-primary-rgb), 0.04);"></div>
    @endif

    <div class="container position-relative">
        {{-- Section Header --}}
        @if($title || $badge || $description)
            <div class="panel-header {{ $textClasses }}">
                @if($badge)
                    <span class="panel-badge @if($backgroundStyle === 'gradient' || $backgroundStyle === 'dark') bg-white @endif"
                          @if($backgroundStyle === 'gradient' || $backgroundStyle === 'dark') style="color: var(--panel-primary) !important;" @endif>
                        {{ $badge }}
                    </span>
                @endif
                @if($title)
                    <h2 class="panel-title {{ $textClasses }}">{{ $title }}</h2>
                @endif
                @if($description)
                    <p class="panel-description" @if($backgroundStyle === 'gradient' || $backgroundStyle === 'dark') style="color: rgba(255,255,255,0.8);" @endif>
                        {{ $description }}
                    </p>
                @endif
            </div>
        @endif

        {{-- Custom HTML Content --}}
        @if($htmlContent)
            <div class="custom-content panel-animate {{ $textClasses }}">
                {!! $htmlContent !!}
            </div>
        @endif

        {{-- Custom Items --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4">
                @foreach($panel->activeItems as $index => $item)
                    @php
                        $itemHtml = $item->data['html_content'][$locale] ?? $item->data['html_content'] ?? null;
                        $itemTitle = $item->getTranslation('title', $locale);
                        $itemContent = $item->getTranslation('content', $locale);
                        $itemIcon = $item->data['icon'] ?? null;
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp

                    @if($itemHtml)
                        {{-- Custom HTML Item --}}
                        <div class="col-12 panel-animate {{ $textClasses }}" style="animation-delay: {{ $index * 0.1 }}s;">
                            {!! $itemHtml !!}
                        </div>
                    @else
                        {{-- Default Card Item --}}
                        <div class="col-md-6 col-lg-4 panel-animate" style="animation-delay: {{ $index * 0.1 }}s;">
                            <div class="panel-card">
                                @if($itemImage)
                                    <div class="overflow-hidden">
                                        <img src="{{ $itemImage }}" alt="{{ $itemTitle }}" class="w-100"
                                             style="height: 200px; object-fit: cover; transition: var(--panel-transition);">
                                    </div>
                                @endif
                                <div class="panel-card-body">
                                    @if($itemIcon)
                                        <div class="panel-icon-box">
                                            <i class="ti {{ $itemIcon }}"></i>
                                        </div>
                                    @endif
                                    @if($itemTitle)
                                        <h4 class="mb-3" style="color: var(--panel-secondary); font-weight: 700;">
                                            {{ $itemTitle }}
                                        </h4>
                                    @endif
                                    @if($itemContent)
                                        <div style="color: var(--panel-gray); line-height: 1.7;">
                                            {!! $itemContent !!}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    #panel-{{ $panel->id }} .panel-card:hover img {
        transform: scale(1.05);
    }

    /* Custom content styling */
    #panel-{{ $panel->id }} .custom-content h1,
    #panel-{{ $panel->id }} .custom-content h2,
    #panel-{{ $panel->id }} .custom-content h3,
    #panel-{{ $panel->id }} .custom-content h4,
    #panel-{{ $panel->id }} .custom-content h5,
    #panel-{{ $panel->id }} .custom-content h6 {
        color: {{ ($backgroundStyle === 'gradient' || $backgroundStyle === 'dark') ? '#fff' : 'var(--panel-secondary)' }};
        font-weight: 700;
        margin-bottom: 1rem;
    }

    #panel-{{ $panel->id }} .custom-content p {
        color: {{ ($backgroundStyle === 'gradient' || $backgroundStyle === 'dark') ? 'rgba(255,255,255,0.8)' : 'var(--panel-gray)' }};
        line-height: 1.7;
    }

    #panel-{{ $panel->id }} .custom-content a {
        color: var(--panel-primary);
        text-decoration: none;
        transition: var(--panel-transition);
    }

    #panel-{{ $panel->id }} .custom-content a:hover {
        text-decoration: underline;
    }

    #panel-{{ $panel->id }} .custom-content img {
        max-width: 100%;
        height: auto;
        border-radius: var(--panel-radius);
    }

    #panel-{{ $panel->id }} .custom-content ul,
    #panel-{{ $panel->id }} .custom-content ol {
        padding-{{ $isRtl ? 'right' : 'left' }}: 1.5rem;
        color: {{ ($backgroundStyle === 'gradient' || $backgroundStyle === 'dark') ? 'rgba(255,255,255,0.8)' : 'var(--panel-gray)' }};
    }

    #panel-{{ $panel->id }} .custom-content blockquote {
        border-{{ $isRtl ? 'right' : 'left' }}: 4px solid var(--panel-primary);
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        background: rgba(var(--panel-primary-rgb), 0.05);
        border-radius: 0 var(--panel-radius) var(--panel-radius) 0;
    }
</style>
