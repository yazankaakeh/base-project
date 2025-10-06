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
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('notifiable');
            $table->string('type');
            $table->boolean('read')->default(0);
            $table->string('action_key')->after('read')->nullable();
            $table->string('action_value')->after('action_key')->nullable();
            $table->longText('data')->nullable()->after('action_value');
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
        Schema::dropIfExists('notifications');
    }
};
