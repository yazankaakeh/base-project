<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $menuId = $this->route('menu');

        return [
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('cms_menus', 'slug')->ignore($menuId),
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'items' => ['nullable', 'array'],
            'items.*.title' => ['required', 'array'],
            'items.*.title.*' => ['required', 'string', 'max:255'],
            'items.*.url' => ['nullable', 'string', 'max:255'],
            'items.*.target' => ['required', 'string', 'in:_self,_blank'],
            'items.*.page_id' => ['nullable', 'exists:cms_pages,id'],
            'items.*.parent_id' => ['nullable', 'integer'],
            'items.*.icon' => ['nullable', 'string', 'max:255'],
            'items.*.css_class' => ['nullable', 'string', 'max:255'],
            'items.*.order' => ['nullable', 'integer', 'min:0'],
            'items.*.is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The menu name field is required.',
            'name.*.required' => 'The menu name is required in all languages.',
            'slug.required' => 'The slug field is required.',
            'slug.regex' => 'The slug must be lowercase with hyphens only (e.g., main-menu).',
            'slug.unique' => 'This slug is already in use.',
        ];
    }
}
