<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Core\App\Enum\Gender;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Core\app\Models\Address;
use Modules\Doctor\Database\Factories\PatientFactory;
use Modules\Doctor\Enums\BloodType;
use Modules\Doctor\Enums\MaritalStatus;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        'blood_type',
        'gender',
        'children',
        'is_active',
        'marital_status',
        'nationality_id',
        'work',
        'drug_allergies',
        'disabilities',
        'medical_history',
        'surgical_history',
        'accident_history',
        'password',
        'email',
        'id',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'blood_type' => BloodType::class,
        'is_active' => ActiveEnum::class,
        'gender' => Gender::class,
        'marital_status' => MaritalStatus::class,
    ];

    protected static function newFactory(): PatientFactory
    {
        return PatientFactory::new();
    }

    public function clinics(): BelongsToMany
    {
        return $this
            ->belongsToMany(Clinic::class, 'clinic_patients')
            ->using(ClinicPatient::class); // optional
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function scopeFilter(Builder $q, array $f): Builder
    {
        // small helpers
        $toArray = fn($v) => is_array($v) ? $v : (isset($v) && $v !== '' ? [$v] : []);
        $enumBacked = function (array $vals, string $enum): array {
            return array_values(array_filter(array_map(function ($v) use ($enum) {
                if ($v instanceof $enum) {
                    return $v->value;
                }
                if (($e = $enum::tryFrom($v))) {
                    return $e->value;
                }   // backed value
                // allow passing enum NAME like "A_POS"
                if (is_string($v) && defined("$enum::$v")) {
                    $const = constant("$enum::$v");
                    return $const instanceof $enum ? $const->value : null;
                }
                return is_scalar($v) ? $v : null; // last resort
            }, $vals), fn($v) => $v !== null && $v !== ''));
        };

        // text
        $q->when($f['name'] ?? null, fn($q, $v) => $q->where('name', 'like', "%{$v}%"));

        // nationality_id (single or array)
        if ($ids = $toArray($f['nationality_id'] ?? null)) {
            $q->where('nationality_id', $ids);
        }

        // age range
        $min = $f['min_age'] ?? null;
        $max = $f['max_age'] ?? null;
        if ($min !== null) {
            $q->where('age', '>=', $min);
        }
        if ($max !== null) {
            $q->where('age', '<=', $max);
        }
        // exact age still supported
        $q->when($f['age'] ?? null, fn($q, $v) => $q->where('age', $v));

        // enums (except single value or array → do whereIn)
        if ($vals = $enumBacked($toArray($f['blood_type'] ?? null), BloodType::class)) {
            $q->whereIn('blood_type', $vals);
        }
        if ($vals = $enumBacked($toArray($f['gender'] ?? null), Gender::class)) {
            $q->where('gender', $vals);
        }
        if ($vals = $enumBacked($toArray($f['marital_status'] ?? null), MaritalStatus::class)) {
            $q->whereIn('marital_status', $vals);
        }
        if ($vals = $enumBacked($toArray($f['is_active'] ?? null), ActiveEnum::class)) {
            $q->where('is_active', $vals);
        }

        return $q;
    }
}
