<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\CMS\Enums\PageStatusEnum;
use Modules\CMS\Enums\PageTemplateEnum;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Convert "None" or empty string to null for parent_id
        if ($this->parent_id === 'None' || $this->parent_id === '' || $this->parent_id === '0') {
            $this->merge(['parent_id' => null]);
        }
    }

    public function rules(): array
    {
        $pageId = $this->route('cms');

        return [
            'title' => ['required', 'array'],
            'title.*' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('cms_pages', 'slug')->ignore($pageId),
            ],
            'content' => ['nullable', 'array'],
            'content.*' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'array'],
            'excerpt.*' => ['nullable', 'string', 'max:500'],
            'status' => ['required', Rule::enum(PageStatusEnum::class)],
            'template' => ['required', Rule::enum(PageTemplateEnum::class)],
            'parent_id' => ['nullable', 'exists:cms_pages,id'],
            'order' => ['nullable', 'integer', 'min:0'],
            'meta_data' => ['nullable', 'array'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'use_panel_builder' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'title.*.required' => 'The title is required in all languages.',
            'slug.required' => 'The slug field is required.',
            'slug.regex' => 'The slug must be lowercase with hyphens only (e.g., my-page-slug).',
            'slug.unique' => 'This slug is already in use.',
            'featured_image.image' => 'The featured image must be an image file.',
            'featured_image.max' => 'The featured image must not exceed 2MB.',
        ];
    }
}
