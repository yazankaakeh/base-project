<?php

use Modules\Blog\Enums\PostTypeEnum;

return [
    'enums' => [
        'PostTypeEnum' => [
            PostTypeEnum::ARCHIVED->value => 'Archived',
            PostTypeEnum::PUBLISHED->value => 'Published',
            PostTypeEnum::DRAFT->value => 'Draft',
            PostTypeEnum::PENDING->value => 'Pending',
            PostTypeEnum::FEATURED->value => 'Featured',
        ],
    ],
    'category' => [
        'main_title' => 'Category',
        'create_title' => 'Create Category',
        'edit_title' => 'Edit Category',
        'title' => 'Category Title',
        'image' => 'Category Image',
        'description' => 'Category Description',
    ],
    'post' => [
        'main_title' => 'Post',
        'create_title' => 'Create Post',
        'update_title' => 'Update Post',
        'create' => 'Create Post',
        'edit' => 'Edit Post',
        'title' => 'Post Title',
        'titlePlaceholder' => 'Enter post title...',
        'content' => 'Post Content',
        'contentPlaceholder' => 'Write your post content here...',
        'image' => 'Post Image',
        'description' => 'Post Description',
        'type' => 'Post Type',
        'relatedPost' => 'Related Post',
        'tags' => 'Tags',
        'selectTags' => 'Select tags...',
        'selectRelatedPosts' => 'Select related posts...',
        'quickCreate' => 'Quick Create Post',
    ],
    'seo' => [
        'title' => 'SEO Settings',
        'titlePlaceholder' => 'Enter SEO title...',
        'description' => 'SEO Description',
        'descriptionPlaceholder' => 'Enter SEO description...',
    ],
    'tag' => [
        'main_title' => 'Tags',
        'create' => 'Create Tag',
        'edit' => 'Edit Tag',
        'name' => 'Tag Name',
        'no_tags' => 'No tags found',
    ],
];
