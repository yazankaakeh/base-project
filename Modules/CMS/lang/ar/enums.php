<?php

use Modules\CMS\Enums\PageStatusEnum;
use Modules\CMS\Enums\PageTemplateEnum;

return [
    'PageStatusEnum' => [
        PageStatusEnum::DRAFT->value => 'مسودة',
        PageStatusEnum::PUBLISHED->value => 'منشور',
        PageStatusEnum::ARCHIVED->value => 'مؤرشف',
    ],
    'PageTemplateEnum' => [
        PageTemplateEnum::DEFAULT->value => 'افتراضي',
        PageTemplateEnum::FULL_WIDTH->value => 'عرض كامل',
        PageTemplateEnum::LANDING->value => 'صفحة هبوط',
        PageTemplateEnum::CONTACT->value => 'صفحة الاتصال',
    ],
];
