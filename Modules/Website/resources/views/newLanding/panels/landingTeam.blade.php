@php
    $team = $sections['team'] ?? [];
    $teamBadge       = $team['badge'][$locale]       ?? trans('newLandingPage.howItWorksSection.titleSm');
    $teamTitle       = $team['title'][$locale]       ?? trans('newLandingPage.howItWorksSection.title1');
    $teamDescription = $team['description'][$locale] ?? trans('newLandingPage.howItWorksSection.title2');
    $teamMembers     = $team['members'] ?? [];

    // Static fallback — our "how we work" steps map to numbered milestones.
    $steps = [
        [
            'icon'  => 'ti tabler-phone',
            'title' => trans('newLandingPage.howItWorksSection.cardTitle1'),
            'desc'  => trans('newLandingPage.howItWorksSection.cardDesc1'),
        ],
        [
            'icon'  => 'ti tabler-file-description',
            'title' => trans('newLandingPage.howItWorksSection.cardTitle2'),
            'desc'  => trans('newLandingPage.howItWorksSection.cardDesc2'),
        ],
        [
            'icon'  => 'ti tabler-code',
            'title' => trans('newLandingPage.howItWorksSection.cardTitle3'),
            'desc'  => trans('newLandingPage.howItWorksSection.cardDesc3'),
        ],
        [
            'icon'  => 'ti tabler-rocket',
            'title' => trans('newLandingPage.howItWorksSection.cardTitle4'),
            'desc'  => trans('newLandingPage.howItWorksSection.cardDesc4'),
        ],
    ];
@endphp

<section id="theHow" class="codliy-section bg-codliy position-relative">
    <div class="container position-relative">
        <div class="text-center mb-5">
            <div class="codliy-section__kicker">{{ $teamBadge }}</div>
            <h2 class="codliy-section__title">{{ $teamTitle }}</h2>
            @if($teamDescription && $teamDescription !== $teamTitle)
                <p class="codliy-section__sub mx-auto">{{ $teamDescription }}</p>
            @endif
        </div>

        @if(!empty($teamMembers))
            {{-- CMS-driven team members --}}
            <div class="row g-4">
                @foreach($teamMembers as $member)
                    <div class="col-lg-3 col-md-6">
                        <div class="codliy-card h-100 text-center">
                            <div class="mx-auto mb-3 overflow-hidden rounded-circle"
                                 style="width:120px;height:120px;background:var(--codliy-gradient);border:1px solid rgba(255,255,255,.08)">
                                @if(!empty($member['avatar']))
                                    <img src="{{ asset($member['avatar']) }}"
                                         alt="{{ $member['name'] ?? '' }}"
                                         class="w-100 h-100" style="object-fit:cover">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-codliy-primary">
                                        <i class="ti tabler-user" style="font-size:40px"></i>
                                    </div>
                                @endif
                            </div>
                            <h4 class="codliy-card__title mb-1" style="font-size:1.05rem">{{ $member['name'] ?? '' }}</h4>
                            <div class="text-codliy-mute small">{{ $member['position'][$locale] ?? '' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Fallback: render as "how we work" timeline --}}
            <div class="row g-4 position-relative">
                {{-- connector line on desktop --}}
                <div class="position-absolute d-none d-lg-block"
                     style="left:0;right:0;top:54px;height:1px;background:linear-gradient(90deg, transparent, rgba(var(--codliy-primary-rgb), 0.35), transparent);z-index:0"></div>

                @foreach($steps as $i => $step)
                    <div class="col-lg-3 col-md-6 position-relative" style="z-index:1">
                        <div class="codliy-card h-100 text-center">
                            <div class="mx-auto mb-3 d-inline-flex align-items-center justify-content-center rounded-4 position-relative"
                                 style="width:72px;height:72px;background:rgba(var(--codliy-primary-rgb), 0.1);border:1px solid rgba(var(--codliy-primary-rgb), 0.25);color:var(--codliy-primary);">
                                <i class="{{ $step['icon'] }}" style="font-size:32px"></i>
                                <span class="position-absolute d-flex align-items-center justify-content-center rounded-circle fw-semibold"
                                      style="top:-10px;right:-10px;width:28px;height:28px;background:var(--codliy-primary);color:#fff;font-size:.75rem">
                                    {{ $i + 1 }}
                                </span>
                            </div>
                            <h4 class="codliy-card__title mb-2" style="font-size:1.05rem">{{ $step['title'] }}</h4>
                            <p class="codliy-card__body mb-0 small">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
