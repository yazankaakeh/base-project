<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogTagTranslation extends Model
{


  protected $table = 'blog_tags_translation';

  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = ['name', 'locale', 'blog_tag_id'];

  public function blogTag(): BelongsTo
  {
    return $this->belongsTo(BlogTag::class);

  }


}
