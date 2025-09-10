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
    Schema::create('blog_posts_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('blog_posts_id')->unsigned();
      $table->string('title');
      $table->string('locale');
      $table->text('description');
      $table->string('short_description');
      $table->unique(['blog_posts_id', 'locale']);
      $table->foreign('blog_posts_id')->references('id')
        ->on('blog_posts')->onDelete('cascade');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('blog_posts_translations');
  }
};
