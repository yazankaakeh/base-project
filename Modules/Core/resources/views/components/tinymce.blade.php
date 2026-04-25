@props([
    'label' => null,          // Translation key for label
    'name' => '',             // Form field name
    'id' => '',               // Textarea ID
    'lang' => app()->getLocale(), // Language code for directionality
    'value' => '',            // Initial content value
    'uploadRoute' => null,    // Upload route (optional)
    'height' => 500,          // Editor height
    'required' => false,      // Required field
])

@php
    $hiddenInputId = $id;
    $editorId = 'editor-' . $lang;
    $isRtl = in_array($lang, ['ar','fa','he','ur']);
@endphp

<div class="tinymce-wrapper">
    @if($label)
        <label class="form-label" for="{{ $editorId }}">
            {{ trans($label) }}
            @if($required) <span class="text-danger">*</span> @endif
        </label>
    @endif

    <textarea
        id="{{ $editorId }}"
        class="tinymce-editor"
        data-lang="{{ $lang }}"
        data-input="{{ $hiddenInputId }}"
        @if($uploadRoute)
        data-upload="{{ $uploadRoute }}"
        @endif
        dir="{{ $isRtl ? 'rtl' : 'ltr' }}">{{ old($name, $value) }}</textarea>

    <input
        type="hidden"
        name="{{ $name }}"
        id="{{ $hiddenInputId }}"
        value="{{ old($name, $value) }}">

    @error($name)
        <span class="error text-danger">{{ $message }}</span>
    @enderror
</div>