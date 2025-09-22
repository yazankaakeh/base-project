<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Doctor\Database\Factories\MedicalExaminationFactory;
use Modules\Doctor\Enums\MedicalExaminationStatusEnum;
use Modules\Doctor\Enums\MedicalTestTypeEnum;

/**
 * @property Patient $patient
 */
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
        'status',
    ];

    protected $casts = [
        'status' => MedicalExaminationStatusEnum::class,
    ];

    protected static function newFactory(): MedicalExaminationFactory
    {
        return MedicalExaminationFactory::new();
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function vitalSigns(): BelongsToMany
    {
        return $this
            ->belongsToMany(VitalSign::class, 'medical_examination_vital_sign')
            ->withPivot('value')
            ->withTimestamps()
            ->using(MedicalExaminationVitalSign::class); // optional
    }

    public function medicines(): BelongsToMany
    {
        return $this
            ->belongsToMany(Medicine::class, 'medical_examination_medicine')
            ->withPivot('value')
            ->withTimestamps()
            ->using(MedicalExaminationMedicine::class); // optional
    }

    public function laboratoryTests(): BelongsToMany
    {
        return $this
            ->medicalTests()
            ->where('medical_tests.type', MedicalTestTypeEnum::LABORATORY_TESTS->value);
    }

    public function medicalTests(): BelongsToMany
    {
        return $this
            ->belongsToMany(MedicalTest::class, 'medical_examination_medical_test')
            ->using(MedicalExaminationMedicalTest::class)
            ->withPivot('value');
    }

    public function radiologyTests(): BelongsToMany
    {
        return $this
            ->medicalTests()
            ->where('medical_tests.type', MedicalTestTypeEnum::RADIOLOGY_TESTS->value);
    }

}
