<?php

namespace Modules\Blog\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Blog\Enum\Languages;

/**
 * @property mixed $name
 * @property mixed $langs
 * @property mixed $id
 */
class BlogTagRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   */
  public function rules(): array
  {
    $rules = [];
    if ($this->method() === 'PUT') {
      $rules['id'] = ['required', 'integer', 'exists:blog_tags,id'];
    }
    $languages = Languages::cases();
    foreach ($languages as $language) {
      $rules["langs.{$language->value}.name"] = 'required|string|max:255';
      // Add more validation rules as needed for each language
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
