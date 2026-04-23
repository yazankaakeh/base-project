<?php

/*
|--------------------------------------------------------------------------
| Pest Bootstrap
|--------------------------------------------------------------------------
|
| Binds base TestCases to suites + exposes helpers. New modules register
| their own `uses(...)->in(__DIR__.'/../Modules/<Module>/tests/…')` call
| here so phpunit.xml + Pest stay in lockstep.
|
*/

use Illuminate\Foundation\Testing\RefreshDatabase;

// ─── Root suites ───────────────────────────────────────────────────────
uses(Tests\TestCase::class)->in('Feature');
uses(Tests\TestCase::class)->in('Unit');

// ─── Module: AdminManagement ───────────────────────────────────────────
// Explicit binding so tests don't silently fall back to the bare Tests\TestCase
// when the nested Pest.php discovery isn't triggered.
uses(Modules\AdminManagement\Tests\TestCase::class, RefreshDatabase::class)
    ->in(__DIR__ . '/../Modules/AdminManagement/tests/Feature');
uses(Modules\AdminManagement\Tests\TestCase::class)
    ->in(__DIR__ . '/../Modules/AdminManagement/tests/Unit');

// Custom expectations — project-wide.
expect()->extend('toBeOne', fn () => $this->toBe(1));

/**
 * Quick login helper for Feature tests outside a module-specific TestCase:
 *     actingAsAdmin();
 *
 * Modules with their own TestCase (like AdminManagement) have richer
 * helpers (actingAsSuperAdmin) that handle Spatie role setup too.
 */
function actingAsAdmin(?Modules\AdminManagement\Models\Admin $admin = null): Tests\TestCase
{
    /** @var Tests\TestCase $testCase */
    $testCase = test();

    $admin ??= Modules\AdminManagement\Models\Admin::factory()->create();
    $testCase->actingAs($admin, 'admin');

    return $testCase;
}
