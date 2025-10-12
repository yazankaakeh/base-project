@php
    $features = $sections['features'] ?? [];
    $featuresBadge = $features['badge'][$locale] ?? trans('newLandingPage.featuresSection.titleSM');
    $featuresTitle = $features['title'][$locale] ?? trans('newLandingPage.featuresSection.description1');
    $featuresDescription = $features['description'][$locale] ?? trans('newLandingPage.featuresSection.description3');
    $featureItems = $features['items'] ?? [];
@endphp

<section id="landingFeatures" class="section-py landing-features">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge bg-label-primary">{{ $featuresBadge }}</span>
        </div>
        <h4 class="text-center mb-1">
            <span class="position-relative fw-extrabold z-1">
                {{ $featuresTitle }}
                <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="laptop charging"
                     class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
        </h4>
        <p class="text-center mb-12">
            {{ $featuresDescription }}
        </p>
        <div class="features-icon-wrapper row gx-0 gy-6 g-sm-12">
            @foreach($featureItems as $item)
                <div class="col-lg-4 col-sm-6 text-center features-icon-box">
                    <div class="mb-4 text-primary text-center">
                        @if(isset($item['icon']))
                            <i class="{{ $item['icon'] }}" style="font-size: 64px;"></i>
                        @else
                            <i class="ti tabler-star" style="font-size: 64px;"></i>
                        @endif
                    </div>
                    <h5 class="mb-2">
                        {{ $item['title'][$locale] ?? '' }}
                    </h5>
                    <p class="features-icon-description">
                        {{ $item['description'][$locale] ?? '' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
