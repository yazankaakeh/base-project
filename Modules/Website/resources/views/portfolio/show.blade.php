@extends('theme::user.layouts.layoutFront')

@section('title', $portfolio->getTranslation('title', $locale))

@section('meta')
    <meta name="description" content="{{ $portfolio->getTranslation('short_description', $locale) }}">
    @if($portfolio->getFirstMediaUrl('featured_image'))
        <meta property="og:image" content="{{ $portfolio->getFirstMediaUrl('featured_image') }}">
    @endif
@endsection

@section('vendor-style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        :root {
            --theme-primary: #1EAAE7;
            --theme-primary-dark: #1890c7;
            --theme-secondary: #092C4C;
            --theme-accent: #ff8510;
            --theme-accent-light: #ff9f43;
        }

        .portfolio-hero {
            position: relative;
            min-height: 60vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--theme-secondary) 0%, #0d3a5c 50%, var(--theme-primary) 100%);
            overflow: hidden;
        }

        .portfolio-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231EAAE7' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .portfolio-hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.15;
        }

        .portfolio-hero-content {
            position: relative;
            z-index: 1;
        }

        /* Gallery Styles */
        .gallery-main-swiper {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(9, 44, 76, 0.15);
            border: 3px solid rgba(30, 170, 231, 0.1);
        }

        .gallery-main-swiper .swiper-slide img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            cursor: zoom-in;
        }

        .gallery-thumbs-swiper {
            margin-top: 1rem;
        }

        .gallery-thumbs-swiper .swiper-slide {
            cursor: pointer;
            opacity: 0.6;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .gallery-thumbs-swiper .swiper-slide-thumb-active {
            opacity: 1;
            box-shadow: 0 0 0 3px var(--theme-primary);
        }

        .gallery-thumbs-swiper .swiper-slide:hover {
            opacity: 1;
        }

        .gallery-thumbs-swiper .swiper-slide img {
            width: 100%;
            height: 70px;
            object-fit: cover;
        }

        /* Lightbox Styles */
        .lightbox-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .lightbox-overlay.active {
            display: flex;
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 133, 16, 0.2);
            border: 2px solid rgba(255, 133, 16, 0.3);
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10001;
        }

        .lightbox-close:hover {
            background: var(--theme-accent);
            border-color: var(--theme-accent);
            transform: rotate(90deg) scale(1.1);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(30, 170, 231, 0.2);
            border: 2px solid rgba(30, 170, 231, 0.3);
            color: white;
            font-size: 28px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10001;
        }

        .lightbox-nav:hover {
            background: var(--theme-primary);
            border-color: var(--theme-primary);
            transform: translateY(-50%) scale(1.1);
        }

        .lightbox-prev {
            left: 20px;
        }

        .lightbox-next {
            right: 20px;
        }

        .lightbox-content {
            max-width: 90vw;
            max-height: 85vh;
        }

        .lightbox-content img {
            max-width: 100%;
            max-height: 85vh;
            object-fit: contain;
            border-radius: 0.5rem;
        }

        .lightbox-counter {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 14px;
            background: var(--theme-secondary);
            padding: 8px 20px;
            border-radius: 20px;
            border: 1px solid rgba(30, 170, 231, 0.3);
        }

        .lightbox-caption {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 16px;
            text-align: center;
            max-width: 80%;
        }

        /* Project Info Cards */
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(9, 44, 76, 0.08);
            transition: all 0.3s ease;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item:hover {
            padding-left: 0.5rem;
        }

        .info-icon {
            width: 45px;
            height: 45px;
            min-width: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .info-item:hover .info-icon {
            transform: scale(1.1);
        }

        /* Feature List */
        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background: rgba(30, 170, 231, 0.08);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .feature-item:hover {
            background: var(--theme-accent);
            color: white;
            transform: translateX(5px);
            border-color: var(--theme-accent);
            box-shadow: 0 4px 15px rgba(255, 133, 16, 0.3);
        }

        .feature-item:hover .feature-icon {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .feature-icon {
            width: 28px;
            height: 28px;
            min-width: 28px;
            border-radius: 50%;
            background: var(--theme-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        /* Testimonial Card */
        .testimonial-card {
            background: linear-gradient(135deg, var(--theme-secondary) 0%, var(--theme-primary) 100%);
            border-radius: 1rem;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -20px;
            left: 20px;
            font-size: 150px;
            font-family: Georgia, serif;
            color: rgba(255, 255, 255, 0.1);
            line-height: 1;
        }

        /* Related Projects */
        .related-card {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(9, 44, 76, 0.1);
            transition: all 0.4s ease;
        }

        .related-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(30, 170, 231, 0.2);
        }

        .related-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .related-card:hover img {
            transform: scale(1.1);
        }

        .related-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, var(--theme-secondary) 0%, rgba(9, 44, 76, 0.5) 40%, transparent 70%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .related-card:hover .related-card-overlay {
            background: linear-gradient(to top, var(--theme-secondary) 0%, rgba(9, 44, 76, 0.7) 50%, transparent 80%);
        }

        /* Technologies Pills */
        .tech-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(30, 170, 231, 0.1);
            border: 1px solid rgba(30, 170, 231, 0.2);
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--theme-secondary);
            transition: all 0.3s ease;
        }

        .tech-pill:hover {
            background: var(--theme-primary);
            border-color: var(--theme-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 170, 231, 0.3);
        }

        /* Card Enhancements */
        .card {
            border: 1px solid rgba(9, 44, 76, 0.08);
        }

        .card:hover {
            box-shadow: 0 10px 40px rgba(9, 44, 76, 0.1);
        }

        .card-header.bg-primary {
            background: linear-gradient(135deg, var(--theme-secondary) 0%, var(--theme-primary) 100%) !important;
        }

        /* Button Enhancements */
        .btn-primary {
            background: var(--theme-primary) !important;
            border-color: var(--theme-primary) !important;
        }

        .btn-primary:hover {
            background: var(--theme-primary-dark) !important;
            border-color: var(--theme-primary-dark) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(30, 170, 231, 0.4);
        }

        /* Badge Styles */
        .badge.bg-primary {
            background: var(--theme-primary) !important;
        }

        .bg-label-primary {
            background: rgba(30, 170, 231, 0.12) !important;
            color: var(--theme-primary) !important;
        }

        .bg-label-success {
            background: rgba(40, 199, 111, 0.12) !important;
        }

        .bg-label-warning {
            background: rgba(255, 153, 0, 0.12) !important;
        }

        .bg-label-info {
            background: rgba(23, 162, 184, 0.12) !important;
        }

        /* Swiper Navigation */
        .swiper-button-next,
        .swiper-button-prev {
            color: var(--theme-primary) !important;
            background: rgba(255, 255, 255, 0.9);
            width: 45px !important;
            height: 45px !important;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(9, 44, 76, 0.15);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 18px !important;
            font-weight: bold;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: var(--theme-primary);
            color: white !important;
        }

        /* Social Share Buttons */
        .btn-facebook {
            background: #1877f2 !important;
            border-color: #1877f2 !important;
            color: white !important;
        }

        .btn-twitter {
            background: #1da1f2 !important;
            border-color: #1da1f2 !important;
            color: white !important;
        }

        .btn-linkedin {
            background: #0077b5 !important;
            border-color: #0077b5 !important;
            color: white !important;
        }

        /* Hero Stat Pills - Better contrast */
        .hero-stat-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.25rem;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .hero-stat-pill:hover {
            background: rgba(30, 170, 231, 0.4);
            border-color: rgba(30, 170, 231, 0.5);
            transform: translateY(-2px);
        }

        .hero-stat-pill i {
            color: var(--theme-accent);
        }

        @media (max-width: 768px) {
            .portfolio-hero {
                min-height: 50vh;
            }

            .gallery-main-swiper .swiper-slide img {
                height: 300px;
            }

            .lightbox-nav {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }

            .hero-stat-pill {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
        }

        /* Toast Notification */
        .copy-toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: linear-gradient(135deg, var(--theme-secondary) 0%, var(--theme-primary) 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            box-shadow: 0 10px 40px rgba(9, 44, 76, 0.3);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .copy-toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .copy-toast .toast-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: toastIconPop 0.5s ease 0.2s both;
        }

        .copy-toast .toast-icon i {
            font-size: 16px;
        }

        .copy-toast .toast-message {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .copy-toast .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: var(--theme-accent);
            border-radius: 0 0 50px 50px;
            animation: toastProgress 2.5s linear forwards;
        }

        @keyframes toastIconPop {
            0% {
                transform: scale(0) rotate(-180deg);
            }
            100% {
                transform: scale(1) rotate(0deg);
            }
        }

        @keyframes toastProgress {
            0% {
                width: 100%;
            }
            100% {
                width: 0%;
            }
        }

        /* Copy button animation */
        .btn-copy-link {
            position: relative;
            overflow: hidden;
        }

        .btn-copy-link::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--theme-primary) 0%, var(--theme-accent) 100%);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .btn-copy-link.copied::after {
            transform: translateX(0);
        }

        .btn-copy-link .btn-text {
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .btn-copy-link.copied .btn-text {
            color: white;
        }

        .btn-copy-link.copied {
            border-color: var(--theme-primary) !important;
        }
    </style>
@endsection

@section('content')
    @php
        $featuredImage = $portfolio->getFirstMediaUrl('featured_image');
        $galleryImages = $portfolio->getMedia('gallery');
        $allImages = collect();
        if ($featuredImage) {
            $allImages->push(['url' => $featuredImage, 'caption' => $portfolio->getTranslation('title', $locale)]);
        }
        foreach ($galleryImages as $img) {
            $allImages->push(['url' => $img->getUrl(), 'caption' => $img->getCustomProperty('caption', '')]);
        }
    @endphp

    {{-- Hero Section --}}
    <section class="portfolio-hero first-section-pt">
        @if($featuredImage)
            <div class="portfolio-hero-bg" style="background-image: url('{{ $featuredImage }}');"></div>
        @endif
        <div class="container portfolio-hero-content py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center text-white">
                    {{-- Breadcrumb --}}
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb breadcrumb-style1 justify-content-center mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('landing.home') }}"
                                   class="text-white-50">{{ __('customer.breadcrumbs.home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('portfolio.index') }}" class="text-white-50">{{ __('Portfolio') }}</a>
                            </li>
                            <li class="breadcrumb-item text-white">{{ Str::limit($portfolio->getTranslation('title', $locale), 30) }}</li>
                        </ol>
                    </nav>

                    @if($portfolio->getTranslation('category', $locale))
                        <span class="badge bg-white text-primary px-3 py-2 mb-3 rounded-pill">
                            <i class="ti tabler-folder me-1"></i>{{ $portfolio->getTranslation('category', $locale) }}
                        </span>
                    @endif

                    <h1 class="display-4 fw-bold mb-3">{{ $portfolio->getTranslation('title', $locale) }}</h1>

                    @if($portfolio->getTranslation('short_description', $locale))
                        <p class="lead opacity-75 mb-4 mx-auto" style="max-width: 700px;">
                            {{ $portfolio->getTranslation('short_description', $locale) }}
                        </p>
                    @endif

                    {{-- Quick Stats --}}
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                        @if($portfolio->client_name)
                            <div class="hero-stat-pill">
                                <i class="ti tabler-user me-2"></i>{{ $portfolio->client_name }}
                            </div>
                        @endif
                        @if($portfolio->completion_date)
                            <div class="hero-stat-pill">
                                <i class="ti tabler-calendar me-2"></i>{{ $portfolio->completion_date->format('M Y') }}
                            </div>
                        @endif
                        @if($portfolio->project_duration)
                            <div class="hero-stat-pill">
                                <i class="ti tabler-clock me-2"></i>{{ $portfolio->project_duration }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="section-py bg-body">
        <div class="container">
            <div class="row g-4 g-lg-5">
                {{-- Left Column - Content --}}
                <div class="col-lg-8">
                    {{-- Image Gallery --}}
                    @if($allImages->count() > 0)
                        <div class="mb-5">
                            {{-- Main Swiper --}}
                            <div class="gallery-main-swiper swiper" id="galleryMain">
                                <div class="swiper-wrapper">
                                    @foreach($allImages as $index => $image)
                                        <div class="swiper-slide">
                                            <img src="{{ $image['url'] }}"
                                                 alt="{{ $image['caption'] ?: $portfolio->getTranslation('title', $locale) }}"
                                                 data-index="{{ $index }}"
                                                 class="gallery-image">
                                        </div>
                                    @endforeach
                                </div>
                                @if($allImages->count() > 1)
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                @endif
                            </div>

                            {{-- Thumbnail Swiper --}}
                            @if($allImages->count() > 1)
                                <div class="gallery-thumbs-swiper swiper" id="galleryThumbs">
                                    <div class="swiper-wrapper">
                                        @foreach($allImages as $image)
                                            <div class="swiper-slide">
                                                <img src="{{ $image['url'] }}"
                                                     alt="Thumbnail">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <p class="text-center text-muted mt-3 mb-0">
                                    <i class="ti tabler-hand-click me-1"></i>
                                    {{ __('Click image to view full size') }} &bull;
                                    <strong>{{ $allImages->count() }}</strong> {{ __('images') }}
                                </p>
                            @endif
                        </div>
                    @endif

                    {{-- Description --}}
                    @if($portfolio->getTranslation('description', $locale))
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <span class="info-icon bg-label-primary me-3">
                                        <i class="ti tabler-file-text"></i>
                                    </span>
                                    <h4 class="mb-0">{{ __('About This Project') }}</h4>
                                </div>
                                <div class="content fs-6 lh-lg">
                                    {!! $portfolio->getTranslation('description', $locale) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Features --}}
                    @if($portfolio->getTranslation('features', $locale))
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <span class="info-icon bg-label-success me-3">
                                        <i class="ti tabler-list-check"></i>
                                    </span>
                                    <h4 class="mb-0">{{ __('Key Features') }}</h4>
                                </div>
                                <div class="row g-2">
                                    @foreach(array_filter(explode("\n", $portfolio->getTranslation('features', $locale))) as $feature)
                                        <div class="col-md-6">
                                            <div class="feature-item">
                                                <span class="feature-icon">
                                                    <i class="ti tabler-check"></i>
                                                </span>
                                                <span>{{ trim($feature) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Challenges & Solutions --}}
                    @if($portfolio->getTranslation('challenges', $locale) || $portfolio->getTranslation('solutions', $locale))
                        <div class="row g-4 mb-4">
                            @if($portfolio->getTranslation('challenges', $locale))
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="info-icon bg-label-warning me-3">
                                                    <i class="ti tabler-bulb"></i>
                                                </span>
                                                <h5 class="mb-0">{{ __('Challenges') }}</h5>
                                            </div>
                                            <p class="text-muted mb-0">{{ $portfolio->getTranslation('challenges', $locale) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($portfolio->getTranslation('solutions', $locale))
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="info-icon bg-label-success me-3">
                                                    <i class="ti tabler-puzzle"></i>
                                                </span>
                                                <h5 class="mb-0">{{ __('Solutions') }}</h5>
                                            </div>
                                            <p class="text-muted mb-0">{{ $portfolio->getTranslation('solutions', $locale) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Testimonial --}}
                    @if($portfolio->getTranslation('testimonial', $locale))
                        <div class="testimonial-card text-white mb-4">
                            <p class="fs-5 mb-4 position-relative" style="z-index: 1;">
                                "{{ $portfolio->getTranslation('testimonial', $locale) }}"
                            </p>
                            @if($portfolio->testimonial_author)
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-md me-3">
                                        <span class="avatar-initial rounded-circle bg-white text-primary">
                                            {{ strtoupper(substr($portfolio->testimonial_author, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-white">{{ $portfolio->testimonial_author }}</h6>
                                        @if($portfolio->testimonial_position)
                                            <small class="opacity-75">{{ $portfolio->testimonial_position }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Right Column - Sidebar --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        {{-- Project Details Card --}}
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-primary text-white py-3">
                                <h5 class="card-title mb-0 text-white">
                                    <i class="ti tabler-info-circle me-2"></i>{{ __('Project Details') }}
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                @if($portfolio->client_name)
                                    <div class="info-item px-4">
                                        <span class="info-icon bg-label-primary">
                                            <i class="ti tabler-user"></i>
                                        </span>
                                        <div>
                                            <small class="text-muted text-uppercase">{{ __('Client') }}</small>
                                            <p class="mb-0 fw-medium">{{ $portfolio->client_name }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($portfolio->client_company)
                                    <div class="info-item px-4">
                                        <span class="info-icon bg-label-info">
                                            <i class="ti tabler-building"></i>
                                        </span>
                                        <div>
                                            <small class="text-muted text-uppercase">{{ __('Company') }}</small>
                                            <p class="mb-0 fw-medium">{{ $portfolio->client_company }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($portfolio->completion_date)
                                    <div class="info-item px-4">
                                        <span class="info-icon bg-label-success">
                                            <i class="ti tabler-calendar-check"></i>
                                        </span>
                                        <div>
                                            <small class="text-muted text-uppercase">{{ __('Completed') }}</small>
                                            <p class="mb-0 fw-medium">{{ $portfolio->completion_date->format('F j, Y') }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($portfolio->project_duration)
                                    <div class="info-item px-4">
                                        <span class="info-icon bg-label-warning">
                                            <i class="ti tabler-hourglass"></i>
                                        </span>
                                        <div>
                                            <small class="text-muted text-uppercase">{{ __('Duration') }}</small>
                                            <p class="mb-0 fw-medium">{{ $portfolio->project_duration }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($portfolio->project_url)
                                    <div class="p-4">
                                        <a href="{{ $portfolio->project_url }}"
                                           target="_blank"
                                           rel="noopener"
                                           class="btn btn-primary btn-lg w-100">
                                            <i class="ti tabler-external-link me-2"></i>{{ __('Visit Live Project') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Technologies --}}
                        @if($portfolio->technologies && count($portfolio->technologies) > 0)
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header py-3">
                                    <h5 class="card-title mb-0">
                                        <i class="ti tabler-code me-2 text-primary"></i>{{ __('Technologies Used') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($portfolio->technologies as $tech)
                                            <span class="tech-pill">
                                                <i class="ti tabler-code me-2 text-primary"
                                                   onerror="this.className='ti tabler-code'"></i>
                                                {{ $tech }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Share --}}
                        <div class="card border-0 shadow-sm">
                            <div class="card-header py-3">
                                <h5 class="card-title mb-0">
                                    <i class="ti tabler-share me-2 text-primary"></i>{{ __('Share This Project') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-2">
                                    <a href="{{ $shareLinks['facebook'] }}"
                                       target="_blank"
                                       class="btn btn-facebook flex-fill">
                                        <i class="ti tabler-brand-facebook"></i>
                                    </a>
                                    <a href="{{ $shareLinks['twitter'] }}"
                                       target="_blank"
                                       class="btn btn-twitter flex-fill">
                                        <i class="ti tabler-brand-twitter"></i>
                                    </a>
                                    <a href="{{ $shareLinks['linkedin'] }}"
                                       target="_blank"
                                       class="btn btn-linkedin flex-fill">
                                        <i class="ti tabler-brand-linkedin"></i>
                                    </a>
                                    <a href="{{ $shareLinks['whatsapp'] }}"
                                       target="_blank"
                                       class="btn btn-success flex-fill">
                                        <i class="ti tabler-brand-whatsapp"></i>
                                    </a>
                                </div>
                                <button type="button"
                                        class="btn btn-outline-secondary w-100 mt-2 btn-copy-link"
                                        id="copyLinkBtn"
                                        onclick="copyToClipboard('{{ url()->current() }}', this)">
                                    <span class="btn-text">
                                        <i class="ti tabler-link me-2"></i>{{ __('Copy Link') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Projects --}}
    @if($relatedPortfolios->count() > 0)
        <section class="section-py bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">{{ __('More Work') }}</span>
                    <h2 class="display-6 fw-bold">{{ __('Related Projects') }}</h2>
                    <p class="text-muted">{{ __('Explore more of our work in similar categories') }}</p>
                </div>

                <div class="row g-4">
                    @foreach($relatedPortfolios as $related)
                        <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('portfolio.show', $related->slug) }}" class="text-decoration-none">
                                <div class="related-card">
                                    @if($related->getFirstMediaUrl('featured_image'))
                                        <img src="{{ $related->getFirstMediaUrl('featured_image') }}"
                                             alt="{{ $related->getTranslation('title', $locale) }}">
                                    @else
                                        <div class="bg-primary d-flex align-items-center justify-content-center"
                                             style="height: 200px;">
                                            <i class="ti tabler-photo display-4 text-white opacity-50"></i>
                                        </div>
                                    @endif
                                    <div class="related-card-overlay">
                                        @if($related->getTranslation('category', $locale))
                                            <span class="badge bg-primary mb-2 align-self-start">
                                                {{ $related->getTranslation('category', $locale) }}
                                            </span>
                                        @endif
                                        <h5 class="text-white mb-0">
                                            {{ Str::limit($related->getTranslation('title', $locale), 40) }}
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('portfolio.index') }}" class="btn btn-primary btn-lg">
                        <i class="ti tabler-grid-dots me-2"></i>{{ __('View All Projects') }}
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Toast Notification --}}
    <div class="copy-toast" id="copyToast">
        <div class="toast-icon">
            <i class="ti tabler-check"></i>
        </div>
        <span class="toast-message">{{ __('Link copied to clipboard!') }}</span>
        <div class="toast-progress"></div>
    </div>

    {{-- Lightbox --}}
    <div class="lightbox-overlay" id="lightboxOverlay">
        <button class="lightbox-close" onclick="closeLightbox()">
            <i class="ti tabler-x"></i>
        </button>
        @if($allImages->count() > 1)
            <button class="lightbox-nav lightbox-prev" onclick="prevImage()">
                <i class="ti tabler-chevron-left"></i>
            </button>
            <button class="lightbox-nav lightbox-next" onclick="nextImage()">
                <i class="ti tabler-chevron-right"></i>
            </button>
        @endif
        <div class="lightbox-content">
            <img src="" alt="" id="lightboxImage">
        </div>
        <div class="lightbox-caption" id="lightboxCaption"></div>
        @if($allImages->count() > 1)
            <div class="lightbox-counter">
                <span id="lightboxCurrent">1</span> / {{ $allImages->count() }}
            </div>
        @endif
    </div>
@endsection

@section('vendor-script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endsection

@push('page-script')
    <script>
        // Gallery Images Data
        const galleryImages = @json($allImages);
        let currentImageIndex = 0;
        let mainSwiper = null;
        let thumbsSwiper = null;

        // Initialize Swipers
        document.addEventListener('DOMContentLoaded', function () {
            const thumbsEl = document.getElementById('galleryThumbs');
            const mainEl = document.getElementById('galleryMain');

            // Initialize thumbs swiper first (if exists)
            if (thumbsEl) {
                thumbsSwiper = new Swiper(thumbsEl, {
                    spaceBetween: 10,
                    slidesPerView: 5,
                    freeMode: true,
                    watchSlidesProgress: true,
                    slideToClickedSlide: true,
                    breakpoints: {
                        0: {slidesPerView: 4},
                        768: {slidesPerView: 5},
                        1024: {slidesPerView: 6}
                    }
                });
            }

            // Initialize main swiper
            if (mainEl) {
                const mainSwiperConfig = {
                    spaceBetween: 10,
                    loop: false,
                    navigation: {
                        nextEl: '#galleryMain .swiper-button-next',
                        prevEl: '#galleryMain .swiper-button-prev',
                    },
                    on: {
                        slideChange: function () {
                            currentImageIndex = this.activeIndex;
                            // Sync thumbs when main slide changes
                            if (thumbsSwiper && thumbsSwiper.slides) {
                                thumbsSwiper.slideTo(currentImageIndex);
                            }
                        }
                    }
                };

                // Add thumbs connection if thumbs swiper exists
                if (thumbsSwiper) {
                    mainSwiperConfig.thumbs = {
                        swiper: thumbsSwiper,
                    };
                }

                mainSwiper = new Swiper(mainEl, mainSwiperConfig);

                // Handle thumbnail clicks manually for better control
                if (thumbsEl) {
                    const thumbSlides = thumbsEl.querySelectorAll('.swiper-slide');
                    thumbSlides.forEach((slide, index) => {
                        slide.addEventListener('click', function () {
                            if (mainSwiper) {
                                mainSwiper.slideTo(index);
                            }
                        });
                    });
                }
            }

            // Click on main image to open lightbox
            document.querySelectorAll('.gallery-image').forEach((img, index) => {
                img.addEventListener('click', () => openLightbox(index));
            });
        });

        // Lightbox Functions
        function openLightbox(index) {
            currentImageIndex = index;
            updateLightboxImage();
            document.getElementById('lightboxOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightboxOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function updateLightboxImage() {
            const img = galleryImages[currentImageIndex];
            document.getElementById('lightboxImage').src = img.url;
            document.getElementById('lightboxCaption').textContent = img.caption || '';
            const counter = document.getElementById('lightboxCurrent');
            if (counter) counter.textContent = currentImageIndex + 1;
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            updateLightboxImage();
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            updateLightboxImage();
        }

        // Keyboard Navigation
        document.addEventListener('keydown', function (e) {
            if (!document.getElementById('lightboxOverlay').classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });

        // Close lightbox on overlay click
        document.getElementById('lightboxOverlay').addEventListener('click', function (e) {
            if (e.target === this) closeLightbox();
        });

        // Copy Link Function with fallback and animation
        function copyToClipboard(text, button) {
            // Try modern clipboard API first
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text)
                    .then(() => showCopySuccess(button))
                    .catch(() => fallbackCopyToClipboard(text, button));
            } else {
                // Fallback for older browsers or non-HTTPS
                fallbackCopyToClipboard(text, button);
            }
        }

        // Fallback copy method using textarea
        function fallbackCopyToClipboard(text, button) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopySuccess(button);
                } else {
                    showCopyError();
                }
            } catch (err) {
                showCopyError();
            }

            document.body.removeChild(textArea);
        }

        // Show success animation
        function showCopySuccess(button) {
            // Button animation
            if (button) {
                button.classList.add('copied');
                const btnText = button.querySelector('.btn-text');
                if (btnText) {
                    const originalHTML = btnText.innerHTML;
                    btnText.innerHTML = '<i class="ti tabler-check me-2"></i>{{ __("Copied!") }}';

                    setTimeout(() => {
                        button.classList.remove('copied');
                        btnText.innerHTML = originalHTML;
                    }, 2500);
                }
            }

            // Show toast
            const toast = document.getElementById('copyToast');
            if (toast) {
                // Reset animation
                toast.classList.remove('show');
                const progress = toast.querySelector('.toast-progress');
                if (progress) {
                    progress.style.animation = 'none';
                    progress.offsetHeight; // Trigger reflow
                    progress.style.animation = 'toastProgress 2.5s linear forwards';
                }

                // Show toast
                setTimeout(() => {
                    toast.classList.add('show');
                }, 10);

                // Hide toast after delay
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        }

        // Show error notification
        function showCopyError() {
            const toast = document.getElementById('copyToast');
            if (toast) {
                const icon = toast.querySelector('.toast-icon i');
                const message = toast.querySelector('.toast-message');

                if (icon) icon.className = 'ti tabler-x';
                if (message) message.textContent = '{{ __("Failed to copy. Please try again.") }}';

                toast.style.background = 'linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%)';
                toast.classList.add('show');

                setTimeout(() => {
                    toast.classList.remove('show');
                    // Reset toast
                    setTimeout(() => {
                        if (icon) icon.className = 'ti tabler-check';
                        if (message) message.textContent = '{{ __("Link copied to clipboard!") }}';
                        toast.style.background = '';
                    }, 400);
                }, 3000);
            }
        }
    </script>
@endpush
