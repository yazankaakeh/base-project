<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // Translatable
            $table->string('slug')->unique();
            $table->json('short_description')->nullable(); // Translatable
            $table->json('description')->nullable(); // Translatable - Full content
            $table->json('category')->nullable(); // Translatable
            $table->string('client_name')->nullable();
            $table->string('client_company')->nullable();
            $table->string('project_url')->nullable();
            $table->json('technologies')->nullable(); // Array of technologies used
            $table->date('start_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->decimal('project_budget', 12, 2)->nullable();
            $table->string('project_duration')->nullable(); // e.g., "3 months"
            $table->json('features')->nullable(); // Translatable - Key features list
            $table->json('challenges')->nullable(); // Translatable - Challenges faced
            $table->json('solutions')->nullable(); // Translatable - Solutions provided
            $table->json('results')->nullable(); // Translatable - Results achieved
            $table->json('testimonial')->nullable(); // Translatable - Client testimonial
            $table->string('testimonial_author')->nullable();
            $table->string('testimonial_position')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->json('meta_data')->nullable(); // Additional settings
            $table->bigInteger('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'is_featured']);
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
