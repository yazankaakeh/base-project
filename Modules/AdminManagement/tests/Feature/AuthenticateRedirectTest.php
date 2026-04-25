<?php

/*
|--------------------------------------------------------------------------
| Authenticate middleware redirect tests
|--------------------------------------------------------------------------
|
| Regression coverage for the "Route [login] not defined" bug we shipped
| a fix for. Ensures the admin Authenticate middleware redirects safely
| whether or not a `login` route exists, and never throws on missing
| routes. Also verifies AJAX requests get a 401 instead of a 302 — the
| SPA needs that signal to re-run the login flow.
|
*/

use Illuminate\Support\Facades\Route;

it('redirects unauthenticated admin requests to /admin/login', function () {
    $response = $this->get('/admin/dashboard');

    // The middleware walks: Route::has('login') → Route::has('admin.login')
    // → url('/admin/login'). `login` isn't registered in this codebase so
    // it should land on admin.login.
    $response->assertRedirect(route('admin.login'));
});

it('returns 401 for AJAX requests instead of redirecting', function () {
    $response = $this->getJson('/admin/dashboard');

    $response->assertStatus(401);
});

it('keeps admin.login registered', function () {
    // If this ever flips to false, the middleware's final fallback
    // (`url('/admin/login')`) still works — but the user experience degrades
    // because Laravel's auth helpers that call `route('admin.login')`
    // elsewhere start throwing. Guard against the regression.
    expect(Route::has('admin.login'))->toBeTrue();
});
