@extends('theme::user.layouts.layoutFront')

@section('title', __('Portfolio'))

@section('content')
    {{-- Hero Section --}}
    <section class="section-py bg-primary first-section-pt">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center py-4">
                    <span class="badge bg-white text-primary mb-3">{{ __('Our Work') }}</span>
                    <h1 class="display-5 fw-bold text-white mb-3">{{ __('Portfolio') }}</h1>
                    <p class="lead text-white opacity-75 mb-4">{{ __('Explore our latest projects and see how we bring ideas to life') }}</p>

                    {{-- Search --}}
                    <form action="{{ route('portfolio.index') }}" method="GET" class="mx-auto" style="max-width: 500px;">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-0">
                                <i class="ti tabler-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-0"
                                   placeholder="{{ __('Search projects...') }}" value="{{ $search ?? '' }}">
                            <button type="submit" class="btn btn-dark">{{ __('Search') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Category Filter --}}
    @if(count($categories) > 0)
        <section class="py-4 bg-body border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="{{ route('portfolio.index') }}"
                       class="btn {{ !$category ? 'btn-primary' : 'btn-label-primary' }} rounded-pill">
                        <i class="ti tabler-apps me-1"></i>{{ __('All') }}
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('portfolio.index', ['category' => $cat]) }}"
                           class="btn {{ $category === $cat ? 'btn-primary' : 'btn-label-secondary' }} rounded-pill">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Active Filter Info --}}
    @if($search || $category)
        <section class="py-3 bg-label-secondary">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="ti tabler-filter me-2"></i>
                        @if($search)
                            {{ __('Results for') }}: <strong>"{{ $search }}"</strong>
                        @else
                            {{ __('Category') }}: <strong>{{ $category }}</strong>
                        @endif
                        <span class="text-muted ms-2">({{ $portfolios->total() }} {{ __('projects') }})</span>
                    </div>
                    <a href="{{ route('portfolio.index') }}" class="btn btn-sm btn-label-danger">
                        <i class="ti tabler-x me-1"></i>{{ __('Clear Filter') }}
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Projects Grid --}}
    <section class="section-py bg-body">
        <div class="container">
            @if($portfolios->count() > 0)
                <div class="row g-4">
                    @foreach($portfolios as $portfolio)
                        <div class="col-sm-6 col-lg-4">
                            <div class="card h-100">
                                <div class="position-relative">
                                    @if($portfolio->getFirstMediaUrl('featured_image'))
                                        <img src="{{ $portfolio->getFirstMediaUrl('featured_image') }}"
                                             class="card-img-top"
                                             style="height: 220px; object-fit: cover;"
                                             alt="{{ $portfolio->getTranslation('title', $locale) }}">
                                    @else
                                        <div class="card-img-top bg-label-primary d-flex align-items-center justify-content-center"
                                             style="height: 220px;">
                                            <i class="ti tabler-photo display-3 text-primary"></i>
                                        </div>
                                    @endif
                                    @if($portfolio->is_featured)
                                        <span class="badge bg-warning position-absolute top-0 end-0 m-3">
                                            <i class="ti tabler-star-filled me-1"></i>{{ __('Featured') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    @if($portfolio->getTranslation('category', $locale))
                                        <span class="badge bg-label-primary mb-2">
                                            {{ $portfolio->getTranslation('category', $locale) }}
                                        </span>
                                    @endif
                                    <h5 class="card-title">
                                        <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="text-body stretched-link">
                                            {{ $portfolio->getTranslation('title', $locale) }}
                                        </a>
                                    </h5>
                                    @if($portfolio->getTranslation('short_description', $locale))
                                        <p class="card-text text-muted small mb-0">
                                            {{ Str::limit($portfolio->getTranslation('short_description', $locale), 100) }}
                                        </p>
                                    @endif
                                </div>
                                @if($portfolio->technologies && count($portfolio->technologies) > 0)
                                    <div class="card-footer bg-transparent pt-0">
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach(array_slice($portfolio->technologies, 0, 3) as $tech)
                                                <span class="badge bg-label-secondary">{{ $tech }}</span>
                                            @endforeach
                                            @if(count($portfolio->technologies) > 3)
                                                <span class="badge bg-label-secondary">+{{ count($portfolio->technologies) - 3 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($portfolios->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $portfolios->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <span class="badge badge-center rounded-pill bg-label-secondary p-5">
                            <i class="ti tabler-folder-off display-4"></i>
                        </span>
                    </div>
                    <h4>{{ __('No projects found') }}</h4>
                    <p class="text-muted mb-4">{{ __('Try adjusting your search or filter to find what you\'re looking for.') }}</p>
                    <a href="{{ route('portfolio.index') }}" class="btn btn-primary">
                        <i class="ti tabler-refresh me-1"></i>{{ __('View All Projects') }}
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="section-py bg-label-primary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <span class="badge bg-primary mb-3">{{ __('Start a Project') }}</span>
                    <h3 class="mb-3">{{ __('Have a project in mind?') }}</h3>
                    <p class="text-muted mb-4">{{ __("Let's work together to bring your ideas to life") }}</p>
                    <a href="{{ route('landing.home') }}#contactUs" class="btn btn-primary btn-lg">
                        <i class="ti tabler-message me-2"></i>{{ __('Get in Touch') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
