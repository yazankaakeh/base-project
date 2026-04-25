<?php

namespace Modules\MCP\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'conversationable_type' => ['sometimes', 'string'],
            'conversationable_id' => ['sometimes', 'integer'],
            'session_id' => ['sometimes', 'string', 'unique:chat_conversations,session_id'],
            'metadata' => ['sometimes', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'session_id.unique' => 'Session already exists',
        ];
    }
}
