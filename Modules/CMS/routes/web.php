<?php

use Illuminate\Support\Facades\Route;
use Modules\CMS\Http\Controllers\CMSController;
use Modules\CMS\Http\Controllers\MenuController;

Route::middleware(['auth:doctor', 'audit', 'admin-enabled', 'authorize', 'setLocale', 'doctorMenu'])->group(
    function () {
        // Home page specific routes
        Route::get('cms/home/edit', [CMSController::class, 'editHome'])->name('cms.home.edit');
        Route::put('cms/home/update', [CMSController::class, 'updateHome'])->name('cms.home.update');

        // Standard CMS routes
        Route::resource('cms', CMSController::class)->names('cms');
        Route::resource('menus', MenuController::class)->names('menus');
    },
);
