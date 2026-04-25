<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\app\Http\Controllers\SocialController;

/*
|--------------------------------------------------------------------------
| Auth Module Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for the Auth module.
|
*/

// Social Login Routes
Route::get('/auth/{provider}/redirect', [SocialController::class, 'redirect'])
    ->whereIn('provider', ['google', 'facebook', 'x'])
    ->name('auth.social.redirect');

Route::get('/auth/{provider}/callback', [SocialController::class, 'callback'])
    ->whereIn('provider', ['google', 'facebook', 'x'])
    ->name('auth.social.callback');
