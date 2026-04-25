@php
    $hero = $sections['hero'] ?? [];
    $heroTitle       = $hero['title'][$locale]       ?? trans('newLandingPage.heroSection.title');
    $heroSubtitle    = $hero['subtitle'][$locale]    ?? '';
    $heroDescription = $hero['description'][$locale] ?? trans('newLandingPage.heroSection.description');
    $heroCtaText     = $hero['cta_text'][$locale]    ?? trans('newLandingPage.heroSection.getStarted');
    $heroCtaUrl      = $hero['cta_url']              ?? '#landingFeatures';
    $heroSecondaryText = $hero['secondary_cta_text'][$locale] ?? trans('newLandingPage.heroSection.seeWork');
    $heroSecondaryUrl  = $hero['secondary_cta_url'] ?? '#landingContact';
    $heroImage = $hero['image'] ?? 'codliy/images/hero.png';
@endphp

<!-- Hero: Start -->
<section id="hero-animation">
    <div id="landingHero" class="codliy-hero position-relative">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <div class="codliy-hero__kicker">
                        Codliy &middot; Software Studio
                    </div>
                    <h1 class="codliy-hero__title mb-3">
                        {{ $heroTitle }}
                    </h1>
                    @if($heroSubtitle)
                        <p class="codliy-hero__sub mb-2 mx-auto mx-lg-0" style="opacity:.9">
                            {{ $heroSubtitle }}
                        </p>
                    @endif
                    <p class="codliy-hero__sub mb-4 mx-auto mx-lg-0">
                        {!! $heroDescription !!}
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <a href="{{ $heroCtaUrl }}" class="btn-codliy">
                            {{ $heroCtaText }}
                        </a>
                        <a href="{{ $heroSecondaryUrl }}" class="btn-codliy-outline">
                            {{ $heroSecondaryText }}
                        </a>
                    </div>
                    <div class="codliy-hero__stack mt-5 d-flex flex-wrap gap-4 justify-content-center justify-content-lg-start text-codliy-mute small">
                        <span>Laravel &middot; PHP 8.3+</span>
                        <span>Vue 3 &middot; React &middot; Next.js</span>
                        <span>AWS &middot; GCP &middot; Cloudflare</span>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="position-relative">
                        <img src="{{ asset($heroImage) }}"
                             alt="Codliy systems diagram"
                             class="img-fluid rounded-4 shadow-lg"
                             style="width:100%;height:auto;border:1px solid rgba(255,255,255,0.08)"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero: End -->
