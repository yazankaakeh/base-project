<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chat_conversations')->onDelete('cascade');
            $table->morphs('sender'); // Polymorphic for user, bot, guest
            $table->enum('role', ['user', 'assistant', 'system'])->default('user');
            $table->text('message');
            $table->json('context')->nullable(); // AI context and references
            $table->boolean('is_from_bot')->default(false);
            $table->string('model_used')->nullable(); // AI model identifier
            $table->integer('tokens_used')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Custom index names to avoid MySQL 64 character limit
            $table->index('conversation_id', 'idx_chat_msg_conv');
            $table->index(['sender_type', 'sender_id'], 'idx_chat_msg_sender');
            $table->index('role', 'idx_chat_msg_role');
            $table->index('is_from_bot', 'idx_chat_msg_from_bot');
            $table->index('created_at', 'idx_chat_msg_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
