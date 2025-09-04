<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\database\seeders\CoreDatabaseSeeder;
use Modules\Mps\Database\Seeders\MpsDatabaseSeeder;
use Modules\UserManagement\database\seeders\UserManagementDatabaseSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserManagementDatabaseSeeder::class,
            MpsDatabaseSeeder::class,
            CoreDatabaseSeeder::class,
        ]);
    }
}
