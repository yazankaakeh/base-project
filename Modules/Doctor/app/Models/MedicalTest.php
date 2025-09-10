<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Doctor\Database\Factories\MedicalTestFactory;
use Spatie\Translatable\HasTranslations;

class MedicalTest extends Model
{
    public array $translatable = ['name'];
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'unit',
    ];

    protected static function newFactory(): MedicalTestFactory
    {
        return MedicalTestFactory::new();
    }

    public function medicalExaminations(): BelongsToMany
    {
        return $this
            ->belongsToMany(MedicalExamination::class, 'medical_examination_medical_test')
            ->withPivot('value')
            ->withTimestamps()
            ->using(MedicalExaminationMedicalTest::class); // optional
    }
}
