@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
@endphp

<section class="section-py bg-body" id="panel-{{ $panel->id }}">
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

        {{-- FAQ Accordion --}}
        @if($panel->activeItems->count() > 0)
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion{{ $panel->id }}">
                        @foreach($panel->activeItems as $index => $item)
                            @php
                                $question = $item->getTranslation('title', $locale);
                                $answer = $item->getTranslation('content', $locale);
                            @endphp
                            <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }} fw-semibold"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#faqCollapse{{ $item->id }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="faqCollapse{{ $item->id }}">
                                        <i class="ti tabler-help-circle me-2 text-primary"></i>
                                        {{ $question }}
                                    </button>
                                </h2>
                                <div id="faqCollapse{{ $item->id }}"
                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                     data-bs-parent="#faqAccordion{{ $panel->id }}">
                                    <div class="accordion-body text-muted">
                                        {!! nl2br(e($answer)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
