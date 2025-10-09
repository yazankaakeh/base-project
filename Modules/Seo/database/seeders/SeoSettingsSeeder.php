<?php

namespace Modules\Seo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Seo\Enums\SeoSettingsEnum;
use Modules\Seo\Models\SeoSettings;

class SeoSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seoSettings = SeoSettingsEnum::cases();
        foreach ($seoSettings as $seoSetting) {
            SeoSettings::query()->create([
                'key' => $seoSetting->value,
            ]);
        }
    }
}
