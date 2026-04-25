@extends('theme::user.layouts.layoutFront')

@php
    $fallback = config('app.fallback_locale', 'en');

    // Page-level fallback chain for meta + on-page title.
    $pageTitle = $page->getTranslation('title', $locale)
        ?: $page->getTranslation('title', $fallback)
        ?: ucwords(str_replace(['-', '_'], ' ', $page->slug));
    $pageExcerpt = $page->getTranslation('excerpt', $locale)
        ?: $page->getTranslation('excerpt', $fallback);

    // SEO record (via Modules\Seo\Traits\HasSeo morphOne relation) wins
    // when the admin explicitly typed a meta title / description. Fall
    // back to the page title/excerpt so pages without a custom SEO row
    // still ship something meaningful to crawlers.
    $seo = $page->seo ?? null;
    $metaTitle = ($seo?->getTranslation('title', $locale) ?? '')
        ?: ($seo?->getTranslation('title', $fallback) ?? '')
        ?: $pageTitle;
    $metaDescription = ($seo?->getTranslation('meta_description', $locale) ?? '')
        ?: ($seo?->getTranslation('meta_description', $fallback) ?? '')
        ?: $pageExcerpt;
    $metaImage = $page->getFirstMediaUrl('featured_image') ?: null;
    $canonical = url()->current();
@endphp

@section('title', $metaTitle)

@section('meta')
    {{-- Per-page SEO block. Injected into <head> via commonMaster's @yield('meta'). --}}
    @if($metaDescription)
        <meta name="description" content="{{ Str::limit(strip_tags($metaDescription), 160) }}">
    @endif
    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:type"        content="article"/>
    <meta property="og:title"       content="{{ $metaTitle }}"/>
    <meta property="og:url"         content="{{ $canonical }}"/>
    <meta property="og:locale"      content="{{ app()->getLocale() }}"/>
    @if($metaDescription)
        <meta property="og:description" content="{{ Str::limit(strip_tags($metaDescription), 200) }}"/>
    @endif
    @if($metaImage)
        <meta property="og:image"   content="{{ $metaImage }}"/>
    @endif

    <meta name="twitter:card"       content="summary_large_image"/>
    <meta name="twitter:title"      content="{{ $metaTitle }}"/>
    @if($metaDescription)
        <meta name="twitter:description" content="{{ Str::limit(strip_tags($metaDescription), 200) }}"/>
    @endif
    @if($metaImage)
        <meta name="twitter:image"  content="{{ $metaImage }}"/>
    @endif

    {{-- Robots — respect what the SEO row says, default to index,follow. --}}
    @php
        $robotsIndex  = $seo->robots_index  ?? true;
        $robotsFollow = $seo->robots_follow ?? true;
    @endphp
    <meta name="robots" content="{{ $robotsIndex ? 'index' : 'noindex' }}, {{ $robotsFollow ? 'follow' : 'nofollow' }}"/>
@endsection

@section('page-style')
    <style>
        /*
         * Every color here flows through the Codliy theme tokens
         * (--codliy-primary, --codliy-primary-rgb, --codliy-bg-deep), which
         * are injected by ThemeSetting::getCssVariables() at runtime. So when
         * the admin changes "Primary color" in Theme Settings, this page
         * updates instantly — no hardcoded hex values.
         */
        .page-hero {
            position: relative;
            min-height: 40vh;
            display: flex;
            align-items: center;
            background: linear-gradient(
                135deg,
                var(--codliy-bg-deep, #0A1F4D) 0%,
                color-mix(in srgb, var(--codliy-bg-deep, #0A1F4D) 60%, var(--codliy-primary, #0056F8)) 55%,
                var(--codliy-primary, #0056F8) 100%
            );
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            /* Subtle dot pattern — same alpha on any primary color so it
               reads on blue, purple, green, etc. Uses currentColor so it
               inherits the text color of the surrounding element. */
            background-image: radial-gradient(rgba(255, 255, 255, 0.06) 1.2px, transparent 1.2px);
            background-size: 22px 22px;
            opacity: 0.9;
            pointer-events: none;
        }

        .page-hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.18;
            mix-blend-mode: luminosity;
        }

        .page-hero-content {
            position: relative;
            z-index: 1;
        }

        .page-content {
            font-size: 1.1rem;
            line-height: 1.9;
        }

        .page-content h2,
        .page-content h3,
        .page-content h4 {
            color: var(--bs-heading-color, var(--codliy-bg-deep, #0A1F4D));
        }

        .page-content h2 { margin-top: 2rem;    margin-bottom: 1rem; }
        .page-content h3 { margin-top: 1.5rem;  margin-bottom: 0.75rem; }

        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5rem 0;
        }

        .page-content ul,
        .page-content ol {
            margin: 1rem 0;
            padding-inline-start: 1.5rem;
        }

        .page-content li { margin-bottom: 0.5rem; }

        .page-content blockquote {
            border-inline-start: 4px solid var(--codliy-primary, #0056F8);
            padding: 1rem 1.5rem;
            margin: 1.5rem 0;
            background: rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.06);
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .page-content a {
            color: var(--codliy-primary, #0056F8);
            text-decoration: none;
        }
        .page-content a:hover {
            color: var(--codliy-accent, var(--codliy-primary, #0056F8));
            text-decoration: underline;
        }

        .page-card {
            border: none;
            box-shadow: 0 10px 40px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.08);
            border-radius: 1rem;
        }

        .sidebar-card {
            border: none;
            box-shadow: 0 5px 20px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.06);
            border-radius: 0.75rem;
        }

        .sidebar-card .card-header {
            background: linear-gradient(135deg,
                var(--codliy-bg-deep, #0A1F4D) 0%,
                var(--codliy-primary, #0056F8) 100%);
            color: #fff;
            border-radius: 0.75rem 0.75rem 0 0;
        }

        .child-page-link {
            display: block;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.08);
            color: var(--bs-body-color, #1a2338);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .child-page-link:last-child { border-bottom: none; }

        .child-page-link:hover {
            background: rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.08);
            color: var(--codliy-primary, #0056F8);
            padding-inline-start: 1.5rem;
        }
    </style>
@endsection

@section('content')
    @php
        use Modules\CMS\Enums\PageTemplateEnum;

        $featuredImage     = $page->getFirstMediaUrl('featured_image');
        $isLandingTemplate = $page->template === PageTemplateEnum::LANDING;

        /*
         * Resolve the title with a robust fallback chain so the hero never
         * renders empty when a translation is missing for the current locale:
         *   current locale  ->  app fallback locale  ->  any saved locale
         *   ->  humanized slug (last resort).
         */
        $resolveTranslated = function ($field) use ($page, $locale) {
            $value = $page->getTranslation($field, $locale);
            if (filled($value)) {
                return $value;
            }
            $fallback = $page->getTranslation($field, config('app.fallback_locale', 'en'));
            if (filled($fallback)) {
                return $fallback;
            }
            foreach ($page->getTranslations($field) as $any) {
                if (filled($any)) {
                    return $any;
                }
            }
            return null;
        };

        $pageTitle   = $resolveTranslated('title') ?: ucwords(str_replace(['-', '_'], ' ', $page->slug));
        $pageExcerpt = $resolveTranslated('excerpt');
        $pageContent = $resolveTranslated('content');

        // For LANDING-template pages, the hero normally comes from a CMS
        // panel. But if there are no panels, we still need *something* so
        // the page isn't title-less — show a compact hero with just the title.
        $hasCmsPanels = $page->activePanels->count() > 0;
        $showHero     = !$isLandingTemplate || !$hasCmsPanels;
    @endphp

    {{-- Hero Section --}}
    @if($showHero)
        <section class="page-hero first-section-pt">
            @if($featuredImage)
                <div class="page-hero-bg" style="background-image: url('{{ $featuredImage }}');"></div>
            @endif
            <div class="container page-hero-content py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 text-center text-white">
                        {{-- Breadcrumb --}}
                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb breadcrumb-style1 justify-content-center mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('landing.home') }}" class="text-white-50">
                                        {{ __('customer.breadcrumbs.home') }}
                                    </a>
                                </li>
                                @if($page->parent)
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('page.show', $page->parent->slug) }}" class="text-white-50">
                                            {{ $page->parent->getTranslation('title', $locale)
                                                ?: $page->parent->getTranslation('title', config('app.fallback_locale', 'en'))
                                                ?: $page->parent->slug }}
                                        </a>
                                    </li>
                                @endif
                                <li class="breadcrumb-item text-white">
                                    {{ Str::limit($pageTitle, 40) }}
                                </li>
                            </ol>
                        </nav>

                        <h1 class="display-5 fw-bold mb-3">{{ $pageTitle }}</h1>

                        @if($pageExcerpt)
                            <p class="lead opacity-75 mb-0 mx-auto" style="max-width: 700px;">
                                {{ $pageExcerpt }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Panel Builder Content (Full Width Sections) --}}
    @if($page->use_panel_builder && $page->activePanels->count() > 0)
        @foreach($page->activePanels as $panel)
            @include('website::panels.render', ['panel' => $panel])
        @endforeach
    @else
        {{-- Regular Content Section --}}
        <section class="section-py bg-body">
            <div class="container">
                <div class="row">
                    {{-- Main Content Column --}}
                    <div class="col-lg-{{ ($page->children->count() > 0 || $page->parent) ? '8' : '12' }}">
                        <div class="card page-card">
                            <div class="card-body p-4 p-lg-5">
                                @if($featuredImage)
                                    <img src="{{ $featuredImage }}"
                                         alt="{{ $pageTitle }}"
                                         class="img-fluid rounded-3 mb-4 w-100"
                                         style="max-height: 400px; object-fit: cover;">
                                @endif

                                @if($pageContent)
                                    <div class="page-content">
                                        {!! $pageContent !!}
                                    </div>
                                @else
                                    <div class="text-center py-5 text-muted">
                                        <i class="ti tabler-file-text display-4 mb-3"></i>
                                        <p>{{ __('No content available for this page.') }}</p>
                                    </div>
                                @endif

                                @if($page->updated_at)
                                    <hr class="my-4">
                                    <p class="text-muted mb-0 small">
                                        <i class="ti tabler-clock me-1"></i>
                                        {{ __('Last updated') }}: {{ $page->updated_at->format('F j, Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    @if($page->children->count() > 0 || $page->parent)
                        <div class="col-lg-4">
                            <div class="sticky-top" style="top: 100px;">
                                {{-- Child Pages --}}
                                @if($page->children->count() > 0)
                                    <div class="card sidebar-card mb-4">
                                        <div class="card-header py-3">
                                            <h5 class="mb-0">
                                                <i class="ti tabler-list me-2"></i>{{ __('In This Section') }}
                                            </h5>
                                        </div>
                                        <div class="card-body p-0">
                                            @foreach($page->children as $child)
                                                @if($child->isPublished())
                                                    <a href="{{ route('page.show', $child->slug) }}" class="child-page-link">
                                                        <i class="ti tabler-chevron-right me-2"></i>
                                                        {{ $child->getTranslation('title', $locale)
                                                            ?: $child->getTranslation('title', config('app.fallback_locale', 'en'))
                                                            ?: $child->slug }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Sibling Pages (if has parent) --}}
                                @if($page->parent && $page->parent->children->count() > 1)
                                    <div class="card sidebar-card">
                                        <div class="card-header py-3">
                                            <h5 class="mb-0">
                                                <i class="ti tabler-files me-2"></i>{{ __('Related Pages') }}
                                            </h5>
                                        </div>
                                        <div class="card-body p-0">
                                            @foreach($page->parent->children as $sibling)
                                                @if($sibling->isPublished() && $sibling->id !== $page->id)
                                                    <a href="{{ route('page.show', $sibling->slug) }}" class="child-page-link">
                                                        <i class="ti tabler-chevron-right me-2"></i>
                                                        {{ $sibling->getTranslation('title', $locale)
                                                            ?: $sibling->getTranslation('title', config('app.fallback_locale', 'en'))
                                                            ?: $sibling->slug }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Show Panels After Content if page has both content and panels --}}
    @if(!$page->use_panel_builder && $page->activePanels->count() > 0)
        @foreach($page->activePanels as $panel)
            @include('website::panels.render', ['panel' => $panel])
        @endforeach
    @endif
@endsection
