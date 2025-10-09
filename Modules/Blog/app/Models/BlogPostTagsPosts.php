<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostTagsPosts extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'post_id',
        'tag_id',
    ];

}
