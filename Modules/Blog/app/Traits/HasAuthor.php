<?php

namespace Modules\Blog\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Blog\Models\BlogPost;

trait HasAuthor
{
    public function posts(): MorphMany
    {
        return $this->morphMany(BlogPost::class, 'authorable');
    }
}
