<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;


class MedicalExaminationMedicalTest extends Pivot
{

    protected $table = 'medical_examination_medical_test';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'medical_examination_id',
        'medical_test_id',
        'value',
    ];

    public function medicalTest(): HasOne
    {
        return $this->hasOne(MedicalTest::class, 'id', 'medical_test_id');
    }

    public function medicalExamination(): HasOne
    {
        return $this->hasOne(MedicalExamination::class, 'id', 'medical_examination_id');
    }

}
