<?php

namespace Modules\AdminManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminManagement\app\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($credentials, (bool) $request->get('remember'))) {
            $request->session()->regenerate();

            $target = \Illuminate\Support\Facades\Route::has('admin.dashboard')
                ? route('admin.dashboard')
                : (\Illuminate\Support\Facades\Route::has('admin.user_management.index')
                    ? route('admin.user_management.index')
                    : '/');

            return redirect()->intended($target);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => trans('auth.failed')]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
