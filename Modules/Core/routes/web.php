<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\app\Http\Controllers\EnvController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth:admin', 'admin-enabled', 'setLocale', 'audit'])->prefix('admin')->group(function () {
    Route::get('get/env', [EnvController::class, 'index'])->name('admin.env.getEnv');
    Route::post('update-env', [EnvController::class, 'update'])->name('admin.env.updateEnv');
    Route::post('sendTestEmail', [EnvController::class, 'sendTestEmail'])->name('admin.env.sendTestEmail');
});
