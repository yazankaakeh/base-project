<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Core\App\Enum\Gender;
use Modules\Core\app\Enums\UserStatusEnum;
use Modules\Core\app\Models\Address;
use Modules\Doctor\Database\Factories\PatientFactory;
use Modules\Doctor\Enums\BloodType;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Patient extends Authenticatable implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'age',
        'gender',
        'children',
        'work',
        'blood_type',
        'drug_allergies',
        'disabilities',
        'medical_history',
        'surgical_history',
        'accident_history',
        'password',
        'email',
        'is_active',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'blood_type' => BloodType::class,
        'is_active' => UserStatusEnum::class,
        'gender' => Gender::class,
    ];

    protected static function newFactory(): PatientFactory
    {
        return PatientFactory::new();
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
