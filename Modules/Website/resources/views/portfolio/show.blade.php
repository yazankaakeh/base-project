@extends('theme::user.layouts.layoutFront')

@section('title', $portfolio->getTranslation('title', $locale))

@section('content')
    {{-- Hero Section --}}
    <section class="section-py bg-body first-section-pt">
        <div class="container">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('landing.home') }}">{{ __('Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('portfolio.index') }}">{{ __('Portfolio') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ Str::limit($portfolio->getTranslation('title', $locale), 25) }}</li>
                </ol>
            </nav>

            <div class="row g-4 g-lg-5">
                {{-- Main Content --}}
                <div class="col-lg-8">
                    {{-- Header --}}
                    <div class="mb-4">
                        @if($portfolio->getTranslation('category', $locale))
                            <span class="badge bg-label-primary rounded-pill mb-3">
                                <i class="ti tabler-folder me-1"></i>{{ $portfolio->getTranslation('category', $locale) }}
                            </span>
                        @endif

                        <h1 class="display-6 fw-bold mb-3">{{ $portfolio->getTranslation('title', $locale) }}</h1>

                        @if($portfolio->getTranslation('short_description', $locale))
                            <p class="lead text-muted">{{ $portfolio->getTranslation('short_description', $locale) }}</p>
                        @endif

                        {{-- Meta Info --}}
                        <div class="d-flex flex-wrap gap-4 mt-4">
                            @if($portfolio->client_name)
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-center rounded-pill bg-label-secondary p-2 me-2">
                                        <i class="ti tabler-user ti-sm"></i>
                                    </span>
                                    <div>
                                        <small class="text-muted d-block">{{ __('Client') }}</small>
                                        <span class="fw-medium">{{ $portfolio->client_name }}</span>
                                    </div>
                                </div>
                            @endif
                            @if($portfolio->completion_date)
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-center rounded-pill bg-label-secondary p-2 me-2">
                                        <i class="ti tabler-calendar ti-sm"></i>
                                    </span>
                                    <div>
                                        <small class="text-muted d-block">{{ __('Completed') }}</small>
                                        <span class="fw-medium">{{ $portfolio->completion_date->format('M Y') }}</span>
                                    </div>
                                </div>
                            @endif
                            @if($portfolio->project_duration)
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-center rounded-pill bg-label-secondary p-2 me-2">
                                        <i class="ti tabler-clock ti-sm"></i>
                                    </span>
                                    <div>
                                        <small class="text-muted d-block">{{ __('Duration') }}</small>
                                        <span class="fw-medium">{{ $portfolio->project_duration }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    @if($portfolio->getFirstMediaUrl('featured_image'))
                        <div class="card mb-4 overflow-hidden">
                            <img src="{{ $portfolio->getFirstMediaUrl('featured_image') }}"
                                 class="img-fluid w-100"
                                 style="max-height: 450px; object-fit: cover;"
                                 alt="{{ $portfolio->getTranslation('title', $locale) }}">
                        </div>
                    @endif

                    {{-- Description --}}
                    @if($portfolio->getTranslation('description', $locale))
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge badge-center rounded-pill bg-label-primary p-2 me-2">
                                        <i class="ti tabler-file-text ti-sm"></i>
                                    </span>
                                    <h5 class="mb-0">{{ __('About This Project') }}</h5>
                                </div>
                                <div class="content">
                                    {!! $portfolio->getTranslation('description', $locale) !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Features --}}
                    @if($portfolio->getTranslation('features', $locale))
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge badge-center rounded-pill bg-label-success p-2 me-2">
                                        <i class="ti tabler-list-check ti-sm"></i>
                                    </span>
                                    <h5 class="mb-0">{{ __('Key Features') }}</h5>
                                </div>
                                <ul class="list-unstyled mb-0">
                                    @foreach(array_filter(explode("\n", $portfolio->getTranslation('features', $locale))) as $feature)
                                        <li class="d-flex align-items-center mb-2">
                                            <span class="badge badge-center rounded-pill bg-label-primary p-0 me-2">
                                                <i class="ti tabler-check ti-xs"></i>
                                            </span>
                                            {{ trim($feature) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- Gallery --}}
                    @if($portfolio->getMedia('gallery')->count() > 0)
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge badge-center rounded-pill bg-label-info p-2 me-2">
                                        <i class="ti tabler-photo ti-sm"></i>
                                    </span>
                                    <h5 class="mb-0">{{ __('Gallery') }}</h5>
                                </div>
                                <div class="row g-3">
                                    @foreach($portfolio->getMedia('gallery') as $image)
                                        <div class="col-6 col-md-4">
                                            <a href="{{ $image->getUrl() }}" target="_blank">
                                                <img src="{{ $image->getUrl() }}"
                                                     class="img-fluid rounded"
                                                     style="height: 120px; width: 100%; object-fit: cover;"
                                                     alt="Gallery">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Testimonial --}}
                    @if($portfolio->getTranslation('testimonial', $locale))
                        <div class="card bg-label-primary border-0 mb-4">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <i class="ti tabler-quote text-primary display-5 opacity-50"></i>
                                </div>
                                <p class="mb-4 fs-5">{{ $portfolio->getTranslation('testimonial', $locale) }}</p>
                                @if($portfolio->testimonial_author)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-3">
                                            <span class="avatar-initial rounded-circle bg-primary">
                                                {{ strtoupper(substr($portfolio->testimonial_author, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $portfolio->testimonial_author }}</h6>
                                            @if($portfolio->testimonial_position)
                                                <small class="text-muted">{{ $portfolio->testimonial_position }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 80px;">
                        {{-- Project Details Card --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ti tabler-info-circle me-2 text-primary"></i>{{ __('Project Details') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($portfolio->client_company)
                                    <div class="mb-3 pb-3 border-bottom">
                                        <small class="text-muted text-uppercase fw-medium">{{ __('Company') }}</small>
                                        <p class="mb-0 fw-medium">{{ $portfolio->client_company }}</p>
                                    </div>
                                @endif

                                @if($portfolio->technologies && count($portfolio->technologies) > 0)
                                    <div class="mb-3 pb-3 border-bottom">
                                        <small class="text-muted text-uppercase fw-medium d-block mb-2">{{ __('Technologies') }}</small>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($portfolio->technologies as $tech)
                                                <span class="badge bg-label-secondary">{{ $tech }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($portfolio->project_url)
                                    <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener"
                                       class="btn btn-primary w-100">
                                        <i class="ti tabler-external-link me-2"></i>{{ __('Visit Project') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Share Card --}}
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ti tabler-share me-2 text-primary"></i>{{ __('Share') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-2">
                                    <a href="{{ $shareLinks['facebook'] }}" target="_blank"
                                       class="btn btn-icon btn-label-primary">
                                        <i class="ti tabler-brand-facebook"></i>
                                    </a>
                                    <a href="{{ $shareLinks['twitter'] }}" target="_blank"
                                       class="btn btn-icon btn-label-info">
                                        <i class="ti tabler-brand-twitter"></i>
                                    </a>
                                    <a href="{{ $shareLinks['linkedin'] }}" target="_blank"
                                       class="btn btn-icon btn-label-primary">
                                        <i class="ti tabler-brand-linkedin"></i>
                                    </a>
                                    <a href="{{ $shareLinks['whatsapp'] }}" target="_blank"
                                       class="btn btn-icon btn-label-success">
                                        <i class="ti tabler-brand-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Projects --}}
    @if($relatedPortfolios->count() > 0)
        <section class="section-py bg-body">
            <div class="container">
                <div class="text-center mb-4">
                    <span class="badge bg-label-primary rounded-pill mb-2">{{ __('More Work') }}</span>
                    <h3 class="mb-0">{{ __('Related Projects') }}</h3>
                </div>

                <div class="row g-4">
                    @foreach($relatedPortfolios as $related)
                        <div class="col-sm-6 col-lg-3">
                            <div class="card h-100">
                                @if($related->getFirstMediaUrl('featured_image'))
                                    <img src="{{ $related->getFirstMediaUrl('featured_image') }}"
                                         class="card-img-top"
                                         style="height: 160px; object-fit: cover;"
                                         alt="{{ $related->getTranslation('title', $locale) }}">
                                @else
                                    <div class="card-img-top bg-label-primary d-flex align-items-center justify-content-center"
                                         style="height: 160px;">
                                        <i class="ti tabler-photo display-4 text-primary"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    @if($related->getTranslation('category', $locale))
                                        <span class="badge bg-label-secondary mb-2">
                                            {{ $related->getTranslation('category', $locale) }}
                                        </span>
                                    @endif
                                    <h6 class="card-title mb-0">
                                        <a href="{{ route('portfolio.show', $related->slug) }}" class="text-body stretched-link">
                                            {{ Str::limit($related->getTranslation('title', $locale), 35) }}
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('portfolio.index') }}" class="btn btn-label-primary">
                        <i class="ti tabler-arrow-left me-1"></i>{{ __('View All Projects') }}
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection
