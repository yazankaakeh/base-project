<?php

namespace Modules\Seo\Traits;


use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Seo\Models\SeoMeta;

trait HasSeo
{
    public function seo(): MorphMany
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}