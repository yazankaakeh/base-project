<?php

namespace Modules\AiChat\Providers\Drivers;

use Illuminate\Support\Facades\Http;
use Modules\AiChat\Contracts\AiProviderInterface;
use Modules\AiChat\DTO\ChatResponse;
use RuntimeException;

/**
 * OpenAI chat-completions driver.
 *
 * Also used for xAI Grok because Grok's API is OpenAI-compatible — it just
 * points at api.x.ai/v1 instead of api.openai.com/v1.
 */
class OpenAiProvider implements AiProviderInterface
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

        $payload = [
            'model' => $model,
            'messages' => $this->prependSystem($messages, $system),
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ];

        $response = Http::timeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->config['api_key'],
                'Content-Type' => 'application/json',
            ])
            ->post(rtrim($this->config['base_url'], '/') . '/chat/completions', $payload);

        if (! $response->successful()) {
            throw new RuntimeException(
                "[{$this->name}] HTTP " . $response->status() . ': ' . $response->body()
            );
        }

        $body = $response->json();
        $content = $body['choices'][0]['message']['content'] ?? '';

        return new ChatResponse(
            content: trim($content),
            providerKey: $this->name,
            model: $body['model'] ?? $model,
            promptTokens: $body['usage']['prompt_tokens'] ?? null,
            completionTokens: $body['usage']['completion_tokens'] ?? null,
            raw: $body,
        );
    }

    protected function prependSystem(array $messages, ?string $system): array
    {
        if (! $system) {
            return $messages;
        }
        array_unshift($messages, ['role' => 'system', 'content' => $system]);

        return $messages;
    }
}
