<?php

use Modules\Blog\Enums\PostTypeEnum;
use Modules\Core\App\Enums\LanguageEnum;

$page = 'sales-dashboard'; ?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('blog::blog.post.edit_title'))

<!-- Vendor Styles -->
@section('vendor-style')
    @livewireStyles
    @livewireScripts
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.scss'],
            'build/modules/theme')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
            'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
            'resources/assets/vendor/libs/select2/select2.scss',
            'resources/assets/vendor/libs/@form-validation/form-validation.scss',
            'resources/assets/vendor/libs/highlight/highlight.scss'],
            'build/modules/theme')
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('.select2').each(function () {
                $(this).select2({
                    allowClear: true,
                    tags: false
                });
            });
        })
    </script>
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.js'], 'build/modules/theme')
    @vite([ 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
            'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
            'resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/libs/highlight/highlight.js',
            'resources/assets/vendor/libs/@form-validation/popular.js',
            'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
            'resources/assets/vendor/libs/@form-validation/auto-focus.js'],
            'build/modules/theme')
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/forms-file-upload.js','resources/assets/js/forms-editors.js'],'build/modules/theme')

    <script>
        $(document).ready(function() {
            // Initialize Select2 for tags
            $('#tags').select2({
                placeholder: 'Select tags...',
                allowClear: true,
                tags: false
            });

        });
    </script>
    @includeIf('blog::partials.tag-modal')

@endsection


@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="">
                        <div class="card-header px-0 pt-0">
                            <div class="nav-align-top">
                                <ul class="nav nav-tabs" role="tablist">
                                    @foreach(LanguageEnum::values() as $lang)
                                        <li class="nav-item" role="presentation">
                                            <button type="button"
                                                    class="nav-link waves-effect {{$lang == app()->getLocale() ? 'active': ''}}"
                                                    role="tab"
                                                    data-bs-toggle="tab" data-bs-target="#navs-tab-{{$lang}}"
                                                    aria-controls="navs-tab-home" aria-selected="true">{{$lang}}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <form action="{{ route('doctor.posts.update', $post->id) }}" method="post"
                              enctype="multipart/form-data">
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
                                                        <h5 class="mb-1">{{$lang}}</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <x-core::input label="blog::blog.post.title" type="text"
                                                                               name="title[{{$lang}}]"
                                                                               id="title[{{$lang}}]"
                                                                               :value="$post->getTranslation('title', $lang)"></x-core::input>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="my-3">
                                                                    <div id="editor-{{ $lang }}" class="quill-editor"
                                                                         data-lang="{{ $lang }}"
                                                                         data-input="postContent-{{ $lang }}"
                                                                         data-upload="{{ route('doctor.quillUpload.store') }}"
                                                                         dir="{{ in_array($lang, ['ar','fa','he','ur']) ? 'rtl' : 'ltr' }}">

                                                                    </div>
                                                                    <input type="hidden" name="description[{{$lang}}]"
                                                                           id="postContent-{{$lang}}"
                                                                           value="{{ $post->getTranslation('description', $lang) }}">
                                                                </div>
                                                            </div>
                                                            @php($seo = $post->seo)
                                                            @includeIf('blog::partials.seo_form', [
                                                                'seoTitle' => $seo?->getTranslations('title') ?? null,
                                                                'seoDescription' => $seo?->getTranslations('meta_description') ?? null,
                                                                'lang' => $lang
                                                            ])
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
                                            <h5 class="mb-1">{{trans('blog::blog.post.image')}}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <img src="{{ $post->getFirstMediaUrl('img') }}"
                                                     class="img-fluid rounded" alt=""/>
                                            </div>
                                            <x-core::input label="blog::blog.post.image" required="" type="file"
                                                           name="image" id="image"></x-core::input>
                                            <div class="mt-3">
                                                <x-core::select :label="trans('blog::blog.post.relatedPost')"
                                                                :placeholder="trans('blog::blog.post.relatedPost')"
                                                                id="relatedPosts" name="relatedPosts[]" required=""
                                                                multiple="true" :options="$relatedPostsOptions"
                                                                :values="$post->relatedPosts->pluck('id')->toArray()"></x-core::select>
                                            </div>
                                            <div class="mt-3">
                                                <label for="tags" class="form-label">{{ trans('blog::blog.post.tags') }}</label>
                                                <div class="d-flex gap-2">
                                                    <select id="tags" name="tags[]" multiple class="form-select select2" style="flex: 1;">
                                                        @foreach($tagOptions as $id => $name)
                                                            <option value="{{ $id }}"
                                                                @if($post->tags->contains('id', $id)) selected @endif>
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-outline-primary"
                                                            data-bs-toggle="modal" data-bs-target="#createTagModal">
                                                        <i class="ti tabler-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <x-core::select :label="trans('blog::blog.post.type')"
                                                                :placeholder="trans('blog::blog.post.type')" id="type"
                                                                name="type" required="required"
                                                                :options="PostTypeEnum::getAllEnumValuesKeysLabel()"
                                                                :value="$post->type->value"></x-core::select>
                                            </div>
                                            <div class="mt-3">
                                                <button type="submit"
                                                        class="btn btn-primary">{{ trans('core::core.env.save') }}</button>
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
    </div>
@endsection
