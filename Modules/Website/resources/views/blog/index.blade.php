@php
    use Modules\Theme\Helpers\Helpers;
    $configData = Helpers::appClasses();
@endphp

@extends('theme::user.layouts.layoutFront')

@section('title', 'Blog')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss'], 'build/modules/theme')
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-help-center.scss'], 'build/modules/theme')
@endsection

@section('content')
    <section class="section-py bg-body first-section-pt">
        <div class="container">
            <h2 class="text-center mb-2">{{__('Our Blog')}}</h2>
            <p class="text-center mb-10">{{__('Explore our latest articles and insights')}}</p>

            {{-- Search --}}
            <div class="row justify-content-center mb-10">
                <div class="col-lg-8">
                    <form action="{{ route('blog.index') }}" method="GET">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti tabler-search"></i></span>
                            <input type="text" name="search" class="form-control form-control-lg"
                                   placeholder="{{__('Search articles...')}}"
                                   value="{{ old('search', request('search')) }}">
                            <button type="submit" class="btn btn-primary z-1">{{__('Search')}}</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                {{-- Sidebar --}}
                <div class="col-lg-3 mb-6 mb-lg-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{__('Categories')}}</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                @foreach($categories as $category)
                                    <li class="mb-2">
                                        <a href="{{ route('blog.category', $category->id) }}"
                                           class="d-flex align-items-center {{ request('category') == $category->id ? 'text-primary fw-medium' : '' }}">
                                            <i class="ti tabler-folder me-2"></i>
                                            {{ $category->getTranslation('title', app()->getLocale()) }}
                                            <span class="badge bg-label-secondary ms-auto">{{ $category->posts()->count() }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{__('Tags')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($tags as $tag)
                                    <a href="{{ route('blog.tag', $tag->id) }}" class="badge bg-label-primary">
                                        {{ $tag->getTranslation('name', app()->getLocale()) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">{{__('Popular Posts')}}</h5>
                        </div>
                        <div class="card-body">
                            @foreach($popularPosts as $popularPost)
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        @if($popularPost->getFirstMediaUrl('img'))
                                            <img src="{{ $popularPost->getFirstMediaUrl('img') }}"
                                                 alt="{{ $popularPost->getTranslation('title', app()->getLocale()) }}"
                                                 class="rounded" width="50">
                                        @else
                                            <div class="avatar avatar-sm">
                                                <span class="avatar-initial rounded bg-label-primary"><i
                                                            class="ti tabler-article"></i></span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <a href="{{ route('blog.show', $popularPost->id) }}" class="text-body">
                                            <h6 class="mb-1">{{ Str::limit($popularPost->getTranslation('title', app()->getLocale()), 40) }}</h6>
                                        </a>
                                        <small class="text-muted">
                                            <i class="ti tabler-heart-handshake me-1"></i>{{ $popularPost->clapping }} {{__('claps')}}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Blog Posts --}}
                <div class="col-lg-9">
                    <div class="row">
                        @forelse($posts as $post)
                            <div class="col-md-6 col-lg-4 mb-6">
                                <div class="card h-100">
                                    @if($post->getFirstMediaUrl('img'))
                                        <img class="card-img-top" src="{{ $post->getFirstMediaUrl('img') }}"
                                             alt="{{ $post->getTranslation('title', app()->getLocale()) }}">
                                    @else
                                        <div class="card-img-top bg-label-primary d-flex align-items-center justify-content-center"
                                             style="height: 200px;">
                                            <i class="ti tabler-article display-4"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        @if($post->category)
                                            <a href="{{ route('blog.category', $post->category->id) }}"
                                               class="badge bg-label-primary mb-2">
                                                {{ $post->category->getTranslation('title', app()->getLocale()) }}
                                            </a>
                                        @endif
                                        <h5 class="card-title">
                                            <a href="{{ route('blog.show', $post->id) }}" class="text-body">
                                                {{ Str::limit($post->getTranslation('title', app()->getLocale()), 50) }}
                                            </a>
                                        </h5>
                                        <p class="card-text">
                                            {{ Str::limit(strip_tags($post->getTranslation('description', app()->getLocale())), 100) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="ti tabler-calendar me-1"></i>{{ $post->created_at->format('M d, Y') }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="ti tabler-heart-handshake me-1"></i>{{ $post->clapping }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center py-10">
                                        <i class="ti tabler-article-off display-3 text-muted mb-4"></i>
                                        <h5>{{__('No posts found')}}</h5>
                                        <p class="text-muted">{{__('Try adjusting your search or filter to find what you\'re looking for.')}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($posts->hasPages())
                        <div class="row mt-6">
                            <div class="col-12">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
