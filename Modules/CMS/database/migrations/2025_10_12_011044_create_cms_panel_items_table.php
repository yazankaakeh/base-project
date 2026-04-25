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
        Schema::create('cms_panel_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panel_id')->constrained('cms_panels')->onDelete('cascade');
            $table->string('type'); // PanelItemTypeEnum
            $table->json('title')->nullable(); // Translatable
            $table->json('content')->nullable(); // Translatable
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('data')->nullable(); // Flexible data storage (icon, social links, rating, etc.)
            $table->timestamps();
            $table->softDeletes();

            $table->index(['panel_id', 'order']);
            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_panel_items');
    }
};
