<?php

/*
|--------------------------------------------------------------------------
| Smoke Tests
|--------------------------------------------------------------------------
|
| Runs on every commit. These tests prove the framework is boot-able and
| CI is correctly wired — they do NOT assert on specific business logic
| OR touch the database. Real coverage for each module lives in
| Modules/<Name>/tests/ (which opt into RefreshDatabase individually).
|
*/

use Illuminate\Support\Facades\Route;

it('boots the Laravel application', function () {
    expect(app())->not->toBeNull();
    expect(config('app.name'))->not->toBeEmpty();
});

it('has the admin login route registered', function () {
    // `admin.login` is guaranteed to exist — the RouteServiceProvider::HOME
    // constant + the Authenticate middleware redirect both depend on it.
    // We just check Route::has() rather than hitting the URL because the
    // root Feature suite doesn't run RefreshDatabase, and the login view
    // would trip the ThemeSettingsComposer trying to query theme_settings.
    // Module-level tests exercise the full request pipeline.
    expect(Route::has('admin.login'))->toBeTrue();
});
