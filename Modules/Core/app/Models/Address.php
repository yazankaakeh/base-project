<?php

namespace Modules\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Core\app\Enum\PrimaryAddressStatus;

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
    'full_address',
    'latitude',
    'longitude',
    'is_primary',
  ];

  protected $casts = [
    'is_primary' => PrimaryAddressStatus::class,
  ];

  public function country(): BelongsTo
  {
    return $this->belongsTo(Country::class);
  }

  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class);
  }

  public function addressable(): MorphTo
  {
    return $this->morphTo();
  }

}
