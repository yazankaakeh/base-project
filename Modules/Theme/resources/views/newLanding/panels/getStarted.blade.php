@php
    $start = $sections['getStarted'] ?? [];
    $startTitle = $start['title'][$locale] ?? trans('newLandingPage.getStartedSection.title');
    $startDesc  = $start['description'][$locale] ?? trans('newLandingPage.getStartedSection.desc');
    $startBtn   = $start['btn'][$locale] ?? trans('newLandingPage.getStartedSection.btn');
    $startUrl   = $start['url'] ?? '#contactUs';
@endphp

<section class="codliy-section bg-codliy position-relative">
    <div class="container position-relative">
        <div class="codliy-card p-4 p-lg-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="codliy-card__eyebrow mb-2">GET STARTED</div>
                    <h3 class="codliy-section__title mb-2" style="font-size:1.75rem">
                        {{ $startTitle }}
                    </h3>
                    <p class="codliy-card__body mb-0" style="max-width:640px">
                        {{ $startDesc }}
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ $startUrl }}" class="btn-codliy px-4 py-2">
                        {{ $startBtn }}
                        <i class="ti tabler-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
