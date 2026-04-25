<?php

namespace Modules\Core\App\Enums;

enum AddressEnum: string
{
    case USER = 'USER';
    case ADMIN = 'ADMIN';

    public function label(): string
    {
        return trans('core::core.env.cancel');
    }
}
