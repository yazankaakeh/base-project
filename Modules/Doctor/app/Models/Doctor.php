<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Core\App\Enum\Gender;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Core\app\Models\Address;
use Modules\Doctor\Database\Factories\DoctorFactory;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed $name
 * @property mixed $phone
 * @property mixed $email
 * @property mixed|string $password
 * @property int|mixed $is_active
 * @property mixed $gender
 * @property mixed $age
 * @property mixed $medical_specialty_id
 */
class Doctor extends Authenticatable implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'gender',
        'id',
        'is_active',
        'age',
        'medical_specialty_id',
    ];
    protected $casts = [
        'gender' => Gender::class,
        'is_active' => ActiveEnum::class,
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory(): DoctorFactory
    {
        return DoctorFactory::new();
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function medicalSpecialty(): BelongsTo
    {
        return $this->belongsTo(MedicalSpecialty::class, 'medical_specialty_id', 'id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
