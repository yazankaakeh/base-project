<?php

namespace Modules\AiChat\Services;

use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use Modules\AiChat\Contracts\AiProviderInterface;
use Modules\AiChat\Providers\Drivers\AnthropicProvider;
use Modules\AiChat\Providers\Drivers\GeminiProvider;
use Modules\AiChat\Providers\Drivers\OpenAiProvider;

/**
 * Resolves a named provider (openai|anthropic|gemini|grok) to a driver instance
 * using the driver key declared in config('aichat.providers.<name>.driver').
 *
 * xAI Grok uses the OpenAI driver because its HTTP surface is identical —
 * just a different base_url and api_key.
 */
class ProviderFactory
{
    public function __construct(
        protected Application $app,
        protected array $catalog,
    ) {}

    public function make(string $name): AiProviderInterface
    {
        if (! isset($this->catalog[$name])) {
            throw new InvalidArgumentException("Unknown AI provider [{$name}].");
        }

        $config = $this->catalog[$name];
        $driver = $config['driver'] ?? $name;

        return match ($driver) {
            'openai' => new OpenAiProvider($name, $config),
            'anthropic' => new AnthropicProvider($name, $config),
            'gemini' => new GeminiProvider($name, $config),
            default => throw new InvalidArgumentException("Unsupported AI driver [{$driver}]."),
        };
    }

    /**
     * @return array<string, array{label: string, configured: bool, default_model: ?string, available_models: array<int, string>}>
     */
    public function catalog(): array
    {
        $out = [];
        foreach ($this->catalog as $name => $config) {
            $out[$name] = [
                'label' => $config['label'] ?? ucfirst($name),
                'configured' => ! empty($config['api_key']),
                'default_model' => $config['default_model'] ?? null,
                'available_models' => $config['available_models'] ?? [],
            ];
        }

        return $out;
    }

    public function has(string $name): bool
    {
        return isset($this->catalog[$name]);
    }
}
