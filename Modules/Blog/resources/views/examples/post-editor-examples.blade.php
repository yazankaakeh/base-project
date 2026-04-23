{{--
    Example usage of TinyMCE Post Editor Components
    This file demonstrates how to use the new blog post editor components
--}}

@extends('theme::user.layouts.horizontalLayout')

@section('title', 'TinyMCE Post Editor Examples')

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

@section('page-script')
    @vite(['resources/assets/js/forms-file-upload.js','resources/assets/js/forms-editors.js','resources/assets/js/blog-tinymce-config.js'],'build/modules/theme')
@endsection

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">TinyMCE Post Editor Examples</h4>
                        <p class="text-muted mb-0">Examples of how to use the new TinyMCE post editor components</p>
                    </div>
                    <div class="card-body">

                        <!-- Example 1: Full Featured Post Editor -->
                        <div class="mb-5">
                            <h5>1. Full Featured Post Editor</h5>
                            <p class="text-muted">Complete post editor with all features including SEO, tags, related posts, etc.</p>

                            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                @include('blog::components.tinymce-post-editor', [
                                    'formId' => 'full-post-form',
                                    'isEdit' => false,
                                    'model' => null,
                                    'showSeo' => true,
                                    'showImage' => true,
                                    'showTags' => true,
                                    'showType' => true,
                                    'showRelatedPosts' => true,
                                    'tagOptions' => [
                                        1 => 'Technology',
                                        2 => 'Health',
                                        3 => 'Lifestyle',
                                        4 => 'News'
                                    ],
                                    'relatedPostsOptions' => [
                                        1 => 'Sample Post 1',
                                        2 => 'Sample Post 2',
                                        3 => 'Sample Post 3'
                                    ]
                                ])
                            </form>
                        </div>

                        <hr class="my-5">

                        <!-- Example 2: Quick Post Editor -->
                        <div class="mb-5">
                            <h5>2. Quick Post Editor</h5>
                            <p class="text-muted">Simplified editor for quick post creation with minimal features.</p>

                            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                @include('blog::components.quick-post-editor', [
                                    'formId' => 'quick-post-form',
                                    'isEdit' => false,
                                    'model' => null,
                                    'showImage' => true,
                                    'showTags' => true,
                                    'tagOptions' => [
                                        1 => 'Technology',
                                        2 => 'Health',
                                        3 => 'Lifestyle',
                                        4 => 'News'
                                    ]
                                ])
                            </form>
                        </div>

                        <hr class="my-5">

                        <!-- Example 3: Minimal Editor -->
                        <div class="mb-5">
                            <h5>3. Minimal Editor</h5>
                            <p class="text-muted">Basic editor with just title and content fields.</p>

                            <form action="{{ route('admin.posts.store') }}" method="POST">
                                @csrf

                                @include('blog::components.quick-post-editor', [
                                    'formId' => 'minimal-post-form',
                                    'isEdit' => false,
                                    'model' => null,
                                    'showImage' => false,
                                    'showTags' => false
                                ])
                            </form>
                        </div>

                        <hr class="my-5">

                        <!-- Example 4: Edit Mode -->
                        <div class="mb-5">
                            <h5>4. Edit Mode Example</h5>
                            <p class="text-muted">Example of how the editor looks in edit mode with existing content.</p>

                            @php
                                // Mock post data for demonstration
                                $mockPost = (object) [
                                    'id' => 1,
                                    'title' => ['en' => 'Sample Blog Post', 'ar' => 'منشور مدونة عينة', 'tr' => 'Örnek Blog Yazısı'],
                                    'description' => [
                                        'en' => '<h2>Introduction</h2><p>This is a sample blog post content with <strong>rich text formatting</strong>.</p><h3>Features</h3><ul><li>Rich text editing</li><li>Image support</li><li>SEO optimization</li></ul>',
                                        'ar' => '<h2>مقدمة</h2><p>هذا محتوى منشور مدونة عينة مع <strong>تنسيق نص غني</strong>.</p>',
                                        'tr' => '<h2>Giriş</h2><p>Bu <strong>zengin metin formatlaması</strong> ile örnek blog yazısı içeriğidir.</p>'
                                    ],
                                    'seo' => (object) [
                                        'seo_title' => ['en' => 'Sample SEO Title', 'ar' => 'عنوان SEO عينة', 'tr' => 'Örnek SEO Başlığı'],
                                        'seo_description' => ['en' => 'Sample SEO description', 'ar' => 'وصف SEO عينة', 'tr' => 'Örnek SEO açıklaması']
                                    ]
                                ];
                            @endphp

                            <form action="{{ route('admin.posts.update', 1) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @include('blog::components.tinymce-post-editor', [
                                    'formId' => 'edit-post-form',
                                    'isEdit' => true,
                                    'model' => $mockPost,
                                    'showSeo' => true,
                                    'showImage' => true,
                                    'showTags' => true,
                                    'showType' => true,
                                    'showRelatedPosts' => true,
                                    'tagOptions' => [
                                        1 => 'Technology',
                                        2 => 'Health',
                                        3 => 'Lifestyle',
                                        4 => 'News'
                                    ],
                                    'relatedPostsOptions' => [
                                        1 => 'Sample Post 1',
                                        2 => 'Sample Post 2',
                                        3 => 'Sample Post 3'
                                    ],
                                    'selectedTags' => [1, 3],
                                    'selectedRelatedPosts' => [2],
                                    'selectedType' => 'article',
                                    'imageUrl' => 'https://via.placeholder.com/400x300'
                                ])
                            </form>
                        </div>

                        <hr class="my-5">

                        <!-- Usage Instructions -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Usage Instructions</h5>
                            </div>
                            <div class="card-body">
                                <h6>1. Full Featured Post Editor</h6>
                                <pre><code>@include('blog::components.tinymce-post-editor', [
    'formId' => 'my-form',
    'isEdit' => false,
    'model' => null,
    'showSeo' => true,
    'showImage' => true,
    'showTags' => true,
    'showType' => true,
    'showRelatedPosts' => true,
    'tagOptions' => $tagOptions,
    'relatedPostsOptions' => $relatedPostsOptions
])</code></pre>

                                <h6>2. Quick Post Editor</h6>
                                <pre><code>@include('blog::components.quick-post-editor', [
    'formId' => 'quick-form',
    'isEdit' => false,
    'model' => null,
    'showImage' => true,
    'showTags' => true,
    'tagOptions' => $tagOptions
])</code></pre>

                                <h6>3. Available Parameters</h6>
                                <ul>
                                    <li><strong>formId</strong>: Unique form identifier</li>
                                    <li><strong>isEdit</strong>: Boolean, true for edit mode</li>
                                    <li><strong>model</strong>: The post model (for edit mode)</li>
                                    <li><strong>showSeo</strong>: Show/hide SEO fields</li>
                                    <li><strong>showImage</strong>: Show/hide image upload</li>
                                    <li><strong>showTags</strong>: Show/hide tags selection</li>
                                    <li><strong>showType</strong>: Show/hide post type selection</li>
                                    <li><strong>showRelatedPosts</strong>: Show/hide related posts</li>
                                    <li><strong>tagOptions</strong>: Array of available tags</li>
                                    <li><strong>relatedPostsOptions</strong>: Array of related posts</li>
                                    <li><strong>selectedTags</strong>: Array of selected tag IDs</li>
                                    <li><strong>selectedRelatedPosts</strong>: Array of selected related post IDs</li>
                                    <li><strong>selectedType</strong>: Selected post type</li>
                                    <li><strong>imageUrl</strong>: Current image URL (for edit mode)</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
