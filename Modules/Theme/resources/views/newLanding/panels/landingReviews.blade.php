@php
    $reviews = $sections['reviews'] ?? [];
    $reviewsBadge = $reviews['badge'][$locale] ?? __('Testimonials');
    $reviewsTitle = $reviews['title'][$locale] ?? __('What teams say about working with us');
    $reviewsDesc  = $reviews['description'][$locale] ?? __('Feedback from founders and product leaders after shipping real software together.');
    $items        = $reviews['items'] ?? [];

    if (empty($items)) {
        $items = [
            [
                'quote'    => __('They moved faster than our internal team — and what they handed over was more maintainable than anything we had before. Tests, CI, runbooks, the works.'),
                'name'     => 'Mira Aydın',
                'role'     => 'CTO, Orbit Labs',
                'avatar'   => asset('codliy/images/testimonials/avatar-1.png'),
                'rating'   => 5,
            ],
            [
                'quote'    => __('Weekly demos with real working software. No slideware, no excuses. Exactly the engineering culture we needed around our product.'),
                'name'     => 'Samir Haddad',
                'role'     => __('Head of Product, Fielder'),
                'avatar'   => asset('codliy/images/testimonials/avatar-2.png'),
                'rating'   => 5,
            ],
            [
                'quote'    => __('The RAG pipeline they built actually holds up in production. Observability from day one meant we could trust what we shipped.'),
                'name'     => 'Leïla Ouali',
                'role'     => __('Founder, Bookstack AI'),
                'avatar'   => asset('codliy/images/testimonials/avatar-3.png'),
                'rating'   => 5,
            ],
        ];
    }
@endphp

<section id="landingReviews" class="codliy-section bg-codliy position-relative">
    <div class="container position-relative">
        <div class="row align-items-end mb-5 g-4">
            <div class="col-lg-8">
                <div class="codliy-section__kicker">{{ $reviewsBadge }}</div>
                <h2 class="codliy-section__title mb-2">{{ $reviewsTitle }}</h2>
                <p class="codliy-section__sub mb-0">{{ $reviewsDesc }}</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <button type="button" id="reviews-previous-btn"
                        class="btn-codliy-outline me-2 scaleX-n1-rtl" style="width:44px;height:44px;padding:0;display:inline-flex;align-items:center;justify-content:center">
                    <i class="ti tabler-chevron-left"></i>
                </button>
                <button type="button" id="reviews-next-btn"
                        class="btn-codliy-outline scaleX-n1-rtl" style="width:44px;height:44px;padding:0;display:inline-flex;align-items:center;justify-content:center">
                    <i class="ti tabler-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="swiper-reviews-carousel overflow-hidden">
            <div class="swiper" id="swiper-reviews">
                <div class="swiper-wrapper">
                    @foreach($items as $item)
                        <div class="swiper-slide">
                            <div class="codliy-card h-100 d-flex flex-column">
                                <div class="mb-3 text-codliy-primary" style="line-height:0">
                                    <i class="ti tabler-quote" style="font-size:30px"></i>
                                </div>
                                <p class="codliy-card__body flex-grow-1 mb-3">
                                    {{ is_array($item['quote'] ?? null) ? ($item['quote'][$locale] ?? '') : ($item['quote'] ?? '') }}
                                </p>
                                <div class="mb-3 text-codliy-primary">
                                    @for($i = 0; $i < ($item['rating'] ?? 5); $i++)
                                        <i class="ti tabler-star-filled"></i>
                                    @endfor
                                </div>
                                <div class="d-flex align-items-center pt-3 border-top border-codliy">
                                    <div class="flex-shrink-0">
                                        @if(!empty($item['avatar']))
                                            <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] ?? '' }}"
                                                 class="rounded-circle" width="44" height="44" style="object-fit:cover;border:1px solid rgba(255,255,255,.08)">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width:44px;height:44px;background:rgba(0,86,248,.12);color:#3B82F6">
                                                <i class="ti tabler-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <div class="fw-medium text-codliy-soft">{{ $item['name'] ?? '' }}</div>
                                        <small class="text-codliy-mute">{{ is_array($item['role'] ?? null) ? ($item['role'][$locale] ?? '') : ($item['role'] ?? '') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
