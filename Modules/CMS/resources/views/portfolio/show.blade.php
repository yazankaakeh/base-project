@php
    use Modules\Core\App\Enums\LanguageEnum;
    $page = 'cms-portfolios';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', $portfolio->getTranslation('title', app()->getLocale()))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    {{-- Header --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex gap-3">
                                    @if($portfolio->featured_image_url)
                                        <img src="{{ $portfolio->featured_image_url }}"
                                             class="rounded"
                                             style="width: 120px; height: 90px; object-fit: cover;">
                                    @endif
                                    <div>
                                        <h4 class="mb-1">{{ $portfolio->getTranslation('title', app()->getLocale()) }}</h4>
                                        <p class="text-muted mb-2">{{ $portfolio->getTranslation('short_description', app()->getLocale()) }}</p>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-{{ $portfolio->is_active ? 'success' : 'secondary' }}">
                                                {{ $portfolio->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            @if($portfolio->is_featured)
                                                <span class="badge bg-warning">
                                                    <i class="ti tabler-star-filled me-1"></i>Featured
                                                </span>
                                            @endif
                                            @if($portfolio->getTranslation('category', app()->getLocale()))
                                                <span class="badge bg-label-info">
                                                    {{ $portfolio->getTranslation('category', app()->getLocale()) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('portfolio.show', $portfolio->slug) }}"
                                       target="_blank"
                                       class="btn btn-outline-info">
                                        <i class="ti tabler-external-link me-1"></i>View on Site
                                    </a>
                                    <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                                       class="btn btn-primary">
                                        <i class="ti tabler-edit me-1"></i>Edit
                                    </a>
                                    <a href="{{ route('admin.portfolios.index') }}"
                                       class="btn btn-outline-secondary">
                                        <i class="ti tabler-arrow-left me-1"></i>Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Main Content --}}
                        <div class="col-lg-8">
                            {{-- Description --}}
                            @if($portfolio->getTranslation('description', app()->getLocale()))
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ti tabler-file-text me-2"></i>Description</h6>
                                    </div>
                                    <div class="card-body">
                                        {!! $portfolio->getTranslation('description', app()->getLocale()) !!}
                                    </div>
                                </div>
                            @endif

                            {{-- Features --}}
                            @if($portfolio->getTranslation('features', app()->getLocale()))
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ti tabler-list-check me-2"></i>Features</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="mb-0">
                                            @foreach(array_filter(explode("\n", $portfolio->getTranslation('features', app()->getLocale()))) as $feature)
                                                <li>{{ trim($feature) }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            {{-- Gallery --}}
                            @if(count($portfolio->gallery_images) > 0)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ti tabler-photo me-2"></i>Gallery ({{ count($portfolio->gallery_images) }})</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-2">
                                            @foreach($portfolio->gallery_images as $image)
                                                <div class="col-md-3">
                                                    <a href="{{ $image['url'] }}" target="_blank">
                                                        <img src="{{ $image['thumb'] }}"
                                                             class="img-fluid rounded"
                                                             style="width: 100%; height: 100px; object-fit: cover;">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Testimonial --}}
                            @if($portfolio->getTranslation('testimonial', app()->getLocale()))
                                <div class="card mb-4 bg-label-primary">
                                    <div class="card-body">
                                        <i class="ti tabler-quote display-6 opacity-50 mb-2"></i>
                                        <p class="mb-3">{{ $portfolio->getTranslation('testimonial', app()->getLocale()) }}</p>
                                        @if($portfolio->testimonial_author)
                                            <strong>{{ $portfolio->testimonial_author }}</strong>
                                            @if($portfolio->testimonial_position)
                                                <span class="text-muted">- {{ $portfolio->testimonial_position }}</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Sidebar --}}
                        <div class="col-lg-4">
                            {{-- Project Info --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="ti tabler-info-circle me-2"></i>Project Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td class="text-muted">Slug</td>
                                            <td><code>{{ $portfolio->slug }}</code></td>
                                        </tr>
                                        @if($portfolio->client_name)
                                            <tr>
                                                <td class="text-muted">Client</td>
                                                <td>{{ $portfolio->client_name }}</td>
                                            </tr>
                                        @endif
                                        @if($portfolio->client_company)
                                            <tr>
                                                <td class="text-muted">Company</td>
                                                <td>{{ $portfolio->client_company }}</td>
                                            </tr>
                                        @endif
                                        @if($portfolio->project_url)
                                            <tr>
                                                <td class="text-muted">URL</td>
                                                <td>
                                                    <a href="{{ $portfolio->project_url }}" target="_blank">
                                                        {{ Str::limit($portfolio->project_url, 30) }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                        @if($portfolio->start_date)
                                            <tr>
                                                <td class="text-muted">Start Date</td>
                                                <td>{{ $portfolio->start_date->format('M d, Y') }}</td>
                                            </tr>
                                        @endif
                                        @if($portfolio->completion_date)
                                            <tr>
                                                <td class="text-muted">Completed</td>
                                                <td>{{ $portfolio->completion_date->format('M d, Y') }}</td>
                                            </tr>
                                        @endif
                                        @if($portfolio->project_duration)
                                            <tr>
                                                <td class="text-muted">Duration</td>
                                                <td>{{ $portfolio->project_duration }}</td>
                                            </tr>
                                        @endif
                                        @if($portfolio->project_budget)
                                            <tr>
                                                <td class="text-muted">Budget</td>
                                                <td>${{ number_format($portfolio->project_budget, 2) }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-muted">Views</td>
                                            <td>{{ number_format($portfolio->views_count) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Order</td>
                                            <td>{{ $portfolio->order }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Created</td>
                                            <td>{{ $portfolio->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{-- Technologies --}}
                            @if($portfolio->technologies && count($portfolio->technologies) > 0)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ti tabler-code me-2"></i>Technologies</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($portfolio->technologies as $tech)
                                            <span class="badge bg-label-secondary me-1 mb-1">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Logo --}}
                            @if($portfolio->logo_url)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ti tabler-building me-2"></i>Client Logo</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <img src="{{ $portfolio->logo_url }}"
                                             class="img-fluid"
                                             style="max-height: 80px;">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
