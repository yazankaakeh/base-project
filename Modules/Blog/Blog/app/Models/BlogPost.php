<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Blog\app\traits\Translatable;

class BlogPost extends Model
{
  use  Translatable;


  protected $fillable = ['slug', 'img',
    'is_active', 'title', 'short_description', 'description',
    'created_by', 'updated_by'];
  protected string $translationRelation = 'Translations';
  protected string $foreignKey = 'blog_posts_id';

  public function PostTypes(): BelongsToMany
  {
    return $this->belongsToMany(PostType::class);
  }

  public function Translations(): HasMany
  {
    return $this->hasMany(BlogPostTranslation::class, 'post_types_id', 'id');
  }
}
