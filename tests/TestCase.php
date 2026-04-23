<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Cache;

/**
 * Base test case used by every Feature + Unit test in the project.
 *
 * Intentionally lean — responsibilities:
 *   - Bootstrap the Laravel application (inherited).
 *   - Reset the ThemeSetting static cache between tests so a theme
 *     change in one test doesn't leak into the next.
 *   - Keep every test deterministic (fixed locale, fresh cache).
 */
abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Deterministic locale so translation-sensitive assertions don't
        // depend on developer environment.
        app()->setLocale(config('app.fallback_locale', 'en'));

        Cache::flush();

        if (class_exists(\Modules\Core\App\Models\ThemeSetting::class)) {
            \Modules\Core\App\Models\ThemeSetting::clearCache();
        }
    }
}
