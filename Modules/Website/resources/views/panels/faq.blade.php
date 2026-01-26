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
    <div class="panel-shape" style="width: 300px; height: 300px; top: 10%; {{ $isRtl ? 'right' : 'left' }}: -100px; background: rgba(var(--panel-primary-rgb), 0.04);"></div>
    <div class="panel-shape" style="width: 200px; height: 200px; bottom: 15%; {{ $isRtl ? 'left' : 'right' }}: -50px; background: rgba(var(--panel-primary-rgb), 0.06);"></div>

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

        {{-- FAQ Accordion --}}
        @if($panel->activeItems->count() > 0)
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="panel-accordion accordion" id="faqAccordion{{ $panel->id }}">
                        @foreach($panel->activeItems as $index => $item)
                            @php
                                $question = $item->getTranslation('title', $locale);
                                $answer = $item->getTranslation('content', $locale);
                                $icon = $item->data['icon'] ?? 'tabler-help-circle';
                            @endphp
                            <div class="accordion-item panel-animate" style="animation-delay: {{ $index * 0.1 }}s;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faqCollapse{{ $item->id }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="faqCollapse{{ $item->id }}">
                                        <span class="d-inline-flex align-items-center gap-3">
                                            <i class="ti {{ $icon }}" style="color: var(--panel-primary); font-size: 1.25rem;"></i>
                                            {{ $question }}
                                        </span>
                                    </button>
                                </h2>
                                <div id="faqCollapse{{ $item->id }}"
                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                     data-bs-parent="#faqAccordion{{ $panel->id }}">
                                    <div class="accordion-body">
                                        {!! nl2br(e($answer)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Contact CTA --}}
                    <div class="text-center mt-5 pt-3 panel-animate" style="animation-delay: 0.5s;">
                        <p class="mb-3" style="color: var(--panel-gray);">
                            {{ __('Still have questions?') }}
                        </p>
                        <a href="#contact" class="panel-btn panel-btn-primary">
                            <i class="ti tabler-message-circle"></i>
                            {{ __('Contact Us') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
