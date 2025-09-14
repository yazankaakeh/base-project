<?php

namespace Modules\Core\app\Enums;

use Illuminate\Contracts\Translation\Translator;
use Modules\Core\app\Traits\OptimizeEnumTrait;

enum UserStatusEnum: int
{
    use OptimizeEnumTrait;

    case ACTIVE = 1;
    case DEACTIVATE = 0;

    public function label(): array|string|Translator
    {
        return trans('doctor::doctor.enum.UserStatusEnum.'.$this->value);
    }

    public function class(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::DEACTIVATE => 'danger',
        };
    }
}
