<?php

namespace Modules\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

// use Modules\Core\Database\Factories\DistrictFactory;

class District extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'town_id',
    ];

    public static function getDistrict($townId): array
    {
        return District::query()->where('town_id', $townId)->pluck('name', 'id')->toArray();
    }
}
