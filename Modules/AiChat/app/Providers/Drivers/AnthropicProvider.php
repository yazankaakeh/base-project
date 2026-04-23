<?php

namespace Modules\AiChat\Providers\Drivers;

use Illuminate\Support\Facades\Http;
use Modules\AiChat\Contracts\AiProviderInterface;
use Modules\AiChat\DTO\ChatResponse;
use RuntimeException;

/**
 * Anthropic (Claude) messages API driver.
 *
 * Differences from OpenAI:
 *  - Endpoint is /v1/messages (not /chat/completions)
 *  - System prompt goes in a top-level `system` field, not in messages[]
 *  - Auth uses `x-api-key` + `anthropic-version` headers
 *  - Response shape: { content: [{type: 'text', text: '...'}], ... }
 */
class AnthropicProvider implements AiProviderInterface
{
    public function __construct(
        protected string $name,
        protected array $config,
    ) {}

    public function key(): string
    {
        return $this->name;
    }

    public function isConfigured(): bool
    {
        return ! empty($this->config['api_key']) && ! empty($this->config['base_url']);
    }

    public function sendMessage(array $messages, array $options = []): ChatResponse
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException("Provider [{$this->name}] is not configured (missing API key).");
        }

        $model = $options['model'] ?? $this->config['default_model'];
        $maxTokens = $options['max_tokens'] ?? 600;
        $temperature = $options['temperature'] ?? 0.5;
        $system = $options['system_prompt'] ?? null;

        // Anthropic only accepts role=user|assistant; strip any system entries
        // from the message array and hoist them to the top-level `system` field.
        $cleanMessages = [];
        foreach ($messages as $m) {
            if (($m['role'] ?? '') === 'system') {
                $system = ($system ? $system . "\n\n" : '') . ($m['content'] ?? '');

                continue;
            }
            $cleanMessages[] = [
                'role' => $m['role'] ?? 'user',
                'content' => $m['content'] ?? '',
            ];
        }

        $payload = [
            'model' => $model,
            'messages' => $cleanMessages,
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ];
        if ($system) {
            $payload['system'] = $system;
        }

        $response = Http::timeout(60)
            ->withHeaders([
                'x-api-key' => $this->config['api_key'],
                'anthropic-version' => $this->config['api_version'] ?? '2023-06-01',
                'Content-Type' => 'application/json',
            ])
            ->post(rtrim($this->config['base_url'], '/') . '/messages', $payload);

        if (! $response->successful()) {
            throw new RuntimeException(
                "[{$this->name}] HTTP " . $response->status() . ': ' . $response->body()
            );
        }

        $body = $response->json();

        $content = '';
        foreach ($body['content'] ?? [] as $block) {
            if (($block['type'] ?? '') === 'text') {
                $content .= $block['text'] ?? '';
            }
        }

        return new ChatResponse(
            content: trim($content),
            providerKey: $this->name,
            model: $body['model'] ?? $model,
            promptTokens: $body['usage']['input_tokens'] ?? null,
            completionTokens: $body['usage']['output_tokens'] ?? null,
            raw: $body,
        );
    }
}
