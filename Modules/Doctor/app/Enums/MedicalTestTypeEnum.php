<?php

namespace Modules\Doctor\Enums;

use Modules\Core\app\Traits\OptimizeEnumTrait;

enum MedicalTestTypeEnum: int
{
    use OptimizeEnumTrait;

    case LABORATORY_TESTS = 1;
    case RADIOLOGY_TESTS = 0;

    public function label(): array|string
    {
        return trans('doctor::doctor.enum.MedicalTestTypeEnum.'.$this->value);
    }

    public function class(): string
    {
        return match ($this) {
            self::LABORATORY_TESTS => 'success',
            self::RADIOLOGY_TESTS => 'primary',
        };
    }
}
