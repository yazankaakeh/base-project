<?php

namespace Modules\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Core\app\Enum\PrimaryAddressStatus;
use Modules\Core\App\Enums\AddressEnum;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'country_id',
        'addressable_id',
        'addressable_type',
        'city_id',
        'town_id',
        'district_id',
        'neighborhood_id',
        'full_address',
        'latitude',
        'longitude',
        'is_primary',
        'type',
    ];

    protected $casts = [
        'is_primary' => PrimaryAddressStatus::class,
        'type' => AddressEnum::class,
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function town(): BelongsTo
    {
        return $this->belongsTo(Town::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function neighborhood(): BelongsTo
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

}
