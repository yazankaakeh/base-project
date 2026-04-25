<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\SeoSettingsController;

Route::middleware(['auth:admin', 'audit', 'admin-enabled', 'authorize', 'setLocale', 'adminMenu'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('seo', [SeoSettingsController::class, 'index'])->name('seoConfig.get');
        Route::post('seo/update', [SeoSettingsController::class, 'update'])->name('seoConfig.update');
    });
