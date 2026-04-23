<?php

use Modules\AdminManagement\Enums\ActiveAdminEnum;

return [
    'ActiveAdminEnum' => [
        ActiveAdminEnum::ACTIVE->value => 'نشط',
        ActiveAdminEnum::DE_ACTIVE->value => 'غير نشط',
    ],
    'user' => [
        'title' => 'إدارة المستخدمين',
        'subtitle' => 'إدارة المشرفين وأدوارهم وصلاحياتهم',
        'createLabel' => 'مستخدم جديد',
        'editUserStatus' => 'تعديل حالة المستخدم',
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'role' => 'الدور',
        'image' => 'الصورة',
        'status' => 'الحالة',
        'actions' => 'الإجراءات',
        'search' => 'ابحث بالاسم أو البريد الإلكتروني',
        'filter_by_role' => 'تصفية حسب الدور',
        'filter_by_status' => 'تصفية حسب الحالة',
        'all_roles' => 'جميع الأدوار',
        'all_statuses' => 'جميع الحالات',
        'reset' => 'إعادة تعيين',
        'no_results' => 'لا يوجد مستخدمون مطابقون',
        'no_results_hint' => 'حاول تعديل البحث أو إزالة التصفية.',
        'stats' => [
            'total' => 'إجمالي المستخدمين',
            'active' => 'نشط',
            'inactive' => 'غير نشط',
            'roles' => 'الأدوار',
        ],
        'edit' => [
            'title' => 'تعديل المستخدم',
        ],
        'create' => [
            'title' => 'إنشاء مستخدم',
            'img' => 'الصورة',
            'password' => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'isActive' => 'نشط',
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'role' => 'الدور',
            'phone' => 'الهاتف',
        ],
    ],
    'roles' => [
        'title' => 'الأدوار',
        'createBtn' => 'إنشاء',
        'id' => 'المعرف',
        'name' => 'الاسم',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
        'actions' => 'الإجراءات',
        'create' => [
            'title' => 'إنشاء دور',
            'subtitle' => 'اختر اسمًا وفعّل الصلاحيات المناسبة لهذا الدور.',
            'name' => 'الاسم',
            'namePlaceholder' => 'مثال: محرر، مدير المحتوى',
            'guard' => 'الحارس',
            'allCheckBoxes' => 'تحديد كل الصلاحيات',
            'searchPermissions' => 'ابحث في الصلاحيات…',
            'selected' => 'تم تحديدها',
            'permissions_count' => ':count صلاحية',
            'selectAllSection' => 'تحديد كل هذا القسم',
            'noPermissions' => 'لا توجد صلاحيات مطابقة للبحث.',
            'save' => 'إنشاء الدور',
            'cancel' => 'إلغاء',
        ],
        'edit' => [
            'title' => 'تعديل الدور',
        ],
    ],
    'audits' => [
        'index' => 'سجلات التدقيق',
        'getPayLoad' => 'الحصول على الحمولة',
        'filter' => 'تصفية',
        'admin' => 'المدير',
        'action' => 'الإجراء',
        'ip' => 'عنوان IP',
        'time' => 'الوقت',
        'changes' => 'التغييرات',
        'filterModal' => [
            'all' => 'الكل',
            'index' => 'تصفية',
            'adminId' => 'المدير',
            'date' => 'التاريخ',
            'routeName' => 'اسم المسار',
        ],
    ],
    'submit' => 'إرسال',
    'close' => 'إغلاق',
    'save' => 'حفظ التغييرات',
    'pleaseSelectOne' => 'يرجى اختيار واحد',
    'permissions' => [
        // Admin Management Permissions
        'admin-user_management-index' => 'عرض إدارة المستخدمين',
        'admin-user_management-store' => 'إنشاء مستخدم',
        'admin-user_management-update' => 'تحديث مستخدم',
        'admin-user_management-status' => 'حذف/تغيير حالة المستخدم',

        'admin-audits-index' => 'عرض سجل التدقيق',
        'admin-audits-getPayload' => 'عرض تفاصيل سجل التدقيق',

        'admin-role_management-index' => 'عرض إدارة الأدوار',
        'admin-role_management-create' => 'إنشاء دور',
        'admin-role_management-store' => 'حفظ دور',
        'admin-role_management-edit' => 'تعديل دور',
        'admin-role_management-update' => 'تحديث دور',
        'admin-role_management-destroy' => 'حذف دور',

        // Blog Permissions
        'admin-categories-index' => 'عرض الفئات',
        'admin-categories-create' => 'إنشاء فئة',
        'admin-categories-store' => 'حفظ فئة',
        'admin-categories-show' => 'عرض تفاصيل الفئة',
        'admin-categories-edit' => 'تعديل فئة',
        'admin-categories-update' => 'تحديث فئة',
        'admin-categories-destroy' => 'حذف فئة',

        'admin-posts-index' => 'عرض المقالات',
        'admin-posts-create' => 'إنشاء مقال',
        'admin-posts-store' => 'حفظ مقال',
        'admin-posts-show' => 'عرض تفاصيل المقال',
        'admin-posts-edit' => 'تعديل مقال',
        'admin-posts-update' => 'تحديث مقال',
        'admin-posts-destroy' => 'حذف مقال',

        'admin-quillUpload-store' => 'رفع الصور للمحرر',

        'admin-tags-index' => 'عرض العلامات',
        'admin-tags-create' => 'إنشاء علامة',
        'admin-tags-store' => 'حفظ علامة',
        'admin-tags-show' => 'عرض تفاصيل العلامة',
        'admin-tags-edit' => 'تعديل علامة',
        'admin-tags-update' => 'تحديث علامة',
        'admin-tags-destroy' => 'حذف علامة',
        'admin-tags-storeAjax' => 'إنشاء علامة عبر AJAX',
        'admin-tags-options' => 'الحصول على خيارات العلامات',

        // CMS Permissions
        'cms-home-edit' => 'تعديل الصفحة الرئيسية',
        'cms-home-update' => 'تحديث الصفحة الرئيسية',

        'cms-index' => 'عرض صفحات CMS',
        'cms-create' => 'إنشاء صفحة CMS',
        'cms-store' => 'حفظ صفحة CMS',
        'cms-show' => 'عرض تفاصيل صفحة CMS',
        'cms-edit' => 'تعديل صفحة CMS',
        'cms-update' => 'تحديث صفحة CMS',
        'cms-destroy' => 'حذف صفحة CMS',

        'menus-index' => 'عرض القوائم',
        'menus-create' => 'إنشاء قائمة',
        'menus-store' => 'حفظ قائمة',
        'menus-show' => 'عرض تفاصيل القائمة',
        'menus-edit' => 'تعديل قائمة',
        'menus-update' => 'تحديث قائمة',
        'menus-destroy' => 'حذف قائمة',

        // Doctor Permissions
        'admin-dashboard' => 'عرض لوحة التحكم',

        'admin-clinic-index' => 'عرض العيادة',
        'admin-clinic-store' => 'حفظ معلومات العيادة',
        'admin-clinic-update' => 'تحديث معلومات العيادة',

        'admin-patients-index' => 'عرض المرضى',
        'admin-patients-store' => 'إنشاء مريض',
        'admin-patients-update' => 'تحديث مريض',
        'admin-patients-show' => 'عرض تفاصيل المريض',
        'admin-patients-downloadVCard' => 'تحميل بطاقة المريض',

        'admin-medicalTest-index' => 'عرض الفحوصات الطبية',
        'admin-medicalTest-store' => 'إنشاء فحص طبي',
        'admin-medicalTest-update' => 'تحديث فحص طبي',

        'admin-medicine-index' => 'عرض الأدوية',
        'admin-medicine-store' => 'إنشاء دواء',
        'admin-medicine-update' => 'تحديث دواء',


        'admin-vitalSign-index' => 'عرض العلامات الحيوية',
        'admin-vitalSign-store' => 'إنشاء علامة حيوية',
        'admin-vitalSign-update' => 'تحديث علامة حيوية',

        'admin-finalDiagnosis-index' => 'عرض التشخيصات النهائية',
        'admin-finalDiagnosis-store' => 'إنشاء تشخيص نهائي',
        'admin-finalDiagnosis-update' => 'تحديث تشخيص نهائي',

        'admin-dosageForm-index' => 'عرض أشكال الجرعات',
        'admin-dosageForm-store' => 'إنشاء شكل جرعة',
        'admin-dosageForm-update' => 'تحديث شكل جرعة',

        'admin-medicalExamination-create' => 'إنشاء فحص طبي',
        'admin-medicalExamination-store' => 'حفظ فحص طبي',
        'admin-medicalExamination-submit' => 'إرسال فحص طبي',
        'admin-medicalExamination-show' => 'عرض فحص طبي',
        'admin-medicalExamination-index' => 'عرض الفحوصات الطبية',

        'admin-uploadFile-index' => 'رفع الملفات',
        'admin-uploadFile-delete' => 'حذف الملفات',

        'admin-pdf-downloadMedicines' => 'تحميل PDF الأدوية',
        'admin-pdf-downloadMedicalTest' => 'تحميل PDF الفحص الطبي',
        'admin-pdf-downloadMedicinesPharmacy' => 'تحميل PDF أدوية الصيدلية',

        // أذونات البورتفوليو
        'admin-portfolios-index' => 'عرض أعمال المعرض',
        'admin-portfolios-create' => 'إنشاء عمل جديد',
        'admin-portfolios-store' => 'حفظ عمل جديد',
        'admin-portfolios-show' => 'عرض تفاصيل العمل',
        'admin-portfolios-edit' => 'تعديل العمل',
        'admin-portfolios-update' => 'تحديث العمل',
        'admin-portfolios-destroy' => 'حذف العمل',
        'admin-portfolios-toggle-status' => 'تبديل حالة العمل',
        'admin-portfolios-toggle-featured' => 'تبديل عمل مميز',
        'admin-portfolios-duplicate' => 'تكرار العمل',
        'admin-portfolios-reorder' => 'إعادة ترتيب الأعمال',
        'admin-portfolios-delete-gallery' => 'حذف صورة من المعرض',

        // إدارة اللوحات
        'admin-panels-sort' => 'ترتيب اللوحات',
        'admin-panel-items-sort' => 'ترتيب عناصر اللوحة',

        // لوحات CMS
        'cms-panels-forPage' => 'عرض لوحات الصفحة',
        'cms-panels-store' => 'إنشاء لوحة',
        'cms-panels-show' => 'عرض تفاصيل اللوحة',
        'cms-panels-update' => 'تحديث اللوحة',
        'cms-panels-destroy' => 'حذف اللوحة',
        'cms-panels-toggle' => 'تبديل ظهور اللوحة',
        'cms-panels-duplicate' => 'تكرار اللوحة',
        'cms-panels-reorder' => 'إعادة ترتيب اللوحات',

        // عناصر اللوحات
        'cms-panel-items-store' => 'إنشاء عنصر لوحة',
        'cms-panel-items-show' => 'عرض تفاصيل العنصر',
        'cms-panel-items-update' => 'تحديث عنصر اللوحة',
        'cms-panel-items-destroy' => 'حذف عنصر اللوحة',

        // إعدادات الإشعارات
        'admin-notification-configs' => 'عرض إعدادات الإشعارات',
        'admin-notification-update' => 'تحديث إعدادات الإشعارات',

        // SEO
        'admin-seo-index' => 'عرض إعدادات SEO',
        'admin-seo-update' => 'تحديث إعدادات SEO',

        // إعدادات المظهر
        'admin-theme_settings-index' => 'عرض إعدادات المظهر',
        'admin-theme_settings-update' => 'تحديث إعدادات المظهر',
    ],
    'sections' => [
        'admin' => 'إدارة النظام',
        'audits' => 'التدقيق',
        'role_management' => 'إدارة الأدوار',
        'user_management' => 'إدارة المستخدمين',
        'categories' => 'الفئات',
        'posts' => 'المقالات',
        'tags' => 'العلامات',
        'cms' => 'نظام إدارة المحتوى',
        'menus' => 'القوائم',
        'dashboard' => 'لوحة التحكم',
        'portfolios' => 'أعمال المعرض',
        'panels' => 'اللوحات',
        'panel-items' => 'عناصر اللوحة',
        'notification' => 'الإشعارات',
        'seo' => 'تحسين محركات البحث',
        'theme_settings' => 'إعدادات المظهر',
        'quillUpload' => 'رفع المحرر',
        'etc' => 'أخرى',
        'clinic' => 'العيادة',
        'patients' => 'المرضى',
        'medicalTest' => 'الفحوصات الطبية',
        'medicine' => 'الأدوية',
        'vitalSign' => 'العلامات الحيوية',
        'finalDiagnosis' => 'التشخيصات النهائية',
        'dosageForm' => 'أشكال الجرعات',
        'medicalExamination' => 'الفحوصات الطبية',
        'uploadFile' => 'رفع الملفات',
        'pdf' => 'تقارير PDF',
    ],
];
