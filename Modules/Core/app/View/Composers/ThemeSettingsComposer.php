<?php

namespace Modules\Core\App\View\Composers;

use Illuminate\View\View;
use Modules\Core\App\Models\ThemeSetting;

class ThemeSettingsComposer
{
    /**
     * Cache keys for request-level caching
     */
    private const CACHE_KEY_SETTINGS = 'theme_settings_request_cache';
    private const CACHE_KEY_CSS = 'theme_settings_css_request_cache';

    /**
     * Bind data to the view.
     * Uses request-level caching to avoid multiple queries per request.
     */
    public function compose(View $view): void
    {
        // Determine scope based on route or request
        $scope = request()->is('admin/*') || request()->is('doctor/*') ? 'admin' : 'website';
        $cacheKey = self::CACHE_KEY_SETTINGS . '_' . $scope;
        $cssCacheKey = self::CACHE_KEY_CSS . '_' . $scope;

        // Check if already loaded in this request (using app container as request-level cache)
        if (app()->bound($cacheKey)) {
            $themeSettings = app($cacheKey);
            $customThemeCss = app($cssCacheKey);
        } else {
            // Load from database/cache once per request
            $themeSettings = ThemeSetting::getForScope($scope);
            $customThemeCss = $themeSettings?->getFullCustomCss() ?? '';

            // Store in app container for subsequent view compositions in this request
            app()->instance($cacheKey, $themeSettings);
            app()->instance($cssCacheKey, $customThemeCss);
        }

        if ($themeSettings) {
            $view->with('themeSettings', $themeSettings);
            $view->with('customThemeCss', $customThemeCss);
        }
    }
}