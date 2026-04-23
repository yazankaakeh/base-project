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
        'rtl_font_family',
        'rtl_headings_font_family',
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

    /**
     * Public logo URL for this scope.
     *
     * Resolution order (first non-empty wins):
     *   1. Spatie media collection 'logo' / 'logo_dark'
     *   2. `logo_path` / `logo_dark_path` column (legacy field — stored as a
     *      path relative to /storage or a full URL)
     *   3. Null — template should fall back to the inline SVG / text brand.
     *
     * @param  bool  $dark  If true, prefer the dark-mode variant and fall
     *                      back to the light logo when no dark one is set.
     */
    public function getLogoUrl(bool $dark = false): ?string
    {
        if ($dark) {
            $url = $this->getFirstMediaUrl('logo_dark');
            if ($url) {
                return $url;
            }
            if (filled($this->logo_dark_path)) {
                return $this->normalizeAssetPath($this->logo_dark_path);
            }
            // Fall through to light logo so dark mode still shows something.
        }

        $url = $this->getFirstMediaUrl('logo');
        if ($url) {
            return $url;
        }
        if (filled($this->logo_path)) {
            return $this->normalizeAssetPath($this->logo_path);
        }
        return null;
    }

    /**
     * Public favicon URL. Resolution same as the logo helper.
     */
    public function getFaviconUrl(): ?string
    {
        $url = $this->getFirstMediaUrl('favicon');
        if ($url) {
            return $url;
        }
        if (filled($this->favicon_path)) {
            return $this->normalizeAssetPath($this->favicon_path);
        }
        return null;
    }

    /**
     * Convert a legacy stored path into a URL.
     * - `http://...` / `https://...` / `//...` → used as-is.
     * - Leading `/` → treated as absolute URL (e.g. `/storage/foo.png`).
     * - Otherwise → run through `asset()` so relative paths work.
     *
     * Spaces in filenames (the seeded brand asset ships as
     * `assets/brand/Ligh Logo.png`) get rawurlencoded per-segment so the
     * resulting URL is valid for every browser.
     */
    private function normalizeAssetPath(string $path): string
    {
        if (preg_match('#^(https?:)?//#', $path) || str_starts_with($path, '/')) {
            return $path;
        }
        // Encode each path segment individually so the `/` separators stay intact.
        $encoded = implode('/', array_map('rawurlencode', explode('/', $path)));
        return asset($encoded);
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
     * Mix a hex color with pure black.
     *
     * $blackPct 0.0 = original color, 1.0 = pure black. Used to derive a
     * strong body/soft/mute text hierarchy from the admin's secondary
     * color so muted text stays tonally related to the brand.
     */
    private function mixWithBlack(string $hex, float $blackPct): string
    {
        $blackPct = max(0.0, min(1.0, $blackPct));
        [$r, $g, $b] = $this->hexToRgbTriplet($hex);

        $r = (int) round($r * (1 - $blackPct));
        $g = (int) round($g * (1 - $blackPct));
        $b = (int) round($b * (1 - $blackPct));

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

        // Always define --codliy-font-family and --codliy-heading-font-family
        // on :root. If the admin hasn't chosen a custom font we fall through
        // to `--bs-body-font-family` which is guaranteed to resolve. This
        // kills the "variable not defined" warning at the source — the vars
        // are always present, even if the stylesFront compiled view cache is
        // stale.
        $ltrFontStack = fn(?string $family) => $family
            ? "{$family}, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif"
            : 'var(--bs-body-font-family, system-ui, -apple-system, Segoe UI, Roboto, sans-serif)';
        $lightVariables['--codliy-font-family']         = $ltrFontStack($this->font_family);
        $lightVariables['--codliy-heading-font-family'] = $ltrFontStack($this->headings_font_family ?: $this->font_family);

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
        //
        // Body / soft / mute text colors — derived from the admin's SECONDARY
        // color so muted labels (kickers, subtitles, stack rows, card body)
        // stay tonally consistent with the chosen palette. We mix with black
        // to get progressively darker shades for readability on light bg.
        //   body  = strong (for body copy)
        //   soft  = medium (for secondary copy like card body, subtitles)
        //   mute  = light (for ultra-quiet labels like "SERVICE 01")
        // Defaults to neutral grays if secondary isn't set.
        $secondaryLight = $this->secondary_color ?: '#8A94B0';
        $lightVariables['--codliy-heading']   = $this->primary_color;
        $lightVariables['--codliy-body']      = $this->mixWithBlack($secondaryLight, 0.72);
        $lightVariables['--codliy-text-soft'] = $this->mixWithBlack($secondaryLight, 0.45);
        $lightVariables['--codliy-text-mute'] = $secondaryLight;

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
        //
        // Dark-mode body / soft / mute — derive from dark_secondary_color by
        // mixing with WHITE so each step reads progressively lighter on the
        // dark background. Inverse relationship vs. light mode.
        //   body  = near-white (strong contrast)
        //   soft  = soft gray
        //   mute  = dim gray
        $secondaryDark = $this->dark_secondary_color ?: '#8A94B0';
        $darkVariables['--codliy-heading']   = $this->dark_primary_color;
        $darkVariables['--codliy-body']      = $this->mixWithWhite($secondaryDark, 0.70);
        $darkVariables['--codliy-text-soft'] = $this->mixWithWhite($secondaryDark, 0.45);
        $darkVariables['--codliy-text-mute'] = $secondaryDark;

        // Ensure Codliy font-family vars are also defined in dark mode so any
        // `var(--codliy-font-family)` reference resolves regardless of the
        // active theme or cached compiled views.
        $darkVariables['--codliy-font-family']         = $ltrFontStack($this->font_family);
        $darkVariables['--codliy-heading-font-family'] = $ltrFontStack($this->headings_font_family ?: $this->font_family);

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
        $css .= '}'.PHP_EOL.PHP_EOL;

        // ---- Runtime overrides that ALWAYS win ---------------------------
        // Some CSS bundles were compiled with postcss-custom-properties in a
        // mode that flattens `var(--token, 10px)` down to its fallback literal
        // (`10px`). That freezes the radius/color at build time, which means
        // admin tweaks to border_radius / primary_color wouldn't show up on
        // those pages even though the CSS variable is set correctly here.
        //
        // To make admin settings authoritative, we re-declare the critical
        // "branded" rules directly with the admin values — so they override
        // whatever the compiled bundle contains, with no rebuild required.
        $radius = $this->border_radius ?: '10px';
        // Normalize — some saved values are bare numbers like "10" rather
        // than "10px". Default to px when unit is missing.
        if (is_numeric(trim($radius))) {
            $radius = trim($radius) . 'px';
        }

        $primaryLight     = $this->primary_color        ?: '#0056F8';
        $primaryDark      = $this->dark_primary_color   ?: '#3B82F6';
        $secondaryLight   = $this->secondary_color      ?: '#8A94B0';
        $secondaryDark    = $this->dark_secondary_color ?: '#8A94B0';

        $css .= '/* Runtime overrides — ensures admin settings beat any stale compiled CSS */'.PHP_EOL;

        // Button radius — applies to both Codliy brand buttons AND Bootstrap
        // outline/solid buttons on dashboard + site. `!important` because
        // Sneat/Bootstrap precompute radii in places.
        $css .= ".btn, .btn-codliy, .btn-codliy-outline,".PHP_EOL;
        $css .= ".btn-outline-primary, .btn-outline-secondary, .btn-outline-success,".PHP_EOL;
        $css .= ".btn-outline-danger, .btn-outline-warning, .btn-outline-info,".PHP_EOL;
        $css .= ".btn-primary, .btn-secondary, .btn-success, .btn-danger, .btn-warning, .btn-info {".PHP_EOL;
        $css .= "  border-radius: {$radius} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Outline-primary color alignment — Sneat sometimes bakes in the
        // default blue. Keep border + text in the admin's primary.
        $css .= ':root, [data-bs-theme="light"] {'.PHP_EOL;
        $css .= "  --bs-btn-border-radius: {$radius};".PHP_EOL;
        $css .= "  --bs-btn-border-radius-sm: calc({$radius} * 0.75);".PHP_EOL;
        $css .= "  --bs-btn-border-radius-lg: calc({$radius} * 1.25);".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Hero headline — forces the admin's primary color on .codliy-hero
        // titles even if the compiled app.css lost the --codliy-heading
        // fallback during minification.
        $css .= '[data-bs-theme="light"] .codliy-hero h1,'.PHP_EOL;
        $css .= '[data-bs-theme="light"] .codliy-hero .codliy-hero__title,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-hero h1,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-hero .codliy-hero__title {'.PHP_EOL;
        $css .= "  color: {$primaryLight} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        $css .= '[data-bs-theme="dark"] .codliy-hero h1,'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-hero .codliy-hero__title,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-hero h1,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-hero .codliy-hero__title {'.PHP_EOL;
        $css .= "  color: {$primaryDark} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Section titles too — users set ONE primary color, they expect
        // every branded heading to reflect it.
        $css .= '[data-bs-theme="light"] .codliy-section .codliy-section__title,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-section .codliy-section__title {'.PHP_EOL;
        $css .= "  color: {$primaryLight} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-section .codliy-section__title,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-section .codliy-section__title {'.PHP_EOL;
        $css .= "  color: {$primaryDark} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Kickers — the small uppercase eyebrow text above hero & section
        // titles. Drives off the admin's SECONDARY color so the site has a
        // clear two-color brand hierarchy (primary = headline, secondary =
        // label). `.codliy-section__kicker` was previously pinned to primary;
        // we keep the single source of truth here so both match.
        $css .= '[data-bs-theme="light"] .codliy-hero .codliy-hero__kicker,'.PHP_EOL;
        $css .= '[data-bs-theme="light"] .codliy-section .codliy-section__kicker,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-hero .codliy-hero__kicker,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-section .codliy-section__kicker {'.PHP_EOL;
        $css .= "  color: {$secondaryLight} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-hero .codliy-hero__kicker,'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-section .codliy-section__kicker,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-hero .codliy-hero__kicker,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-section .codliy-section__kicker {'.PHP_EOL;
        $css .= "  color: {$secondaryDark} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Soft / mute utility classes + all the "secondary copy" surfaces.
        // These were the ones reported as pinned to #D9D9D9 / #8A94B0 in the
        // compiled CSS. Force them to the admin-derived values so every
        // subtitle, stack row, card body and "text-codliy-soft fw-medium"
        // chip on the page follows the admin palette.
        $textSoftLight = $this->mixWithBlack($secondaryLight, 0.45);
        $textSoftDark  = $this->mixWithWhite($secondaryDark,  0.45);

        $css .= '[data-bs-theme="light"] .text-codliy-soft,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .text-codliy-soft,'.PHP_EOL;
        $css .= '[data-bs-theme="light"] .codliy-hero .codliy-hero__sub,'.PHP_EOL;
        $css .= '[data-bs-theme="light"] .codliy-section .codliy-section__sub,'.PHP_EOL;
        $css .= '[data-bs-theme="light"] .codliy-card .codliy-card__body,'.PHP_EOL;
        $css .= '[data-bs-theme="light"] .codliy-card .codliy-card__eyebrow,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-hero .codliy-hero__sub,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-section .codliy-section__sub,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-card .codliy-card__body,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-card .codliy-card__eyebrow {'.PHP_EOL;
        $css .= "  color: {$textSoftLight} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        $css .= '[data-bs-theme="dark"] .text-codliy-soft,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .text-codliy-soft,'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-hero .codliy-hero__sub,'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-section .codliy-section__sub,'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-card .codliy-card__body,'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-card .codliy-card__eyebrow,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-hero .codliy-hero__sub,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-section .codliy-section__sub,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-card .codliy-card__body,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-card .codliy-card__eyebrow {'.PHP_EOL;
        $css .= "  color: {$textSoftDark} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Muted utility + hero stack (the "Laravel · PHP 8.3+" row under the
        // hero CTA) — one step lighter than soft. Drives off secondary
        // directly so the tone still tracks the admin palette.
        $css .= '[data-bs-theme="light"] .text-codliy-mute,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .text-codliy-mute,'.PHP_EOL;
        $css .= '[data-bs-theme="light"] .codliy-hero .codliy-hero__stack,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-hero .codliy-hero__stack {'.PHP_EOL;
        $css .= "  color: {$secondaryLight} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .text-codliy-mute,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .text-codliy-mute,'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-hero .codliy-hero__stack,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-hero .codliy-hero__stack {'.PHP_EOL;
        $css .= "  color: {$secondaryDark} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // `.text-codliy-primary` — the quick "use primary color for this
        // text" helper. Belt-and-suspenders so it beats any literal color
        // PostCSS may have baked into the compiled bundle.
        $css .= '[data-bs-theme="light"] .text-codliy-primary,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .text-codliy-primary {'.PHP_EOL;
        $css .= "  color: {$primaryLight} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .text-codliy-primary,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .text-codliy-primary {'.PHP_EOL;
        $css .= "  color: {$primaryDark} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Cards — surface + border + title color all derived from theme.
        // In LIGHT mode, the card sits on a light body bg, so we give it a
        // white-ish surface with a faint primary border tint. In DARK mode,
        // the card uses the admin's dark_card_bg (with subtle transparency)
        // so cards sit naturally on the deep-space gradient.
        $lightCardBg   = $this->card_bg      ?: '#FFFFFF';
        $darkCardBg    = $this->dark_card_bg ?: '#0A1F4D';
        $css .= '.codliy-card {'.PHP_EOL;
        $css .= "  border-radius: calc({$radius} * 1.8) !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;
        $css .= '[data-bs-theme="light"] .codliy-card,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-card {'.PHP_EOL;
        $css .= "  background: {$lightCardBg} !important;".PHP_EOL;
        $css .= "  border-color: rgba(var(--codliy-primary-rgb), 0.1) !important;".PHP_EOL;
        $css .= "  box-shadow: 0 10px 40px rgba(var(--codliy-primary-rgb), 0.06) !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-card,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-card {'.PHP_EOL;
        $css .= "  background: rgba(var(--codliy-primary-rgb), 0.04) !important;".PHP_EOL;
        $css .= "  border-color: rgba(255, 255, 255, 0.06) !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Card title — should read as a strong body heading in both modes.
        // Uses --codliy-body (admin-derived) with the admin heading font.
        $bodyLight = $this->mixWithBlack($secondaryLight, 0.72);
        $bodyDark  = $this->mixWithWhite($secondaryDark,  0.70);
        $css .= '[data-bs-theme="light"] .codliy-card .codliy-card__title,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-card .codliy-card__title {'.PHP_EOL;
        $css .= "  color: {$bodyLight} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;
        $css .= '[data-bs-theme="dark"] .codliy-card .codliy-card__title,'.PHP_EOL;
        $css .= '[data-layout-mode="dark_mode"] .codliy-card .codliy-card__title {'.PHP_EOL;
        $css .= "  color: {$bodyDark} !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Section/hero background in LIGHT mode — the Codliy cinematic gradient
        // gets flipped to a soft primary-tinted surface so copy stays readable.
        $css .= '[data-bs-theme="light"] .codliy-section,'.PHP_EOL;
        $css .= '[data-layout-mode="light_mode"] .codliy-section {'.PHP_EOL;
        $css .= "  background: var(--codliy-gradient) !important;".PHP_EOL;
        $css .= '}'.PHP_EOL;

        // Typography — heading + body font families, only when the admin
        // actually set something (don't clobber system fonts on fresh installs).
        if ($this->font_family) {
            $css .= 'body, .codliy-card, .codliy-card__body, .codliy-section__sub {'.PHP_EOL;
            $css .= "  font-family: {$this->font_family}, system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important;".PHP_EOL;
            $css .= '}'.PHP_EOL;
        }
        if ($this->headings_font_family) {
            $css .= 'h1, h2, h3, h4, h5, h6,'.PHP_EOL;
            $css .= '.codliy-hero__title, .codliy-section__title, .codliy-card__title {'.PHP_EOL;
            $css .= "  font-family: {$this->headings_font_family}, system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important;".PHP_EOL;
            $css .= '}'.PHP_EOL;
        }

        return $css;
    }
}