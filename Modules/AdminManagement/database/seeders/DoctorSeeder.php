<?php

namespace Modules\AdminManagement\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\AdminManagement\Enums\Roles;
use Modules\Core\App\Enums\Gender;
use Modules\Doctor\Enums\MedicalSpecialtyCodeEnum;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Models\MedicalSpecialty;
use Spatie\Permission\Models\Role;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => Roles::SUPER_ADMIN->value,
            'guard_name' => 'doctor',
        ]);
        $names = [
            'en' => 'Internal Medicine And Endocrinology',
            'ar' => 'الطب الباطني والغدد الصماء',
        ];
        /** @var MedicalSpecialty $medical */
        $medical = MedicalSpecialty::query()->create([
            'name' => $names,
            'code' => MedicalSpecialtyCodeEnum::INTERNAL_MEDICINE_AND_ENDOCRINOLOGY,

        ]);
        /** @var Doctor $adminYazan */
        $adminYazan = Doctor::query()->create([
            'name' => 'Yazan Kaakeh',
            'email' => 'yazanka187@gmail.com',
            'gender' => Gender::MALE->value,
            'medical_specialty_id' => $medical->id,
            'age' => 30,
            'is_active' => 1,
            'phone' => '05522998130',
            'password' => Hash::make('D1207forever#'),
        ]);
        $adminDoctor = Doctor::query()->create([
            'name' => 'Bassam Jawish',
            'email' => 'dr.bassam@gmail.com',
            'gender' => Gender::MALE->value,
            'medical_specialty_id' => $medical->id,
            'age' => 30,
            'is_active' => 1,
            'phone' => '05386002771',
            'password' => Hash::make('D1207forever#'),
        ]);
        $adminYazan->assignRole(Roles::SUPER_ADMIN->value);
        $adminDoctor->assignRole(Roles::SUPER_ADMIN->value);
    }
}
