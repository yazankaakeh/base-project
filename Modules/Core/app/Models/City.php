<?php

namespace Modules\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
  use HasTranslations;

  public array $translatable = ['name'];
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = ['name', 'country_id'];

}
