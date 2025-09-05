<?php

namespace Modules\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Modules\Core\app\Enums\UserStatusEnum;
use Modules\Core\app\Models\SocialAccount;

// see migration below

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function redirect(string $provider)
    {
        $driver = Socialite::driver($provider);

        // Example scopes:
        if ($provider === 'google') {
            $driver->scopes(['openid', 'profile', 'email']);
        } elseif ($provider === 'facebook') {
            $driver->scopes(['public_profile', 'email']); // email requires review in some cases
        } elseif ($provider === 'x') {
            // X OAuth 2.0: request minimal scopes you need; email is not guaranteed.
            $driver->scopes(['tweet.read', 'users.read', 'offline.access']);
        }

        return $driver->redirect();
    }

    public function callback(string $provider)
    {
        // If you’re behind a proxy / SPA, you may need ->stateless()
        $oauthUser = Socialite::driver($provider)->user();

        // Try to locate an existing social link:
        /** @var SocialAccount $account */
        $account = SocialAccount::query()->where('provider', $provider)
            ->where('provider_user_id', $oauthUser->getId())
            ->first();

        if ($account) {
            $user = $account->user;
        } else {
            // Fallback: match by email when available
            $email = $oauthUser->getEmail();
            $user = $email ? User::where('email', $email)->first() : null;

            if (!$user) {
                $user = User::query()->forceCreate([
                    'name' => $oauthUser->getName() ?: $oauthUser->getNickname() ?: 'User',
                    'email' => $email,           // may be null for X if not granted
                    'password' => Hash::make(Str::random(32)),
                    'img' => $oauthUser->getAvatar(),
                    'is_active' => UserStatusEnum::ACTIVE,
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $user->socialAccounts()->create([
                'provider' => $provider,
                'provider_user_id' => (string)$oauthUser->getId(),
                'token' => $oauthUser->token ?? null,
                'refresh_token' => $oauthUser->refreshToken ?? null,
                'expires_in' => $oauthUser->expiresIn ?? null,
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->route('customer.home');
    }
}
