<?php

use Illuminate\Support\Facades\Route;
use Modules\CMS\Http\Controllers\CMSController;
use Modules\CMS\Http\Controllers\MenuController;
use Modules\CMS\Http\Controllers\PanelController;
use Modules\CMS\Http\Controllers\PanelItemController;
use Modules\CMS\Http\Controllers\PortfolioController;

Route::middleware(['auth:doctor', 'audit', 'admin-enabled', 'authorize', 'setLocale', 'doctorMenu'])->group(
    function () {
        // Home page specific routes
        Route::get('cms/home/edit', [CMSController::class, 'editHome'])->name('cms.home.edit');
        Route::put('cms/home/update', [CMSController::class, 'updateHome'])->name('cms.home.update');

        // Standard CMS routes
        Route::resource('cms', CMSController::class)->names('cms');

        // Panel management routes (after resource routes to avoid conflicts)
        Route::prefix('cms/panels')->name('cms.panels.')->group(function () {
            Route::get('{pageId}', [PanelController::class, 'getPanelsForPage'])->name('forPage');
            Route::post('', [PanelController::class, 'store'])->name('store');
            Route::get('panel/{id}', [PanelController::class, 'show'])->name('show');
            Route::put('{id}', [PanelController::class, 'update'])->name('update');
            Route::delete('{id}', [PanelController::class, 'destroy'])->name('destroy');
            Route::post('{id}/toggle', [PanelController::class, 'toggle'])->name('toggle');
            Route::post('{id}/duplicate', [PanelController::class, 'duplicate'])->name('duplicate');
            Route::post('reorder', [PanelController::class, 'reorder'])->name('reorder');
        });

        // Panel Items management routes
        Route::prefix('cms/panel-items')->name('cms.panel-items.')->group(function () {
            Route::post('', [PanelItemController::class, 'store'])->name('store');
            Route::get('{id}', [PanelItemController::class, 'show'])->name('show');
            Route::put('{id}', [PanelItemController::class, 'update'])->name('update');
            Route::delete('{id}', [PanelItemController::class, 'destroy'])->name('destroy');
        });

        Route::resource('menus', MenuController::class)->names('menus');

        // Portfolio management routes
        Route::prefix('admin/portfolios')->name('admin.portfolios.')->group(function () {
            Route::get('/', [PortfolioController::class, 'index'])->name('index');
            Route::get('/create', [PortfolioController::class, 'create'])->name('create');
            Route::post('/', [PortfolioController::class, 'store'])->name('store');
            Route::get('/{portfolio}', [PortfolioController::class, 'show'])->name('show');
            Route::get('/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('edit');
            Route::put('/{portfolio}', [PortfolioController::class, 'update'])->name('update');
            Route::delete('/{portfolio}', [PortfolioController::class, 'destroy'])->name('destroy');
            Route::post('/{portfolio}/toggle-status', [PortfolioController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{portfolio}/toggle-featured', [PortfolioController::class, 'toggleFeatured'])->name('toggle-featured');
            Route::post('/{portfolio}/duplicate', [PortfolioController::class, 'duplicate'])->name('duplicate');
            Route::post('/reorder', [PortfolioController::class, 'reorder'])->name('reorder');
            Route::delete('/{portfolio}/gallery/{media}', [PortfolioController::class, 'deleteGalleryImage'])->name('delete-gallery');
        });
    },
);
