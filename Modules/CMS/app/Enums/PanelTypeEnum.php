<?php

namespace Modules\CMS\Enums;

use Modules\Core\app\Traits\OptimizeEnumTrait;

enum PanelTypeEnum: string
{
    use OptimizeEnumTrait;

    case HERO = 'hero';
    case FEATURES = 'features';
    case TEAM = 'team';
    case REVIEWS = 'reviews';
    case FAQ = 'faq';
    case CTA = 'cta';
    case CONTACT = 'contact';
    case STATS = 'stats';
    case GALLERY = 'gallery';
    case CUSTOM = 'custom';

    public function label(): string
    {
        return match ($this) {
            self::HERO => 'Hero Section',
            self::FEATURES => 'Features',
            self::TEAM => 'Team Members',
            self::REVIEWS => 'Reviews / Testimonials',
            self::FAQ => 'FAQ',
            self::CTA => 'Call to Action',
            self::CONTACT => 'Contact Form',
            self::STATS => 'Statistics / Numbers',
            self::GALLERY => 'Image Gallery',
            self::CUSTOM => 'Custom HTML',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::HERO => 'Large header section with title, subtitle, and CTA buttons',
            self::FEATURES => 'Grid of feature cards with icons, titles, and descriptions',
            self::TEAM => 'Team member profiles with photos, names, and roles',
            self::REVIEWS => 'Customer reviews and testimonials',
            self::FAQ => 'Frequently asked questions with collapsible answers',
            self::CTA => 'Call-to-action section with button',
            self::CONTACT => 'Contact form with customizable fields',
            self::STATS => 'Statistics or number counters',
            self::GALLERY => 'Image gallery with lightbox',
            self::CUSTOM => 'Custom HTML content',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::HERO => 'ti-rocket',
            self::FEATURES => 'ti-list-check',
            self::TEAM => 'ti-users',
            self::REVIEWS => 'ti-message-star',
            self::FAQ => 'ti-help',
            self::CTA => 'ti-click',
            self::CONTACT => 'ti-mail',
            self::STATS => 'ti-chart-bar',
            self::GALLERY => 'ti-photo',
            self::CUSTOM => 'ti-code',
        };
    }

    public function hasItems(): bool
    {
        return in_array($this, [
            self::FEATURES,
            self::TEAM,
            self::REVIEWS,
            self::FAQ,
            self::STATS,
            self::GALLERY,
        ], true);
    }

    public function maxItems(): ?int
    {
        return match ($this) {
            self::HERO => 1,
            self::CTA => 1,
            self::CONTACT => 1,
            default => null, // Unlimited
        };
    }
}