<?php

use Modules\CMS\Enums\PageStatusEnum;
use Modules\CMS\Enums\PageTemplateEnum;

return [
    'PageStatusEnum' => [
        PageStatusEnum::DRAFT->value => 'Taslak',
        PageStatusEnum::PUBLISHED->value => 'Yayınlandı',
        PageStatusEnum::ARCHIVED->value => 'Arşivlendi',
    ],
    'PageTemplateEnum' => [
        PageTemplateEnum::DEFAULT->value => 'Varsayılan',
        PageTemplateEnum::FULL_WIDTH->value => 'Tam Genişlik',
        PageTemplateEnum::LANDING->value => 'Açılış Sayfası',
        PageTemplateEnum::CONTACT->value => 'İletişim Sayfası',
    ],
];
