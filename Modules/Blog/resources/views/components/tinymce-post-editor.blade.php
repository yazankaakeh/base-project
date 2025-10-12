@php
    use Modules\Core\App\Enums\LanguageEnum;
    use Modules\Blog\Enums\PostTypeEnum;

    // Default values
    $languages = $languages ?? LanguageEnum::values();
    $currentLang = $currentLang ?? app()->getLocale();
    $titleField = $titleField ?? 'title';
    $descriptionField = $descriptionField ?? 'description';
    $seoTitleField = $seoTitleField ?? 'seo_title';
    $seoDescriptionField = $seoDescriptionField ?? 'seo_description';
    $isEdit = $isEdit ?? false;
    $model = $model ?? null;
    $formId = $formId ?? 'post-form';
    $showSeo = $showSeo ?? true;
    $showImage = $showImage ?? true;
    $showTags = $showTags ?? true;
    $showType = $showType ?? true;
    $showRelatedPosts = $showRelatedPosts ?? true;
    $tagOptions = $tagOptions ?? [];
    $relatedPostsOptions = $relatedPostsOptions ?? [];
    $selectedTags = $selectedTags ?? [];
    $selectedRelatedPosts = $selectedRelatedPosts ?? [];
    $selectedType = $selectedType ?? '';
    $imageUrl = $imageUrl ?? null;
@endphp

<div class="tinymce-post-editor" id="{{ $formId }}">
    <!-- Language Tabs -->
    <div class="card-header px-0 pt-0">
        <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
                @foreach($languages as $lang)
                    <li class="nav-item" role="presentation">
                        <button type="button"
                                class="nav-link waves-effect {{$lang == $currentLang ? 'active': ''}}"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-tab-{{$lang}}"
                                aria-controls="navs-tab-{{$lang}}"
                                aria-selected="{{$lang == $currentLang ? 'true' : 'false'}}">
                            {{ strtoupper($lang) }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        @foreach($languages as $lang)
            <div class="tab-pane fade {{ $lang == $currentLang ? 'active show': '' }}"
                 id="navs-tab-{{$lang}}" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-1">{{ strtoupper($lang) }} {{ trans('blog::blog.post.content') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Title Field -->
                            <div class="col-12">
                                <x-core::input
                                    :label="trans('blog::blog.post.title')"
                                    type="text"
                                    :name="$titleField . '[' . $lang . ']'"
                                    :id="$titleField . '[' . $lang . ']'"
                                    :value="$isEdit && $model ? $model->getTranslation($titleField, $lang) : ''"
                                    required="required">
                                </x-core::input>
                            </div>

                            <!-- TinyMCE Editor -->
                            <div class="col-12">
                                <div class="my-3">
                                    <label class="form-label">{{ trans('blog::blog.post.content') }}</label>
                                    <textarea id="editor-{{ $lang }}"
                                              class="tinymce-editor"
                                              data-lang="{{ $lang }}"
                                              data-input="{{ $descriptionField }}-{{ $lang }}"
                                              data-upload="{{ route('tinymce.upload') }}"
                                              data-content="{{ $isEdit && $model ? $model->getTranslation($descriptionField, $lang) : '' }}"
                                              dir="{{ in_array($lang, ['ar','fa','he','ur']) ? 'rtl' : 'ltr' }}"
                                              rows="15">{{ $isEdit && $model ? $model->getTranslation($descriptionField, $lang) : '' }}</textarea>
                                    <input type="hidden"
                                           name="{{ $descriptionField }}[{{$lang}}]"
                                           id="{{ $descriptionField }}-{{$lang}}"
                                           value="{{ $isEdit && $model ? $model->getTranslation($descriptionField, $lang) : '' }}">
                                </div>
                            </div>

                            <!-- SEO Fields -->
                            @if($showSeo)
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">{{ trans('blog::blog.seo.title') }} ({{ strtoupper($lang) }})</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <x-core::input
                                                        :label="trans('blog::blog.seo.title')"
                                                        type="text"
                                                        :name="$seoTitleField . '[' . $lang . ']'"
                                                        :id="$seoTitleField . '[' . $lang . ']'"
                                                        :value="$isEdit && $model && $model->seo ? $model->seo->getTranslation($seoTitleField, $lang) : ''"
                                                        :placeholder="trans('blog::blog.seo.titlePlaceholder')">
                                                    </x-core::input>
                                                </div>
                                                <div class="col-12">
                                                    <x-core::textarea
                                                        :label="trans('blog::blog.seo.description')"
                                                        :name="$seoDescriptionField . '[' . $lang . ']'"
                                                        :id="$seoDescriptionField . '[' . $lang . ']'"
                                                        :value="$isEdit && $model && $model->seo ? $model->seo->getTranslation($seoDescriptionField, $lang) : ''"
                                                        :placeholder="trans('blog::blog.seo.descriptionPlaceholder')"
                                                        rows="3">
                                                    </x-core::textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Sidebar Form -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <!-- Additional content can be added here -->
        </div>

        <div class="col-lg-4">
            <!-- Image Upload -->
            @if($showImage)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-1">{{ trans('blog::blog.post.image') }}</h5>
                    </div>
                    <div class="card-body">
                        @if($imageUrl)
                            <div class="mb-3">
                                <img src="{{ $imageUrl }}" class="img-fluid rounded" alt="Post Image"/>
                            </div>
                        @endif
                        <x-core::input
                            :label="trans('blog::blog.post.image')"
                            type="file"
                            name="image"
                            id="image"
                            :required="!$imageUrl"
                            accept="image/*">
                        </x-core::input>
                    </div>
                </div>
            @endif

            <!-- Post Type -->
            @if($showType)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-1">{{ trans('blog::blog.post.type') }}</h5>
                    </div>
                    <div class="card-body">
                        <x-core::select
                            :label="trans('blog::blog.post.type')"
                            :placeholder="trans('blog::blog.post.type')"
                            id="type"
                            name="type"
                            required="required"
                            :options="PostTypeEnum::getAllEnumValuesKeysLabel()"
                            :value="$selectedType">
                        </x-core::select>
                    </div>
                </div>
            @endif

            <!-- Tags -->
            @if($showTags)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-1">{{ trans('blog::blog.post.tags') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <select id="tags" name="tags[]" multiple class="form-select select2" style="flex: 1;">
                                @foreach($tagOptions as $id => $name)
                                    <option value="{{ $id }}" @if(in_array($id, $selectedTags)) selected @endif>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createTagModal">
                                <i class="ti tabler-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Related Posts -->
            @if($showRelatedPosts)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-1">{{ trans('blog::blog.post.relatedPost') }}</h5>
                    </div>
                    <div class="card-body">
                        <x-core::select
                            :label="trans('blog::blog.post.relatedPost')"
                            :placeholder="trans('blog::blog.post.relatedPost')"
                            id="relatedPosts"
                            name="relatedPosts[]"
                            multiple="true"
                            :options="$relatedPostsOptions"
                            :values="$selectedRelatedPosts">
                        </x-core::select>
                    </div>
                </div>
            @endif

            <!-- Save Button -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti tabler-device-floppy me-1"></i>
                        {{ $isEdit ? trans('core::core.env.save') : trans('blog::blog.post.create') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tag Creation Modal -->
@if($showTags)
    @include('blog::partials.tag-modal')
@endif

<style>
.tinymce-post-editor .nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
}

.tinymce-post-editor .nav-tabs .nav-link.active {
    color: var(--bs-primary);
    background-color: var(--bs-body-bg);
    border-color: var(--bs-border-color) var(--bs-border-color) var(--bs-body-bg);
}

.tinymce-post-editor .card {
    border: 1px solid var(--bs-border-color);
    border-radius: 0.375rem;
}

.tinymce-post-editor .card-header {
    background-color: var(--bs-light);
    border-bottom: 1px solid var(--bs-border-color);
}

.tinymce-post-editor .select2-container {
    width: 100% !important;
}

.tinymce-post-editor .tox-tinymce {
    border-radius: 0.375rem;
}

/* Dark mode support */
[data-bs-theme="dark"] .tinymce-post-editor .card-header {
    background-color: var(--bs-dark);
}

[data-bs-theme="dark"] .tinymce-post-editor .nav-tabs .nav-link.active {
    background-color: var(--bs-dark);
    border-color: var(--bs-border-color) var(--bs-border-color) var(--bs-dark);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for tags
    if (document.querySelector('#tags')) {
        $('#tags').select2({
            placeholder: '{{ trans("blog::blog.post.selectTags") }}',
            allowClear: true,
            tags: false
        });
    }

    // Initialize Select2 for related posts
    if (document.querySelector('#relatedPosts')) {
        $('#relatedPosts').select2({
            placeholder: '{{ trans("blog::blog.post.selectRelatedPosts") }}',
            allowClear: true,
            tags: false
        });
    }

    // Manual TinyMCE initialization as fallback
    setTimeout(function() {
        if (typeof window.manualInitTinyMCE === 'function') {
            console.log('Manual TinyMCE initialization triggered for post editor');
            window.manualInitTinyMCE();
        }
    }, 1000);

    // Form submission handler
    const form = document.getElementById('{{ $formId }}');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Ensure all TinyMCE editors sync their content
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }
        });
    }
});
</script>
