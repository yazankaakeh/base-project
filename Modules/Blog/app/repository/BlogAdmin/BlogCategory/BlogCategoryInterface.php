<?php

namespace Modules\Blog\app\repository\BlogAdmin\BlogCategory;

use Modules\Blog\app\Http\Requests\BlogCategoryRequest;

interface BlogCategoryInterface
{

  public function store(BlogCategoryRequest $request);

  public function index();

  public function update(BlogCategoryRequest $request);

  public function delete();
}
