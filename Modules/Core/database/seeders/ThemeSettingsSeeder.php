<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\App\Models\ThemeSetting;

/**
 * Seeds Codliy brand defaults for both admin and website scopes.
 *
 * Brand assets live under public/assets/brand/ (NB: the light logo filename
 * is "Ligh Logo.png" — the space is intentional / pre-existing). We store
 * them as path strings on `*_path` columns so they work even before the
 * Spatie media_library table is populated; the ThemeSetting::getLogoUrl()
 * helper already handles both sources seamlessly.
 */
class ThemeSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $brandDefaults = [
            // Light logo  — shown on light surfaces
            'logo_path' => 'assets/brand/Ligh Logo.png',
            // Dark logo   — shown on dark surfaces
            'logo_dark_path' => 'assets/brand/Dark Logo.png',
            // Browser tab icon
            'favicon_path' => 'assets/brand/FAV-1.ico',
        ];

        // ─────────────────────────────────────────────────────────────
        // Admin dashboard defaults
        // ─────────────────────────────────────────────────────────────
        ThemeSetting::query()->updateOrCreate(
            ['scope' => 'admin'],
            array_merge($brandDefaults, [
                // Light mode colors — Codliy primary #0059ff
                'primary_color' => '#0059ff',
                'secondary_color' => '#8592a3',
                'success_color' => '#71dd37',
                'info_color' => '#03c3ec',
                'warning_color' => '#ffab00',
                'danger_color' => '#ff3e1d',
                // Dark mode — brighter blue so it reads on dark surfaces
                'dark_primary_color' => '#3B82F6',
                'dark_secondary_color' => '#8592a3',
                'dark_success_color' => '#71dd37',
                'dark_info_color' => '#03c3ec',
                'dark_warning_color' => '#ffab00',
                'dark_danger_color' => '#ff3e1d',
                // Typography — Latin body + headings in Inter, Arabic in Cairo
                'font_family' => 'Google Sans Flex',
                'font_size_base' => '0.9375rem',
                'headings_font_family' => 'Google Sans Flex',
                'headings_font_weight' => '600',
                'rtl_font_family' => 'Noto Kufi Arabic',
                'rtl_headings_font_family' => 'Noto Kufi Arabic',
                // Layout
                'body_bg' => '#f5f5f9',
                'card_bg' => '#ffffff',
                'dark_body_bg' => '#232333',
                'dark_card_bg' => '#2b2c40',
                'border_radius' => '18px',
                'site_title' => 'Codliy',
                'custom_css' => '',
                'dark_custom_css' => '',
                'is_active' => true,
            ])
        );

        // ─────────────────────────────────────────────────────────────
        // Public website defaults
        // ─────────────────────────────────────────────────────────────
        ThemeSetting::query()->updateOrCreate(
            ['scope' => 'website'],
            array_merge($brandDefaults, [
                'primary_color' => '#0059ff',
                'secondary_color' => '#6c757d',
                'success_color' => '#28a745',
                'info_color' => '#17a2b8',
                'warning_color' => '#ffc107',
                'danger_color' => '#dc3545',
                'dark_primary_color' => '#3B82F6',
                'dark_secondary_color' => '#8592a3',
                'dark_success_color' => '#71dd37',
                'dark_info_color' => '#03c3ec',
                'dark_warning_color' => '#ffab00',
                'dark_danger_color' => '#ff3e1d',
                'font_family' => 'Google Sans Flex',
                'font_size_base' => '1rem',
                'headings_font_family' => 'Google Sans Flex',
                'headings_font_weight' => '600',
                'rtl_font_family' => 'Noto Kufi Arabic',
                'rtl_headings_font_family' => 'Noto Kufi Arabic',
                'body_bg' => '#ffffff',
                'card_bg' => '#f8f9fa',
                'dark_body_bg' => '#020611',
                'dark_card_bg' => '#0A1F4D',
                'border_radius' => '18px',
                'site_title' => 'Codliy',
                'custom_css' => '',
                'dark_custom_css' => '',
                'is_active' => true,
            ])
        );

        // Bust any cached ThemeSetting instances so the next request immediately
        // picks up the new palette / fonts / brand assets.
        ThemeSetting::clearCache();

        $this->command->info('Theme settings seeded with Codliy defaults (primary #0059ff, 18px radius, Cairo RTL, brand logos).');
    }
}
