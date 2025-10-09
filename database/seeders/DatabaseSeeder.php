<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AdminManagement\database\seeders\AdminManagementDatabaseSeeder;
use Modules\Core\database\seeders\CoreDatabaseSeeder;
use Modules\Doctor\Database\Seeders\DoctorDatabaseSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminManagementDatabaseSeeder::class,
            CoreDatabaseSeeder::class,
            DoctorDatabaseSeeder::class,
        ]);
    }
}
