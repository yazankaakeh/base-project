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
        $validated = $request->validate([
            'email' => ['email', 'string', 'required'],
            'password' => ['string', 'required'],
            'recaptcha' => ['required', new ReCaptchaRule()],
        ]);
        $value = $this->guard('web')->attempt(
            $this->credentials($request),
            $request->boolean('remember'),
        );
        $user = Auth::user();

        return $value;
    }
}
