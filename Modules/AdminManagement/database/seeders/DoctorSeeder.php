<?php

namespace Modules\AdminManagement\database\seeders;

use Illuminate\Database\Seeder;

/**
 * Legacy seeder retained as a no-op. The Doctor module has been removed
 * from Codliy; admin users are now seeded by AdminUserSeeder and roles
 * by RolePermissionSeeder.
 */
class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // Intentionally empty.
    }
}
