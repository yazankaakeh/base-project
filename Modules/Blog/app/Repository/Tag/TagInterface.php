<?php

namespace Modules\Blog\Repository\Tag;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Blog\Http\Requests\TagRequest;
use Modules\Blog\Models\BlogPostTags;

interface TagInterface
{
    public function index(): LengthAwarePaginator;

    public function store(TagRequest $request): BlogPostTags;

    public function update(int $id, TagRequest $request): BlogPostTags;

    public function find(int $id): BlogPostTags;

    public function destroy(int $id): void;

    public function getTagOptions(): array;
}
