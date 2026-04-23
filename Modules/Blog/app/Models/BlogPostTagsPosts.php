<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BlogPostTagsPosts extends Pivot
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'post_id',
        'tag_id',
    ];
}
