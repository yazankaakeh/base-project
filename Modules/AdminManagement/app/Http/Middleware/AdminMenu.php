<?php

namespace Modules\AdminManagement\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Builds the admin-area side menu. Replaces the legacy DoctorMenu middleware
 * that shipped with the removed Doctor module. Only routes that actually
 * exist (via route-name lookup) are emitted, so the menu is safe even if
 * optional modules (Blog, CMS, Seo) are disabled.
 */
class AdminMenu
{
    public function handle(Request $request, Closure $next): Response
    {
        $menu = $this->getMenuData();
        View::share('menuData', json_decode(json_encode($menu)));

        return $next($request);
    }

    private function getMenuData(): array
    {
        $menu = [];

        // Dashboard
        if (Route::has('admin.dashboard')) {
            $menu[] = [
                'name' => trans('admin.sidebar.dashboard'),
                'icon' => 'menu-icon tf-icons ti tabler-dashboard',
                'slug' => route('admin.dashboard'),
                'url' => route('admin.dashboard'),
            ];
        }

        // Admin / Role / Audit management
        $adminSubmenu = [];
        if (Route::has('admin.user_management.index')) {
            $adminSubmenu[] = [
                'url' => route('admin.user_management.index'),
                'slug' => route('admin.user_management.index'),
                'name' => trans('admin.sidebar.admins'),
                'icon' => 'menu-icon tf-icons ti tabler-user-shield',
            ];
        }
        if (Route::has('admin.role_management.index')) {
            $adminSubmenu[] = [
                'url' => route('admin.role_management.index'),
                'slug' => route('admin.role_management.index'),
                'name' => trans('admin.sidebar.roles'),
                'icon' => 'menu-icon tf-icons ti tabler-shield-check',
            ];
        }
        if (Route::has('admin.audits.index')) {
            $adminSubmenu[] = [
                'url' => route('admin.audits.index'),
                'slug' => route('admin.audits.index'),
                'name' => trans('admin.sidebar.audits'),
                'icon' => 'menu-icon tf-icons ti tabler-history',
            ];
        }
        if (!empty($adminSubmenu)) {
            $menu[] = [
                'name' => trans('admin.sidebar.admins'),
                'icon' => 'menu-icon tf-icons ti tabler-user-cog',
                'slug' => 'user-management',
                'url' => 'javascript:void(0)',
                'submenu' => $adminSubmenu,
            ];
        }

        // Blog
        $blogSubmenu = [];
        foreach ([
            'admin.categories.index' => ['customer.sidebar.blogCategories', 'tabler-category'],
            'admin.posts.index'      => ['customer.sidebar.blogPosts', 'tabler-article'],
            'admin.tags.index'       => ['customer.sidebar.blogTags', 'tabler-tag'],
        ] as $routeName => [$transKey, $icon]) {
            if (Route::has($routeName)) {
                $blogSubmenu[] = [
                    'url' => route($routeName),
                    'slug' => route($routeName),
                    'name' => trans($transKey),
                    'icon' => 'menu-icon tf-icons ti '.$icon,
                ];
            }
        }
        if (!empty($blogSubmenu)) {
            $menu[] = [
                'name' => trans('customer.sidebar.blog'),
                'icon' => 'menu-icon tf-icons ti tabler-article',
                'slug' => 'blog',
                'url' => 'javascript:void(0)',
                'submenu' => $blogSubmenu,
            ];
        }

        // CMS
        $cmsSubmenu = [];
        foreach ([
            'cms.index'               => ['cms::cms.pages.title', 'tabler-file'],
            'menus.index'             => ['cms::cms.menus.title', 'tabler-menu-2'],
            'admin.portfolios.index'  => ['cms::cms.portfolio.title', 'tabler-briefcase'],
        ] as $routeName => [$transKey, $icon]) {
            if (Route::has($routeName)) {
                $cmsSubmenu[] = [
                    'url' => route($routeName),
                    'slug' => route($routeName),
                    'name' => trans($transKey),
                    'icon' => 'menu-icon tf-icons ti '.$icon,
                ];
            }
        }
        if (!empty($cmsSubmenu)) {
            $menu[] = [
                'name' => trans('cms::cms.title'),
                'icon' => 'menu-icon tf-icons ti tabler-layout',
                'slug' => 'cms',
                'url' => 'javascript:void(0)',
                'submenu' => $cmsSubmenu,
            ];
        }

        // Settings
        $settingsSubmenu = [];
        foreach ([
            'admin.theme.settings.index' => ['core::core.theme_settings.title', 'tabler-palette'],
            'admin.seoConfig.get'        => ['customer.sidebar.seoSettings', 'tabler-seo'],
            'admin.env.get'              => ['customer.sidebar.envSettings', 'tabler-server'],
        ] as $routeName => [$transKey, $icon]) {
            if (Route::has($routeName)) {
                $settingsSubmenu[] = [
                    'url' => route($routeName),
                    'slug' => route($routeName),
                    'name' => trans($transKey),
                    'icon' => 'menu-icon tf-icons ti '.$icon,
                ];
            }
        }
        if (!empty($settingsSubmenu)) {
            $menu[] = [
                'name' => trans('customer.sidebar.settings'),
                'icon' => 'menu-icon tf-icons ti tabler-settings',
                'slug' => 'settings',
                'url' => 'javascript:void(0)',
                'submenu' => $settingsSubmenu,
            ];
        }

        return $menu;
    }
}
