<?php

namespace Modules\Auth\Actions\Doctor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    /**
     * Handle the login action for doctors.
     *
     * @throws ValidationException
     */
    public function handle(array $credentials, bool $remember = false): bool
    {
        $authenticated = Auth::guard('doctor')->attempt(
            [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ],
            $remember
        );

        if (! $authenticated) {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        // Regenerate session to prevent session fixation
        request()->session()->regenerate();

        return true;
    }
}