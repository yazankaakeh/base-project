<?php

use Illuminate\Support\Facades\Route;
use Modules\Doctor\Http\Controllers\DashboardController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('doctors', DashboardController::class)->names('doctor');
});
