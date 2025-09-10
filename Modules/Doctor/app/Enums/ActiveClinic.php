<?php

namespace Modules\Doctor\Enums;

use Illuminate\Contracts\Translation\Translator;
use Modules\Core\app\Traits\OptimizeEnumTrait;

enum ActiveClinic: int
{
    use OptimizeEnumTrait;

    case ACTIVE = 1;
    case INACTIVE = 0;

    public function label(): array|string|Translator
    {
        return trans('doctor::doctor.enum.ActiveClinic.'.$this->value);
    }
}
