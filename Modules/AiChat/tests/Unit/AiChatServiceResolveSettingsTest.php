<?php

/*
|--------------------------------------------------------------------------
| AiChatService::resolveSettings() unit tests
|--------------------------------------------------------------------------
|
| Guards the three-tier resolution order we rely on:
|   1. ThemeSetting row    (admin explicitly toggled / picked)
|   2. .env via config     (AI_CHAT_ENABLED / AI_CHAT_PROVIDER)
|   3. Auto-detect         (first provider with a non-empty API key)
|
| If this logic regresses, the AI chat widget either appears when it
| shouldn't or silently swallows the admin's explicit preferences.
|
*/

use Modules\AiChat\Services\AiChatService;
use Modules\AiChat\Services\ProviderFactory;

beforeEach(function () {
    // Reset getenv state between tests so prior sets don't leak.
    putenv('AI_CHAT_ENABLED');
    putenv('AI_CHAT_PROVIDER');
});

it('auto-enables when any provider has an API key', function () {
    $factory = Mockery::mock(ProviderFactory::class);
    $factory->shouldReceive('catalog')->andReturn([
        'openai' => ['label' => 'OpenAI',    'configured' => true,  'default_model' => 'gpt-4o-mini', 'available_models' => []],
        'anthropic' => ['label' => 'Anthropic', 'configured' => false, 'default_model' => null,          'available_models' => []],
    ]);

    $service = new AiChatService($factory, [
        // Simulate a fresh install — neither the admin row nor .env set.
        'enabled' => null,
        'provider' => null,
        'system_prompt' => null,
    ]);

    $settings = $service->resolveSettings();

    expect($settings['enabled'])->toBeTrue();
    expect($settings['provider'])->toBe('openai');
});

it('slides to a configured provider when the default has no key', function () {
    $factory = Mockery::mock(ProviderFactory::class);
    $factory->shouldReceive('catalog')->andReturn([
        'openai' => ['label' => 'OpenAI',    'configured' => false, 'default_model' => null,             'available_models' => []],
        'anthropic' => ['label' => 'Anthropic', 'configured' => true,  'default_model' => 'claude-sonnet-4-6', 'available_models' => []],
    ]);

    $service = new AiChatService($factory, [
        'enabled' => null,
        'provider' => null,  // nothing explicit — expect auto-detect
        'system_prompt' => null,
    ]);

    $settings = $service->resolveSettings();

    expect($settings['enabled'])->toBeTrue();
    expect($settings['provider'])->toBe('anthropic');
});

it('returns disabled when no provider is configured', function () {
    $factory = Mockery::mock(ProviderFactory::class);
    $factory->shouldReceive('catalog')->andReturn([
        'openai' => ['label' => 'OpenAI',    'configured' => false, 'default_model' => null, 'available_models' => []],
        'anthropic' => ['label' => 'Anthropic', 'configured' => false, 'default_model' => null, 'available_models' => []],
    ]);

    $service = new AiChatService($factory, [
        'enabled' => null,
        'provider' => null,
        'system_prompt' => null,
    ]);

    $settings = $service->resolveSettings();

    expect($settings['enabled'])->toBeFalse();
});

it('honors explicit AI_CHAT_ENABLED=false even when keys are present', function () {
    putenv('AI_CHAT_ENABLED=false');

    $factory = Mockery::mock(ProviderFactory::class);
    $factory->shouldReceive('catalog')->andReturn([
        'openai' => ['label' => 'OpenAI', 'configured' => true, 'default_model' => 'gpt-4o-mini', 'available_models' => []],
    ]);

    $service = new AiChatService($factory, [
        'enabled' => null,
        'provider' => null,
        'system_prompt' => null,
    ]);

    $settings = $service->resolveSettings();

    expect($settings['enabled'])->toBeFalse();
});

afterEach(function () {
    Mockery::close();
});
