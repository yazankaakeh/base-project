<?php

namespace Modules\Seo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Seo\Enums\SeoSettingsEnum;
use Modules\Seo\Models\SeoSettings;

/**
 * Seeds Codliy-branded defaults for the global SEO settings row set.
 *
 * Each SeoSettings record is a (key, value) pair. The admin can edit values
 * from the SEO Settings UI; this seeder ships with sensible defaults so the
 * very first page load already has a site_name, robots directives, and
 * brand social links pointing at Codliy.
 */
class SeoSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Defaults keyed by the enum value so adding a new setting is just
        // appending a row — unknown keys still get created with null.
        $defaults = [
            SeoSettingsEnum::SITE_NAME->value     => config('variables.templateName', 'Codliy'),
            SeoSettingsEnum::SITE_LOGO->value     => '/assets/brand/Ligh Logo.png',
            SeoSettingsEnum::TYPE->value          => 'website',
            SeoSettingsEnum::TWITTER_CARD->value  => 'summary_large_image',
            SeoSettingsEnum::TWITTER_SITE->value  => '@codliy',
            SeoSettingsEnum::TWITTER_IMAGE->value => '/assets/brand/Ligh Logo.png',
            SeoSettingsEnum::robots_index->value  => 'index',
            SeoSettingsEnum::robots_follow->value => 'follow',
            SeoSettingsEnum::FACEBOOK->value      => 'https://www.facebook.com/codliy',
            SeoSettingsEnum::TWITTER->value       => 'https://twitter.com/codliy',
            SeoSettingsEnum::LINKEDIN->value      => 'https://www.linkedin.com/company/codliy',
            SeoSettingsEnum::INSTAGRAM->value     => 'https://www.instagram.com/codliy',
            SeoSettingsEnum::YOUTUBE->value       => null,
            SeoSettingsEnum::PINTEREST->value     => null,
            SeoSettingsEnum::GITHUB->value        => 'https://github.com/codliy',
            SeoSettingsEnum::BEHANCE->value       => null,
            SeoSettingsEnum::DRIBBBLE->value      => null,
            SeoSettingsEnum::TUMBLR->value        => null,
            SeoSettingsEnum::TIKTOK->value        => null,
            SeoSettingsEnum::DEVTO->value         => null,
            SeoSettingsEnum::MEDIUM->value        => null,
        ];

        foreach (SeoSettingsEnum::cases() as $setting) {
            SeoSettings::query()->updateOrCreate(
                ['key' => $setting->value],
                ['value' => $defaults[$setting->value] ?? null],
            );
        }
    }
}
