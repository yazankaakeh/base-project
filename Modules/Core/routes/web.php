<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\app\Http\Controllers\ContactUsController;
use Modules\Core\app\Http\Controllers\EnvController;
use Modules\Core\app\Http\Controllers\SocialController;

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

Route::middleware(['auth:admin', 'adminMenu', 'admin-enabled', 'audit'])->prefix('admin')->group(function () {
  Route::get('get/env', [EnvController::class, 'index'])->name('getEnv');
  Route::post('update-env', [EnvController::class, 'update'])->name('env.updateEnv');
  Route::post('sendTestEmail', [EnvController::class, 'sendTestEmail'])->name('env.sendTestEmail');

});
Route::post('submitContactUs', [ContactUsController::class, 'submitContactForm'])->name('env.submitContactForm');

Route::get('/auth/{provider}/redirect', [SocialController::class, 'redirect'])
  ->whereIn('provider', ['google', 'facebook', 'x'])
  ->name('oauth.redirect');

Route::get('/auth/{provider}/callback', [SocialController::class, 'callback'])
  ->whereIn('provider', ['google', 'facebook', 'x'])
  ->name('oauth.callback');
