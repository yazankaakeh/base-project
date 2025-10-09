<?php

namespace Modules\Seo\Enums;

use Modules\Core\app\Traits\OptimizeEnumTrait;

enum SeoSettingsEnum: string
{
    use OptimizeEnumTrait;

    case TWITTER_CARD = 'twitter_card';
    case TWITTER_SITE = 'twitter_site';
    case TWITTER_IMAGE = 'twitter_image';
    case SITE_NAME = 'site_name';
    case SITE_LOGO = 'site_logo';
    case TYPE = 'type';
    case robots_index = 'robots_index';
    case robots_follow = 'robots_follow';
    case FACEBOOK = 'facebook';
    case TWITTER = 'twitter';
    case YOUTUBE = 'youtube';
    case INSTAGRAM = 'instagram';
    case LINKEDIN = 'linkedin';
    case PINTEREST = 'pinterest';
    case GITHUB = 'github';
    case BEHANCE = 'behance';
    case DRIBBBLE = 'dribbble';
    case TUMBLR = 'tumblr';
    case TIKTOK = 'tiktok';
    case DEVTO = 'devTo';
    case MEDIUM = 'medium';

    public function label(): string
    {
        return trans('seo::seo.seo_settings.'.$this->value);
    }
}
