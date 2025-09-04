<?php

namespace Modules\Core\App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\UserManagement\app\Models\Admin;

class Helper
{
    public static function generateCode($code): string
    {
        Log::info('code Is: '.$code);
        $key = base64_decode(explode(':', config('app.key'), 2)[1]);
        $hashedCode = hash_hmac('sha256', $code, $key);
        Log::info('hashedCode Is: '.$hashedCode);
        return $hashedCode;
    }

    public static function logoutOtherDevices(User|Admin $user, string $guard): void
    {
        $currentSessionId = Session::getId();

        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('guard', $guard)
            ->where('id', '!=', $currentSessionId) // keep current session
            ->delete();
        if ($user instanceof User) {
            $user->tokens()->delete();
        }
    }

    public static function updateSessionGuard($sessionId, $guard): void
    {
        DB::table('sessions')
            ->where('id', $sessionId)
            ->update(['guard' => $guard]);
    }


}
