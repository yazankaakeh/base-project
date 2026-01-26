@php
    use Modules\Core\App\Enums\LanguageEnum;
    $page = 'cms-pages';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.pages.create'))

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
    @vite(['resources/assets/js/forms-file-upload.js','resources/assets/js/forms-editors.js'],'build/modules/theme')
    @vite([
            'resources/assets/js/panel-builder.js'
        ],'build/modules/theme')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">
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
                    <form action="{{ route('cms.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
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
                                                                value="{{ old('title.'.$lang) }}"
                                                                required="required" />
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <x-core::textarea
                                                                label="cms::cms.pages.excerpt"
                                                                name="excerpt[{{$lang}}]"
                                                                id="excerpt-{{$lang}}"
                                                                value="{{ old('excerpt.'.$lang) }}" />
                                                        </div>
                                                        <div class="col-12">
                                                            <x-core::tinymce
                                                                label="cms::cms.pages.content"
                                                                name="content[{{$lang}}]"
                                                                id="content-{{$lang}}"
                                                                :lang="$lang"
                                                                :value="old('content.'.$lang)" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Panel Builder Section -->
                                @include('cms::partials.panel-builder', ['pageId' => null])
                            </div>
                            <div class="col-3">
                                <div class="card my-3">
                                    <div class="card-header">
                                        <h5 class="mb-1">{{ trans('cms::cms.pages.settings') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <x-core::input
                                                label="cms::cms.pages.slug"
                                                type="text"
                                                name="slug"
                                                id="slug"
                                                value="{{ old('slug') }}"
                                                required="required" />
                                            <small class="text-muted">{{ trans('cms::cms.pages.slug_help') }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <x-core::select
                                                :label="trans('cms::cms.pages.status')"
                                                :placeholder="trans('cms::cms.pages.status')"
                                                id="status"
                                                name="status"
                                                :options="$statusOptions"
                                                value="{{ old('status') }}"
                                                required="required" />
                                        </div>
                                        <div class="mb-3">
                                            <x-core::select
                                                :label="trans('cms::cms.pages.template')"
                                                :placeholder="trans('cms::cms.pages.template')"
                                                id="template"
                                                name="template"
                                                :options="$templateOptions"
                                                value="{{ old('template') }}"
                                                required="required" />
                                        </div>
                                        <div class="mb-3">
                                            <x-core::select
                                                :label="trans('cms::cms.pages.parent_page')"
                                                :placeholder="trans('cms::cms.pages.none')"
                                                id="parent_id"
                                                name="parent_id"
                                                :options="$parentOptions"
                                                value="{{ old('parent_id') }}" />
                                        </div>
                                        <div class="mb-3">
                                            <x-core::input
                                                label="cms::cms.pages.order"
                                                type="number"
                                                name="order"
                                                id="order"
                                                value="{{ old('order', 0) }}" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ trans('cms::cms.pages.featured_image') }}</label>
                                            <input type="file" class="form-control" name="featured_image" id="featured_image"
                                                   accept="image/jpeg,image/png,image/webp">
                                            <small class="text-muted">{{ __('Optional. Max 2MB. Formats: JPG, PNG, WebP') }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                       name="use_panel_builder" id="use_panel_builder" value="1"
                                                       {{ old('use_panel_builder') ? 'checked' : '' }}>
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
                                                value="{{ old('published_at') }}" />
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit"
                                                    class="btn btn-primary w-100">{{ trans('cms::cms.pages.create') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
