<?php

namespace Modules\AiChat\Services;

use Illuminate\Support\Facades\Session;
use Modules\AiChat\DTO\ChatResponse;
use Modules\AiChat\Models\AiConversation;
use Modules\AiChat\Models\AiMessage;
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
    ) {}

    /**
     * Figure out the admin-configured settings for the active scope.
     *
     * Resolution order:
     *   1. ThemeSetting row (admin explicitly toggled / picked provider via Theme Settings UI)
     *   2. config/aichat.php defaults (driven by AI_CHAT_ENABLED / AI_CHAT_PROVIDER env vars)
     *   3. Auto-detect: if no admin preference AND the resolved provider has
     *      no API key, find ANY provider with a key and use that. This lets
     *      "drop an API key into .env → widget appears" just work, without
     *      forcing admins to click through Theme Settings first.
     *
     * Notes on the precedence:
     *   - An explicit `ai_enabled=false` from ThemeSetting always wins — the
     *     admin can turn chat off even if keys are present.
     *   - `AI_CHAT_ENABLED` in .env is also respected when set explicitly
     *     (true OR false). Auto-detect only fires when both are null/unset.
     *
     * @return array{enabled: bool, provider: ?string, model: ?string, system_prompt: ?string}
     */
    public function resolveSettings(): array
    {
        $setting = null;
        try {
            $setting = ThemeSetting::getForScope('website');
        } catch (\Throwable $e) {
            // Table may not exist yet (fresh install) — ignore and use config.
        }

        // Admin preference wins (including an explicit `false` / empty string).
        $explicitEnabled = $setting->ai_enabled ?? null;
        $explicitProvider = $setting->ai_provider ?? null;

        // .env preference comes next. We use getenv() to distinguish "user
        // set this to empty/false" from "user never set it at all".
        $envEnabledRaw = getenv('AI_CHAT_ENABLED');
        $envProviderRaw = getenv('AI_CHAT_PROVIDER');
        $envEnabledSet = $envEnabledRaw !== false && $envEnabledRaw !== '';
        $envProviderSet = $envProviderRaw !== false && $envProviderRaw !== '';

        // Auto-detect the first provider that has a non-empty api_key.
        $autoProvider = null;
        foreach ($this->factory->catalog() as $name => $info) {
            if (! empty($info['configured'])) {
                $autoProvider = $name;
                break;
            }
        }

        // ---- Resolve provider ----
        $provider = $explicitProvider
            ?? ($envProviderSet ? $envProviderRaw : null)
            ?? $autoProvider
            ?? 'openai';

        // If the chosen provider has no key but another provider does, slide
        // over to the configured one rather than silently failing.
        $catalog = $this->factory->catalog();
        $chosenReady = isset($catalog[$provider]) && ! empty($catalog[$provider]['configured']);
        if (! $chosenReady && $autoProvider && $explicitProvider === null && ! $envProviderSet) {
            $provider = $autoProvider;
        }

        // ---- Resolve enabled ----
        if ($explicitEnabled !== null) {
            $enabled = (bool) $explicitEnabled;
        } elseif ($envEnabledSet) {
            $enabled = filter_var($envEnabledRaw, FILTER_VALIDATE_BOOLEAN);
        } else {
            // Nothing was explicitly configured — enable automatically
            // whenever at least one provider has a key.
            $enabled = $autoProvider !== null;
        }

        $model = $setting->ai_model ?? null;
        $systemPrompt = $setting->ai_system_prompt ?? $this->defaults['system_prompt'] ?? null;

        return [
            'enabled' => $enabled,
            'provider' => $provider,
            'model' => $model,
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
            'enabled' => $s['enabled'] && $providerReady,
            'provider' => $s['provider'],
            'title' => config('aichat.widget.title', 'Chat with us'),
            'greeting' => config('aichat.widget.greeting', 'Hi! How can we help?'),
            'placeholder' => config('aichat.widget.placeholder', 'Type your message...'),
            'endpoint' => url('/ai-chat/message'),
            'reset_url' => url('/ai-chat/reset'),
            'history_url' => url('/ai-chat/history'),
            'catalog' => $catalog,
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
            'role' => 'user',
            'content' => $userMessage,
        ]);

        $options = [
            'model' => $settings['model'] ?? null,
            'max_tokens' => $this->defaults['max_tokens'] ?? 600,
            'temperature' => $this->defaults['temperature'] ?? 0.5,
            'system_prompt' => $settings['system_prompt'],
        ];
        // Drop null model so the provider's default kicks in.
        $options = array_filter($options, fn ($v) => $v !== null);

        /** @var ChatResponse $response */
        $response = $provider->sendMessage($history, $options);

        $conversation->messages()->create([
            'role' => 'assistant',
            'content' => $response->content,
            'provider' => $response->providerKey,
            'model' => $response->model,
            'prompt_tokens' => $response->promptTokens,
            'completion_tokens' => $response->completionTokens,
        ]);

        $conversation->touch();

        return [
            'reply' => $response->content,
            'provider' => $response->providerKey,
            'model' => $response->model,
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
                'role' => $m->role,
                'content' => $m->content,
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
