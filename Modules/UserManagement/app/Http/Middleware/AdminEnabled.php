<?php

namespace Modules\UserManagement\app\Http\Middleware;

use Closure as ClosureAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\UserManagement\app\Models\Admin;

class AdminEnabled
{
    /**
     * Check if Admin is enabled
     */
    public function handle(Request $request, ClosureAlias $next)
    {
        /* @var Admin $user */
        $user = Auth::user();
        if ($user->is_active) {
            return $next($request);
        }

        return redirect('/');
    }
}
