<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('authorable'); // creates authorable_id (bigint) + authorable_type (string, indexed)
            $table->json('title');
            $table->json('description');
            $table->boolean('is_active')->default(true);
            $table->integer('type');
            $table->integer('clapping')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
