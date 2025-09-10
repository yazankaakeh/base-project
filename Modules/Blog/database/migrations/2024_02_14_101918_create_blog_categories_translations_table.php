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
    Schema::create('blog_categories_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('blog_category_id')->unsigned();
      $table->string('locale')->index();
      $table->string('name');
      $table->text('description')->nullable();
      $table->timestamps();
      $table->unique(['blog_category_id', 'locale']);
      $table->foreign('blog_category_id')->references('id')
        ->on('blog_categories')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('blog_categories');
  }
};
