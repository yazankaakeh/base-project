@php
    $nfc = $sections['getNfc'] ?? [];
    $nfcTitle = $nfc['title'][$locale] ?? trans('newLandingPage.getNFCSection.title');
    $nfcDesc  = $nfc['description'][$locale] ?? trans('newLandingPage.getNFCSection.desc');
    $nfcBtn   = $nfc['btn'][$locale] ?? trans('newLandingPage.getNFCSection.btn');
    $nfcUrl   = $nfc['url'] ?? '#contactUs';
@endphp

<section class="codliy-section position-relative">
    <div class="container position-relative">
        <div class="codliy-card p-4 p-lg-5 overflow-hidden position-relative"
             style="background:linear-gradient(135deg, rgba(0,86,248,0.14) 0%, rgba(59,130,246,0.06) 100%)">
            <div class="row align-items-center g-4 position-relative" style="z-index:2">
                <div class="col-lg-7">
                    <div class="codliy-card__eyebrow mb-2">LET'S TALK</div>
                    <h3 class="codliy-section__title mb-2" style="font-size:1.85rem">
                        {{ $nfcTitle }}
                    </h3>
                    <p class="codliy-card__body mb-4">
                        {{ $nfcDesc }}
                    </p>
                    <a href="{{ $nfcUrl }}" class="btn-codliy px-4 py-2">
                        <i class="ti tabler-message-circle me-2"></i>
                        {{ $nfcBtn }}
                    </a>
                </div>
                <div class="col-lg-5 text-center d-none d-lg-block">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-4 position-relative"
                         style="width:220px;height:220px;background:var(--codliy-gradient);border:1px solid rgba(255,255,255,.08)">
                        <i class="ti tabler-send text-codliy-primary" style="font-size:90px"></i>
                        <div class="position-absolute rounded-circle"
                             style="width:40px;height:40px;background:var(--codliy-primary);top:14px;right:14px;box-shadow:0 0 0 8px rgba(0,86,248,.2)"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
