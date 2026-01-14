<?php

use Illuminate\Support\Facades\Route;
use Modules\MCP\Http\Controllers\ChatBotController;
use Modules\MCP\Http\Controllers\KnowledgeBaseController;

// Knowledge Base Management (Admin only)
Route::middleware(['auth:doctor', 'admin-enabled', 'authorize', 'doctorMenu', 'setLocale', 'audit'])->prefix(
    'mcp',
)->name('mcp.')->group(function () {
    // Knowledge Base CRUD
    Route::resource('knowledge', KnowledgeBaseController::class)->except(['show']);
    Route::post('knowledge/{id}/toggle-active', [KnowledgeBaseController::class, 'toggleActive'])
        ->name('knowledge.toggle-active');

    // Admin Chat Management
    Route::get('conversations/active', [ChatBotController::class, 'getActiveConversations'])
        ->name('conversations.active');
    Route::get('conversations/{id}', [ChatBotController::class, 'getConversation'])
        ->name('conversations.show');
});

// Public Chat Widget Routes
Route::prefix('chat-widget')->name('chat-widget.')->group(function () {
    Route::view('/', 'mcp::chat-widget.index')->name('index');
});
