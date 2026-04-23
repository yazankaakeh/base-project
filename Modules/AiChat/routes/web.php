<?php

use Illuminate\Support\Facades\Route;
use Modules\AiChat\Http\Controllers\AiChatController;

Route::middleware(['web'])
    ->prefix('ai-chat')
    ->name('aichat.')
    ->group(function () {
        Route::post('/message', [AiChatController::class, 'send'])->name('message');
        Route::get('/history', [AiChatController::class, 'history'])->name('history');
        Route::post('/reset', [AiChatController::class, 'reset'])->name('reset');
    });
