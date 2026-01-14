<?php

namespace Modules\MCP\Database\Seeders;

use Illuminate\Database\Seeder;

class MCPDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            BusinessKnowledgeSeeder::class,
        ]);
    }
}
