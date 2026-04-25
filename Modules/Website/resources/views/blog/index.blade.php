@php
    use Modules\Theme\Helpers\Helpers;
    $configData = Helpers::appClasses();
    $locale = app()->getLocale();
@endphp

@extends('theme::user.layouts.layoutFront')

@section('title', 'Journal')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss'], 'build/modules/theme')
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-help-center.scss'], 'build/modules/theme')
@endsection

@section('content')
    {{-- Journal hero --}}
    <section class="codliy-hero position-relative">
        <div class="container position-relative">
            <div class="row align-items-end g-4">
                <div class="col-lg-8">
                    <div class="codliy-hero__kicker">CODLIY &middot; JOURNAL</div>
                    <h1 class="codliy-hero__title mb-3">
                        {{ __('Engineering notes from the studio') }}
                    </h1>
                    <p class="codliy-hero__sub mb-0">
                        {{ __('Case studies, architectural decisions and practical takeaways from shipping real software — web, mobile, cloud and AI.') }}
                    </p>
                </div>
                <div class="col-lg-4">
                    <form action="{{ route('blog.index') }}" method="GET" class="position-relative">
                        <div class="input-group input-group-merge codliy-card p-2">
                            <span class="input-group-text bg-transparent border-0 text-codliy-mute">
                                <i class="ti tabler-search"></i>
                            </span>
                            <input type="text" name="search"
                                   class="form-control bg-transparent border-0 text-codliy-soft"
                                   placeholder="{{ __('Search articles...') }}"
                                   value="{{ old('search', request('search')) }}"
                                   style="color:var(--codliy-text-soft)">
                            <button type="submit" class="btn-codliy px-3 py-1">
                                <i class="ti tabler-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Journal listing --}}
    <section class="codliy-section">
        <div class="container">
            <div class="row g-5">
                {{-- Sidebar --}}
                <div class="col-lg-3">
                    <div class="codliy-card mb-4">
                        <div class="codliy-card__eyebrow">{{ __('Categories') }}</div>
                        <ul class="list-unstyled mb-0 mt-2">
                            @foreach($categories as $category)
                                <li class="mb-2">
                                    <a href="{{ route('blog.category', $category->id) }}"
                                       class="d-flex align-items-center text-decoration-none {{ request('category') == $category->id ? 'text-codliy-primary fw-medium' : 'text-codliy-soft' }}">
                                        <i class="ti tabler-folder me-2"></i>
                                        <span class="flex-grow-1">{{ $category->getTranslation('title', $locale) }}</span>
                                        <span class="badge bg-transparent text-codliy-mute border border-codliy">
                                            {{ $category->posts()->count() }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="codliy-card mb-4">
                        <div class="codliy-card__eyebrow">{{ __('Tags') }}</div>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('blog.tag', $tag->id) }}"
                                   class="badge text-decoration-none border border-codliy text-codliy-soft px-2 py-1"
                                   style="background:rgba(0,86,248,0.08)">
                                    {{ $tag->getTranslation('name', $locale) }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="codliy-card">
                        <div class="codliy-card__eyebrow">{{ __('Popular Posts') }}</div>
                        <div class="mt-2">
                            @foreach($popularPosts as $popularPost)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        @if($popularPost->getFirstMediaUrl('img'))
                                            <img src="{{ $popularPost->getFirstMediaUrl('img') }}"
                                                 alt="{{ $popularPost->getTranslation('title', $locale) }}"
                                                 class="rounded-3" width="50" height="50" style="object-fit:cover">
                                        @else
                                            <div class="rounded-3 d-flex align-items-center justify-content-center"
                                                 style="width:50px;height:50px;background:rgba(0,86,248,0.12);color:#3B82F6">
                                                <i class="ti tabler-article"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3 min-width-0">
                                        <a href="{{ route('blog.show', $popularPost->id) }}"
                                           class="text-codliy-soft text-decoration-none">
                                            <div class="small fw-medium">{{ Str::limit($popularPost->getTranslation('title', $locale), 42) }}</div>
                                        </a>
                                        <small class="text-codliy-mute">
                                            <i class="ti tabler-heart-handshake me-1"></i>{{ $popularPost->clapping }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Posts grid --}}
                <div class="col-lg-9">
                    <div class="row g-4">
                        @forelse($posts as $post)
                            <div class="col-md-6 col-xl-4">
                                <article class="codliy-card h-100 p-0 overflow-hidden d-flex flex-column">
                                    <a href="{{ route('blog.show', $post->id) }}"
                                       class="d-block position-relative"
                                       style="aspect-ratio:16/10;background:var(--codliy-gradient)">
                                        @if($post->getFirstMediaUrl('img'))
                                            <img src="{{ $post->getFirstMediaUrl('img') }}"
                                                 alt="{{ $post->getTranslation('title', $locale) }}"
                                                 class="w-100 h-100"
                                                 style="object-fit:cover">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-codliy-mute">
                                                <i class="ti tabler-article" style="font-size:40px"></i>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="p-4 d-flex flex-column flex-grow-1">
                                        @if($post->category)
                                            <div class="codliy-card__eyebrow mb-2">
                                                {{ $post->category->getTranslation('title', $locale) }}
                                            </div>
                                        @endif
                                        <h3 class="codliy-card__title mb-2">
                                            <a href="{{ route('blog.show', $post->id) }}" class="text-codliy-soft text-decoration-none">
                                                {{ Str::limit($post->getTranslation('title', $locale), 64) }}
                                            </a>
                                        </h3>
                                        <p class="codliy-card__body flex-grow-1">
                                            {{ Str::limit(strip_tags($post->getTranslation('description', $locale)), 120) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center pt-2 mt-auto border-top border-codliy">
                                            <small class="text-codliy-mute">
                                                <i class="ti tabler-calendar me-1"></i>{{ $post->created_at->format('M d, Y') }}
                                            </small>
                                            <small class="text-codliy-mute">
                                                <i class="ti tabler-heart-handshake me-1"></i>{{ $post->clapping }}
                                            </small>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="codliy-card text-center py-5">
                                    <i class="ti tabler-article-off text-codliy-mute mb-3" style="font-size:40px"></i>
                                    <h3 class="codliy-card__title">{{ __('No posts found') }}</h3>
                                    <p class="codliy-card__body mb-0">{{ __('Try adjusting your search or filter to find what you\'re looking for.') }}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if($posts->hasPages())
                        <div class="mt-5">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
