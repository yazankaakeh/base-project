<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Doctor\Database\Factories\VitalSignFactory;

class VitalSign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

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
