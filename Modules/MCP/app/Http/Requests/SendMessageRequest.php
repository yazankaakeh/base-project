<?php

namespace Modules\MCP\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'conversation_id' => ['required', 'integer', 'exists:chat_conversations,id'],
            'message' => ['required', 'string', 'min:1', 'max:5000'],
            'session_id' => ['sometimes', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'conversation_id.required' => 'Conversation ID is required',
            'conversation_id.exists' => 'Conversation not found',
            'message.required' => 'Message cannot be empty',
            'message.max' => 'Message is too long (maximum 5000 characters)',
        ];
    }
}
