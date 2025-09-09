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
    Schema::create('blog_tags_translation', function (Blueprint $table) {
      $table->id();
      $table->foreignId('blog_tag_id')->unsigned();
      $table->string('locale')->index();
      $table->string('name');
      $table->timestamps();
      $table->unique(['blog_tag_id', 'locale']);
      $table->foreign('blog_tag_id')->references('id')
        ->on('blog_tags')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('blog_tags_translation');
  }
};
