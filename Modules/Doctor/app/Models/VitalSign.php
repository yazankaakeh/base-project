<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Doctor\Database\Factories\VitalSignFactory;
use Spatie\Translatable\HasTranslations;

class VitalSign extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['name'];
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => ActiveEnum::class,
    ];

    public static function getVitalSignsSelect2(): Collection
    {
        return VitalSign::query()->pluck('name', 'id');
    }

    protected static function newFactory(): VitalSignFactory
    {
        return VitalSignFactory::new();
    }

    public function medicalExaminations(): BelongsToMany
    {
        return $this
            ->belongsToMany(MedicalExamination::class, 'medical_examination_vital_sign')
            ->withPivot('value')
            ->withTimestamps()
            ->using(MedicalExaminationVitalSign::class); // optional
    }
}
