<?php

namespace Modules\Core\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Core\App\Actions\ThemeSettings\GetThemeSettingsAction;
use Modules\Core\App\Actions\ThemeSettings\UpdateThemeSettingsAction;
use Modules\Core\App\Http\Requests\ThemeSettingsRequest;
use Modules\Core\App\Models\ThemeSetting;

class ThemeSettingsController extends Controller
{
    /**
     * Show the theme settings page
     */
    public function index(GetThemeSettingsAction $action): View
    {
        $adminSettings = $action->handle('admin');

        $websiteSettings = $action->handle('website');

        return view('core::theme-settings.index', compact('adminSettings', 'websiteSettings'));
    }

    /**
     * Reset theme settings to defaults
     */
    public function reset(Request $request): RedirectResponse
    {
        $scope = $request->input('scope', 'admin');

        $themeSetting = ThemeSetting::query()->where('scope', $scope)->first();

        if ($themeSetting) {
            // Shared Codliy defaults — same primary / radius / brand across
            // both scopes so a "Reset" always returns to the canonical look.
            $shared = [
                'primary_color'            => '#0059ff',
                'dark_primary_color'       => '#3B82F6',
                'success_color'            => '#71dd37',
                'info_color'               => '#03c3ec',
                'warning_color'            => '#ffab00',
                'danger_color'             => '#ff3e1d',
                'dark_success_color'       => '#71dd37',
                'dark_info_color'          => '#03c3ec',
                'dark_warning_color'       => '#ffab00',
                'dark_danger_color'        => '#ff3e1d',
                'font_family'              => 'Google Sans Flex',
                'headings_font_family'     => 'Google Sans Flex',
                'headings_font_weight'     => '600',
                'rtl_font_family'          => 'Noto Kufi Arabic',
                'rtl_headings_font_family' => 'Noto Kufi Arabic',
                'border_radius'            => '18px',
                'site_title'               => 'Codliy',
                'custom_css'               => null,
                'dark_custom_css'          => null,
            ];

            $defaults = $scope === 'admin' ? array_merge($shared, [
                'secondary_color'      => '#8592a3',
                'dark_secondary_color' => '#8592a3',
                'font_size_base'       => '0.9375rem',
                'body_bg'              => '#f5f5f9',
                'card_bg'              => '#ffffff',
                'dark_body_bg'         => '#232333',
                'dark_card_bg'         => '#2b2c40',
            ]) : array_merge($shared, [
                'secondary_color'      => '#6c757d',
                'dark_secondary_color' => '#8592a3',
                'font_size_base'       => '1rem',
                'body_bg'              => '#ffffff',
                'card_bg'              => '#f8f9fa',
                'dark_body_bg'         => '#020611',
                'dark_card_bg'         => '#0A1F4D',
            ]);

            // Reset to defaults
            $themeSetting->update($defaults);

            return redirect()
                ->route('theme.settings.index')
                ->with('success', trans('core::core.theme_settings.reset_successfully'));
        }

        return redirect()
            ->route('theme.settings.index')
            ->with('error', trans('core::core.theme_settings.reset_failed'));
    }

    /**
     * Update theme settings
     */
    public function update(
        ThemeSettingsRequest      $request,
        UpdateThemeSettingsAction $action,
    ): RedirectResponse
    {
        try {
            $action->handle($request);

            return redirect()
                ->route('theme.settings.index')
                ->with('success', trans('core::core.theme_settings.updated_successfully'));
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', trans('core::core.theme_settings.update_failed') . ': ' . $e->getMessage())
                ->withInput();
        }
    }
}
