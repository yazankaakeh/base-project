<?php

/*
|--------------------------------------------------------------------------
| Smoke Tests
|--------------------------------------------------------------------------
|
| Runs on every commit. These tests prove the framework is boot-able and
| CI is correctly wired — they do NOT assert on specific business logic.
| Real coverage for each module's routes lives in Modules/<Name>/tests/.
|
*/

it('boots the Laravel application', function () {
    expect(app())->not->toBeNull();
    expect(config('app.name'))->not->toBeEmpty();
});

it('responds to the admin login route', function () {
    // `admin.login` is guaranteed to exist — the RouteServiceProvider::HOME
    // constant + the ComingSoon middleware both depend on it. If this 404s,
    // something in Modules/Theme/routes/web.php broke the login flow.
    $response = $this->get(route('admin.login'));

    $response->assertStatus(200);
});
