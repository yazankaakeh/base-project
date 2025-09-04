<?php

namespace Modules\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'country_id'];

    public static function getCitiesSelect2($countryId): Collection
    {
        return City::query()->where('country_id', $countryId)->pluck('name', 'id');
    }
}
