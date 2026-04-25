<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminManagement\Http\Controllers\AdminManagementController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('adminmanagements', AdminManagementController::class)->names('adminmanagements');
});
