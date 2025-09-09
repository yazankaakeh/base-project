<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;


class MedicalExaminationMedicalTest extends Model
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

}
