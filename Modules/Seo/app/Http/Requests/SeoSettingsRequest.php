<?php

namespace Modules\Seo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Seo\Enums\SeoSettingsEnum;

class SeoSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [];

        // Get all valid keys from the enum
        $validKeys = array_column(SeoSettingsEnum::cases(), 'value');

        // Create validation rules for each valid key
        foreach ($validKeys as $key) {
            $rules[$key] = ['nullable', 'string', 'max:255'];
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

        // Get all valid keys from the enum
        $validKeys = array_column(SeoSettingsEnum::cases(), 'value');

        // Create custom messages for each key
        foreach ($validKeys as $key) {
            $messages["{$key}.max"] = "The {$key} field must not be greater than 255 characters.";
        }

        return $messages;
    }
}
