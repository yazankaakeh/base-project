<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPostTranslation extends Model
{
  use HasFactory;

  protected $table = 'blog_posts_translations';
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = ['blog_posts_id', 'title', 'locale', 'description', 'short_description'];

}
