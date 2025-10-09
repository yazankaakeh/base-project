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
                "icon" => "menu-icon tf-icons ti tabler-smart-home",
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
                "icon" => "menu-icon tf-icons ti tabler-smart-home",
                "slug" => "user-management",
                "url" => "user-management",
                "submenu" => [
                    [
                        "url" => route('admin.user_management.index'),
                        "slug" => route('admin.user_management.index'),
                        "name" => trans("admin.sidebar.admins"),
                        "icon" => "menu-icon tf-icons ti tabler-truck",
                    ],
                    [
                        "url" => route('admin.role_management.index'),
                        "slug" => route('admin.role_management.index'),
                        "name" => trans("admin.sidebar.roles"),
                        "icon" => "menu-icon tf-icons ti tabler-book",
                    ],
                    [
                        "url" => route('admin.audits.index'),
                        "slug" => route('admin.audits.index'),
                        "name" => trans("admin.sidebar.audits"),
                        "icon" => "menu-icon tf-icons ti tabler-book",
                    ],
                ],
            ],
            /* [
               "name" => "admin.sidebar.blogs",
               "icon" => "menu-icon tf-icons ti tabler-smart-home",
               "slug" => "blog",
               "url" => "blog",
               "submenu" => [
                 [
                       "url" => route('blogPosts.posts.index'),
                       "slug" => route('blogPosts.posts.index'),
                       "name" => trans("admin.sidebar.posts"),
                       "icon" => "menu-icon tf-icons ti tabler-truck",
                   ],
                   [
                       "url" => route('blogCategory.category.index'),
                       "slug" => route('blogCategory.category.index'),
                       "name" => trans("admin.sidebar.categories"),
                       "icon" => "menu-icon tf-icons ti tabler-book",
                   ],
                   [
                       "url" => route('blogTags.tags.index'),
                       "slug" => route('blogTags.tags.index'),
                       "name" => trans("admin.sidebar.tags"),
                       "icon" => "menu-icon tf-icons ti tabler-book",
                   ],
                   [
                       "url" => route('blogPostType.postType.index'),
                       "slug" => route('blogPostType.postType.index'),
                       "name" => trans("admin.sidebar.postType"),
                       "icon" => "menu-icon tf-icons ti tabler-book",
                   ],
               ],
           ],*/

        ];
    }
}
