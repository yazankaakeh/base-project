<?php

namespace Modules\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

// use Modules\Core\Database\Factories\NeighborhoodFactory;

class Neighborhood extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'zipcode',
        'district_id',
    ];

    public static function getNeighborhood($district_id): array
    {
        return Neighborhood::query()->where('district_id', $district_id)->pluck('name', 'id')->toArray();
    }

}
