<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;


class MedicalExaminationVitalSign extends Model
{

    protected $table = 'medical_examination_vital_sign';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'vital_sign_id',
        'medical_examination_id',
        'value',
    ];
    protected $casts = [
        'value' => 'string',
    ];

}
