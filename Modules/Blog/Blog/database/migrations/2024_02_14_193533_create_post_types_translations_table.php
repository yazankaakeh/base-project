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
    Schema::create('post_types_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('post_types_id')->unsigned();
      $table->string('locale')->index();
      $table->string('name');
      $table->timestamps();
      $table->unique(['post_types_id', 'locale']);
      $table->foreign('post_types_id')->references('id')
        ->on('post_types')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('post_types_translations');
  }
};
