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
        Schema::create('business_knowledge_base', function (Blueprint $table) {
            $table->id();
            // Polymorphic relationship with custom index name
            $table->string('knowledgeable_type');
            $table->unsignedBigInteger('knowledgeable_id');
            $table->index(['knowledgeable_type', 'knowledgeable_id'], 'idx_biz_know_morph');
            $table->string('category')->index();
            $table->string('subcategory')->nullable()->index();
            $table->json('question'); // Translatable
            $table->json('answer'); // Translatable
            $table->json('keywords')->nullable(); // For search optimization
            $table->json('tags')->nullable();
            $table->integer('priority')->default(0); // Higher priority shown first
            $table->boolean('is_active')->default(true)->index();
            $table->integer('usage_count')->default(0); // Track popularity
            $table->timestamp('last_used_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Custom index names to avoid MySQL 64 character limit
            $table->index(['category', 'is_active'], 'idx_biz_know_cat_active');
            $table->index('priority', 'idx_biz_know_priority');
            $table->index('usage_count', 'idx_biz_know_usage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_knowledge_base');
    }
};
