<?php

namespace Modules\Blog\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Blog\Enum\Languages;

/**
 * @property mixed $parent_id
 * @property mixed $name
 * @property mixed $is_active
 * @property mixed $langs
 * @property mixed $id
 */
class BlogCategoryRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   */
  public function rules(): array
  {
    $rules = [];
    $img = 'required';
    if ($this->method() === 'PUT') {
      $rules['id'] = ['required', 'integer', 'exists:blog_categories,id'];
      $img = 'nullable';
    }
    $rules['img'] = [$img, 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
    $rules['parent_id'] = ['nullable', 'integer', 'exists:blog_categories,id'];
    $rules['is_active'] = ['nullable', 'in:on,off'];
    $languages = Languages::cases();
    foreach ($languages as $language) {
      $rules["langs.{$language->value}.name"] = 'required|string|max:255';
      $rules["langs.{$language->value}.description"] = 'required|min:3|max:1000';
    }
    return $rules;
  }

  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }
}
