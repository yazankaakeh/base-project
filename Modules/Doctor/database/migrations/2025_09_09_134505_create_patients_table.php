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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->foreign('nationality_id')->references('id')->on('countries');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->integer('age');
            $table->string('work')->nullable();
            $table->string('children')->nullable();
            $table->integer('gender');
            $table->integer('blood_type');
            $table->integer('marital_status');
            $table->integer('is_active')->default(1);
            $table->string('drug_allergies')->nullable();
            $table->string('disabilities')->nullable();
            $table->string('medical_history')->nullable();
            $table->string('surgical_history')->nullable();
            $table->string('accident_history')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
