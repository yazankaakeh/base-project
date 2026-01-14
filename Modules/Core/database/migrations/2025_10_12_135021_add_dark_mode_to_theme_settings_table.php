<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            // Dark mode color scheme
            $table->string('dark_primary_color')->default('#696cff')->after('danger_color');
            $table->string('dark_secondary_color')->default('#8592a3')->after('dark_primary_color');
            $table->string('dark_success_color')->default('#71dd37')->after('dark_secondary_color');
            $table->string('dark_info_color')->default('#03c3ec')->after('dark_success_color');
            $table->string('dark_warning_color')->default('#ffab00')->after('dark_info_color');
            $table->string('dark_danger_color')->default('#ff3e1d')->after('dark_warning_color');

            // Dark mode layout colors
            $table->string('dark_body_bg')->default('#232333')->after('border_radius');
            $table->string('dark_card_bg')->default('#2b2c40')->after('dark_body_bg');

            // Dark mode custom CSS
            $table->text('dark_custom_css')->nullable()->after('custom_css');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->dropColumn([
                'dark_primary_color',
                'dark_secondary_color',
                'dark_success_color',
                'dark_info_color',
                'dark_warning_color',
                'dark_danger_color',
                'dark_body_bg',
                'dark_card_bg',
                'dark_custom_css',
            ]);
        });
    }
};
