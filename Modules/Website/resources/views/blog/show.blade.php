@php
    use Modules\Theme\Helpers\Helpers;
    $configData = Helpers::appClasses();
@endphp

@extends('theme::user.layouts.layoutFront')

@section('title', $post->getTranslation('title', app()->getLocale()))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss'], 'build/modules/theme')
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-help-center.scss'], 'build/modules/theme')
    <style>
        .clap-button {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .clap-button:hover {
            transform: scale(1.1);
        }

        .clap-button:active {
            transform: scale(0.9);
        }

        .blog-content img {
            max-width: 100%;
            height: auto;
        }

        .blog-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }
    </style>
@endsection

@section('content')
    <section class="section-py bg-body first-section-pt">
        <div class="container">
            <div class="row">
                {{-- Main Content --}}
                <div class="col-lg-8 mb-6 mb-lg-0">
                    {{-- Post Header --}}
                    <div class="card mb-6">
                        @if($post->getFirstMediaUrl('img'))
                            <img class="card-img-top" src="{{ $post->getFirstMediaUrl('img') }}"
                                 alt="{{ $post->getTranslation('title', app()->getLocale()) }}">
                        @endif
                        <div class="card-body">
                            @if($post->category)
                                <a href="{{ route('blog.category', $post->category->id) }}"
                                   class="badge bg-label-primary mb-3">
                                    {{ $post->category->getTranslation('title', app()->getLocale()) }}
                                </a>
                            @endif

                            <h1 class="mb-4">{{ $post->getTranslation('title', app()->getLocale()) }}</h1>

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="ti tabler-calendar me-2"></i>
                                    <small class="text-muted">{{ $post->created_at->format('F d, Y') }}</small>
                                </div>
                                <div class="d-flex align-items-center gap-4">
                                    <div class="d-flex align-items-center">
                                        <i class="ti tabler-heart-handshake me-2"></i>
                                        <span id="total-claps">{{ $totalClaps }}</span> {{__('claps')}}
                                    </div>
                                    <div class="clap-button" id="clap-btn" data-post-id="{{ $post->id }}">
                                        <button class="btn btn-primary btn-sm">
                                            <i class="ti tabler-heart-handshake me-1"></i>
                                            {{__('Clap')}} (<span id="remaining-claps">{{ $remainingClaps }}</span>)
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Tags --}}
                            @if($post->tags->count() > 0)
                                <div class="mb-4">
                                    @foreach($post->tags as $tag)
                                        <a href="{{ route('blog.tag', $tag->id) }}" class="badge bg-label-info me-2">
                                            <i class="ti tabler-hash"></i>{{ $tag->getTranslation('name', app()->getLocale()) }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Post Content --}}
                            <div class="blog-content mt-6">
                                {!! $post->getTranslation('description', app()->getLocale()) !!}
                            </div>
                        </div>
                    </div>

                    {{-- Related Posts --}}
                    @if($relatedPosts->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">{{__('Related Posts')}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($relatedPosts as $relatedPost)
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                @if($relatedPost->getFirstMediaUrl('img'))
                                                    <img class="card-img-top"
                                                         src="{{ $relatedPost->getFirstMediaUrl('img') }}"
                                                         alt="{{ $relatedPost->getTranslation('title', app()->getLocale()) }}"
                                                         style="height: 150px; object-fit: cover;">
                                                @endif
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <a href="{{ route('blog.show', $relatedPost->id) }}"
                                                           class="text-body">
                                                            {{ Str::limit($relatedPost->getTranslation('title', app()->getLocale()), 40) }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i class="ti tabler-heart-handshake me-1"></i>{{ $relatedPost->clapping }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="card mb-4">
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
                                                 class="rounded" width="60" style="height: 60px; object-fit: cover;">
                                        @else
                                            <div class="avatar avatar-md">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="ti tabler-article"></i>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <a href="{{ route('blog.show', $popularPost->id) }}" class="text-body">
                                            <h6 class="mb-1">{{ Str::limit($popularPost->getTranslation('title', app()->getLocale()), 50) }}</h6>
                                        </a>
                                        <small class="text-muted">
                                            <i class="ti tabler-heart-handshake me-1"></i>{{ $popularPost->clapping }} {{__('claps')}}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{__('Share This Post')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                   target="_blank" class="btn btn-sm btn-facebook">
                                    <i class="ti tabler-brand-facebook me-1"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->getTranslation('title', app()->getLocale())) }}"
                                   target="_blank" class="btn btn-sm btn-twitter">
                                    <i class="ti tabler-brand-twitter me-1"></i> Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                                   target="_blank" class="btn btn-sm btn-linkedin">
                                    <i class="ti tabler-brand-linkedin me-1"></i> LinkedIn
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const clapBtn = document.getElementById('clap-btn');
            const totalClapsEl = document.getElementById('total-claps');
            const remainingClapsEl = document.getElementById('remaining-claps');

            if (clapBtn) {
                clapBtn.addEventListener('click', function () {
                    const postId = this.dataset.postId;

                    fetch(`/blog/post/${postId}/clap`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                totalClapsEl.textContent = data.total_claps;
                                remainingClapsEl.textContent = data.remaining_claps;

                                // Animation
                                clapBtn.classList.add('animate__animated', 'animate__heartBeat');
                                setTimeout(() => {
                                    clapBtn.classList.remove('animate__animated', 'animate__heartBeat');
                                }, 1000);
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }
        });
    </script>
@endsection
