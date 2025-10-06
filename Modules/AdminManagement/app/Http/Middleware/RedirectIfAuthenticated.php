<?php

namespace Modules\AdminManagement\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            if ($guard === 'doctor' && Auth::guard($guard)->check()) {
                return redirect('admin.dashboard');
            }
            /* elseif ($guard === 'web' && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }*/
        }

        return $next($request);
    }
}
