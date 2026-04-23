<?php

use Modules\AdminManagement\Enums\ActiveAdminEnum;

/**
 * user_management.php
 *
 * The ActiveAdminEnum::label() method translates through
 * `adminmanagement::user_management.ActiveAdminEnum.{value}`, so this file
 * exists specifically to resolve that key. The admin_management.php file
 * carries the rest of the module's translations — keep this one focused
 * on the enum so both namespaces resolve cleanly.
 */
return [
    'ActiveAdminEnum' => [
        ActiveAdminEnum::ACTIVE->value    => 'Active',
        ActiveAdminEnum::DE_ACTIVE->value => 'Inactive',
    ],
];
