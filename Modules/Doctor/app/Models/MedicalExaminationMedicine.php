<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;


class MedicalExaminationMedicine extends Pivot
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
        'note',
    ];


}
