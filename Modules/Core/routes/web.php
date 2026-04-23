<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\app\Http\Controllers\ContactUsController;
use Modules\Core\app\Http\Controllers\EnvController;
use Modules\Core\App\Http\Controllers\ThemeSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes (Core)
|--------------------------------------------------------------------------
|
| Back-office environment and theme settings routes. These live under the
| /admin prefix and use the Codliy admin guard. The legacy /doctor prefix
| was retired together with the Doctor module.
|
*/

Route::middleware(['auth:admin', 'adminMenu', 'admin-enabled', 'setLocale', 'authorize', 'audit'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('env', [EnvController::class, 'index'])->name('env.get');
        Route::post('env/update', [EnvController::class, 'update'])->name('env.update');
        Route::post('env/sendTestEmail', [EnvController::class, 'sendTestEmail'])->name('env.sendTestEmail');

        // Firebase routes
        Route::post('firebase/saveToken', [EnvController::class, 'savePushToken'])->name('firebase.saveToken');
        Route::post('firebase/sendTestNotification', [EnvController::class, 'sendTestNotification'])
            ->name('firebase.sendTestNotification');

        // Theme Settings routes
        Route::get('theme-settings', [ThemeSettingsController::class, 'index'])->name('theme.settings.index');
        Route::post('theme-settings/update', [ThemeSettingsController::class, 'update'])->name('theme.settings.update');
        Route::post('theme-settings/reset', [ThemeSettingsController::class, 'reset'])->name('theme.settings.reset');

        // Contact Us inbox — read-only inbox of landing form submissions.
        Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact_us.index');
        Route::get('contact-us/{contact}', [ContactUsController::class, 'show'])->name('contact_us.show');
        Route::delete('contact-us/{contact}', [ContactUsController::class, 'destroy'])->name('contact_us.destroy');
    });

Route::post('submitContactUs', [ContactUsController::class, 'submitContactForm'])->name('env.submitContactForm');
