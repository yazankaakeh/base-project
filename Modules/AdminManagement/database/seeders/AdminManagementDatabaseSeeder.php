<?php

namespace Modules\AdminManagement\database\seeders;

use Illuminate\Database\Seeder;

class AdminManagementDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
