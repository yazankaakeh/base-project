<?php

namespace Modules\UserManagement\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\UserManagement\app\Enums\Roles;
use Modules\UserManagement\app\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => Roles::SUPER_ADMIN->value,
            'guard_name' => 'admin',
        ]);
        /** @var Admin $adminYazan */
        $adminYazan = Admin::query()->create([
            'name' => 'Yazan Kaakeh',
            'email' => 'yazanka187@gmail.com',
            'is_active' => 1,
            'phone' => '05522998130',
            'img' => '/img/admin.jpg',
            'password' => Hash::make('D1207forever#'),
        ]);
        $adminYazan->assignRole(Roles::SUPER_ADMIN->value);
    }
}
