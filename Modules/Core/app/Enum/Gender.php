<?php

namespace Modules\Core\App\Enum;

use Illuminate\Contracts\Translation\Translator;
use Modules\Core\app\Traits\OptimizeEnumTrait;

enum Gender: int
{
    use OptimizeEnumTrait;

    case MALE = 1;
    case FEMALE = 0;

    public function label(): array|string|Translator
    {
        return trans('mps::mps.enums.Gender.'.$this->value);
    }
}
