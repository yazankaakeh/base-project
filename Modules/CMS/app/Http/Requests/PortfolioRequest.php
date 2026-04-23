<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Core\App\Enums\LanguageEnum;

class PortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $portfolioId = $this->route('portfolio');

        $rules = [
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('portfolios', 'slug')->ignore($portfolioId),
            ],
            'client_name' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'project_url' => 'nullable|url|max:500',
            'technologies' => 'nullable|string',
            'start_date' => 'nullable|date',
            'completion_date' => 'nullable|date|after_or_equal:start_date',
            'project_budget' => 'nullable|numeric|min:0',
            'project_duration' => 'nullable|string|max:100',
            'testimonial_author' => 'nullable|string|max:255',
            'testimonial_position' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'featured_image' => 'nullable|image|mimes:jpeg,png,webp,gif|max:5120',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,webp,gif|max:5120',
            'logo' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
            'delete_gallery' => 'nullable|array',
            'delete_gallery.*' => 'integer',
        ];

        // Add translatable field rules
        foreach (LanguageEnum::values() as $lang) {
            $isRequired = $lang === 'en' ? 'required' : 'nullable';

            $rules["title.{$lang}"] = "{$isRequired}|string|max:255";
            $rules["short_description.{$lang}"] = 'nullable|string|max:500';
            $rules["description.{$lang}"] = 'nullable|string';
            $rules["category.{$lang}"] = 'nullable|string|max:100';
            $rules["features.{$lang}"] = 'nullable|string';
            $rules["challenges.{$lang}"] = 'nullable|string';
            $rules["solutions.{$lang}"] = 'nullable|string';
            $rules["results.{$lang}"] = 'nullable|string';
            $rules["testimonial.{$lang}"] = 'nullable|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.en.required' => 'The English title is required.',
            'featured_image.max' => 'The featured image must not exceed 5MB.',
            'gallery.*.max' => 'Each gallery image must not exceed 5MB.',
            'logo.max' => 'The logo must not exceed 2MB.',
            'completion_date.after_or_equal' => 'The completion date must be after or equal to the start date.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
