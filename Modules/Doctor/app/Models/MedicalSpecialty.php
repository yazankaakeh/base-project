<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Doctor\Database\Factories\MedicalSpecialtyFactory;
use Modules\Doctor\Enums\MedicalSpecialtyCodeEnum;
use Spatie\Translatable\HasTranslations;

/**
 * @property mixed $id
 */
class MedicalSpecialty extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['name'];
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'code',
        'is_active',
    ];
    protected $casts = [
        'code' => MedicalSpecialtyCodeEnum::class,
        'is_active' => ActiveEnum::class,
    ];

    protected static function newFactory(): MedicalSpecialtyFactory
    {
        return MedicalSpecialtyFactory::new();
    }
}
