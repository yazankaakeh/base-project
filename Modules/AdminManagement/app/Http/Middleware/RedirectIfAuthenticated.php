<?php

namespace Modules\AdminManagement\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if ($guard === 'admin' && Auth::guard($guard)->check()) {
                $target = Route::has('admin.dashboard')
                    ? route('admin.dashboard')
                    : (Route::has('admin.user_management.index')
                        ? route('admin.user_management.index')
                        : '/');

                return redirect($target);
            }
        }

        return $next($request);
    }
}
