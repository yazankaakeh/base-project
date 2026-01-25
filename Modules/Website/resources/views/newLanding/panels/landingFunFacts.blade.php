@php
    // Support both dynamic panel data and fallback to static
    if (isset($panel)) {
        $statItems = $items ?? collect();
    } else {
        $statItems = collect();
    }

    // Color classes for stat cards
    $colorClasses = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
@endphp

<!-- Fun facts / Stats: Start -->
<section id="landingFunFacts" class="section-py landing-fun-facts">
    <div class="container">
        <div class="row gy-3">
            @if($statItems->count() > 0)
                @foreach($statItems as $index => $stat)
                    @php
                        $color = $colorClasses[$index % count($colorClasses)];
                    @endphp
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border border-label-{{ $color }} shadow-none">
                            <div class="card-body text-center">
                                <div class="mb-2 text-{{ $color }}">
                                    @if(isset($stat['data']['icon']))
                                        <i class="{{ $stat['data']['icon'] }}" style="font-size: 48px;"></i>
                                    @else
                                        <i class="ti tabler-chart-bar" style="font-size: 48px;"></i>
                                    @endif
                                </div>
                                <h5 class="h2 mb-1">{{ $stat['data']['value'] ?? $stat['title'][$locale] ?? '' }}</h5>
                                <p class="fw-medium mb-0">
                                    {!! nl2br(e($stat['content'][$locale] ?? '')) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Fallback static stats --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="card border border-label-primary shadow-none">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/laptop.png') }}" alt="laptop" class="mb-2"/>
                            <h5 class="h2 mb-1">7.1k+</h5>
                            <p class="fw-medium mb-0">Support Tickets<br/>Resolved</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border border-label-success shadow-none">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/user-success.png') }}" alt="users" class="mb-2"/>
                            <h5 class="h2 mb-1">50k+</h5>
                            <p class="fw-medium mb-0">Join creatives<br/>community</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border border-label-info shadow-none">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/diamond-info.png') }}" alt="diamond" class="mb-2"/>
                            <h5 class="h2 mb-1">4.8/5</h5>
                            <p class="fw-medium mb-0">Highly Rated<br/>Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border border-label-warning shadow-none">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/check-warning.png') }}" alt="check" class="mb-2"/>
                            <h5 class="h2 mb-1">100%</h5>
                            <p class="fw-medium mb-0">Money Back<br/>Guarantee</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Fun facts / Stats: End -->
