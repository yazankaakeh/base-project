@php
use Modules\Core\App\Enums\LanguageEnum;
use Modules\Blog\Enums\PostTypeEnum;
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('blog::blog.post.edit'))

<!-- Vendor Styles -->
@section('vendor-style')
    @livewireStyles
    @livewireScripts
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.scss'],
            'build/modules/theme')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
            'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
            'resources/assets/vendor/libs/select2/select2.scss',
            'resources/assets/vendor/libs/@form-validation/form-validation.scss'],
            'build/modules/theme')
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.js'], 'build/modules/theme')
    @vite([ 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
            'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
            'resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/libs/@form-validation/popular.js',
            'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
            'resources/assets/vendor/libs/@form-validation/auto-focus.js'],
            'build/modules/theme')
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/forms-file-upload.js','resources/assets/js/forms-editors.js','resources/assets/js/blog-tinymce-config.js'],'build/modules/theme')
@endsection

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-2 mb-1">
                        <h5 class="">{{ trans('blog::blog.post.edit') }}</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('doctor.posts.index') }}" class="btn btn-outline-secondary">
                                <i class="ti tabler-arrow-left me-1"></i>
                                {{ trans('core::core.env.back') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <form action="{{ route('doctor.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @include('blog::components.tinymce-post-editor', [
                                    'formId' => 'edit-post-form',
                                    'isEdit' => true,
                                    'model' => $post,
                                    'showSeo' => true,
                                    'showImage' => true,
                                    'showTags' => true,
                                    'showType' => true,
                                    'showRelatedPosts' => true,
                                    'tagOptions' => $tagOptions ?? [],
                                    'relatedPostsOptions' => $relatedPostsOptions ?? [],
                                    'selectedTags' => $post->tags->pluck('id')->toArray(),
                                    'selectedRelatedPosts' => $post->relatedPosts->pluck('id')->toArray(),
                                    'selectedType' => $post->type ?? '',
                                    'imageUrl' => $post->getFirstMediaUrl('image')
                                ])
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
