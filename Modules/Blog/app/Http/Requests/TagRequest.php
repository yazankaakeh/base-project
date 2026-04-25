<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\App\Enums\LanguageEnum;

class TagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'array'],
        ];

        // Add validation for each language
        foreach (LanguageEnum::values() as $lang) {
            $rules["name.{$lang}"] = ['required', 'string', 'max:255'];
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

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        $messages = [];

        foreach (LanguageEnum::values() as $lang) {
            $messages["name.{$lang}.required"] = "The tag name in {$lang} is required.";
            $messages["name.{$lang}.string"] = "The tag name in {$lang} must be a string.";
            $messages["name.{$lang}.max"] = "The tag name in {$lang} must not be greater than 255 characters.";
        }

        return $messages;
    }
}
