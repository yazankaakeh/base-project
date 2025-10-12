@php
    use Modules\Core\App\Enums\LanguageEnum;

    // Default values
    $currentLang = $currentLang ?? app()->getLocale();
    $formId = $formId ?? 'quick-post-widget';
    $showImage = $showImage ?? false;
    $showTags = $showTags ?? false;
    $tagOptions = $tagOptions ?? [];
    $redirectAfterSave = $redirectAfterSave ?? true;
@endphp

<div class="quick-post-widget card shadow-sm" id="{{ $formId }}">
    <div class="card-header bg-primary text-white">
        <div class="d-flex align-items-center">
            <i class="ti tabler-edit me-2"></i>
            <h6 class="mb-0">{{ trans('blog::blog.post.quickCreate') }}</h6>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('doctor.posts.store') }}" method="POST" enctype="multipart/form-data" class="quick-post-form">
            @csrf

            <!-- Title Field -->
            <div class="mb-3">
                <label class="form-label">{{ trans('blog::blog.post.title') }}</label>
                <input type="text"
                       class="form-control"
                       name="title[{{ $currentLang }}]"
                       id="quick-title-{{ $currentLang }}"
                       placeholder="{{ trans('blog::blog.post.titlePlaceholder') }}"
                       required>
            </div>

            <!-- TinyMCE Editor -->
            <div class="mb-3">
                <label class="form-label">{{ trans('blog::blog.post.content') }}</label>
                <textarea id="quick-editor-{{ $currentLang }}"
                          class="tinymce-editor"
                          data-lang="{{ $currentLang }}"
                          data-input="quick-description-{{ $currentLang }}"
                          data-upload="{{ route('tinymce.upload') }}"
                          dir="{{ in_array($currentLang, ['ar','fa','he','ur']) ? 'rtl' : 'ltr' }}"
                          rows="8"
                          placeholder="{{ trans('blog::blog.post.contentPlaceholder') }}"></textarea>
                <input type="hidden"
                       name="description[{{$currentLang}}]"
                       id="quick-description-{{$currentLang}}">
            </div>

            <!-- Image Upload -->
            @if($showImage)
                <div class="mb-3">
                    <label class="form-label">{{ trans('blog::blog.post.image') }}</label>
                    <input type="file"
                           class="form-control"
                           name="image"
                           id="quick-image"
                           accept="image/*">
                </div>
            @endif

            <!-- Tags -->
            @if($showTags && count($tagOptions) > 0)
                <div class="mb-3">
                    <label class="form-label">{{ trans('blog::blog.post.tags') }}</label>
                    <select id="quick-tags" name="tags[]" multiple class="form-select select2">
                        @foreach($tagOptions as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="ti tabler-device-floppy me-1"></i>
                    {{ trans('blog::blog.post.create') }}
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="clearQuickForm()">
                    <i class="ti tabler-refresh me-1"></i>
                    {{ trans('core::core.env.clear') }}
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.quick-post-widget {
    border: 1px solid var(--bs-border-color);
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.quick-post-widget:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.quick-post-widget .card-header {
    border-radius: 0.75rem 0.75rem 0 0;
    border-bottom: none;
}

.quick-post-widget .tox-tinymce {
    border-radius: 0.5rem;
    border: 1px solid var(--bs-border-color);
}

.quick-post-widget .select2-container {
    width: 100% !important;
}

/* Dark mode support */
[data-bs-theme="dark"] .quick-post-widget {
    background-color: var(--bs-dark);
    border-color: var(--bs-border-color);
}

[data-bs-theme="dark"] .quick-post-widget .card-header {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-primary-dark) 100%);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for tags
    if (document.querySelector('#quick-tags')) {
        $('#quick-tags').select2({
            placeholder: '{{ trans("blog::blog.post.selectTags") }}',
            allowClear: true,
            tags: false
        });
    }

    // Manual TinyMCE initialization as fallback
    setTimeout(function() {
        if (typeof window.manualInitTinyMCE === 'function') {
            console.log('Manual TinyMCE initialization triggered for quick post widget');
            window.manualInitTinyMCE();
        }
    }, 1000);

    // Form submission handler
    const form = document.querySelector('.quick-post-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Ensure all TinyMCE editors sync their content
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }

            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="ti tabler-loader me-1"></i>{{ trans("core::core.env.saving") }}...';
            submitBtn.disabled = true;

            // Re-enable button after 3 seconds (fallback)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });
    }
});

// Clear form function
function clearQuickForm() {
    const form = document.querySelector('.quick-post-form');
    if (form) {
        form.reset();

        // Clear TinyMCE editors
        if (typeof tinymce !== 'undefined') {
            const editor = tinymce.get('quick-editor-{{ $currentLang }}');
            if (editor) {
                editor.setContent('');
            }
        }

        // Clear Select2
        if (document.querySelector('#quick-tags')) {
            $('#quick-tags').val(null).trigger('change');
        }
    }
}

// Auto-save functionality (optional)
function enableAutoSave() {
    const form = document.querySelector('.quick-post-form');
    if (form) {
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                // Save to localStorage
                const formData = new FormData(form);
                const data = {};
                for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }
                localStorage.setItem('quick-post-draft', JSON.stringify(data));
            });
        });

        // Load draft on page load
        const draft = localStorage.getItem('quick-post-draft');
        if (draft) {
            try {
                const data = JSON.parse(draft);
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.value = data[key];
                    }
                });
            } catch (e) {
                console.error('Error loading draft:', e);
            }
        }
    }
}

// Enable auto-save if needed
// enableAutoSave();
</script>
