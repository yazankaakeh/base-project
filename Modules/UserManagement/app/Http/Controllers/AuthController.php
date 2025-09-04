<?php

namespace Modules\UserManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\UserManagement\app\Http\Requests\LoginRequest;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],
            $request->get('remember'))) {
            return auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],
                $request->get('remember'))
                ? redirect()->intended(route('admin.dashboard.index'))
                : back()->withInput($request->only('email', 'remember'));
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
