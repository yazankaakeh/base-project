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

        // Disable Vite globally for tests. The admin (and front) layouts
        // call `@vite(...)`, which requires `public/build/**/manifest.json`
        // to exist — we don't run `npm run build` in CI because the test
        // suite is strictly a back-end concern. `withoutVite()` installs a
        // stub that makes every Vite call render an empty string, which
        // keeps views renderable without a compiled manifest.
        $this->withoutVite();

        // Deterministic locale so translation-sensitive assertions don't
        // depend on developer environment.
        app()->setLocale(config('app.fallback_locale', 'en'));

        Cache::flush();

        if (class_exists(\Modules\Core\App\Models\ThemeSetting::class)) {
            \Modules\Core\App\Models\ThemeSetting::clearCache();
        }
    }
}
