<?php

namespace Modules\Doctor\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Doctor\Models\FinalDiagnosis;

class FinalDiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $finalDiagnosis = [
            [
                'en' => 'Hypertension',
                'ar' => 'ارتفاع ضغط الدم',
            ],
            [
                'en' => 'Diabetes Mellitus Type 2',
                'ar' => 'داء السكري النوع الثاني',
            ],
            [
                'en' => 'Diabetes Mellitus Type 1',
                'ar' => 'داء السكري النوع الأول',
            ],
            [
                'en' => 'Hyperlipidemia',
                'ar' => 'ارتفاع الدهون في الدم',
            ],
            [
                'en' => 'Anemia',
                'ar' => 'فقر الدم',
            ],
            [
                'en' => 'Peptic Ulcer Disease',
                'ar' => 'قرحة المعدة',
            ],
            [
                'en' => 'Gastroesophageal Reflux Disease (GERD)',
                'ar' => 'ارتجاع المريء',
            ],
            [
                'en' => 'Irritable Bowel Syndrome (IBS)',
                'ar' => 'متلازمة القولون العصبي',
            ],
            [
                'en' => 'Chronic Kidney Disease',
                'ar' => 'المرض الكلوي المزمن',
            ],
            [
                'en' => 'Liver Cirrhosis',
                'ar' => 'تشمع الكبد',
            ],
            [
                'en' => 'Pneumonia',
                'ar' => 'التهاب الرئة',
            ],
            [
                'en' => 'Chronic Obstructive Pulmonary Disease (COPD)',
                'ar' => 'مرض الانسداد الرئوي المزمن',
            ],
            [
                'en' => 'Asthma',
                'ar' => 'الربو',
            ],
            [
                'en' => 'Heart Failure',
                'ar' => 'قصور القلب',
            ],
            [
                'en' => 'Coronary Artery Disease',
                'ar' => 'مرض الشريان التاجي',
            ],
            [
                'en' => 'Hypothyroidism',
                'ar' => 'قصور الغدة الدرقية',
            ],
            [
                'en' => 'Hyperthyroidism',
                'ar' => 'فرط نشاط الغدة الدرقية',
            ],
            [
                'en' => 'Graves’ Disease',
                'ar' => 'مرض غريفز',
            ],
            [
                'en' => 'Hashimoto’s Thyroiditis',
                'ar' => 'التهاب الغدة الدرقية هاشيموتو',
            ],
            [
                'en' => 'Cushing’s Syndrome',
                'ar' => 'متلازمة كوشينغ',
            ],
            [
                'en' => 'Addison’s Disease',
                'ar' => 'مرض أديسون',
            ],
            [
                'en' => 'Polycystic Ovary Syndrome (PCOS)',
                'ar' => 'متلازمة تكيس المبايض',
            ],
            [
                'en' => 'Pituitary Adenoma',
                'ar' => 'ورم الغدة النخامية',
            ],
            [
                'en' => 'Hyperparathyroidism',
                'ar' => 'فرط نشاط الغدة الجار درقية',
            ],
            [
                'en' => 'Hypoparathyroidism',
                'ar' => 'قصور الغدة الجار درقية',
            ],
            [
                'en' => 'Osteoporosis',
                'ar' => 'هشاشة العظام',
            ],
            [
                'en' => 'Vitamin D Deficiency',
                'ar' => 'نقص فيتامين د',
            ],
        ];

        foreach ($finalDiagnosis as $finalDiagnose) {
            FinalDiagnosis::query()->create([
                'name' => $finalDiagnose,
                'is_active' => ActiveEnum::ACTIVE->value,
            ]);
        }
    }
}
