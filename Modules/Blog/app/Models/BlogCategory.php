<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Blog\app\traits\Translatable;

/**
 * @property mixed $img
 * @property mixed $slug
 * @property int|mixed $is_active
 * @property mixed $parent_id
 */
class BlogCategory extends Model
{
  use HasFactory, Translatable;

  public array $translatable = ['name'];
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = ['parent_id', 'slug', 'img', 'is_active'];

  protected string $translationRelation = 'Translations';
  protected string $foreignKey = 'blog_category_id';

  public function parent(): BelongsTo
  {
    return $this->belongsTo(BlogCategory::class, 'parent_id');
  }

  public function children(): HasMany
  {
    return $this->hasMany(BlogCategory::class, 'parent_id');
  }

  public function BlogPosts(): HasMany
  {
    return $this->hasMany(BlogPost::class);
  }

  public function Translations(): HasMany
  {
    return $this->hasMany(BlogCategoryTranslation::class, 'blog_category_id', 'id');
  }
}
