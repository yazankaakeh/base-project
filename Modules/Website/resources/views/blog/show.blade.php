@php
    use Modules\Theme\Helpers\Helpers;
    $configData = Helpers::appClasses();
    $locale = app()->getLocale();
@endphp

@extends('theme::user.layouts.layoutFront')

@section('title', $post->getTranslation('title', $locale))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss'], 'build/modules/theme')
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-help-center.scss'], 'build/modules/theme')
    <style>
        .clap-button{cursor:pointer;transition:transform .2s}
        .clap-button:hover{transform:scale(1.04)}
        .clap-button:active{transform:scale(.96)}
        .codliy-article{color:var(--codliy-text-soft);font-size:1.05rem;line-height:1.85}
        .codliy-article img{max-width:100%;height:auto;border-radius:14px;margin:1.25rem 0}
        .codliy-article h1,.codliy-article h2,.codliy-article h3,
        .codliy-article h4,.codliy-article h5{color:var(--codliy-text-soft);margin-top:1.6rem;margin-bottom:.85rem;font-weight:600;letter-spacing:-.01em}
        .codliy-article h2{font-size:1.6rem}
        .codliy-article h3{font-size:1.3rem}
        .codliy-article p{margin-bottom:1.1rem}
        .codliy-article a{color:var(--codliy-primary);text-decoration:none;border-bottom:1px solid rgba(0,86,248,.35)}
        .codliy-article a:hover{color:var(--codliy-accent);border-bottom-color:var(--codliy-accent)}
        .codliy-article blockquote{border-left:3px solid var(--codliy-primary);padding:.25rem 1.1rem;margin:1.25rem 0;color:var(--codliy-text-mute);font-style:italic;background:rgba(0,86,248,.05);border-radius:0 10px 10px 0}
        .codliy-article ul,.codliy-article ol{padding-left:1.35rem;margin-bottom:1.1rem}
        .codliy-article li{margin-bottom:.35rem}
        .codliy-article pre{background:#020611;color:#D9D9D9;padding:1rem 1.15rem;border-radius:12px;overflow-x:auto;border:1px solid rgba(255,255,255,.06)}
        .codliy-article code{background:rgba(0,86,248,.1);color:var(--codliy-accent);padding:.1rem .35rem;border-radius:6px;font-size:.92em}
        .codliy-article pre code{background:transparent;color:inherit;padding:0}
        [dir="rtl"] .codliy-article blockquote,[data-direction="rtl"] .codliy-article blockquote{border-left:0;border-right:3px solid var(--codliy-primary);border-radius:10px 0 0 10px}
        [dir="rtl"] .codliy-article ul,[dir="rtl"] .codliy-article ol,
        [data-direction="rtl"] .codliy-article ul,[data-direction="rtl"] .codliy-article ol{padding-left:0;padding-right:1.35rem}
        /* ─── Tag pills ─────────────────────────────────────────────── */
        .post-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            background: rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.1);
            border: 1px solid rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.2);
            color: var(--codliy-primary);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s ease;
        }
        .post-tag:hover {
            background: var(--codliy-primary);
            border-color: var(--codliy-primary);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.28);
        }
        .post-tag i { opacity: 0.85; font-size: 0.9rem; }

        /* ─── Post action bar (clap + share) ───────────────────────── */
        .post-action-bar {
            background: linear-gradient(135deg,
                rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.06),
                rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.02));
            border: 1px solid rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.12);
            border-radius: 16px;
            padding: 1.2rem 1.5rem;
            margin-top: 2rem;
        }
        [data-bs-theme="light"] .post-action-bar,
        [data-layout-mode="light_mode"] .post-action-bar {
            background: linear-gradient(135deg,
                rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.04),
                #fff);
        }

        /* ─── Clap button ─────────────────────────────────────────── */
        .clap-button {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1.25rem;
            background: var(--codliy-primary-gradient, var(--codliy-primary));
            color: #fff;
            border: none;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 8px 22px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.32);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .clap-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.42);
            color: #fff;
        }
        .clap-button:active { transform: scale(.97); }
        .clap-button i { font-size: 1.1rem; }
        .clap-button .clap-count {
            background: rgba(255, 255, 255, 0.22);
            padding: 0.15rem 0.55rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-variant-numeric: tabular-nums;
        }
        /* Pulse animation when clap fires */
        @keyframes clapPulse {
            0%   { transform: scale(1); }
            35%  { transform: scale(1.12); }
            100% { transform: scale(1); }
        }
        .clap-button.pulsing { animation: clapPulse .5s ease; }

        /* ─── Share buttons ────────────────────────────────────────── */
        .share-group { display: inline-flex; align-items: center; gap: 0.45rem; }
        .share-label {
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--codliy-text-mute, #8A94B0);
            margin-right: 0.25rem;
        }
        [dir="rtl"] .share-label { margin-right: 0; margin-left: 0.25rem; }
        .share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.12);
            background: rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.04);
            color: var(--codliy-text-soft, currentColor);
            transition: all .2s ease;
            text-decoration: none;
        }
        .share-btn i { font-size: 1rem; }
        .share-btn:hover {
            background: var(--codliy-primary);
            border-color: var(--codliy-primary);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.28);
        }
        /* Social brand tints on hover — more delightful than a flat primary. */
        .share-btn[data-net="twitter"]:hover  { background: #1DA1F2; border-color: #1DA1F2; }
        .share-btn[data-net="linkedin"]:hover { background: #0A66C2; border-color: #0A66C2; }
        .share-btn[data-net="facebook"]:hover { background: #1877F2; border-color: #1877F2; }
        .share-btn[data-net="email"]:hover    { background: #EA4335; border-color: #EA4335; }

        /* Slim divider between clap and share on wide screens. */
        @media (min-width: 768px) {
            .post-action-bar__divider {
                width: 1px;
                align-self: stretch;
                background: rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.14);
                margin: 0 1rem;
            }
        }
        @media (max-width: 767.98px) {
            .post-action-bar__divider { display: none; }
            .post-action-bar {
                padding: 1rem;
                flex-direction: column;
                gap: 0.85rem;
            }
            .clap-button, .share-group { width: 100%; justify-content: center; }
        }
    </style>
@endsection

@section('content')
    {{-- Article hero --}}
    <section class="codliy-hero position-relative">
        <div class="container position-relative">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0" style="background:transparent;padding:0;font-size:.85rem">
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-codliy-mute text-decoration-none">{{ __('Journal') }}</a></li>
                    @if($post->category)
                        <li class="breadcrumb-item">
                            <a href="{{ route('blog.category', $post->category->id) }}" class="text-codliy-mute text-decoration-none">
                                {{ $post->category->getTranslation('title', $locale) }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active text-codliy-soft" aria-current="page">
                        {{ Str::limit($post->getTranslation('title', $locale), 42) }}
                    </li>
                </ol>
            </nav>

            <div class="row align-items-end g-4">
                <div class="col-lg-9">
                    @if($post->category)
                        <div class="codliy-hero__kicker mb-2">
                            CODLIY &middot; {{ Str::upper($post->category->getTranslation('title', $locale)) }}
                        </div>
                    @else
                        <div class="codliy-hero__kicker mb-2">CODLIY &middot; JOURNAL</div>
                    @endif
                    <h1 class="codliy-hero__title mb-3">
                        {{ $post->getTranslation('title', $locale) }}
                    </h1>
                    <div class="d-flex flex-wrap align-items-center gap-3 text-codliy-mute small">
                        <span><i class="ti tabler-calendar me-1"></i>{{ $post->created_at->translatedFormat('F d, Y') }}</span>
                        <span class="opacity-50">&middot;</span>
                        <span><i class="ti tabler-clock me-1"></i>{{ max(1, ceil(str_word_count(strip_tags($post->getTranslation('description', $locale))) / 200)) }} {{ __('min read') }}</span>
                        <span class="opacity-50">&middot;</span>
                        <span><i class="ti tabler-heart-handshake me-1"></i><span id="total-claps">{{ $totalClaps }}</span> {{ __('claps') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Article body --}}
    <section class="codliy-section">
        <div class="container">
            <div class="row g-5">
                {{-- Main column --}}
                <div class="col-lg-8">
                    @if($post->getFirstMediaUrl('img'))
                        <div class="codliy-card p-0 overflow-hidden mb-5" style="aspect-ratio:16/9;background:var(--codliy-gradient)">
                            <img src="{{ $post->getFirstMediaUrl('img') }}"
                                 alt="{{ $post->getTranslation('title', $locale) }}"
                                 class="w-100 h-100"
                                 style="object-fit:cover">
                        </div>
                    @endif

                    <div class="codliy-card">
                        <div class="codliy-article">
                            {!! $post->getTranslation('description', $locale) !!}
                        </div>

                        @if($post->tags->count() > 0)
                            {{-- Tags row — pills with a primary tint that darken on hover. --}}
                            <div class="pt-4 mt-4 border-top border-codliy">
                                <div class="codliy-card__eyebrow mb-3">
                                    <i class="ti tabler-tags me-1"></i>{{ __('Tags') }}
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($post->tags as $tag)
                                        <a href="{{ route('blog.tag', $tag->id) }}" class="post-tag">
                                            <i class="ti tabler-hash"></i>{{ $tag->getTranslation('name', $locale) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Action bar: clap + share. Lifted out of the article card
                         into its own gradient panel so it reads as a distinct
                         CTA rather than an afterthought. --}}
                    @php $shareUrl = urlencode(request()->url()); $shareTitle = urlencode($post->getTranslation('title', $locale)); @endphp
                    <div class="post-action-bar d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <button type="button" class="clap-button" id="clap-btn" data-post-id="{{ $post->id }}">
                            <i class="ti tabler-hand-three-fingers"></i>
                            <span>{{ __('Clap') }}</span>
                            <span class="clap-count" id="remaining-claps-wrap">
                                <span id="remaining-claps">{{ $remainingClaps }}</span>
                            </span>
                        </button>

                        <div class="post-action-bar__divider"></div>

                        <div class="share-group">
                            <span class="share-label">{{ __('Share') }}</span>
                            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                               target="_blank" rel="noopener" class="share-btn" data-net="twitter" aria-label="Share on X">
                                <i class="ti tabler-brand-x"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
                               target="_blank" rel="noopener" class="share-btn" data-net="linkedin" aria-label="Share on LinkedIn">
                                <i class="ti tabler-brand-linkedin"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                               target="_blank" rel="noopener" class="share-btn" data-net="facebook" aria-label="Share on Facebook">
                                <i class="ti tabler-brand-facebook"></i>
                            </a>
                            <a href="mailto:?subject={{ $shareTitle }}&body={{ $shareUrl }}"
                               class="share-btn" data-net="email" aria-label="{{ __('Share via email') }}">
                                <i class="ti tabler-mail"></i>
                            </a>
                            <button type="button" class="share-btn" data-net="copy" id="copy-link-btn"
                                    aria-label="{{ __('Copy link') }}" title="{{ __('Copy link') }}">
                                <i class="ti tabler-link"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Related posts --}}
                    @if($relatedPosts->count() > 0)
                        <div class="mt-5">
                            <div class="codliy-section__kicker mb-2">{{ __('Keep reading') }}</div>
                            <h3 class="codliy-section__title mb-4">{{ __('Related Posts') }}</h3>
                            <div class="row g-4">
                                @foreach($relatedPosts as $relatedPost)
                                    <div class="col-md-6 col-xl-4">
                                        <article class="codliy-card h-100 p-0 overflow-hidden d-flex flex-column">
                                            <a href="{{ route('blog.show', $relatedPost->id) }}"
                                               class="d-block position-relative"
                                               style="aspect-ratio:16/10;background:var(--codliy-gradient)">
                                                @if($relatedPost->getFirstMediaUrl('img'))
                                                    <img src="{{ $relatedPost->getFirstMediaUrl('img') }}"
                                                         alt="{{ $relatedPost->getTranslation('title', $locale) }}"
                                                         class="w-100 h-100"
                                                         style="object-fit:cover">
                                                @else
                                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-codliy-mute">
                                                        <i class="ti tabler-article" style="font-size:36px"></i>
                                                    </div>
                                                @endif
                                            </a>
                                            <div class="p-3 d-flex flex-column flex-grow-1">
                                                <h4 class="codliy-card__title mb-2" style="font-size:1rem">
                                                    <a href="{{ route('blog.show', $relatedPost->id) }}" class="text-codliy-soft text-decoration-none">
                                                        {{ Str::limit($relatedPost->getTranslation('title', $locale), 56) }}
                                                    </a>
                                                </h4>
                                                <div class="mt-auto pt-2 d-flex justify-content-between small text-codliy-mute">
                                                    <span><i class="ti tabler-calendar me-1"></i>{{ $relatedPost->created_at->format('M d, Y') }}</span>
                                                    <span><i class="ti tabler-heart-handshake me-1"></i>{{ $relatedPost->clapping }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="codliy-card mb-4 position-sticky" style="top:90px">
                        <div class="codliy-card__eyebrow">{{ __('Popular Posts') }}</div>
                        <div class="mt-2">
                            @foreach($popularPosts as $popularPost)
                                <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom border-codliy' : '' }}">
                                    <div class="flex-shrink-0">
                                        @if($popularPost->getFirstMediaUrl('img'))
                                            <img src="{{ $popularPost->getFirstMediaUrl('img') }}"
                                                 alt="{{ $popularPost->getTranslation('title', $locale) }}"
                                                 class="rounded-3" width="56" height="56" style="object-fit:cover">
                                        @else
                                            <div class="rounded-3 d-flex align-items-center justify-content-center"
                                                 style="width:56px;height:56px;background:rgba(0,86,248,0.12);color:#3B82F6">
                                                <i class="ti tabler-article"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3 min-width-0">
                                        <a href="{{ route('blog.show', $popularPost->id) }}"
                                           class="text-codliy-soft text-decoration-none">
                                            <div class="small fw-medium mb-1">{{ Str::limit($popularPost->getTranslation('title', $locale), 48) }}</div>
                                        </a>
                                        <small class="text-codliy-mute">
                                            <i class="ti tabler-heart-handshake me-1"></i>{{ $popularPost->clapping }} {{ __('claps') }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
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
                                if (totalClapsEl) totalClapsEl.textContent = data.total_claps;
                                if (remainingClapsEl) remainingClapsEl.textContent = data.remaining_claps;
                                // Pulse animation — scoped CSS handles the keyframes.
                                clapBtn.classList.add('pulsing');
                                setTimeout(() => clapBtn.classList.remove('pulsing'), 500);
                            } else if (data.message) {
                                // Inline hint rather than an ugly alert().
                                clapBtn.setAttribute('title', data.message);
                            }
                        })
                        .catch(err => console.error('Clap failed:', err));
                });
            }

            // Copy-link share button — swaps to a success icon for 1.5s
            // so the user gets feedback that the URL was copied.
            const copyBtn = document.getElementById('copy-link-btn');
            if (copyBtn) {
                copyBtn.addEventListener('click', async function () {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                        const icon = copyBtn.querySelector('i');
                        const prev = icon.className;
                        icon.className = 'ti tabler-check';
                        copyBtn.style.background = '#10B981';
                        copyBtn.style.borderColor = '#10B981';
                        copyBtn.style.color = '#fff';
                        setTimeout(() => {
                            icon.className = prev;
                            copyBtn.style.background = '';
                            copyBtn.style.borderColor = '';
                            copyBtn.style.color = '';
                        }, 1500);
                    } catch (e) {
                        console.error('Copy failed:', e);
                    }
                });
            }
        });
    </script>
@endsection
