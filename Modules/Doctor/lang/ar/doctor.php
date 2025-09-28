<?php

use Modules\Core\App\Enum\Gender;
use Modules\Doctor\Enums\BloodType;
use Modules\Doctor\Enums\MaritalStatus;
use Modules\Doctor\Enums\MedicalExaminationStatusEnum;
use Modules\Doctor\Enums\MedicalTestTypeEnum;

return [
    'enum' => [
        'Gender' => [
            Gender::MALE->value => 'ذكر',
            Gender::FEMALE->value => 'أنثى',
        ],
        'MedicalExaminationStatusEnum' => [
            MedicalExaminationStatusEnum::ACTIVE->value => 'نشط',
            MedicalExaminationStatusEnum::DONE->value => 'منجز',
        ],
        'MedicalTestTypeEnum' => [
            MedicalTestTypeEnum::LABORATORY_TESTS->value => 'تحاليل مختبرية',
            MedicalTestTypeEnum::RADIOLOGY_TESTS->value => 'فحوصات أشعة',
        ],
        'MaritalStatus' => [
            MaritalStatus::SINGLE->value => 'أعزب',
            MaritalStatus::MARRIED->value => 'متزوج',
            MaritalStatus::DIVORCED->value => 'مطلق',
        ],
        'BloodType' => [
            BloodType::A_POSITIVE->value => 'A موجب',
            BloodType::A_NEGATIVE->value => 'A سالب',
            BloodType::B_POSITIVE->value => 'B موجب',
            BloodType::B_NEGATIVE->value => 'B سالب',
            BloodType::AB_POSITIVE->value => 'AB موجب',
            BloodType::AB_NEGATIVE->value => 'AB سالب',
            BloodType::O_POSITIVE->value => 'O موجب',
            BloodType::O_NEGATIVE->value => 'O سالب',
        ],

    ],
    'doctor' => [
        'medicalSpecialtyId' => 'التخصص الطبي',
    ],
    'patients' => [
        'nameTitle' => 'المرضى',
        'name' => 'الاسم',
        'phone' => 'الهاتف',
        'age' => 'العمر',
        'minAge' => 'العمر الأدنى',
        'maxAge' => 'العمر الأقصى',
        'gender' => 'الجنس',
        'clinics' => 'العيادات',
        'children' => 'الأطفال',
        'work' => 'العمل',
        'blood_type' => 'فصيلة الدم',
        'marital_status' => 'الحالة الاجتماعية',
        'nationality_id' => 'الجنسية',
        'drug_allergies' => 'حساسية الأدوية',
        'disabilities' => 'الإعاقات',
        'medical_history' => 'التاريخ الطبي',
        'surgical_history' => 'التاريخ الجراحي',
        'accident_history' => 'تاريخ الحوادث',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'active' => 'الحالة',
        'createPatients' => 'إضافة مريض',
        'updatePatients' => 'تعديل بيانات مريض',
        'filterPatients' => 'تصفية المرضى',
        'createMedicalExamination' => 'الفحص الطبي',
        'downloadVCard' => 'تحميل VCard',
    ],
    'clinic' => [
        'name' => 'اسم العيادة',
        'img' => 'الصورة',
        'createClinic' => 'إضافة عيادة',
        'updateClinic' => 'تعديل عيادة',
    ],
    'medicalTest' => [
        'name' => 'اسم الفحص الطبي',
        'unit' => 'وحدة الفحص الطبي',
        'createMedicalTest' => 'إضافة فحص طبي',
        'updateMedicalTest' => 'تعديل فحص طبي',
    ],
    'medicine' => [
        'name' => 'اسم الدواء',
        'createMedicine' => 'إضافة دواء',
        'updateMedicine' => 'تعديل دواء',
    ],
    'vitalSign' => [
        'name' => 'اسم العلامة الحيوية',
        'createVitalSign' => 'إضافة علامة حيوية',
        'updateVitalSign' => 'تعديل علامة حيوية',
    ],
    'finalDiagnosis' => [
        'name' => 'اسم التشخيص النهائي',
        'createFinalDiagnosis' => 'إضافة تشخيص نهائي',
        'updateFinalDiagnosis' => 'تعديل تشخيص نهائي',
    ],
    'medicalSpecialty' => [
        'name' => 'اسم التخصص الطبي',
        'name en' => 'اسم التخصص الطبي بالإنجليزية',
        'name ar' => 'اسم التخصص الطبي بالعربية',
        'code' => 'رمز التخصص الطبي',
        'createMedicalSpecialty' => 'إضافة تخصص طبي',
        'updateMedicalSpecialty' => 'تعديل تخصص طبي',
    ],
    'medicalExaminations' => [
        'patientInfo' => 'معلومات المريض',
        'patientDetails' => 'تفاصيل المريض',
        'medicalPreviewInfo' => 'معلومات المعاينة الطبية',
        'finalDiagnosisInfo' => 'معلومات التشخيص النهائي',
        'vitalSignsInfo' => 'معلومات العلامات الحيوية',

        'printMedicalTests' => 'طباعة الفحوصات الطبية',
        'printMedicines' => 'طباعة الأدوية',
        'printMedicinesPharmacy' => 'طباعة أدوية الصيدلية',

        'clinical_examination' => 'الفحص السريري',
        'impression' => 'الانطباع',
        'reasonOfVisiting' => 'سبب الزيارة',
        'createdAt' => 'تاريخ الإنشاء',
        'request_for_action' => 'طلب إجراء',
        'laboratoryTests' => 'تحاليل مختبرية',
        'radiologyTests' => 'فحوصات أشعة',
        'medicines' => 'معلومات الأدوية',

        'drugName' => 'اسم الدواء',
        'repetition' => 'التكرار',
        'howToDrink' => 'طريقة الاستخدام',
        'number' => 'العدد',
        'note' => 'ملاحظة',

        'value' => 'القيمة :name',
        'file' => 'الملف :name',
        'uploadFile' => 'رفع الملفات',
        'card' => [
            'medicalPreview' => 'المعاينة الطبية',
            'createMedicalPreview' => 'إنشاء معاينة طبية',
            'finalDiagnosis' => 'التشخيص النهائي',
            'vitalSigns' => 'العلامات الحيوية',
            'medicines' => 'الأدوية',
            'medicalTest' => 'الفحص الطبي',

            'medicalTestResult' => 'نتيجة الفحص الطبي',
            'medicalTestType' => 'نوع الفحص الطبي',
        ],
    ],
    'modalUploadFile' => [
        'title' => 'رفع الملفات',
        'files' => 'الملفات',
    ],
    'parts' => [
        'files' => [
            'title' => 'الملفات',
            'sADesc' => 'سيتم حذف هذا الملف نهائيًا!',
        ],
    ],
    'filter' => 'تصفية',
    'close' => 'إغلاق',
    'cancel' => 'إلغاء',
    'yes' => 'نعم',
    'delete' => 'حذف',
    'submit' => 'إرسال',
    'save' => 'حفظ',
    'create' => 'إضافة',
    'edit' => 'تعديل',
    'show' => 'عرض',
    'deactivate' => 'تعطيل',
    'areYouSure' => 'هل أنت متأكد؟',
    'pleaseSelectOne' => 'الرجاء اختيار واحد',
    'id' => 'المعرف',
    'saveAll' => 'حفظ الكل',
];
