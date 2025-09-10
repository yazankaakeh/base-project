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
    Schema::create('posts_post_types', function (Blueprint $table) {
      $table->foreignId('blog_posts_id')->constrained('blog_posts')->onDelete('cascade');
      $table->foreignId('post_types_id')->constrained('post_types')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('posts_post_types');
  }
};
