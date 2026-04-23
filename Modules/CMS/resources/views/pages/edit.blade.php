@php
    use Modules\Core\App\Enums\LanguageEnum;
    $pageVar = 'cms-pages';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.pages.edit'))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'],
            'build/modules/theme')
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/sortablejs/sortable.js'
    ], 'build/modules/theme')
@endsection

@section('page-script')
    @vite([
        'resources/assets/js/forms-editors.js',
        'resources/assets/js/panel-builder.js'
    ],'build/modules/theme')
@endsection

@section('content')
    @php
        use Modules\CMS\Enums\PageStatusEnum;

        // Build a "View on site" URL:
        // - slug=home is rendered at the landing route (`/`)
        // - everything else is rendered at `/page/{slug}`
        $viewUrl = $page->slug === 'home'
            ? route('landing.home')
            : route('page.show', $page->slug);

        $isPublished     = $page->status === PageStatusEnum::PUBLISHED;
        $publishedAt     = $page->published_at;
        $hasPublishDate  = $publishedAt !== null;
        $isFutureDated   = $hasPublishDate && $publishedAt->isFuture();
        $isVisibleOnSite = $isPublished && $hasPublishDate && $publishedAt->isPast();

        $statusWarnings = [];
        if (!$isPublished) {
            $statusWarnings[] = [
                'icon' => 'ti tabler-eye-off',
                'text' => __('This page is saved as ":status" — visitors cannot see it yet. Change the status to "Published" to make it live.', [
                    'status' => $page->status->label() ?? $page->status->value,
                ]),
            ];
        } elseif (!$hasPublishDate) {
            $statusWarnings[] = [
                'icon' => 'ti tabler-calendar-off',
                'text' => __('Status is Published but no publish date is set. The page is NOT live. Pick a date (or save — it will be auto-stamped to now).'),
            ];
        } elseif ($isFutureDated) {
            $statusWarnings[] = [
                'icon' => 'ti tabler-clock-hour-3',
                'text' => __('This page is scheduled and will become visible at :date.', [
                    'date' => $publishedAt->format('M d, Y H:i'),
                ]),
            ];
        }
    @endphp

    <div class="page-wrapper">
        <div class="content">
            {{-- Page header: title + quick actions --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <h4 class="mb-0 d-flex align-items-center gap-2">
                        <i class="ti tabler-file-text text-primary"></i>
                        {{ $page->getTranslation('title', app()->getLocale()) ?: $page->slug }}
                    </h4>
                    <small class="text-muted">
                        <code>/{{ $page->slug === 'home' ? '' : 'page/' . $page->slug }}</code>
                        &middot;
                        @if($isVisibleOnSite)
                            <span class="text-success">
                                <i class="ti tabler-circle-check"></i> {{ __('Live') }}
                            </span>
                        @elseif($isFutureDated)
                            <span class="text-warning">
                                <i class="ti tabler-clock"></i> {{ __('Scheduled') }}
                            </span>
                        @else
                            <span class="text-secondary">
                                <i class="ti tabler-eye-off"></i> {{ __('Not live') }}
                            </span>
                        @endif
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ $viewUrl }}" target="_blank" rel="noopener"
                       class="btn btn-outline-primary btn-sm"
                       title="{{ __('Open this page on the public site in a new tab') }}">
                        <i class="ti tabler-external-link me-1"></i>{{ __('View on site') }}
                    </a>
                    <a href="#panel-builder-anchor" class="btn btn-outline-secondary btn-sm">
                        <i class="ti tabler-layout-grid me-1"></i>{{ __('Jump to panels') }}
                    </a>
                </div>
            </div>

            {{-- Status warnings --}}
            @if(count($statusWarnings) > 0)
                <div class="alert alert-warning d-flex align-items-start gap-2 mb-4" role="alert">
                    <i class="ti tabler-alert-triangle mt-1"></i>
                    <div>
                        @foreach($statusWarnings as $w)
                            <div class="{{ !$loop->last ? 'mb-1' : '' }}">
                                <i class="{{ $w['icon'] }} me-1"></i>
                                {{ $w['text'] }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="row mb-5">
                <div class="col-12">
                    <div class="card-header px-0 pt-0">
                        <div class="nav-align-top">
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach(LanguageEnum::values() as $lang)
                                    <li class="nav-item" role="presentation">
                                        <button type="button"
                                                class="nav-link waves-effect {{$lang == app()->getLocale() ? 'active': ''}}"
                                                role="tab"
                                                data-bs-toggle="tab" data-bs-target="#navs-tab-{{$lang}}"
                                                aria-controls="navs-tab-{{$lang}}"
                                                aria-selected="{{$lang == app()->getLocale() ? 'true' : 'false'}}">
                                            {{ strtoupper($lang) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <form action="{{ route('cms.update', $page->id) }}" method="post" enctype="multipart/form-data"
                          data-page-id="{{ $page->id }}" id="page-edit-form">
                        @csrf
                        @method('PUT')
                        <div class="row mt-3">
                            <div class="col-9">
                                <div class="tab-content m-0 p-0">
                                    @foreach(LanguageEnum::values() as $lang)
                                        <div class="tab-pane fade {{$lang == app()->getLocale() ? 'active show': ''}}"
                                             id="navs-tab-{{$lang}}" role="tabpanel">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-1">{{ strtoupper($lang) }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <x-core::input
                                                                    label="cms::cms.common.title"
                                                                    type="text"
                                                                    name="title[{{$lang}}]"
                                                                    id="title-{{$lang}}"
                                                                    value="{{ old('title.'.$lang, $page->getTranslation('title', $lang)) }}"
                                                                    required="required"/>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <x-core::textarea
                                                                    label="cms::cms.pages.excerpt"
                                                                    name="excerpt[{{$lang}}]"
                                                                    id="excerpt-{{$lang}}"
                                                                    value="{{ old('excerpt.'.$lang, $page->getTranslation('excerpt', $lang)) }}"/>
                                                        </div>
                                                        <div class="col-12">
                                                            <x-core::tinymce
                                                                label="cms::cms.pages.content"
                                                                name="content[{{$lang}}]"
                                                                id="content-{{$lang}}"
                                                                :lang="$lang"
                                                                :value="old('content.'.$lang, $page->getTranslation('content', $lang) ?? '')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card my-3">
                                    <div class="card-header">
                                        <h5 class="mb-1">Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <x-core::input
                                                    label="cms::cms.pages.slug"
                                                    type="text"
                                                    name="slug"
                                                    id="slug"
                                                    value="{{ old('slug', $page->slug) }}"
                                                    required="required"/>
                                            <small class="text-muted">URL-friendly slug (e.g., my-page-name)</small>
                                        </div>
                                        <div class="mb-3">
                                            <x-core::select
                                                    :label="trans('cms::cms.pages.status')"
                                                    :placeholder="trans('cms::cms.pages.status')"
                                                    id="status"
                                                    name="status"
                                                    :options="$statusOptions"
                                                    value="{{ old('status', $page->status->value) }}"
                                                    required="required"/>
                                        </div>
                                        <div class="mb-3">
                                            <x-core::select
                                                    :label="trans('cms::cms.pages.template')"
                                                    :placeholder="trans('cms::cms.pages.template')"
                                                    id="template"
                                                    name="template"
                                                    :options="$templateOptions"
                                                    value="{{ old('template', $page->template->value) }}"
                                                    required="required"/>
                                        </div>
                                        <div class="mb-3">
                                            <x-core::select
                                                    required=""
                                                    :label="trans('cms::cms.pages.parent_page')"
                                                    :placeholder="trans('cms::cms.pages.none')"
                                                    id="parent_id"
                                                    name="parent_id"
                                                    :options="$parentOptions"
                                                    value="{{ old('parent_id', $page->parent_id) }}"/>
                                        </div>
                                        <div class="mb-3">
                                            <x-core::input
                                                    label="cms::cms.pages.order"
                                                    type="number"
                                                    name="order"
                                                    id="order"
                                                    value="{{ old('order', $page->order) }}"/>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ trans('cms::cms.pages.featured_image') }}</label>
                                            @if($page->getFirstMediaUrl('featured_image'))
                                                <div class="mb-2 position-relative">
                                                    <img src="{{ $page->getFirstMediaUrl('featured_image') }}"
                                                         alt="Featured Image"
                                                         class="img-fluid rounded" style="max-height: 200px;">
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="remove_featured_image" id="remove_featured_image" value="1">
                                                    <label class="form-check-label text-danger" for="remove_featured_image">
                                                        <i class="ti tabler-trash me-1"></i>{{ __('Remove image') }}
                                                    </label>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="featured_image" id="featured_image"
                                                   accept="image/jpeg,image/png,image/webp">
                                            <small class="text-muted">{{ __('Optional. Max 2MB. Formats: JPG, PNG, WebP') }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                       name="use_panel_builder" id="use_panel_builder" value="1"
                                                       {{ old('use_panel_builder', $page->use_panel_builder) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="use_panel_builder">
                                                    <strong>{{ __('Use Panel Builder') }}</strong>
                                                </label>
                                            </div>
                                            <small class="text-muted">{{ __('Enable to use visual panel builder instead of content editor') }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <x-core::input
                                                    label="cms::cms.pages.publish_date"
                                                    type="datetime-local"
                                                    name="published_at"
                                                    id="published_at"
                                                    value="{{ old('published_at', $page->published_at?->format('Y-m-d\TH:i')) }}"/>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit"
                                                    class="btn btn-primary w-100">{{ trans('cms::cms.pages.update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- Panel Builder (Livewire) - Outside form to prevent form submission issues --}}
                    <div class="row mt-4" id="panel-builder-anchor">
                        <div class="col-12">
                            <livewire:cms::panel-builder :pageId="$page->id"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
