<?php

namespace Modules\AiChat\Providers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\ServiceProvider;
use Modules\AiChat\Contracts\AiProviderInterface;
use Modules\AiChat\Providers\Drivers\AnthropicProvider;
use Modules\AiChat\Providers\Drivers\GeminiProvider;
use Modules\AiChat\Providers\Drivers\OpenAiProvider;
use Modules\AiChat\Services\AiChatService;
use Modules\AiChat\Services\ProviderFactory;

class AiChatServiceProvider extends ServiceProvider
{
    protected string $name = 'AiChat';

    protected string $nameLower = 'aichat';

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
        $this->bootWidgetComposer();
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        // Provider factory resolves OpenAI / Anthropic / Gemini / Grok drivers.
        $this->app->singleton(ProviderFactory::class, function ($app) {
            return new ProviderFactory($app, config('aichat.providers', []));
        });

        // Main chat service — one binding, resolves the active provider lazily.
        $this->app->singleton(AiChatService::class, function ($app) {
            return new AiChatService(
                $app->make(ProviderFactory::class),
                config('aichat.defaults', [])
            );
        });

        // Concrete drivers — kept in the container so tests can swap them.
        $this->app->bind(OpenAiProvider::class);
        $this->app->bind(AnthropicProvider::class);
        $this->app->bind(GeminiProvider::class);
    }

    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, 'config/config.php');
        if (file_exists($configPath)) {
            $this->publishes([$configPath => config_path($this->nameLower.'.php')], 'config');
            $this->mergeConfigFrom($configPath, $this->nameLower);
        }
    }

    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        // Publishing target is optional; only register it as a view path
        // when it actually exists so view:cache doesn't choke.
        $paths = is_dir($viewPath) ? [$viewPath, $sourcePath] : [$sourcePath];

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower.'-module-views']);
        $this->loadViewsFrom($paths, $this->nameLower);
    }

    /**
     * Expose $aiChatConfig to the front layouts so the widget partial renders
     * with admin-driven settings without every controller having to pass it.
     */
    protected function bootWidgetComposer(): void
    {
        ViewFacade::composer(['theme::user.layouts.*', 'aichat::*'], function (View $view) {
            try {
                $service = app(AiChatService::class);
                $view->with('aiChatConfig', $service->widgetConfig());
            } catch (\Throwable $e) {
                $view->with('aiChatConfig', [
                    'enabled'  => false,
                    'error'    => $e->getMessage(),
                ]);
            }
        });
    }

    public function provides(): array
    {
        return [AiChatService::class, ProviderFactory::class];
    }
}
