<?php

namespace Modules\Doctor\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Doctor\Enums\MedicalTestTypeEnum;
use Modules\Doctor\Models\MedicalTest;

class MedicalTestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicalTests = [
            // 🧪 Laboratory Tests
            [
                'slug' => 'hb',
                'name' => 'Hemoglobin (Hb)',
                'normal_range' => '12 - 18',
                'unit' => 'g/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'wbc',
                'name' => 'White Blood Cells (WBC)',
                'normal_range' => '4,000 - 11,000',
                'unit' => 'cells/µL',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'platelets',
                'name' => 'Platelet Count',
                'normal_range' => '150,000 - 400,000',
                'unit' => '/µL',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'glucose_fasting',
                'name' => 'Fasting Blood Glucose',
                'normal_range' => '70 - 100',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'glucose_postprandial',
                'name' => 'Postprandial Blood Glucose',
                'normal_range' => '< 140',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'hba1c',
                'name' => 'HbA1c',
                'normal_range' => '< 5.7',
                'unit' => '%',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'tsh',
                'name' => 'TSH (Thyroid Stimulating Hormone)',
                'normal_range' => '0.4 - 4.0',
                'unit' => 'mIU/L',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 't4_free',
                'name' => 'Free T4',
                'normal_range' => '0.8 - 1.8',
                'unit' => 'ng/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 't3_free',
                'name' => 'Free T3',
                'normal_range' => '2.3 - 4.2',
                'unit' => 'pg/ml',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'cholesterol_total',
                'name' => 'Total Cholesterol',
                'normal_range' => '< 200',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'hdl',
                'name' => 'HDL Cholesterol',
                'normal_range' => '> 40 (men), > 50 (women)',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'ldl',
                'name' => 'LDL Cholesterol',
                'normal_range' => '< 100',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'triglycerides',
                'name' => 'Triglycerides',
                'normal_range' => '< 150',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'alt',
                'name' => 'ALT (Alanine Aminotransferase)',
                'normal_range' => '7 - 55',
                'unit' => 'U/L',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'ast',
                'name' => 'AST (Aspartate Aminotransferase)',
                'normal_range' => '8 - 48',
                'unit' => 'U/L',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'alk_phos',
                'name' => 'Alkaline Phosphatase (ALP)',
                'normal_range' => '40 - 129',
                'unit' => 'U/L',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'bilirubin',
                'name' => 'Total Bilirubin',
                'normal_range' => '0.1 - 1.2',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'albumin',
                'name' => 'Serum Albumin',
                'normal_range' => '3.5 - 5.5',
                'unit' => 'g/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'creatinine',
                'name' => 'Serum Creatinine',
                'normal_range' => '0.6 - 1.3',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'urea',
                'name' => 'Blood Urea Nitrogen (BUN)',
                'normal_range' => '7 - 20',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'psa',
                'name' => 'Prostate Specific Antigen (PSA)',
                'normal_range' => '< 4.0',
                'unit' => 'ng/ml',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'vitamin_d',
                'name' => 'Vitamin D (25-OH)',
                'normal_range' => '20 - 50',
                'unit' => 'ng/ml',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'calcium',
                'name' => 'Serum Calcium',
                'normal_range' => '8.5 - 10.5',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],
            [
                'slug' => 'phosphorus',
                'name' => 'Serum Phosphorus',
                'normal_range' => '2.5 - 4.5',
                'unit' => 'mg/dl',
                'type' => MedicalTestTypeEnum::LABORATORY_TESTS->value,
            ],

            // 🩻 Radiology Tests
            [
                'slug' => 'chest_xray',
                'name' => 'Chest X-Ray',
                'normal_range' => null,
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
            [
                'slug' => 'abdominal_ultrasound',
                'name' => 'Abdominal Ultrasound',
                'normal_range' => null,
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
            [
                'slug' => 'thyroid_ultrasound',
                'name' => 'Thyroid Ultrasound',
                'normal_range' => null,
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
            [
                'slug' => 'ct_brain',
                'name' => 'CT Brain',
                'normal_range' => null,
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
            [
                'slug' => 'ct_abdomen',
                'name' => 'CT Abdomen',
                'normal_range' => null,
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
            [
                'slug' => 'mri_brain',
                'name' => 'MRI Brain',
                'normal_range' => null,
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
            [
                'slug' => 'mri_abdomen',
                'name' => 'MRI Abdomen',
                'normal_range' => null,
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
            [
                'slug' => 'bone_density',
                'name' => 'Bone Density Scan (DEXA)',
                'normal_range' => 'T-score > -1 (normal)',
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
            [
                'slug' => 'echocardiography',
                'name' => 'Echocardiography (Echo)',
                'normal_range' => null,
                'unit' => null,
                'type' => MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
            ],
        ];
        foreach ($medicalTests as $medicalTest) {
            MedicalTest::query()->create([
                'name' => $medicalTest['name'],
                'unit' => "{$medicalTest['unit']} - {$medicalTest['normal_range']}",
                'type' => $medicalTest['type'],
            ]);
        }
    }
}
