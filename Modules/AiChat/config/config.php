<?php

return [
    'name' => 'AiChat',

    /*
    |--------------------------------------------------------------------------
    | AI Provider Catalog
    |--------------------------------------------------------------------------
    |
    | Keys live in the environment; model/system_prompt/enabled live in the
    | admin-editable `theme_settings` row (scope=website) so the site owner can
    | switch provider / tune prompt without a redeploy.
    |
    | Grok uses xAI's OpenAI-compatible endpoint at api.x.ai.
    |
    */
    'providers' => [
        'openai' => [
            'label' => 'ChatGPT (OpenAI)',
            'driver' => 'openai',
            'api_key' => env('OPENAI_API_KEY'),
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
            'default_model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'available_models' => [
                'gpt-4o', 'gpt-4o-mini', 'gpt-4-turbo', 'gpt-3.5-turbo',
            ],
        ],
        'anthropic' => [
            'label' => 'Claude (Anthropic)',
            'driver' => 'anthropic',
            'api_key' => env('ANTHROPIC_API_KEY'),
            'base_url' => env('ANTHROPIC_BASE_URL', 'https://api.anthropic.com/v1'),
            'default_model' => env('ANTHROPIC_MODEL', 'claude-sonnet-4-6'),
            'api_version' => env('ANTHROPIC_API_VERSION', '2023-06-01'),
            'available_models' => [
                'claude-opus-4-6',
                'claude-sonnet-4-6',
                'claude-haiku-4-5-20251001',
                'claude-3-5-sonnet-20241022',
            ],
        ],
        'gemini' => [
            'label' => 'Gemini (Google)',
            'driver' => 'gemini',
            'api_key' => env('GEMINI_API_KEY'),
            'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
            'default_model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
            'available_models' => [
                'gemini-2.0-flash', 'gemini-1.5-pro', 'gemini-1.5-flash',
            ],
        ],
        'grok' => [
            'label' => 'Grok (xAI)',
            'driver' => 'openai', // xAI is OpenAI-compatible
            'api_key' => env('GROK_API_KEY', env('XAI_API_KEY')),
            'base_url' => env('GROK_BASE_URL', 'https://api.x.ai/v1'),
            'default_model' => env('GROK_MODEL', 'grok-2-latest'),
            'available_models' => [
                'grok-2-latest', 'grok-2', 'grok-beta',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Defaults (used when no ThemeSetting override is set)
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'enabled' => env('AI_CHAT_ENABLED', false),
        'provider' => env('AI_CHAT_PROVIDER', 'openai'),
        'system_prompt' => env('AI_CHAT_SYSTEM_PROMPT',
            'You are a helpful assistant for Codliy, a software studio. ' .
            'Answer questions about our services, process, and portfolio clearly and concisely. ' .
            'If asked for pricing, explain that we provide custom quotes after a discovery call.'
        ),
        'max_tokens' => (int) env('AI_CHAT_MAX_TOKENS', 600),
        'temperature' => (float) env('AI_CHAT_TEMPERATURE', 0.5),
        'history_limit' => (int) env('AI_CHAT_HISTORY_LIMIT', 20),
        'rate_limit_per_hour' => (int) env('AI_CHAT_RATE_LIMIT', 40),
    ],

    /*
    |--------------------------------------------------------------------------
    | Widget
    |--------------------------------------------------------------------------
    */
    'widget' => [
        'enabled_routes' => ['*'], // glob-style list; '*' = all front-end pages
        'greeting' => env('AI_CHAT_GREETING', 'Hi there! How can we help with your project today?'),
        'placeholder' => env('AI_CHAT_PLACEHOLDER', 'Ask us anything...'),
        'title' => env('AI_CHAT_TITLE', 'Chat with Codliy'),
    ],
];
