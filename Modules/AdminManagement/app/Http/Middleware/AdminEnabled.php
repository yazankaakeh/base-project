<?php

namespace Modules\AdminManagement\Http\Middleware;

use Closure as ClosureAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminEnabled
{
    /**
     * Check if Admin is enabled
     */
    public function handle(Request $request, ClosureAlias $next)
    {
        $user = Auth::user();
        if ($user->is_active) {
            return $next($request);
        }

        return redirect('/');
    }
}
