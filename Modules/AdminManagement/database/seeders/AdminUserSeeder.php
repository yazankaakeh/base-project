<?php

namespace Modules\AdminManagement\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\AdminManagement\Enums\Roles;
use Modules\AdminManagement\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Role::query()->firstOrCreate(
            ['name' => Roles::SUPER_ADMIN->value, 'guard_name' => 'admin'],
        );

        $yazan = Admin::query()->updateOrCreate(
            ['email' => 'yazanka187@gmail.com'],
            [
                'name' => 'Yazan Kaakeh',
                'password' => Hash::make('D1207forever#'),
                'is_active' => 1,
            ],
        );

        $codliy = Admin::query()->updateOrCreate(
            ['email' => 'hello@codliy.com'],
            [
                'name' => 'Codliy Admin',
                'password' => Hash::make('Codliy@2025'),
                'is_active' => 1,
            ],
        );

        $yazan->assignRole(Roles::SUPER_ADMIN->value);
        $codliy->assignRole(Roles::SUPER_ADMIN->value);
    }
}
