@php
    // Support both dynamic panel data and fallback to sections
    if (isset($panel)) {
        $reviewsBadge = $panel['settings']['badge'][$locale] ?? 'Real Customers Reviews';
        $reviewsTitle = $panel['title'][$locale] ?? 'What people say';
        $reviewsDescription = $panel['settings']['description'][$locale] ?? 'See what our customers have to say about their experience.';
        $reviewItems = $items ?? collect();
    } else {
        $reviews = $sections['reviews'] ?? [];
        $reviewsBadge = $reviews['badge'][$locale] ?? 'Real Customers Reviews';
        $reviewsTitle = $reviews['title'][$locale] ?? 'What people say';
        $reviewsDescription = $reviews['description'][$locale] ?? 'See what our customers have to say about their experience.';
        $reviewItems = collect();
    }
@endphp

<!-- Real customers reviews: Start -->
<section id="landingReviews" class="section-py bg-body landing-reviews pb-0">
    <!-- What people say slider: Start -->
    <div class="container">
        <div class="row align-items-center gx-0 gy-4 g-lg-5">
            <div class="col-md-6 col-lg-5 col-xl-3">
                <div class="mb-3 pb-1">
                    <span class="badge bg-label-primary">{{ $reviewsBadge }}</span>
                </div>
                <h3 class="mb-1">
                    <span class="position-relative fw-bold z-1">{{ $reviewsTitle }}
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                             alt="laptop charging"
                             class="section-title-img position-absolute object-fit-contain bottom-0 z-n1"/>
                    </span>
                </h3>
                <p class="mb-3 mb-md-5">{{ $reviewsDescription }}</p>
                <div class="landing-reviews-btns">
                    <button id="reviews-previous-btn" class="btn btn-label-primary reviews-btn me-3 scaleX-n1-rtl" type="button">
                        <i class="ti tabler-chevron-left ti-sm"></i>
                    </button>
                    <button id="reviews-next-btn" class="btn btn-label-primary reviews-btn scaleX-n1-rtl" type="button">
                        <i class="ti tabler-chevron-right ti-sm"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 col-lg-7 col-xl-9">
                <div class="swiper-reviews-carousel overflow-hidden mb-5 pb-md-2 pb-md-3">
                    <div class="swiper" id="swiper-reviews">
                        <div class="swiper-wrapper">
                            @if($reviewItems->count() > 0)
                                @foreach($reviewItems as $review)
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                @if(isset($review['media']['item_image']) && $review['media']['item_image'])
                                                    <div class="mb-3">
                                                        <img src="{{ $review['media']['item_image'] }}" alt="client logo" class="client-logo img-fluid"/>
                                                    </div>
                                                @endif
                                                <p>"{{ $review['content'][$locale] ?? '' }}"</p>
                                                <div class="text-warning mb-3">
                                                    @php $rating = intval($review['data']['rating'] ?? 5); @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="ti {{ $i <= $rating ? 'tabler-star-filled' : 'tabler-star' }} ti-sm"></i>
                                                    @endfor
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2 avatar-sm">
                                                        <img src="{{ $review['media']['item_image'] ?? asset('assets/img/avatars/1.png') }}"
                                                             alt="Avatar" class="rounded-circle"/>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $review['data']['name'] ?? $review['title'][$locale] ?? '' }}</h6>
                                                        <p class="small text-muted mb-0">{{ $review['data']['role'][$locale] ?? '' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{-- Fallback static reviews --}}
                                @for($i = 1; $i <= 4; $i++)
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <p>"Great service and excellent product quality!"</p>
                                                <div class="text-warning mb-3">
                                                    @for($s = 1; $s <= 5; $s++)
                                                        <i class="ti tabler-star-filled ti-sm"></i>
                                                    @endfor
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/' . $i . '.png') }}" alt="Avatar" class="rounded-circle"/>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Customer {{ $i }}</h6>
                                                        <p class="small text-muted mb-0">Happy Client</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- What people say slider: End -->
</section>
<!-- Real customers reviews: End -->
