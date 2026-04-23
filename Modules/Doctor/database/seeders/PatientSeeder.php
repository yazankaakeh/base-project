<?php

namespace Modules\Doctor\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Doctor\Models\Clinic;
use Modules\Doctor\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Clinic::factory()->count(5)->create();
        Patient::factory(50)->create()->each(function ($patient) {
            $patient->clinics()->attach(
                Clinic::query()->inRandomOrder()->take(rand(1, 3))->pluck('id'),
            );
        });
    }
}
