<?php

namespace Modules\Core\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

class ThemeSetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * Static request-level cache to prevent multiple DB queries per request
     */
    private static array $requestCache = [];

    protected $fillable = [
        'scope',
        'primary_color',
        'secondary_color',
        'success_color',
        'info_color',
        'warning_color',
        'danger_color',
        'dark_primary_color',
        'dark_secondary_color',
        'dark_success_color',
        'dark_info_color',
        'dark_warning_color',
        'dark_danger_color',
        'font_family',
        'font_size_base',
        'headings_font_family',
        'headings_font_weight',
        'body_bg',
        'card_bg',
        'dark_body_bg',
        'dark_card_bg',
        'border_radius',
        'logo_path',
        'logo_dark_path',
        'favicon_path',
        'site_title',
        'custom_css_variables',
        'custom_css',
        'dark_custom_css',
        'ai_enabled',
        'ai_provider',
        'ai_model',
        'ai_system_prompt',
        'is_active',
    ];

    protected $casts = [
        'custom_css_variables' => 'array',
        'is_active' => 'boolean',
        'ai_enabled' => 'boolean',
    ];

    /**
     * Marker value to detect cached null (distinguishes from cache miss)
     */
    private const NULL_CACHE_MARKER = '__NULL_THEME_SETTING__';

    /**
     * Get theme settings for a specific scope
     * Uses request-level caching to avoid multiple DB queries per request
     */
    public static function getForScope(string $scope = 'admin'): ?self
    {
        // Check request-level cache first (avoids repeated cache/DB hits within same request)
        if (array_key_exists($scope, self::$requestCache)) {
            return self::$requestCache[$scope];
        }

        // Use Laravel cache for persistence across requests
        $cacheKey = "theme_settings_{$scope}";
        $cached = Cache::get($cacheKey);

        if ($cached === self::NULL_CACHE_MARKER) {
            // Null was intentionally cached
            $result = null;
        } elseif ($cached instanceof self) {
            // Valid cached model
            $result = $cached;
        } else {
            // Cache miss - query the database
            $result = self::where('scope', $scope)
                ->where('is_active', true)
                ->first();

            // Cache the result (use marker for null to distinguish from cache miss)
            Cache::put($cacheKey, $result ?? self::NULL_CACHE_MARKER, 3600);
        }

        // Store in request cache
        self::$requestCache[$scope] = $result;

        return $result;
    }

    /**
     * Boot method to clear cache on save
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($themeSetting) {
            self::clearCache($themeSetting->scope);
        });

        static::deleted(function ($themeSetting) {
            self::clearCache($themeSetting->scope);
        });
    }

    /**
     * Clear theme settings cache (both Laravel cache and request cache)
     */
    public static function clearCache(?string $scope = null): void
    {
        // Clear request cache
        if ($scope) {
            unset(self::$requestCache[$scope]);
            Cache::forget("theme_settings_{$scope}");
        } else {
            self::$requestCache = [];
            Cache::forget('theme_settings_admin');
            Cache::forget('theme_settings_website');
        }
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType, [
                    'image/jpeg',
                    'image/png',
                    'image/svg+xml',
                    'image/webp',
                ], true);
            })->singleFile();

        $this
            ->addMediaCollection('logo_dark')
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType, [
                    'image/jpeg',
                    'image/png',
                    'image/svg+xml',
                    'image/webp',
                ], true);
            })->singleFile();

        $this
            ->addMediaCollection('favicon')
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType, [
                    'image/x-icon',
                    'image/vnd.microsoft.icon',
                    'image/png',
                ], true);
            })->singleFile();
    }

    /**
     * Get full custom CSS including variables
     */
    public function getFullCustomCss(): string
    {
        $css = $this->getCssVariables();

        if ($this->custom_css) {
            $css .= PHP_EOL.PHP_EOL.'/* Light Mode Custom CSS */'.PHP_EOL.$this->custom_css;
        }

        if ($this->dark_custom_css) {
            $css .= PHP_EOL.PHP_EOL.'/* Dark Mode Custom CSS */'.PHP_EOL.$this->dark_custom_css;
        }

        return $css;
    }

    /**
     * Convert hex color to RGB values
     */
    private function hexToRgb(string $hex): string
    {
        [$r, $g, $b] = $this->hexToRgbTriplet($hex);

        return "{$r}, {$g}, {$b}";
    }

    /**
     * Parse a hex color into a numeric [r, g, b] triplet.
     * Used internally for math (mixing, tinting).
     */
    private function hexToRgbTriplet(string $hex): array
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }

    /**
     * Mix a hex color with pure white.
     *
     * $whitePct 0.0 = original color, 1.0 = pure white. Used to derive a
     * soft, brand-tinted surface from the admin's primary color so light
     * mode sections still feel "Codliy" rather than neutral gray.
     */
    private function mixWithWhite(string $hex, float $whitePct): string
    {
        $whitePct = max(0.0, min(1.0, $whitePct));
        [$r, $g, $b] = $this->hexToRgbTriplet($hex);

        $r = (int) round($r * (1 - $whitePct) + 255 * $whitePct);
        $g = (int) round($g * (1 - $whitePct) + 255 * $whitePct);
        $b = (int) round($b * (1 - $whitePct) + 255 * $whitePct);

        return sprintf('#%02X%02X%02X', $r, $g, $b);
    }

    /**
     * Get CSS variables as a string for both light and dark modes
     */
    public function getCssVariables(): string
    {
        // Light mode variables with both hex and RGB values
        $lightVariables = [
            // Primary colors (hex and RGB)
            '--bs-primary' => $this->primary_color,
            '--bs-primary-rgb' => $this->hexToRgb($this->primary_color),
            '--bs-secondary' => $this->secondary_color,
            '--bs-secondary-rgb' => $this->hexToRgb($this->secondary_color),
            '--bs-success' => $this->success_color,
            '--bs-success-rgb' => $this->hexToRgb($this->success_color),
            '--bs-info' => $this->info_color,
            '--bs-info-rgb' => $this->hexToRgb($this->info_color),
            '--bs-warning' => $this->warning_color,
            '--bs-warning-rgb' => $this->hexToRgb($this->warning_color),
            '--bs-danger' => $this->danger_color,
            '--bs-danger-rgb' => $this->hexToRgb($this->danger_color),

            // Background and layout colors
            '--bs-body-bg' => $this->body_bg,
            '--bs-body-bg-rgb' => $this->hexToRgb($this->body_bg),
            '--bs-card-bg' => $this->card_bg,
            '--bs-card-bg-rgb' => $this->hexToRgb($this->card_bg),
            '--bs-border-radius' => $this->border_radius,

            // Typography
            '--bs-body-font-family' => $this->font_family,
            '--bs-body-font-size' => $this->font_size_base,
        ];

        if ($this->headings_font_family) {
            $lightVariables['--bs-heading-font-family'] = $this->headings_font_family;
        }

        if ($this->headings_font_weight) {
            $lightVariables['--bs-heading-font-weight'] = $this->headings_font_weight;
        }

        // --- Codliy brand tokens ------------------------------------------
        // Map the admin colors onto the Codliy design-system variables so
        // the landing page, portfolio, and any .codliy-* class live-follow
        // whatever the admin picks. Defaults from app.css remain as fallback.
        $accent = $this->info_color ?: $this->primary_color;

        // In LIGHT mode the "brand surface" is the primary color tinted
        // heavily toward white — so .bg-codliy / .codliy-section read as
        // a soft, on-brand panel (never pure gray, never dark-on-light).
        // In DARK mode we keep the cinematic deep-space gradient.
        $lightBgDark = $this->mixWithWhite($this->primary_color, 0.96); // very faint
        $lightBgDeep = $this->mixWithWhite($accent,              0.90); // slightly deeper

        $lightVariables['--codliy-primary']          = $this->primary_color;
        $lightVariables['--codliy-primary-rgb']      = $this->hexToRgb($this->primary_color);
        $lightVariables['--codliy-accent']           = $accent;
        $lightVariables['--codliy-accent-rgb']       = $this->hexToRgb($accent);
        $lightVariables['--codliy-bg-dark']          = $lightBgDark;
        $lightVariables['--codliy-bg-deep']          = $lightBgDeep;
        $lightVariables['--codliy-gradient']         = 'linear-gradient(135deg, '.$lightBgDark.' 0%, '.$lightBgDeep.' 100%)';
        $lightVariables['--codliy-primary-gradient'] = 'linear-gradient(135deg, '.$this->primary_color.' 0%, '.$accent.' 100%)';

        // Hero / CMS headline color — driven by the admin's primary so every
        // .codliy-hero h1 / .codliy-section__title reads in the brand color.
        // Body/copy color stays muted-neutral for readability.
        $lightVariables['--codliy-heading'] = $this->primary_color;
        $lightVariables['--codliy-body']    = '#0a1220';

        // Merge custom CSS variables for light mode (wins over derived values,
        // so power users can still hand-tune individual tokens).
        if ($this->custom_css_variables) {
            $lightVariables = array_merge($lightVariables, $this->custom_css_variables);
        }

        // Dark mode variables with both hex and RGB values
        $darkVariables = [
            '--bs-primary' => $this->dark_primary_color,
            '--bs-primary-rgb' => $this->hexToRgb($this->dark_primary_color),
            '--bs-secondary' => $this->dark_secondary_color,
            '--bs-secondary-rgb' => $this->hexToRgb($this->dark_secondary_color),
            '--bs-success' => $this->dark_success_color,
            '--bs-success-rgb' => $this->hexToRgb($this->dark_success_color),
            '--bs-info' => $this->dark_info_color,
            '--bs-info-rgb' => $this->hexToRgb($this->dark_info_color),
            '--bs-warning' => $this->dark_warning_color,
            '--bs-warning-rgb' => $this->hexToRgb($this->dark_warning_color),
            '--bs-danger' => $this->dark_danger_color,
            '--bs-danger-rgb' => $this->hexToRgb($this->dark_danger_color),
            '--bs-body-bg' => $this->dark_body_bg,
            '--bs-body-bg-rgb' => $this->hexToRgb($this->dark_body_bg),
            '--bs-card-bg' => $this->dark_card_bg,
            '--bs-card-bg-rgb' => $this->hexToRgb($this->dark_card_bg),
        ];

        // --- Codliy brand tokens (dark mode) ------------------------------
        $darkAccent = $this->dark_info_color ?: $this->dark_primary_color;
        $darkVariables['--codliy-primary']          = $this->dark_primary_color;
        $darkVariables['--codliy-primary-rgb']      = $this->hexToRgb($this->dark_primary_color);
        $darkVariables['--codliy-accent']           = $darkAccent;
        $darkVariables['--codliy-accent-rgb']       = $this->hexToRgb($darkAccent);
        $darkVariables['--codliy-bg-dark']          = $this->dark_body_bg ?: '#020611';
        $darkVariables['--codliy-bg-deep']          = $this->dark_card_bg ?: '#0A1F4D';
        $darkVariables['--codliy-gradient']         = 'linear-gradient(135deg, '.($this->dark_body_bg ?: '#020611').' 0%, '.($this->dark_card_bg ?: '#0A1F4D').' 100%)';
        $darkVariables['--codliy-primary-gradient'] = 'linear-gradient(135deg, '.$this->dark_primary_color.' 0%, '.$darkAccent.' 100%)';

        // Dark-mode headline uses the admin's dark primary so CMS hero titles
        // remain brand-colored against the deep-space gradient.
        $darkVariables['--codliy-heading'] = $this->dark_primary_color;
        $darkVariables['--codliy-body']    = '#D9D9D9';

        // Generate CSS for light mode
        $css = ':root, [data-bs-theme="light"] {'.PHP_EOL;
        foreach ($lightVariables as $key => $value) {
            $css .= "  {$key}: {$value};".PHP_EOL;
        }
        $css .= '}'.PHP_EOL.PHP_EOL;

        // Generate CSS for dark mode
        $css .= '[data-bs-theme="dark"] {'.PHP_EOL;
        foreach ($darkVariables as $key => $value) {
            $css .= "  {$key}: {$value};".PHP_EOL;
        }
        $css .= '}';

        return $css;
    }
}