<?php

use Illuminate\Support\Facades\Route;
use Modules\Website\Http\Controllers\WebsiteController;
use Modules\Website\Http\Controllers\LandingPageController;
use Modules\Website\Http\Controllers\BlogFrontController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('websites', WebsiteController::class)->names('website');
});

// Landing Page Routes
Route::middleware('setLocale')->group(function () {
    Route::get('soon', [LandingPageController::class, 'comingSoon'])->name('landing.coming_soon');
    Route::middleware(['coming_soon'])->group(function () {
        Route::get('/', [LandingPageController::class, 'home'])->name('landing.home');
        Route::get('/privacy', [LandingPageController::class, 'privacy'])->name('landing.privacy');
        Route::get('/info', [LandingPageController::class, 'hiHelloInfo'])->name('landing.hiHelloInfo');
        Route::get('/create', [LandingPageController::class, 'hiHelloCreate'])->name('landing.hiHelloCreate');

        // Blog Routes
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/', [BlogFrontController::class, 'index'])->name('index');
            Route::get('/post/{id}', [BlogFrontController::class, 'show'])->name('show');
            Route::get('/category/{id}', [BlogFrontController::class, 'category'])->name('category');
            Route::get('/tag/{id}', [BlogFrontController::class, 'tag'])->name('tag');
            Route::post('/post/{id}/clap', [BlogFrontController::class, 'clap'])->name('clap');
        });
    });
});
