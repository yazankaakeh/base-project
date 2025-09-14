<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function patient(): BelongsToMany
    {
        return $this
            ->belongsToMany(Patient::class, 'medical_examination_medical_test')
            ->using(FinalDiagnosisPatient::class); // optional
    }
}
