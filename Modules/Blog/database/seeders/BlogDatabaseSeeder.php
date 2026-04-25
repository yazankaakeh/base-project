<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;

class BlogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed categories, tags, and example posts in one pass. Keep this
        // list authoritative — the root DatabaseSeeder only calls THIS
        // class, so anything not listed here won't run under
        // `php artisan migrate:fresh --seed`.
        $this->call([
            BlogPostSeeder::class,
        ]);
    }
}
