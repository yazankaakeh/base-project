<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Modules\Core\App\Enums\ActiveEnum;
use Spatie\Translatable\HasTranslations;

// use Modules\Doctor\Database\Factories\FinalDiagnosisFactory;

class FinalDiagnosis extends Model
{

    use HasTranslations;

    public array $translatable = ['name'];
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => ActiveEnum::class,
    ];

    public static function getFinalDiagnosisSelect2(): Collection
    {
        return FinalDiagnosis::query()->where('is_active', ActiveEnum::ACTIVE)->pluck('name', 'id');
    }

    public function patient(): BelongsToMany
    {
        return $this
            ->belongsToMany(Patient::class, 'medical_examination_medical_test')
            ->using(FinalDiagnosisPatient::class); // optional
    }
}
