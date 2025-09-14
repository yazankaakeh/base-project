<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Doctor\Database\Factories\MedicalExaminationFactory;

class MedicalExamination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'clinic_id',
        'clinical_examination',
        'impression',
        'request_for_action',
    ];

    protected static function newFactory(): MedicalExaminationFactory
    {
        return MedicalExaminationFactory::new();
    }

    public function vitalSigns(): BelongsToMany
    {
        return $this
            ->belongsToMany(VitalSign::class, 'medical_examination_vital_sign')
            ->withPivot('value')
            ->withTimestamps()
            ->using(MedicalExaminationVitalSign::class); // optional
    }

    public function medicalTests(): BelongsToMany
    {
        return $this
            ->belongsToMany(MedicalTest::class, 'medical_examination_medical_test')
            ->withPivot('value')
            ->using(MedicalExaminationMedicalTest::class); // optional
    }

    public function medicines(): BelongsToMany
    {
        return $this
            ->belongsToMany(Medicine::class, 'medical_examination_medicine')
            ->withPivot('value')
            ->withTimestamps()
            ->using(MedicalExaminationMedicine::class); // optional
    }
}
