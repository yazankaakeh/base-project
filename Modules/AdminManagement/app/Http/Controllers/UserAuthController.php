<?php

namespace Modules\AdminManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('admin.login');
    }
}
