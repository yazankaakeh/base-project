<?php

namespace Modules\AdminManagement\app\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\AdminManagement\app\Action\Auditing\RouteName;
use Modules\AdminManagement\app\Models\AuditLog;

class AuditLogMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $currentRouteName = Route::currentRouteName();
        $exceptRoutes = RouteName::ImportantRoutesWithGetMethod();

        if ($request->method() == 'GET' &&
            !array_key_exists($currentRouteName, $exceptRoutes)) {
            return $next($request);
        }

        if (in_array($currentRouteName, [
            'admin_save_push_token',
            'search_student_dashboard',
        ])) {
            return $next($request);
        }

        if (empty(\auth()?->id())) {
            return $next($request);
        }

        /* @var User $user */
        $user = Auth::user();
        if ($user->email) {
            try {
                AuditLog::query()->create([
                    'doctor_id' => $user->id,
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'payload' => json_encode($request->except(['img', 'password', 'password_confirmation', '_method'])),
                    'ip' => $request->ip(),
                    'route_name' => $currentRouteName,
                    'created_at' => Carbon::now(),
                ]);
            } catch (Exception $e) {
                dd($e);
            }
        }
        return $next($request);
    }
}
