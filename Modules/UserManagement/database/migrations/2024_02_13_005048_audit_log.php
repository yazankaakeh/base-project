<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up(): void
  {
    Schema::create('audit_logs', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('admin_id')->nullable();
      $table->foreign('admin_id')->references('id')->on('admins');
      $table->string('url')->nullable();
      $table->string('route_name')->index()->nullable();
      $table->string('method')->nullable();
      $table->text('payload')->nullable();
      $table->string('ip')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down(): void
  {
    Schema::dropIfExists('audit_logs');
  }
};
