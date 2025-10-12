@php
    $faq = $sections['faq'] ?? [];
    $faqBadge = $faq['badge'][$locale] ?? 'FAQ';
    $faqTitle = $faq['title'][$locale] ?? 'Frequently asked questions';
    $faqDescription = $faq['description'][$locale] ?? 'Browse through these FAQs to find answers to commonly asked questions.';
    $faqItems = $faq['items'] ?? [];
@endphp

<!-- FAQ: Start -->
<section id="landingFAQ" class="section-py bg-body landing-faq">
    <div class="container">
        <div class="text-center mb-3 pb-1">
            <span class="badge bg-label-primary">{{ $faqBadge }}</span>
        </div>
        <h3 class="text-center mb-1">
            <span class="position-relative fw-bold z-1">{{ $faqTitle }}
                <img
                    src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                    alt="laptop charging"
                    class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
        </h3>
        <p class="text-center mb-5 pb-3">{{ $faqDescription }}</p>
        <div class="row gy-5">
            <div class="col-lg-5">
                <div class="text-center">
                    <img
                        src="{{ asset('assets/img/front-pages/landing-page/faq-boy-with-logos.png') }}"
                        alt="faq boy with logos"
                        class="faq-image" />
                </div>
            </div>
            <div class="col-lg-7">
                <div class="accordion" id="accordionExample">
                    @foreach($faqItems as $index => $item)
                        <div class="card accordion-item {{ $index === 0 ? 'active' : '' }}">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button
                                    type="button"
                                    class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#accordion{{ $index }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="accordion{{ $index }}">
                                    {{ $item['question'][$locale] ?? '' }}
                                </button>
                            </h2>

                            <div id="accordion{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $item['answer'][$locale] ?? '' }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FAQ: End -->
