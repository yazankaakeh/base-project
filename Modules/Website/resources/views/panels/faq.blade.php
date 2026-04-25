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

        {{-- FAQ Accordion --}}
        @if($panel->activeItems->count() > 0)
            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    <div class="panel-accordion accordion" id="faqAccordion{{ $panel->id }}">
                        @foreach($panel->activeItems as $index => $item)
                            @php
                                $question = $item->getTranslation('title', $locale);
                                $answer = $item->getTranslation('content', $locale);
                            @endphp
                            <div class="accordion-item panel-animate">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faqCollapse{{ $item->id }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="faqCollapse{{ $item->id }}">
                                        {{ $question }}
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
                    <div class="text-center mt-5 pt-3 panel-animate">
                        <p style="color: var(--panel-text-muted); margin-bottom: 16px;">
                            {{ __('Still have questions?') }}
                        </p>
                        <a href="#contact" class="panel-btn panel-btn-outline-primary">
                            <i class="ti tabler-message-circle"></i>
                            {{ __('Contact Us') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
