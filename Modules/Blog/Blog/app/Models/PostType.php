<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Blog\app\traits\Translatable;

class PostType extends Model
{
  use HasFactory, Translatable;

  protected string $translationRelation = 'Translations';

  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [];
  protected string $foreignKey = 'post_types_id';

  public function BlogPosts(): BelongsToMany
  {
    return $this->belongsToMany(BlogPost::class);
  }

  public function Translations(): HasMany
  {
    return $this->hasMany(PostTypeTranslation::class, 'post_types_id', 'id');
  }
}
