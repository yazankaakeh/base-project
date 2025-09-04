<?php

namespace Modules\UserManagement\app\Http\Middleware;

use Closure;
use Closure as ClosureAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\UserManagement\app\Enums\Roles;
use Modules\UserManagement\App\Models\Admin;
use Symfony\Component\HttpFoundation\Response;

class AdminPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, ClosureAlias $next)
    {
        /**
         * @var Admin $user
         */
        $user = Auth::user();
        abort_if(
            !($user->can($request->route()->getName()) || $user->hasRole(Roles::SUPER_ADMIN->value)),
            Response::HTTP_FORBIDDEN,
            'Sorry!, You dont have the right permission to access this Buy Global Operation.',
        );
        return $next($request);
    }
}
