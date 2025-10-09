<?php

use Modules\Blog\Enums\PostTypeEnum;

return [
    'enums' => [
        'PostTypeEnum' => [
            PostTypeEnum::ARCHIVED->value => 'Archived',
            PostTypeEnum::PUBLISHED->value => 'Published',
            PostTypeEnum::DRAFT->value => 'Draft',
            PostTypeEnum::PENDING->value => 'Pending',
        ],
    ],
    'category' => [
        'main_title' => 'Category',
        'create_title' => 'Create Category',
        'edit_title' => 'Edit Category',
        'title' => 'Category Title',
        'description' => 'Category Description',
    ],
    'post' => [
        'main_title' => 'Post',
        'create_title' => 'Create Post',
        'update_title' => 'Update Post',
        'title' => 'Post Title',
        'description' => 'Post Description',
        'type' => 'Post Type',
    ],
];
