<?php

namespace Modules\Doctor\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Doctor\Models\Clinic;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $finalDiagnosis = [
            [
                'en' => 'Dr.Bassam Clinic',
                'ar' => 'عيادة الدكتور بسام',
            ],
        ];

        foreach ($finalDiagnosis as $finalDiagnose) {
            Clinic::query()->create([
                'name' => $finalDiagnose,
                'is_active' => ActiveEnum::ACTIVE->value,
            ]);
        }
    }
}
