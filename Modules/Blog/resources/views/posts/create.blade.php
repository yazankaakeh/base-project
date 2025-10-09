<?php

use Modules\Blog\Enums\PostTypeEnum;
use Modules\Core\App\Enums\LanguageEnum;

$page = 'sales-dashboard'; ?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('blog::blog.post.create_title'))

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
            'resources/assets/vendor/libs/quill/typography.scss',
            'resources/assets/vendor/libs/highlight/highlight.scss',
            'resources/assets/vendor/libs/quill/katex.scss',
            'resources/assets/vendor/libs/quill/editor.scss'],
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
            'resources/assets/vendor/libs/quill/katex.js',
            'resources/assets/vendor/libs/highlight/highlight.js',
            'resources/assets/vendor/libs/quill/quill.js',
            'resources/assets/vendor/libs/@form-validation/popular.js',
            'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
            'resources/assets/vendor/libs/@form-validation/auto-focus.js'],
            'build/modules/theme')
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/forms-file-upload.js','resources/assets/js/forms-editors.js'],'build/modules/theme')
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
                        <div class="tab-content mt-3 p-0">
                            @foreach(LanguageEnum::values() as $lang)
                                <div class="tab-pane fade {{$lang == app()->getLocale() ? 'active show': ''}}"
                                     id="navs-tab-{{$lang}}" role="tabpanel">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-1">{{$lang}}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <x-core::input label="blog::blog.post.title"
                                                                           type="text"
                                                                           name="title[{{$lang}}]"
                                                                           id="title[{{$lang}}]">

                                                            </x-core::input>
                                                        </div>
                                                        <div class="col-6">
                                                            <x-core::select
                                                                    :label="trans('blog::blog.post.type')"
                                                                    :placeholder="trans('blog::blog.post.type')"
                                                                    id="type[{{$lang}}]"
                                                                    name="type[{{$lang}}]"
                                                                    required="required"
                                                                    :options="PostTypeEnum::getAllEnumValuesKeysLabel()"
                                                                    value="">
                                                            </x-core::select>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="my-3">
                                                                <!-- Full Editor -->
                                                                <div id="editor-{{ $lang }}"
                                                                     class="quill-editor"
                                                                     data-lang="{{ $lang }}"
                                                                     data-input="postContent-{{ $lang }}"
                                                                     data-upload="/quillUpload/store"
                                                                     dir="{{ in_array($lang, ['ar','fa','he','ur']) ? 'rtl' : 'ltr' }}">
                                                                    <h6>Quill Rich Text Editor</h6>
                                                                    <p>Cupcake ipsum dolor sit amet. Halvah cheesecake
                                                                        chocolate
                                                                        bar
                                                                        gummi bears cupcake. Pie macaroon bear claw.
                                                                        Soufflé I love candy canes I love cotton candy I
                                                                        love.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            @includeIf('seo::partials.create_seo')
                                            <div class="card my-3">
                                                <div class="card-header">
                                                    <h5 class="mb-1">{{trans('blog::blog.post.image')}}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <x-core::input label="blog::blog.post.image"
                                                                   type="file"
                                                                   name="image"
                                                                   id="image">

                                                    </x-core::input>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-3">
                                    <div class="card my-3">
                                        <div class="card-header">
                                            <h5 class="mb-1">{{trans('blog::blog.post.relatedPost')}}</h5>
                                        </div>
                                        <div class="card-body">
                                            <x-core::select
                                                    :label="trans('blog::blog.post.relatedPost')"
                                                    :placeholder="trans('blog::blog.post.relatedPost')"
                                                    id="relatedPosts[]"
                                                    name="relatedPosts[]"
                                                    required="required"
                                                    multiple="true"
                                                    :options="PostTypeEnum::getAllEnumValuesKeysLabel()"
                                                    value="">
                                            </x-core::select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection