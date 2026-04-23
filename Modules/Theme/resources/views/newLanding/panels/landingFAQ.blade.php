@php
    $faq = $sections['faq'] ?? [];
    $faqBadge       = $faq['badge'][$locale]       ?? 'FAQ';
    $faqTitle       = $faq['title'][$locale]       ?? __('Frequently asked questions');
    $faqDescription = $faq['description'][$locale] ?? __('Browse through these FAQs to find answers to commonly asked questions.');
    $faqItems       = $faq['items'] ?? [];

    if (empty($faqItems)) {
        $faqItems = [
            [
                'question' => [$locale => __('How long does a typical engagement last?')],
                'answer'   => [$locale => __('Most projects run 8–16 weeks to first production release, then evolve on a monthly cadence as we add features and scale.')],
            ],
            [
                'question' => [$locale => __('Do you sign NDAs and work on proprietary codebases?')],
                'answer'   => [$locale => __('Yes. We sign mutual NDAs, work inside your repos and cloud accounts, and respect your code review and security policies from day one.')],
            ],
            [
                'question' => [$locale => __('Who actually writes the code?')],
                'answer'   => [$locale => __('Senior engineers only. We do not hide juniors on projects. You meet the people doing the work, and they stay with you through the engagement.')],
            ],
            [
                'question' => [$locale => __('How do you handle handover?')],
                'answer'   => [$locale => __('Everything ships with tests, CI/CD, observability dashboards, README and runbooks. We document architectural decisions and record walk-through videos of critical systems.')],
            ],
        ];
    }
@endphp

<section id="landingFAQ" class="codliy-section position-relative">
    <div class="container position-relative">
        <div class="text-center mb-5">
            <div class="codliy-section__kicker">{{ $faqBadge }}</div>
            <h2 class="codliy-section__title mb-2">{{ $faqTitle }}</h2>
            <p class="codliy-section__sub mx-auto">{{ $faqDescription }}</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="accordion accordion-flush" id="codliyFaqAccordion">
                    @foreach($faqItems as $index => $item)
                        <div class="codliy-card mb-3 p-0 overflow-hidden">
                            <h2 class="accordion-header" id="faq-heading-{{ $index }}">
                                <button
                                    type="button"
                                    class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq-collapse-{{ $index }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="faq-collapse-{{ $index }}"
                                    style="background:transparent;color:var(--codliy-text-soft);font-weight:500;box-shadow:none;padding:1.1rem 1.25rem">
                                    {{ is_array($item['question'] ?? null) ? ($item['question'][$locale] ?? '') : ($item['question'] ?? '') }}
                                </button>
                            </h2>
                            <div id="faq-collapse-{{ $index }}"
                                 class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                 data-bs-parent="#codliyFaqAccordion">
                                <div class="accordion-body text-codliy-mute" style="padding:0 1.25rem 1.25rem">
                                    {{ is_array($item['answer'] ?? null) ? ($item['answer'][$locale] ?? '') : ($item['answer'] ?? '') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
