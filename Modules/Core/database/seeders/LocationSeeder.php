<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basePath = module_path('Core', 'Database/sql');

        $this->importSql($basePath.'/city.sql');
        $this->importSql($basePath.'/town.sql');
        $this->importSql($basePath.'/district.sql');
        $this->importSql($basePath.'/neighborhood.sql');
    }

    /**
     * @throws FileNotFoundException
     */
    protected function importSql(string $filePath): void
    {
        if (File::exists($filePath)) {
            DB::unprepared(File::get($filePath));
            $this->command->info("Imported: ".basename($filePath));
        } else {
            $this->command->error("File not found: ".$filePath);
        }
    }
}
