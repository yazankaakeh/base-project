<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Doctor\ForgotPasswordController as DoctorForgotPasswordController;
use Modules\Auth\Http\Controllers\Doctor\LoginController as DoctorLoginController;
use Modules\Auth\Http\Controllers\Doctor\ResetPasswordController as DoctorResetPasswordController;
use Modules\Auth\Http\Controllers\Doctor\VerifyEmailController as DoctorVerifyEmailController;
use Modules\Auth\Http\Controllers\Patient\ForgotPasswordController as PatientForgotPasswordController;
use Modules\Auth\Http\Controllers\Patient\LoginController as PatientLoginController;
use Modules\Auth\Http\Controllers\Patient\RegisterController as PatientRegisterController;
use Modules\Auth\Http\Controllers\Patient\ResetPasswordController as PatientResetPasswordController;
use Modules\Auth\Http\Controllers\Patient\VerifyEmailController as PatientVerifyEmailController;

/*
|--------------------------------------------------------------------------
| Doctor Authentication Routes
|--------------------------------------------------------------------------
*/

Route::prefix('doctor')->name('doctor.')->group(function () {
    // Guest routes (for doctors who are not authenticated)
    Route::middleware('guest:doctor')->group(function () {
        // Login
        Route::get('login', [DoctorLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [DoctorLoginController::class, 'login'])->name('login.post');

        // Password Reset
        Route::get('forgot-password', [DoctorForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('forgot-password', [DoctorForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('reset-password/{token}', [DoctorResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('reset-password', [DoctorResetPasswordController::class, 'reset'])->name('password.update');
    });

    // Authenticated doctor routes
    Route::middleware('auth:doctor')->group(function () {
        // Logout
        Route::post('logout', [DoctorLoginController::class, 'logout'])->name('logout');

        // Email Verification
        Route::get('verify-email', [DoctorVerifyEmailController::class, 'notice'])->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', [DoctorVerifyEmailController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('email/verification-notification', [DoctorVerifyEmailController::class, 'resend'])
            ->middleware('throttle:6,1')
            ->name('verification.resend');
    });
});

/*
|--------------------------------------------------------------------------
| Patient Authentication Routes
|--------------------------------------------------------------------------
*/

Route::prefix('patient')->name('patient.')->group(function () {
    // Guest routes (for patients who are not authenticated)
    Route::middleware('guest:web')->group(function () {
        // Login
        Route::get('login', [PatientLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [PatientLoginController::class, 'login'])->name('login.post');

        // Registration
        Route::get('register', [PatientRegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [PatientRegisterController::class, 'register'])->name('register.post');

        // Password Reset
        Route::get('forgot-password', [PatientForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('forgot-password', [PatientForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('reset-password/{token}', [PatientResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('reset-password', [PatientResetPasswordController::class, 'reset'])->name('password.update');
    });

    // Authenticated patient routes
    Route::middleware('auth:web')->group(function () {
        // Logout
        Route::post('logout', [PatientLoginController::class, 'logout'])->name('logout');

        // Email Verification
        Route::get('verify-email', [PatientVerifyEmailController::class, 'notice'])->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', [PatientVerifyEmailController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('email/verification-notification', [PatientVerifyEmailController::class, 'resend'])
            ->middleware('throttle:6,1')
            ->name('verification.resend');
    });
});