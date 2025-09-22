<?php

namespace Modules\Doctor\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Doctor\Models\VitalSign;

class VitalSignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vitalSigns = [
            [
                'slug' => 'blood_pressure',
                'name' => ['en' => 'Blood Pressure', 'ar' => 'ضغط الدم'],
            ],
            [
                'slug' => 'heart_rate',
                'name' => ['en' => 'Heart Rate', 'ar' => 'ضربات القلب'],
            ],
            [
                'slug' => 'temperature',
                'name' => ['en' => 'Temperature', 'ar' => 'الحرارة'],
            ],
            [
                'slug' => 'weight',
                'name' => ['en' => 'Weight', 'ar' => 'الوزن'],
            ],
            [
                'slug' => 'height',
                'name' => ['en' => 'Height', 'ar' => 'الطول'],
            ],
            [
                'slug' => 'waist_circumference',
                'name' => ['en' => 'Waist Circumference', 'ar' => 'محيط الخصر'],
            ],
            [
                'slug' => 'bmi',
                'name' => ['en' => 'Body Mass Index (BMI)', 'ar' => 'مؤشر كتلة الجسم'],
            ],
            [
                'slug' => 'respiratory_rate',
                'name' => ['en' => 'Respiratory Rate', 'ar' => 'عدد حركات التنفس'],
            ],
            [
                'slug' => 'oxygen_saturation',
                'name' => ['en' => 'Oxygen Saturation (SpO₂)', 'ar' => 'الأكسجة'],
            ],
            [
                'slug' => 'peak_expiratory_flow',
                'name' => ['en' => 'Peak Expiratory Flow (PEF)', 'ar' => 'ذروة التدفق الزفيري'],
            ],
            [
                'slug' => 'pregnancy_lactation',
                'name' => ['en' => 'Pregnancy / Lactation', 'ar' => 'حمل / رضاعة'],
            ],
            [
                'slug' => 'blood_glucose',
                'name' => ['en' => 'Blood Glucose', 'ar' => 'قياس السكر'],
            ],
            [
                'slug' => 'note',
                'name' => ['en' => 'Note', 'ar' => 'ملاحظة'],
            ],
            [
                'slug' => 'image_full',
                'name' => ['en' => 'Full Image', 'ar' => 'صورة شاملة'],
            ],
            [
                'slug' => 'image_close',
                'name' => ['en' => 'Close-up Image', 'ar' => 'صورة قريبة'],
            ],
        ];

        foreach ($vitalSigns as $vitalSign) {
            VitalSign::query()->create(['name' => $vitalSign['name']]);
        }
    }
}
