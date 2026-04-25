@php
    $stats = $sections['stats'] ?? [];
    $statsItems = $stats['items'] ?? [];

    if (empty($statsItems)) {
        $statsItems = [
            ['value' => '12+', 'icon' => 'ti tabler-code',           'label' => __('Production releases / week')],
            ['value' => '40+', 'icon' => 'ti tabler-rocket',         'label' => __('Products shipped end-to-end')],
            ['value' => '99.95%','icon' => 'ti tabler-heartbeat',    'label' => __('Average uptime we operate')],
            ['value' => '0',   'icon' => 'ti tabler-shield-lock',    'label' => __('Reportable security incidents')],
        ];
    }
@endphp

<section id="landingFunFacts" class="codliy-section position-relative">
    <div class="container position-relative">
        <div class="row g-4">
            @foreach($statsItems as $item)
                <div class="col-sm-6 col-lg-3">
                    <div class="codliy-card h-100">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3"
                             style="width:48px;height:48px;background:rgba(var(--codliy-primary-rgb), 0.12);color:var(--codliy-primary);">
                            <i class="{{ $item['icon'] ?? 'ti tabler-star' }}" style="font-size:24px"></i>
                        </div>
                        <div class="codliy-section__title mb-1" style="font-size:2rem;line-height:1">
                            {{ is_array($item['value'] ?? null) ? ($item['value'][$locale] ?? '') : ($item['value'] ?? '') }}
                        </div>
                        <p class="codliy-card__body mb-0 small">
                            {{ is_array($item['label'] ?? null) ? ($item['label'][$locale] ?? '') : ($item['label'] ?? '') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
