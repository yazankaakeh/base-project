<?php

namespace Modules\Doctor\Enums;

use Modules\Core\app\Traits\OptimizeEnumTrait;

enum MedicalExaminationStatusEnum: int
{
    use OptimizeEnumTrait;

    case ACTIVE = 1;
    case DONE = 2;
    case PENDING = 3;
    case ARCHIVED = 4;

    // case DONE = 3;
    public function label(): array|string
    {
        return trans('doctor::doctor.enum.MedicalExaminationStatusEnum.'.$this->value);
    }

    public function class(): array|string
    {
        return match ($this) {
            self::ACTIVE => 'primary',
            self::DONE => 'secondary',
            self::PENDING => 'info',
            self::ARCHIVED => 'warning',
        };
    }
}
