<?php

namespace Modules\Auth\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Modules\AdminManagement\Models\Admin;
use Modules\Auth\app\Models\SocialAccount;

/**
 * Social OAuth controller for Codliy. Supports two user types:
 *   - "user"  => public site visitors      (App\Models\User      / web guard)
 *   - "admin" => back-office administrators (Admin model          / admin guard)
 *
 * Legacy "doctor" / "patient" types have been removed along with the
 * Doctor module.
 */
class SocialController extends Controller
{
    private const SUPPORTED_PROVIDERS = ['google', 'facebook', 'x'];

    private const SUPPORTED_USER_TYPES = ['user', 'admin'];

    public function redirect(string $provider, Request $request)
    {
        if (! in_array($provider, self::SUPPORTED_PROVIDERS, true)) {
            abort(404, 'Unsupported social provider');
        }

        $userType = $request->get('user_type', 'user');
        if (! in_array($userType, self::SUPPORTED_USER_TYPES, true)) {
            $userType = 'user';
        }
        session(['social_login_user_type' => $userType]);

        $driver = Socialite::driver($provider);

        if ($provider === 'google') {
            $driver->scopes(['openid', 'profile', 'email']);
        } elseif ($provider === 'facebook') {
            $driver->scopes(['public_profile', 'email']);
        } elseif ($provider === 'x') {
            $driver->scopes(['tweet.read', 'users.read', 'offline.access']);
        }

        return $driver->redirect();
    }

    public function callback(string $provider)
    {
        try {
            $oauthUser = Socialite::driver($provider)->user();
            $userType = session('social_login_user_type', 'user');
            if (! in_array($userType, self::SUPPORTED_USER_TYPES, true)) {
                $userType = 'user';
            }
            session()->forget('social_login_user_type');

            $socialAccount = SocialAccount::query()
                ->where('provider', $provider)
                ->where('provider_user_id', $oauthUser->getId())
                ->first();

            if ($socialAccount) {
                $user = $socialAccount->user;
            } else {
                $user = $this->findUserByEmail($oauthUser->getEmail(), $userType)
                    ?? $this->createUser($oauthUser, $userType);

                $user->socialAccounts()->create([
                    'provider' => $provider,
                    'provider_user_id' => (string) $oauthUser->getId(),
                    'token' => $oauthUser->token ?? null,
                    'refresh_token' => $oauthUser->refreshToken ?? null,
                    'expires_in' => $oauthUser->expiresIn ?? null,
                ]);
            }

            $this->loginUser($user, $userType);

            return $this->getRedirectUrl($userType);

        } catch (\Exception $e) {
            return redirect()->route('admin.login')
                ->with('error', 'Social login failed: ' . $e->getMessage());
        }
    }

    private function findUserByEmail(?string $email, string $userType): ?object
    {
        if (! $email) {
            return null;
        }

        return match ($userType) {
            'admin' => Admin::query()->where('email', $email)->first(),
            default => User::query()->where('email', $email)->first(),
        };
    }

    private function createUser($oauthUser, string $userType): object
    {
        $userData = [
            'name' => $oauthUser->getName() ?: $oauthUser->getNickname() ?: 'User',
            'email' => $oauthUser->getEmail(),
            'password' => Hash::make(Str::random(32)),
            'email_verified_at' => now(),
        ];

        return match ($userType) {
            'admin' => Admin::create(array_merge($userData, ['is_active' => 1])),
            default => User::create(array_merge($userData, ['is_active' => 1])),
        };
    }

    private function loginUser(object $user, string $userType): void
    {
        match ($userType) {
            'admin' => Auth::guard('admin')->login($user, true),
            default => Auth::guard('web')->login($user, true),
        };
    }

    private function getRedirectUrl(string $userType): \Illuminate\Http\RedirectResponse
    {
        return match ($userType) {
            'admin' => redirect(\Illuminate\Support\Facades\Route::has('admin.dashboard')
                ? route('admin.dashboard')
                : '/'),
            default => redirect(\Illuminate\Support\Facades\Route::has('landing.home')
                ? route('landing.home')
                : '/'),
        };
    }
}
