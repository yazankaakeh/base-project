<?php

namespace Modules\Core\App\Actions\ThemeSettings;

use Modules\Core\App\Http\Requests\ThemeSettingsRequest;
use Modules\Core\App\Models\ThemeSetting;

class UpdateThemeSettingsAction
{
    public function handle(ThemeSettingsRequest $request): ThemeSetting
    {
        $scope = $request->input('scope', 'admin');

        $themeSetting = ThemeSetting::where('scope', $scope)->first();

        if (!$themeSetting) {
            $themeSetting = new ThemeSetting(['scope' => $scope]);
        }

        // Update light mode colors
        $themeSetting->primary_color = $request->input('primary_color');
        $themeSetting->secondary_color = $request->input('secondary_color');
        $themeSetting->success_color = $request->input('success_color');
        $themeSetting->info_color = $request->input('info_color');
        $themeSetting->warning_color = $request->input('warning_color');
        $themeSetting->danger_color = $request->input('danger_color');

        // Update dark mode colors
        $themeSetting->dark_primary_color = $request->input('dark_primary_color');
        $themeSetting->dark_secondary_color = $request->input('dark_secondary_color');
        $themeSetting->dark_success_color = $request->input('dark_success_color');
        $themeSetting->dark_info_color = $request->input('dark_info_color');
        $themeSetting->dark_warning_color = $request->input('dark_warning_color');
        $themeSetting->dark_danger_color = $request->input('dark_danger_color');

        // Update typography
        // If user typed a custom family (or picked "__custom__"), prefer the custom field.
        $fontFamilyPick = trim((string) $request->input('font_family', ''));
        $fontFamilyCustom = trim((string) $request->input('font_family_custom', ''));
        if ($fontFamilyCustom !== '' || $fontFamilyPick === '__custom__') {
            $themeSetting->font_family = $fontFamilyCustom !== '' ? $fontFamilyCustom : $themeSetting->font_family;
        } else {
            $themeSetting->font_family = $fontFamilyPick;
        }

        $headingsFamilyPick = trim((string) $request->input('headings_font_family', ''));
        $headingsFamilyCustom = trim((string) $request->input('headings_font_family_custom', ''));
        if ($headingsFamilyCustom !== '' || $headingsFamilyPick === '__custom__') {
            $themeSetting->headings_font_family = $headingsFamilyCustom !== '' ? $headingsFamilyCustom : $themeSetting->headings_font_family;
        } else {
            $themeSetting->headings_font_family = $headingsFamilyPick !== '' ? $headingsFamilyPick : null;
        }

        $themeSetting->font_size_base = $request->input('font_size_base');
        $themeSetting->headings_font_weight = $request->input('headings_font_weight');

        // Merge Google Fonts URLs into custom_css_variables JSON so the runtime
        // layout (styles.blade.php / stylesFront.blade.php) can load them.
        $ccv = is_array($themeSetting->custom_css_variables) ? $themeSetting->custom_css_variables : [];

        $primaryFontUrl = trim((string) $request->input('google_font_url', ''));
        if ($primaryFontUrl !== '') {
            $ccv['google_font_url'] = $primaryFontUrl;
        } else {
            unset($ccv['google_font_url']);
        }

        $extraUrlsRaw = (string) $request->input('google_font_urls', '');
        if ($extraUrlsRaw !== '') {
            $extraUrls = array_values(array_filter(array_map(
                fn ($line) => trim($line),
                preg_split('/\r\n|\r|\n/', $extraUrlsRaw) ?: []
            ), fn ($line) => $line !== '' && filter_var($line, FILTER_VALIDATE_URL)));
            if (!empty($extraUrls)) {
                $ccv['google_font_urls'] = $extraUrls;
            } else {
                unset($ccv['google_font_urls']);
            }
        } else {
            unset($ccv['google_font_urls']);
        }

        $themeSetting->custom_css_variables = $ccv;

        // Update light mode layout
        $themeSetting->body_bg = $request->input('body_bg');
        $themeSetting->card_bg = $request->input('card_bg');
        $themeSetting->border_radius = $request->input('border_radius');

        // Update dark mode layout
        $themeSetting->dark_body_bg = $request->input('dark_body_bg');
        $themeSetting->dark_card_bg = $request->input('dark_card_bg');

        // Update branding
        $themeSetting->site_title = $request->input('site_title');

        // Update advanced settings
        if ($request->filled('custom_css')) {
            $themeSetting->custom_css = $request->input('custom_css');
        }

        if ($request->filled('dark_custom_css')) {
            $themeSetting->dark_custom_css = $request->input('dark_custom_css');
        }

        // AI Assistant configuration (only persisted for the website scope;
        // admin scope rows stay untouched so they don't fight website settings).
        if ($scope === 'website') {
            $themeSetting->ai_enabled = (bool) $request->input('ai_enabled', false);
            $themeSetting->ai_provider = $request->input('ai_provider') ?: null;
            $themeSetting->ai_model = $request->input('ai_model') ?: null;
            $themeSetting->ai_system_prompt = $request->input('ai_system_prompt') ?: null;
        }

        $themeSetting->save();

        // Handle logo uploads
        if ($request->hasFile('logo')) {
            $themeSetting->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        if ($request->hasFile('logo_dark')) {
            $themeSetting->addMediaFromRequest('logo_dark')->toMediaCollection('logo_dark');
        }

        if ($request->hasFile('favicon')) {
            $themeSetting->addMediaFromRequest('favicon')->toMediaCollection('favicon');
        }

        return $themeSetting;
    }
}