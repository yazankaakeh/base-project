<?php

namespace Modules\Core\App\Enums;

use Illuminate\Contracts\Translation\Translator;

enum PrimaryAddressStatus: int
{
    case PRIMARY = 1;
    case NOT_PRIMARY = 0;

    public function label(): array|string|Translator
    {
        return trans('core::customer.enum.PrimaryAddressStatus.' . $this->value);
    }
}
