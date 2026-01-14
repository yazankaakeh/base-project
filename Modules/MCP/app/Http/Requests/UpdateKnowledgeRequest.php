<?php

namespace Modules\MCP\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKnowledgeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('manage knowledge base');
    }

    public function rules(): array
    {
        return [
            'category' => ['sometimes', 'string', 'max:255'],
            'subcategory' => ['sometimes', 'string', 'max:255'],
            'question' => ['sometimes', 'array'],
            'question.en' => ['sometimes', 'string'],
            'question.ar' => ['sometimes', 'string'],
            'question.tr' => ['sometimes', 'string'],
            'answer' => ['sometimes', 'array'],
            'answer.en' => ['sometimes', 'string'],
            'answer.ar' => ['sometimes', 'string'],
            'answer.tr' => ['sometimes', 'string'],
            'keywords' => ['sometimes', 'array'],
            'tags' => ['sometimes', 'array'],
            'priority' => ['sometimes', 'integer', 'min:0', 'max:100'],
            'is_active' => ['sometimes', 'boolean'],
            'metadata' => ['sometimes', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'priority.min' => 'Priority must be at least 0',
            'priority.max' => 'Priority cannot exceed 100',
        ];
    }
}
