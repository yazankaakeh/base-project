<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\app\Http\Controllers\AuthController;
use Modules\UserManagement\app\Http\Controllers\UserAuthController;

/*Route::get('admin/dashboard', function () {
    return view('sales-dashboard');
})->name('admin.dashboard')->middleware(['auth:admin', 'admin-enabled']);*/


Route::get('admin/login', function () {
    return view('theme::admin.login');
})->name('admin.login');
Route::get('/', function () {
    return view('theme::user.login');
})->name('login');

Route::post('admin/login', [AuthController::class, 'login'])
    ->name('admin.login.post');

Route::post('admin/logout', [AuthController::class, 'logout'])
    ->name('admin.logout.post');
Route::post('user/logout', [UserAuthController::class, 'logout'])
    ->name('user.logout.post');