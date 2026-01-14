<?php

namespace Modules\Core\App\View\Composers;

use Illuminate\View\View;
use Modules\Core\App\Models\ThemeSetting;

class ThemeSettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Determine scope based on route or request
        $scope = request()->is('admin/*') || request()->is('doctor/*') ? 'admin' : 'website';

        $themeSettings = ThemeSetting::getForScope($scope);

        if ($themeSettings) {
            $view->with('themeSettings', $themeSettings);
            $view->with('customThemeCss', $themeSettings->getFullCustomCss());
        }
    }
}