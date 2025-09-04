<?php

namespace Modules\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'city_id',
    ];

    public static function getTowns($cityId): array
    {
        return Town::query()->where('city_id', $cityId)->pluck('name', 'id')->toArray();
    }
}
