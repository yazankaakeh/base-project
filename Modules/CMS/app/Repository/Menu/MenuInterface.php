<?php

namespace Modules\CMS\Repository\Menu;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\CMS\Models\Menu;

interface MenuInterface
{
    public function index(): LengthAwarePaginator;

    public function store(Request $request): Menu;

    public function update(int $id, Request $request): Menu;

    public function find(int $id): Menu;

    public function destroy(int $id): void;
}
