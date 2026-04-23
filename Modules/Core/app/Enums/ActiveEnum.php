<?php

namespace Modules\Core\App\Enums;

use Modules\Core\app\Traits\OptimizeEnumTrait;

enum ActiveEnum: int
{
    use OptimizeEnumTrait;

    case ACTIVE = 1;
    case INACTIVE = 0;

    public function label(): string
    {
        return trans('core::core.enum.ActiveClinic.' . $this->value);
    }

    public function class(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'danger',
        };
    }
}
