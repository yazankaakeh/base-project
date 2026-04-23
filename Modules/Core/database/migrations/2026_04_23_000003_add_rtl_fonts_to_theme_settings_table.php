<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds optional RTL-specific font families to ThemeSettings so admins can
 * pair a Latin font (LTR) with an Arabic-ready font (RTL) in one go, e.g.
 * "Inter" for English/Turkish pages and "IBM Plex Sans Arabic" or "Tajawal"
 * for Arabic pages. Stylesheets swap between them based on `dir=rtl`.
 *
 * Columns stay nullable — when empty, the layout falls back to the regular
 * `font_family` / `headings_font_family`, preserving existing behavior.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->string('rtl_font_family')->nullable()->after('headings_font_weight');
            $table->string('rtl_headings_font_family')->nullable()->after('rtl_font_family');
        });
    }

    public function down(): void
    {
        Schema::table('theme_settings', function (Blueprint $table) {
            $table->dropColumn(['rtl_font_family', 'rtl_headings_font_family']);
        });
    }
};
