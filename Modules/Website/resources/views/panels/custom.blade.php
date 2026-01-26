@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
    $htmlContent = $panel->settings['html_content'][$locale] ?? $panel->settings['html_content'] ?? null;
    $cssClass = $panel->settings['css_class'] ?? '';
    $backgroundColor = $panel->settings['background_color'] ?? '';
@endphp

<section class="section-py {{ $cssClass }}" id="panel-{{ $panel->id }}"
         @if($backgroundColor) style="background-color: {{ $backgroundColor }};" @endif>
    <div class="container">
        {{-- Section Header --}}
        @if($title || $badge || $description)
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
        @endif

        {{-- Custom HTML Content --}}
        @if($htmlContent)
            <div class="custom-content">
                {!! $htmlContent !!}
            </div>
        @endif

        {{-- Custom Items --}}
        @if($panel->activeItems->count() > 0)
            @foreach($panel->activeItems as $item)
                @php
                    $itemHtml = $item->data['html_content'][$locale] ?? $item->data['html_content'] ?? null;
                @endphp
                @if($itemHtml)
                    <div class="custom-item mb-4">
                        {!! $itemHtml !!}
                    </div>
                @else
                    {{-- Fallback to title/content --}}
                    @php
                        $itemTitle = $item->getTranslation('title', $locale);
                        $itemContent = $item->getTranslation('content', $locale);
                    @endphp
                    @if($itemTitle || $itemContent)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                @if($itemTitle)
                                    <h4>{{ $itemTitle }}</h4>
                                @endif
                                @if($itemContent)
                                    <div class="content">{!! $itemContent !!}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        @endif
    </div>
</section>
