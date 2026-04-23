<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Legacy class name retained to avoid breaking any cached route definitions
 * or queue payloads. Redirects authenticated admins away from guest-only
 * admin pages. The old "doctor" guard has been replaced by "admin" as part
 * of the Codliy rebrand.
 */
class RedirectIfAuthenticatedDoctor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {
            $target = Route::has('admin.dashboard')
                ? route('admin.dashboard')
                : (Route::has('admin.user_management.index')
                    ? route('admin.user_management.index')
                    : '/');

            return redirect($target);
        }

        return $next($request);
    }
}
