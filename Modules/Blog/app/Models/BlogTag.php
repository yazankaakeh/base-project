<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Blog\app\traits\Translatable;

/**
 * @property mixed $id
 * @property mixed $Posts
 */
class BlogTag extends Model
{
  use HasFactory, Translatable;

  public array $translatable = ['name'];
  protected string $translationRelation = 'Translations';
  protected string $foreignKey = 'blog_tag_id';
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = ['name', 'blog_tag_id'];

  public function Posts(): BelongsToMany
  {
    return $this->belongsToMany(BlogPost::class, 'posts_tags', 'blog_tags_id', 'blog_posts_id');
  }

  public function Translations(): HasMany
  {
    return $this->hasMany(BlogTagTranslation::class);
  }
}
