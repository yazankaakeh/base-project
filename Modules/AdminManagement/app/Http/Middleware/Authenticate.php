<?php

namespace Modules\AdminManagement\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Admin Authenticate middleware.
 *
 * Overrides Laravel's default `redirectTo()` so an expired admin session or
 * an unauthenticated request sent to a protected route doesn't throw
 * `RouteNotFoundException: Route [login] not defined` — the codebase only
 * exposes a back-office login at `admin.login` (the Doctor / patient logins
 * were removed).
 */
class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // If a `login` route is registered (some 3rd-party package might add
        // one), honor it first. Otherwise fall through to the admin login.
        if (Route::has('login')) {
            return route('login');
        }
        if (Route::has('admin.login')) {
            return route('admin.login');
        }

        // Last-resort hard URL — always safe, never throws.
        return url('/admin/login');
    }
}
