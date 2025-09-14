<?php

namespace Modules\Doctor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Doctor\Database\Factories\MedicineFactory;

class Medicine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'is_active',
    ];
    protected $casts = [
        'is_active' => ActiveEnum::class,
    ];

    protected static function newFactory(): MedicineFactory
    {
        return MedicineFactory::new();
    }

    public function medicalExaminations(): BelongsToMany
    {
        return $this
            ->belongsToMany(MedicalExamination::class, 'medical_examination_medicine')
            ->withPivot('value')
            ->withTimestamps()
            ->using(MedicalExaminationMedicine::class); // optional
    }
}
