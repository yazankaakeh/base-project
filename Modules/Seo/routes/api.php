<?php

use Illuminate\Support\Facades\Route;
use Modules\Seo\Http\Controllers\SeoSettingsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('seos', SeoSettingsController::class)->names('seo');
});
