@php
    $cta = $sections['cta'] ?? [];
    $ctaTitle    = $cta['title'][$locale]       ?? __('Ready to build something great?');
    $ctaSubtitle = $cta['subtitle'][$locale]    ?? __('Share a few lines about your product and we will come back with a realistic plan — no heavy sales process.');
    $ctaButtonText = $cta['button_text'][$locale] ?? __('Start a Project');
    $ctaButtonUrl  = $cta['button_url']           ?? '#contactUs';
@endphp

<section id="landingCTA" class="codliy-section position-relative">
    <div class="container position-relative">
        <div class="codliy-card p-4 p-lg-5 overflow-hidden position-relative"
             style="background:linear-gradient(135deg, rgba(0,86,248,0.22) 0%, rgba(10,31,77,0.4) 100%)">
            {{-- decorative grid --}}
            <div class="position-absolute"
                 style="inset:0;background-image:radial-gradient(rgba(255,255,255,.05) 1px, transparent 1px);background-size:24px 24px;opacity:.6"></div>

            <div class="row align-items-center gy-4 position-relative" style="z-index:2">
                <div class="col-lg-8 text-center text-lg-start">
                    <div class="codliy-card__eyebrow mb-2">CALL TO ACTION</div>
                    <h3 class="codliy-section__title mb-2" style="font-size:2rem">{{ $ctaTitle }}</h3>
                    <p class="codliy-card__body mb-4 mb-lg-0" style="max-width:620px">{{ $ctaSubtitle }}</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <a href="{{ $ctaButtonUrl }}" class="btn-codliy px-4 py-2">
                        {{ $ctaButtonText }}
                        <i class="ti tabler-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
