<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;

class FinalDiagnosisPatient extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'patient_id',
        'final_diagnosis_id',
    ];


}
