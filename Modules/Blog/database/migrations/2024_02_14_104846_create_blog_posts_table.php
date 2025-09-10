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
      $table->string('slug');
      $table->string('img');
      $table->foreignId('post_type_id')->unsigned();
      $table->json('related_posts')->nullable();
      $table->integer('clapping')->default(0);
      $table->integer('views')->default(0);
      $table->boolean('is_published')->default(false);
      $table->foreignId('created_by')->unsigned();
      $table->foreignId('updated_by')->unsigned();
      $table->timestamps();
      $table->foreign('created_by')->references('id')
        ->on('admins')->onDelete('cascade');
      $table->foreign('updated_by')->references('id')
        ->on('admins')->onDelete('cascade');
      $table->foreign('post_type_id')->references('id')
        ->on('post_types')->onDelete('cascade');
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
