<?php

use Modules\CMS\Enums\PageStatusEnum;
use Modules\CMS\Enums\PageTemplateEnum;

return [
    'PageStatusEnum' => [
        PageStatusEnum::DRAFT->value => 'Draft',
        PageStatusEnum::PUBLISHED->value => 'Published',
        PageStatusEnum::ARCHIVED->value => 'Archived',
    ],
    'PageTemplateEnum' => [
        PageTemplateEnum::DEFAULT->value => 'Default',
        PageTemplateEnum::FULL_WIDTH->value => 'Full Width',
        PageTemplateEnum::LANDING->value => 'Landing Page',
        PageTemplateEnum::CONTACT->value => 'Contact Page',
    ],
];
