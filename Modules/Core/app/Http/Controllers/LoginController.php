<?php

namespace Modules\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\app\Providers\RouteServiceProvider;
use Modules\Core\app\Rules\ReCaptchaRule;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;


    public function showLoginForm(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('theme::user.auth.login');
    }

    protected function attemptLogin(Request $request): bool
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'recaptcha' => ['required', new ReCaptchaRule()],
        ]);
        // Make sure we're using the DOCTOR guard explicitly
        $ok = Auth::guard('doctor')->attempt(
            ['email' => $credentials['email'], 'password' => $credentials['password']],
            $request->boolean('remember'),
        );

        if ($ok) {
            // Persist the session (requires 'web' middleware)
            $request->session()->regenerate();
        }

        return $ok;
    }
}
