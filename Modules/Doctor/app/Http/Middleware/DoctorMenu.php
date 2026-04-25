<?php

namespace Modules\Doctor\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DoctorMenu
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $arrayData = $this->getMenuData();
        $objectData = json_decode(json_encode($arrayData));
        View::share('menuData', $objectData);
        return $next($request);
    }

    private function getMenuData(): array
    {
        return [
            [
                "name" => trans('customer.sidebar.dashboard'),
                "icon" => "menu-icon tf-icons ti tabler-dashboard",
                "slug" => route('doctor.dashboard'),
                "url" => route('doctor.dashboard'),
            ],
            [
                "name" => trans("customer.sidebar.medicalPreviewSettings"),
                "icon" => "menu-icon tf-icons ti tabler-smart-home",
                "slug" => "dashboard",
                "url" => "dashboard",
                "submenu" => [
                    [
                        "slug" => route('doctor.patients.index'),
                        "url" => route('doctor.patients.index'),
                        "name" => trans("customer.sidebar.patients"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                    ],
                    [
                        "url" => route('doctor.clinic.index'),
                        "name" => trans("customer.sidebar.clinic"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                        "slug" => route('doctor.clinic.index'),
                    ],
                    [
                        "slug" => route('doctor.medicalTest.index'),
                        "url" => route('doctor.medicalTest.index'),
                        "name" => trans("customer.sidebar.medicalTest"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                    ],
                    [
                        "slug" => route('doctor.medicine.index'),
                        "url" => route('doctor.medicine.index'),
                        "name" => trans("customer.sidebar.medicine"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                    ],
                    [
                        "slug" => route('doctor.dosageForm.index'),
                        "url" => route('doctor.dosageForm.index'),
                        "name" => trans("customer.sidebar.dosageForm"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                    ],
                    [
                        "slug" => route('doctor.medicalSpecialty.index'),
                        "url" => route('doctor.medicalSpecialty.index'),
                        "name" => trans("customer.sidebar.medicalSpecialty"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                    ],
                    [
                        "slug" => route('doctor.vitalSign.index'),
                        "url" => route('doctor.vitalSign.index'),
                        "name" => trans("customer.sidebar.vitalSign"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                    ],
                    [
                        "slug" => route('doctor.finalDiagnosis.index'),
                        "url" => route('doctor.finalDiagnosis.index'),
                        "name" => trans("customer.sidebar.finalDiagnosis"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                    ],
                ],
            ],
            [
                "name" => trans("admin.sidebar.admins"),
                "icon" => "menu-icon tf-icons ti tabler-user-cog",
                "slug" => "user-management",
                "url" => "user-management",
                "submenu" => [
                    [
                        "url" => route('admin.user_management.index'),
                        "slug" => route('admin.user_management.index'),
                        "name" => trans("admin.sidebar.admins"),
                        "icon" => "menu-icon tf-icons ti tabler-user-shield",
                    ],
                    [
                        "url" => route('admin.role_management.index'),
                        "slug" => route('admin.role_management.index'),
                        "name" => trans("admin.sidebar.roles"),
                        "icon" => "menu-icon tf-icons ti tabler-shield-check",
                    ],
                    [
                        "url" => route('admin.audits.index'),
                        "slug" => route('admin.audits.index'),
                        "name" => trans("admin.sidebar.audits"),
                        "icon" => "menu-icon tf-icons ti tabler-history",
                    ],
                ],
            ],
            [
                "name" => trans("customer.sidebar.blog"),
                "icon" => "menu-icon tf-icons ti tabler-article",
                "slug" => "blog",
                "url" => "javascript:void(0)",
                "submenu" => [
                    [
                        "url" => route('doctor.categories.index'),
                        "slug" => route('doctor.categories.index'),
                        "name" => trans("customer.sidebar.blogCategories"),
                        "icon" => "menu-icon tf-icons ti tabler-category",
                    ],
                    [
                        "url" => route('doctor.posts.index'),
                        "slug" => route('doctor.posts.index'),
                        "name" => trans("customer.sidebar.blogPosts"),
                        "icon" => "menu-icon tf-icons ti tabler-article",
                    ],
                    [
                        "url" => route('doctor.tags.index'),
                        "slug" => route('doctor.tags.index'),
                        "name" => trans("customer.sidebar.blogTags"),
                        "icon" => "menu-icon tf-icons ti tabler-tag",
                    ],
                ],
            ],
            [
                "name" => trans("cms::cms.title"),
                "icon" => "menu-icon tf-icons ti tabler-layout",
                "slug" => "cms",
                "url" => "javascript:void(0)",
                "submenu" => [
                    [
                        "url" => route('cms.index'),
                        "slug" => route('cms.index'),
                        "name" => trans("cms::cms.pages.title"),
                        "icon" => "menu-icon tf-icons ti tabler-file",
                    ],
                    [
                        "url" => route('menus.index'),
                        "slug" => route('menus.index'),
                        "name" => trans("cms::cms.menus.title"),
                        "icon" => "menu-icon tf-icons ti tabler-menu-2",
                    ],
                    [
                        "url" => route('admin.portfolios.index'),
                        "slug" => route('admin.portfolios.index'),
                        "name" => trans("cms::cms.portfolio.title"),
                        "icon" => "menu-icon tf-icons ti tabler-briefcase",
                    ],
                ],
            ],
            [
                "name" => trans("customer.sidebar.settings"),
                "icon" => "menu-icon tf-icons ti tabler-settings",
                "slug" => "settings",
                "url" => "javascript:void(0)",
                "submenu" => [
                    [
                        "url" => route('doctor.theme.settings.index'),
                        "slug" => route('doctor.theme.settings.index'),
                        "name" => trans("core::core.theme_settings.title"),
                        "icon" => "menu-icon tf-icons ti tabler-palette",
                    ],
                    [
                        "url" => route('doctor.seoConfig.get'),
                        "slug" => route('doctor.seoConfig.get'),
                        "name" => trans("customer.sidebar.seoSettings"),
                        "icon" => "menu-icon tf-icons ti tabler-seo",
                    ],
                    [
                        "url" => route('doctor.env.get'),
                        "slug" => route('doctor.env.get'),
                        "name" => trans("customer.sidebar.envSettings"),
                        "icon" => "menu-icon tf-icons ti tabler-server",
                    ],
                ],
            ],

        ];
    }
}
