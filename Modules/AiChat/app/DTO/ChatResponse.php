<?php

namespace Modules\AiChat\DTO;

class ChatResponse
{
    public function __construct(
        public string $content,
        public string $providerKey,
        public string $model,
        public ?int $promptTokens = null,
        public ?int $completionTokens = null,
        public ?array $raw = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'content'           => $this->content,
            'provider'          => $this->providerKey,
            'model'             => $this->model,
            'prompt_tokens'     => $this->promptTokens,
            'completion_tokens' => $this->completionTokens,
        ];
    }
}
