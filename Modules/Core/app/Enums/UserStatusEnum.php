<?php

namespace Modules\Core\app\Enums;

use Illuminate\Contracts\Translation\Translator;

enum UserStatusEnum: int
{
    case ACTIVE = 1;
    case DEACTIVATE = 0;

    public function label(): array|string|Translator
    {
        return trans('customer.enum.UserStatusEnum.'.$this->value);
    }
}
