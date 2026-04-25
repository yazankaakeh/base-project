<?php

namespace Modules\AiChat\Providers\Drivers;

use Illuminate\Support\Facades\Http;
use Modules\AiChat\Contracts\AiProviderInterface;
use Modules\AiChat\DTO\ChatResponse;
use RuntimeException;

/**
 * Google Gemini generateContent driver.
 *
 * API: POST {base}/models/{model}:generateContent?key={apiKey}
 *
 * Gemini expects role=user|model (not assistant) and wraps content in
 * `parts: [{text: ...}]`.  System prompt goes in `systemInstruction`.
 */
class GeminiProvider implements AiProviderInterface
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

        $contents = [];
        foreach ($messages as $m) {
            $role = $m['role'] ?? 'user';
            if ($role === 'system') {
                // Merge into $system — Gemini doesn't accept system role in contents.
                $system = ($system ? $system . "\n\n" : '') . ($m['content'] ?? '');

                continue;
            }
            $contents[] = [
                'role' => $role === 'assistant' ? 'model' : 'user',
                'parts' => [['text' => $m['content'] ?? '']],
            ];
        }

        $payload = [
            'contents' => $contents,
            'generationConfig' => [
                'maxOutputTokens' => $maxTokens,
                'temperature' => $temperature,
            ],
        ];
        if ($system) {
            $payload['systemInstruction'] = [
                'role' => 'system',
                'parts' => [['text' => $system]],
            ];
        }

        $url = rtrim($this->config['base_url'], '/') . '/models/' . urlencode($model) . ':generateContent';

        $response = Http::timeout(60)
            ->withQueryParameters(['key' => $this->config['api_key']])
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $payload);

        if (! $response->successful()) {
            throw new RuntimeException(
                "[{$this->name}] HTTP " . $response->status() . ': ' . $response->body()
            );
        }

        $body = $response->json();

        $content = '';
        foreach ($body['candidates'][0]['content']['parts'] ?? [] as $part) {
            $content .= $part['text'] ?? '';
        }

        return new ChatResponse(
            content: trim($content),
            providerKey: $this->name,
            model: $model,
            promptTokens: $body['usageMetadata']['promptTokenCount'] ?? null,
            completionTokens: $body['usageMetadata']['candidatesTokenCount'] ?? null,
            raw: $body,
        );
    }
}
