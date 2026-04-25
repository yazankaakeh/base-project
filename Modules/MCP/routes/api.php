<?php

use Illuminate\Support\Facades\Route;
use Modules\MCP\Http\Controllers\ChatBotController;
use Modules\MCP\Http\Controllers\KnowledgeBaseController;

Route::prefix('v1/chat')->name('api.chat.')->group(function () {
    // Public Chat API (no auth required for guests)
    Route::post('conversations/start', [ChatBotController::class, 'startConversation'])
        ->name('conversations.start');
    Route::post('messages/send', [ChatBotController::class, 'sendMessage'])
        ->name('messages.send');
    Route::get('conversations/session', [ChatBotController::class, 'getBySession'])
        ->name('conversations.session');
    Route::post('conversations/{id}/close', [ChatBotController::class, 'closeConversation'])
        ->name('conversations.close');
    Route::post('feedback', [ChatBotController::class, 'submitFeedback'])
        ->name('feedback.submit');
});

// Knowledge Base API
Route::prefix('v1/knowledge')->name('api.knowledge.')->group(function () {
    Route::get('search', [KnowledgeBaseController::class, 'search'])
        ->name('search');
    Route::get('popular', [KnowledgeBaseController::class, 'popular'])
        ->name('popular');
});

// Authenticated API routes
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('conversations/active', [ChatBotController::class, 'getActiveConversations'])
        ->name('api.conversations.active');
    Route::get('conversations/{id}', [ChatBotController::class, 'getConversation'])
        ->name('api.conversations.show');
});
