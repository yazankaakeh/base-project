@php
    use Modules\Core\App\Enums\LanguageEnum;

    // Default values
    $currentLang = $currentLang ?? app()->getLocale();
    $titleField = $titleField ?? 'title';
    $descriptionField = $descriptionField ?? 'description';
    $isEdit = $isEdit ?? false;
    $model = $model ?? null;
    $formId = $formId ?? 'quick-post-form';
    $showImage = $showImage ?? false;
    $showTags = $showTags ?? false;
    $tagOptions = $tagOptions ?? [];
    $selectedTags = $selectedTags ?? [];
    $imageUrl = $imageUrl ?? null;
@endphp

<div class="quick-post-editor" id="{{ $formId }}">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="ti tabler-edit me-2"></i>
                {{ $isEdit ? trans('blog::blog.post.edit') : trans('blog::blog.post.create') }}
            </h5>
        </div>
        <div class="card-body">
            <!-- Title Field -->
            <div class="mb-3">
                <x-core::input
                    :label="trans('blog::blog.post.title')"
                    type="text"
                    :name="$titleField . '[' . $currentLang . ']'"
                    :id="$titleField . '[' . $currentLang . ']'"
                    :value="$isEdit && $model ? $model->getTranslation($titleField, $currentLang) : ''"
                    required="required"
                    :placeholder="trans('blog::blog.post.titlePlaceholder')">
                </x-core::input>
            </div>

            <!-- TinyMCE Editor -->
            <div class="mb-3">
                <label class="form-label">{{ trans('blog::blog.post.content') }}</label>
                <textarea id="editor-{{ $currentLang }}"
                          class="tinymce-editor"
                          data-lang="{{ $currentLang }}"
                          data-input="{{ $descriptionField }}-{{ $currentLang }}"
                          data-upload="{{ route('tinymce.upload') }}"
                          data-content="{{ $isEdit && $model ? $model->getTranslation($descriptionField, $currentLang) : '' }}"
                          dir="{{ in_array($currentLang, ['ar','fa','he','ur']) ? 'rtl' : 'ltr' }}"
                          rows="10"
                          :placeholder="trans('blog::blog.post.contentPlaceholder')">{{ $isEdit && $model ? $model->getTranslation($descriptionField, $currentLang) : '' }}</textarea>
                <input type="hidden"
                       name="{{ $descriptionField }}[{{$currentLang}}]"
                       id="{{ $descriptionField }}-{{$currentLang}}"
                       value="{{ $isEdit && $model ? $model->getTranslation($descriptionField, $currentLang) : '' }}">
            </div>

            <!-- Image Upload -->
            @if($showImage)
                <div class="mb-3">
                    @if($imageUrl)
                        <div class="mb-2">
                            <img src="{{ $imageUrl }}" class="img-fluid rounded" alt="Post Image" style="max-height: 200px;"/>
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
            @endif

            <!-- Tags -->
            @if($showTags && count($tagOptions) > 0)
                <div class="mb-3">
                    <label class="form-label">{{ trans('blog::blog.post.tags') }}</label>
                    <select id="tags" name="tags[]" multiple class="form-select select2">
                        @foreach($tagOptions as $id => $name)
                            <option value="{{ $id }}" @if(in_array($id, $selectedTags)) selected @endif>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="ti tabler-device-floppy me-1"></i>
                    {{ $isEdit ? trans('core::core.env.save') : trans('blog::blog.post.create') }}
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="clearForm()">
                    <i class="ti tabler-refresh me-1"></i>
                    {{ trans('core::core.env.clear') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.quick-post-editor .card {
    border: 1px solid var(--bs-border-color);
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.quick-post-editor .card-header {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark) 100%);
    color: white;
    border-bottom: none;
    border-radius: 0.5rem 0.5rem 0 0;
}

.quick-post-editor .tox-tinymce {
    border-radius: 0.375rem;
    border: 1px solid var(--bs-border-color);
}

.quick-post-editor .select2-container {
    width: 100% !important;
}

/* Dark mode support */
[data-bs-theme="dark"] .quick-post-editor .card {
    background-color: var(--bs-dark);
    border-color: var(--bs-border-color);
}

[data-bs-theme="dark"] .quick-post-editor .card-header {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark) 100%);
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

    // Manual TinyMCE initialization as fallback
    setTimeout(function() {
        if (typeof window.manualInitTinyMCE === 'function') {
            console.log('Manual TinyMCE initialization triggered for quick post editor');
            window.manualInitTinyMCE();
        }
    }, 1000);

    // Form submission handler
    const form = document.getElementById('{{ $formId }}');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Ensure all TinyMCE editors sync their content
            if (typeof tinymce !== 'function') {
                tinymce.triggerSave();
            }
        });
    }
});

// Clear form function
function clearForm() {
    const form = document.getElementById('{{ $formId }}');
    if (form) {
        form.reset();

        // Clear TinyMCE editors
        if (typeof tinymce !== 'undefined') {
            tinymce.get('editor-{{ $currentLang }}').setContent('');
        }

        // Clear Select2
        if (document.querySelector('#tags')) {
            $('#tags').val(null).trigger('change');
        }
    }
}
</script>
