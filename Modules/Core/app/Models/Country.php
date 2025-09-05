<?php

namespace Modules\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
  use HasTranslations;

  public array $translatable = ['name'];
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = ['name', 'code'];
  protected $casts = [
    'name' => 'array',
  ];

  public static function getCountriesSelect2(): Collection
  {
    return Country::query()->pluck('name', 'id');
  }
}
