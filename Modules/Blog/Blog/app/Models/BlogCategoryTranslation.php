<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryTranslation extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = ['name', 'description', 'locale', 'blog_category_id'];
  protected $table = 'blog_categories_translations';

}
