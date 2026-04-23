<?php

namespace Modules\AiChat\Services;

use Illuminate\Support\Facades\Session;
use Modules\AiChat\DTO\ChatResponse;
use Modules\AiChat\Models\AiMessage;
use Modules\AiChat\Models\AiConversation;
use Modules\Core\App\Models\ThemeSetting;

/**
 * Thin orchestration layer over ProviderFactory.
 *
 * Resolves the currently active provider/model/system-prompt using (in order):
 *   1. ThemeSetting on the "website" scope (admin can override per site)
 *   2. config/aichat.php defaults
 *
 * Also persists conversations/messages per browser session so the widget can
 * restore history on reload and so the admin can audit what users asked.
 */
class AiChatService
{
    public function __construct(
        protected ProviderFactory $factory,
        protected array $defaults,
    ) {
    }

    /**
     * Figure out the admin-configured settings for the active scope.
     *
     * @return array{enabled: bool, provider: ?string, model: ?string, system_prompt: ?string}
     */
    public function resolveSettings(): array
    {
        $setting = null;
        try {
            $setting = ThemeSetting::getForScope('website');
        } catch (\Throwable $e) {
            // Table may not exist yet (fresh install) — fall back to config.
        }

        $enabled       = $setting->ai_enabled       ?? $this->defaults['enabled']       ?? false;
        $provider      = $setting->ai_provider      ?? $this->defaults['provider']      ?? 'openai';
        $model         = $setting->ai_model         ?? null;
        $systemPrompt  = $setting->ai_system_prompt ?? $this->defaults['system_prompt'] ?? null;

        return [
            'enabled'       => (bool) $enabled,
            'provider'      => $provider,
            'model'         => $model,
            'system_prompt' => $systemPrompt,
        ];
    }

    /**
     * Widget-safe summary (no secrets). Used by the view composer.
     */
    public function widgetConfig(): array
    {
        $s = $this->resolveSettings();
        $catalog = $this->factory->catalog();

        $providerReady = isset($catalog[$s['provider']]) && $catalog[$s['provider']]['configured'];

        return [
            'enabled'     => $s['enabled'] && $providerReady,
            'provider'    => $s['provider'],
            'title'       => config('aichat.widget.title',       'Chat with us'),
            'greeting'    => config('aichat.widget.greeting',    'Hi! How can we help?'),
            'placeholder' => config('aichat.widget.placeholder', 'Type your message...'),
            'endpoint'    => url('/ai-chat/message'),
            'reset_url'   => url('/ai-chat/reset'),
            'history_url' => url('/ai-chat/history'),
            'catalog'     => $catalog,
        ];
    }

    /**
     * Send a user message, call the provider, persist both messages,
     * return the assistant ChatResponse.
     */
    public function send(string $userMessage, ?string $sessionKey = null): array
    {
        $settings = $this->resolveSettings();
        if (! $settings['enabled']) {
            throw new \RuntimeException('AI chat is disabled.');
        }

        $provider = $this->factory->make($settings['provider']);
        if (! $provider->isConfigured()) {
            throw new \RuntimeException(
                "Provider [{$settings['provider']}] is not configured. Set its API key in .env."
            );
        }

        $sessionKey = $sessionKey ?: Session::getId();

        $conversation = AiConversation::firstOrCreate(
            ['session_key' => $sessionKey],
            ['provider' => $settings['provider']]
        );

        // Load last N messages as conversation context.
        $history = $conversation->messages()
            ->latest('id')
            ->limit($this->defaults['history_limit'] ?? 20)
            ->get()
            ->reverse()
            ->map(fn (AiMessage $m) => ['role' => $m->role, 'content' => $m->content])
            ->values()
            ->all();

        $history[] = ['role' => 'user', 'content' => $userMessage];

        // Persist the user message before the slow HTTP call so rapid retries don't lose it.
        $conversation->messages()->create([
            'role'    => 'user',
            'content' => $userMessage,
        ]);

        $options = [
            'model'         => $settings['model'] ?? null,
            'max_tokens'    => $this->defaults['max_tokens']  ?? 600,
            'temperature'   => $this->defaults['temperature'] ?? 0.5,
            'system_prompt' => $settings['system_prompt'],
        ];
        // Drop null model so the provider's default kicks in.
        $options = array_filter($options, fn ($v) => $v !== null);

        /** @var ChatResponse $response */
        $response = $provider->sendMessage($history, $options);

        $conversation->messages()->create([
            'role'              => 'assistant',
            'content'           => $response->content,
            'provider'          => $response->providerKey,
            'model'             => $response->model,
            'prompt_tokens'     => $response->promptTokens,
            'completion_tokens' => $response->completionTokens,
        ]);

        $conversation->touch();

        return [
            'reply'        => $response->content,
            'provider'     => $response->providerKey,
            'model'        => $response->model,
            'conversation' => $conversation->id,
        ];
    }

    public function history(?string $sessionKey = null): array
    {
        $sessionKey = $sessionKey ?: Session::getId();
        $conversation = AiConversation::where('session_key', $sessionKey)->first();
        if (! $conversation) {
            return [];
        }

        return $conversation->messages()
            ->orderBy('id')
            ->get(['role', 'content', 'created_at'])
            ->map(fn (AiMessage $m) => [
                'role'       => $m->role,
                'content'    => $m->content,
                'created_at' => $m->created_at?->toIso8601String(),
            ])
            ->all();
    }

    public function reset(?string $sessionKey = null): void
    {
        $sessionKey = $sessionKey ?: Session::getId();
        AiConversation::where('session_key', $sessionKey)->delete();
    }
}
