<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Model;


class MedicalExaminationMedicine extends Model
{
    protected $table = 'medical_examination_medicine';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'medicine_id',
        'medical_examination_id',
        'type',
        'dosage',
        'count',
    ];


}
