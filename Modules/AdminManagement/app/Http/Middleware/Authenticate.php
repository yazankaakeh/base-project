<?php

namespace Modules\AdminManagement\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        $firstSegment = $request->segment(1);

        return match ($firstSegment) {
            'admin' => route('admin.login'),
            default => route('login'), // fallback
        };
    }
}
