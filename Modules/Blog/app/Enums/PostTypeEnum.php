<?php

namespace Modules\Blog\Enums;

use Modules\Core\app\Traits\OptimizeEnumTrait;

enum PostTypeEnum: int
{
    use OptimizeEnumTrait;

    case ARCHIVED = 0;
    case PUBLISHED = 1;
    case DRAFT = 2;
    case PENDING = 3;

    public function label(): string
    {
        return trans('blog::blog.enums.PostTypeEnum.'.$this->value);
    }
}
