<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->boolean('ai_enabled')->default(false)->after('dark_custom_css');
            $table->string('ai_provider')->nullable()->after('ai_enabled');
            $table->string('ai_model')->nullable()->after('ai_provider');
            $table->text('ai_system_prompt')->nullable()->after('ai_model');
        });
    }

    public function down(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->dropColumn(['ai_enabled', 'ai_provider', 'ai_model', 'ai_system_prompt']);
        });
    }
};
