<?php

namespace Modules\CMS\Repository\Page;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\CMS\Models\Page;

interface PageInterface
{
    public function index(): LengthAwarePaginator;

    public function store(Request $request): Page;

    public function update(int $id, Request $request): Page;

    public function find(int $id): Page;

    public function findBySlug(string $slug): ?Page;

    public function destroy(int $id): void;

    public function getParentOptions(): array;

    public function getHomePage(): ?Page;
}
