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
    Schema::create('posts_tags', function (Blueprint $table) {
      $table->foreignId('blog_posts_id')->constrained('blog_posts')->onDelete('cascade');
      $table->foreignId('blog_tags_id')->constrained('blog_tags')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('posts_tags');
  }
};
