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
        Schema::create('chat_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('chat_messages')->onDelete('cascade');
            $table->foreignId('conversation_id')->constrained('chat_conversations')->onDelete('cascade');
            $table->morphs('reviewer'); // Who gave feedback
            $table->enum('rating', ['helpful', 'not_helpful', 'neutral'])->nullable();
            $table->integer('score')->nullable(); // 1-5 rating
            $table->text('comment')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            // Custom index names to avoid MySQL 64 character limit
            $table->index('message_id', 'idx_chat_fb_msg');
            $table->index('conversation_id', 'idx_chat_fb_conv');
            $table->index('rating', 'idx_chat_fb_rating');
            $table->index('score', 'idx_chat_fb_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_feedback');
    }
};
