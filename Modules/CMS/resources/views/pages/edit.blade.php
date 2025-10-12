@php
use Modules\Core\App\Enums\LanguageEnum;
$pageVar = 'cms-pages';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.pages.edit'))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss',
            'resources/assets/vendor/libs/quill/typography.scss',
            'resources/assets/vendor/libs/quill/editor.scss'],
            'build/modules/theme')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/libs/quill/quill.js'],
            'build/modules/theme')
@endsection

@section('page-script')
    @vite(['resources/assets/js/forms-editors.js'],'build/modules/theme')
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
                                                aria-controls="navs-tab-{{$lang}}" aria-selected="{{$lang == app()->getLocale() ? 'true' : 'false'}}">
                                            {{ strtoupper($lang) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <form action="{{ route('cms.update', $page->id) }}" method="post" enctype="multipart/form-data">
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
                                                            <label for="title-{{$lang}}" class="form-label">Title *</label>
                                                            <input type="text" class="form-control @error('title.'.$lang) is-invalid @enderror"
                                                                   name="title[{{$lang}}]" id="title-{{$lang}}"
                                                                   value="{{ old('title.'.$lang, $page->getTranslation('title', $lang)) }}" required>
                                                            @error('title.'.$lang)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label for="excerpt-{{$lang}}" class="form-label">Excerpt</label>
                                                            <textarea class="form-control @error('excerpt.'.$lang) is-invalid @enderror"
                                                                      name="excerpt[{{$lang}}]" id="excerpt-{{$lang}}"
                                                                      rows="2">{{ old('excerpt.'.$lang, $page->getTranslation('excerpt', $lang)) }}</textarea>
                                                            @error('excerpt.'.$lang)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Content</label>
                                                            <div id="editor-{{ $lang }}" class="quill-editor"
                                                                 data-lang="{{ $lang }}"
                                                                 data-input="content-{{ $lang }}"
                                                                 data-content="{{ $page->getTranslation('content', $lang) ?? '' }}"
                                                                 dir="{{ in_array($lang, ['ar','fa','he','ur']) ? 'rtl' : 'ltr' }}">
                                                            </div>
                                                            <input type="hidden" name="content[{{$lang}}]" id="content-{{$lang}}"
                                                                   value="{{ old('content.'.$lang, $page->getTranslation('content', $lang)) }}">
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
                                            <label for="slug" class="form-label">Slug *</label>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                                   name="slug" id="slug" value="{{ old('slug', $page->slug) }}" required>
                                            @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">URL-friendly slug (e.g., my-page-name)</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status *</label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                    name="status" id="status" required>
                                                @foreach($statusOptions as $value => $label)
                                                    <option value="{{ $value }}" {{ old('status', $page->status->value) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="template" class="form-label">Template *</label>
                                            <select class="form-select @error('template') is-invalid @enderror"
                                                    name="template" id="template" required>
                                                @foreach($templateOptions as $value => $label)
                                                    <option value="{{ $value }}" {{ old('template', $page->template->value) == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('template')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="parent_id" class="form-label">Parent Page</label>
                                            <select class="form-select @error('parent_id') is-invalid @enderror"
                                                    name="parent_id" id="parent_id">
                                                <option value="">None</option>
                                                @foreach($parentOptions as $id => $title)
                                                    <option value="{{ $id }}" {{ old('parent_id', $page->parent_id) == $id ? 'selected' : '' }}>
                                                        {{ $title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="order" class="form-label">Order</label>
                                            <input type="number" class="form-control @error('order') is-invalid @enderror"
                                                   name="order" id="order" value="{{ old('order', $page->order) }}" min="0">
                                            @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="featured_image" class="form-label">Featured Image</label>
                                            @if($page->getFirstMediaUrl('featured_image'))
                                                <div class="mb-2">
                                                    <img src="{{ $page->getFirstMediaUrl('featured_image') }}" alt="Featured Image"
                                                         class="img-fluid rounded" style="max-height: 200px;">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                                   name="featured_image" id="featured_image" accept="image/*">
                                            @error('featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="published_at" class="form-label">Publish Date</label>
                                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                                   name="published_at" id="published_at"
                                                   value="{{ old('published_at', $page->published_at?->format('Y-m-d\TH:i')) }}">
                                            @error('published_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100">{{ trans('cms::cms.pages.update') }}</button>
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
