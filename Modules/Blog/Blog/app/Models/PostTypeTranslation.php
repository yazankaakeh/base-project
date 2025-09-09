<?php

namespace Modules\Blog\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTypeTranslation extends Model
{
  use HasFactory;

  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = ['post_types_id', 'locale', 'name'];

  protected $table = 'post_types_translations';

}
