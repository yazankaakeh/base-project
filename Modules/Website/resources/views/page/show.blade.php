@extends('theme::user.layouts.layoutFront')

@section('title', $page->getTranslation('title', $locale))

@section('meta')
    @if($page->getTranslation('excerpt', $locale))
        <meta name="description" content="{{ Str::limit(strip_tags($page->getTranslation('excerpt', $locale)), 160) }}">
    @endif
    @if($page->getFirstMediaUrl('featured_image'))
        <meta property="og:image" content="{{ $page->getFirstMediaUrl('featured_image') }}">
    @endif
@endsection

@section('page-style')
    <style>
        :root {
            --theme-primary: #1EAAE7;
            --theme-secondary: #092C4C;
            --theme-accent: #ff8510;
        }

        .page-hero {
            position: relative;
            min-height: 40vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, var(--theme-secondary) 0%, #0d3a5c 50%, var(--theme-primary) 100%);
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231EAAE7' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .page-hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0.15;
        }

        .page-hero-content {
            position: relative;
            z-index: 1;
        }

        .page-content {
            font-size: 1.1rem;
            line-height: 1.9;
        }

        .page-content h2 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--theme-secondary);
        }

        .page-content h3 {
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            color: var(--theme-secondary);
        }

        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5rem 0;
        }

        .page-content ul,
        .page-content ol {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }

        .page-content li {
            margin-bottom: 0.5rem;
        }

        .page-content blockquote {
            border-left: 4px solid var(--theme-primary);
            padding: 1rem 1.5rem;
            margin: 1.5rem 0;
            background: rgba(30, 170, 231, 0.05);
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .page-content a {
            color: var(--theme-primary);
            text-decoration: none;
        }

        .page-content a:hover {
            color: var(--theme-accent);
            text-decoration: underline;
        }

        .page-card {
            border: none;
            box-shadow: 0 10px 40px rgba(9, 44, 76, 0.08);
            border-radius: 1rem;
        }

        .sidebar-card {
            border: none;
            box-shadow: 0 5px 20px rgba(9, 44, 76, 0.06);
            border-radius: 0.75rem;
        }

        .sidebar-card .card-header {
            background: linear-gradient(135deg, var(--theme-secondary) 0%, var(--theme-primary) 100%);
            color: white;
            border-radius: 0.75rem 0.75rem 0 0;
        }

        .child-page-link {
            display: block;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(9, 44, 76, 0.08);
            color: var(--theme-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .child-page-link:last-child {
            border-bottom: none;
        }

        .child-page-link:hover {
            background: rgba(30, 170, 231, 0.08);
            color: var(--theme-primary);
            padding-left: 1.5rem;
        }
    </style>
@endsection

@section('content')
    @php
        $featuredImage = $page->getFirstMediaUrl('featured_image');
    @endphp

    {{-- Hero Section --}}
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
                                        {{ $page->parent->getTranslation('title', $locale) }}
                                    </a>
                                </li>
                            @endif
                            <li class="breadcrumb-item text-white">
                                {{ Str::limit($page->getTranslation('title', $locale), 40) }}
                            </li>
                        </ol>
                    </nav>

                    <h1 class="display-5 fw-bold mb-3">{{ $page->getTranslation('title', $locale) }}</h1>

                    @if($page->getTranslation('excerpt', $locale))
                        <p class="lead opacity-75 mb-0 mx-auto" style="max-width: 700px;">
                            {{ $page->getTranslation('excerpt', $locale) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Panel Builder Content (Full Width Sections) --}}
    @if($page->use_panel_builder && $page->activePanels->count() > 0)
        @foreach($page->activePanels as $panel)
            @includeIf('website::panels.' . $panel->type->value, ['panel' => $panel])
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
                                         alt="{{ $page->getTranslation('title', $locale) }}"
                                         class="img-fluid rounded-3 mb-4 w-100"
                                         style="max-height: 400px; object-fit: cover;">
                                @endif

                                @php
                                    $content = $page->getTranslation('content', $locale);
                                @endphp

                                @if($content)
                                    <div class="page-content">
                                        {!! $content !!}
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
                                                        {{ $child->getTranslation('title', $locale) }}
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
                                                        {{ $sibling->getTranslation('title', $locale) }}
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
            @includeIf('website::panels.' . $panel->type->value, ['panel' => $panel])
        @endforeach
    @endif
@endsection
