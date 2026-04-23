<?php

namespace Modules\MCP\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKnowledgeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage knowledge base');
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'max:255'],
            'subcategory' => ['sometimes', 'string', 'max:255'],
            'question' => ['required', 'array'],
            'question.en' => ['required', 'string'],
            'question.ar' => ['sometimes', 'string'],
            'question.tr' => ['sometimes', 'string'],
            'answer' => ['required', 'array'],
            'answer.en' => ['required', 'string'],
            'answer.ar' => ['sometimes', 'string'],
            'answer.tr' => ['sometimes', 'string'],
            'keywords' => ['sometimes', 'array'],
            'tags' => ['sometimes', 'array'],
            'priority' => ['sometimes', 'integer', 'min:0', 'max:100'],
            'is_active' => ['sometimes', 'boolean'],
            'knowledgeable_type' => ['sometimes', 'string'],
            'knowledgeable_id' => ['sometimes', 'integer'],
            'metadata' => ['sometimes', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.required' => 'Category is required',
            'question.required' => 'Question is required',
            'question.en.required' => 'English question is required',
            'answer.required' => 'Answer is required',
            'answer.en.required' => 'English answer is required',
            'priority.min' => 'Priority must be at least 0',
            'priority.max' => 'Priority cannot exceed 100',
        ];
    }
}
