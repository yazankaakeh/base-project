@php
    $features = $sections['features'] ?? [];
    $featuresBadge       = $features['badge'][$locale]       ?? trans('newLandingPage.featuresSection.titleSM');
    $featuresTitle       = $features['title'][$locale]       ?? trans('newLandingPage.featuresSection.description1');
    $featuresDescription = $features['description'][$locale] ?? trans('newLandingPage.featuresSection.description3');
    $featureItems        = $features['items'] ?? [];

    // Map item slug/title to Codliy service illustration.
    $serviceImages = [
        'web'    => 'codliy/images/services/web.png',
        'mobile' => 'codliy/images/services/mobile.png',
        'cloud'  => 'codliy/images/services/cloud.png',
        'ai'     => 'codliy/images/services/ai.png',
        'uiux'   => 'codliy/images/services/uiux.png',
    ];

    $resolveImg = function (array $item) use ($serviceImages) {
        if (!empty($item['image']))  return $item['image'];
        if (!empty($item['slug']) && isset($serviceImages[$item['slug']])) return $serviceImages[$item['slug']];

        $title = strtolower($item['title']['en'] ?? '');
        foreach ($serviceImages as $key => $img) {
            if (str_contains($title, $key)) return $img;
        }
        return 'codliy/images/services/web.png';
    };
@endphp

<section id="landingFeatures" class="codliy-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="codliy-section__kicker">{{ $featuresBadge }}</div>
            <h2 class="codliy-section__title">{{ $featuresTitle }}</h2>
            <p class="codliy-section__sub mx-auto">{{ $featuresDescription }}</p>
        </div>
        <div class="row g-4">
            @foreach($featureItems as $i => $item)
                <div class="col-lg-4 col-md-6">
                    <div class="codliy-card h-100">
                        <div class="codliy-card__eyebrow">
                            {{ sprintf('SERVICE · 0%d', $i + 1) }}
                        </div>
                        <img src="{{ asset($resolveImg($item)) }}"
                             alt="{{ $item['title'][$locale] ?? '' }}"
                             class="img-fluid rounded-3 mb-3"
                             style="width:100%;height:auto;border:1px solid rgba(255,255,255,0.06)"/>
                        <h3 class="codliy-card__title">
                            {{ $item['title'][$locale] ?? '' }}
                        </h3>
                        <p class="codliy-card__body mb-0">
                            {{ $item['description'][$locale] ?? '' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
