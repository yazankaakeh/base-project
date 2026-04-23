@php
    use Modules\Theme\Helpers\Helpers;
    $configData = Helpers::appClasses();
    $locale = app()->getLocale();
@endphp

@extends('theme::user.layouts.layoutFront')

@section('title', $tag->getTranslation('name', $locale))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss'], 'build/modules/theme')
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-help-center.scss'], 'build/modules/theme')
@endsection

@section('content')
    {{-- Tag hero --}}
    <section class="codliy-hero position-relative">
        <div class="container position-relative">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0" style="background:transparent;padding:0;font-size:.85rem">
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-codliy-mute text-decoration-none">{{ __('Journal') }}</a></li>
                    <li class="breadcrumb-item active text-codliy-soft" aria-current="page">
                        #{{ $tag->getTranslation('name', $locale) }}
                    </li>
                </ol>
            </nav>

            <div class="row align-items-end g-4">
                <div class="col-lg-8">
                    <div class="codliy-hero__kicker">CODLIY &middot; {{ __('Tag') }}</div>
                    <h1 class="codliy-hero__title mb-3">
                        <span class="text-codliy-primary">#</span>{{ $tag->getTranslation('name', $locale) }}
                    </h1>
                    <p class="codliy-hero__sub mb-2">
                        {{ __('Posts tagged with') }} "{{ $tag->getTranslation('name', $locale) }}"
                    </p>
                    <div class="small text-codliy-mute">
                        <i class="ti tabler-article me-1"></i>
                        {{ $posts->total() }} {{ __('posts with this tag') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Listing --}}
    <section class="codliy-section">
        <div class="container">
            <div class="row g-5">
                {{-- Sidebar --}}
                <div class="col-lg-3">
                    <div class="codliy-card mb-4">
                        <div class="codliy-card__eyebrow">{{ __('Categories') }}</div>
                        <ul class="list-unstyled mb-0 mt-2">
                            <li class="mb-2">
                                <a href="{{ route('blog.index') }}"
                                   class="d-flex align-items-center text-decoration-none text-codliy-soft">
                                    <i class="ti tabler-folders me-2"></i>
                                    <span class="flex-grow-1">{{ __('All Posts') }}</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li class="mb-2">
                                    <a href="{{ route('blog.category', $category->id) }}"
                                       class="d-flex align-items-center text-decoration-none text-codliy-soft">
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
                            @foreach($tags as $t)
                                @php $isActive = $tag->id == $t->id; @endphp
                                <a href="{{ route('blog.tag', $t->id) }}"
                                   class="badge text-decoration-none px-2 py-1 border {{ $isActive ? 'border-0' : 'border-codliy text-codliy-soft' }}"
                                   style="{{ $isActive ? 'background:var(--codliy-primary);color:#fff' : 'background:rgba(0,86,248,0.08)' }}">
                                    {{ $t->getTranslation('name', $locale) }}
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
                                        @if($post->tags->count() > 0)
                                            <div class="d-flex flex-wrap gap-1 mb-2">
                                                @foreach($post->tags->take(3) as $postTag)
                                                    <a href="{{ route('blog.tag', $postTag->id) }}"
                                                       class="badge text-decoration-none border border-codliy text-codliy-mute"
                                                       style="background:transparent;font-size:.7rem">
                                                        #{{ $postTag->getTranslation('name', $locale) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
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
                                    <h3 class="codliy-card__title">{{ __('No posts found with this tag') }}</h3>
                                    <p class="codliy-card__body mb-4">{{ __('Check back later for new content.') }}</p>
                                    <a href="{{ route('blog.index') }}" class="btn-codliy-outline">
                                        <i class="ti tabler-arrow-left me-2"></i>{{ __('Back to all posts') }}
                                    </a>
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
