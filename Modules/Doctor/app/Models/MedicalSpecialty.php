<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Doctor\Database\Factories\MedicalSpecialtyFactory;

class MedicalSpecialty extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
    ];

    protected static function newFactory(): MedicalSpecialtyFactory
    {
        return MedicalSpecialtyFactory::new();
    }
}
