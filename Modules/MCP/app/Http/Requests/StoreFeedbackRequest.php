<?php

namespace Modules\MCP\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message_id' => ['required', 'integer', 'exists:chat_messages,id'],
            'conversation_id' => ['required', 'integer', 'exists:chat_conversations,id'],
            'rating' => ['sometimes', 'string', 'in:helpful,not_helpful,neutral'],
            'score' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'comment' => ['sometimes', 'string', 'max:1000'],
            'metadata' => ['sometimes', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'message_id.required' => 'Message ID is required',
            'message_id.exists' => 'Message not found',
            'conversation_id.required' => 'Conversation ID is required',
            'conversation_id.exists' => 'Conversation not found',
            'rating.in' => 'Invalid rating value',
            'score.min' => 'Score must be at least 1',
            'score.max' => 'Score cannot exceed 5',
            'comment.max' => 'Comment is too long (maximum 1000 characters)',
        ];
    }
}
