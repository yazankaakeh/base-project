<?php

use Illuminate\Support\Facades\Route;
use Modules\Doctor\Http\Controllers\DoctorController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('doctors', DoctorController::class)->names('doctor');
});
