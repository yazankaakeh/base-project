<?php

namespace Modules\AiChat\Contracts;

use Modules\AiChat\DTO\ChatResponse;

interface AiProviderInterface
{
    /**
     * Send a list of chat messages and return a normalized ChatResponse.
     *
     * @param  array<int, array{role: string, content: string}>  $messages
     * @param  array<string, mixed>  $options  keys: model, max_tokens, temperature, system_prompt
     */
    public function sendMessage(array $messages, array $options = []): ChatResponse;

    /**
     * Whether this provider is ready to use (has key + base_url).
     */
    public function isConfigured(): bool;

    /**
     * Short identifier, e.g. "openai", "anthropic".
     */
    public function key(): string;
}
