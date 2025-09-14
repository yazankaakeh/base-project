<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicPatient extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'clinic_id',
        'patient_id',
    ];

}
