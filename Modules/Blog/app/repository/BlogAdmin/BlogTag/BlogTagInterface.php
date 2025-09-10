<?php

namespace Modules\Blog\App\repository\BlogAdmin\BlogTag;

use Modules\Blog\app\Http\Requests\BlogTagRequest;

interface BlogTagInterface
{

  public function store(BlogTagRequest $request);

  public function index();

  public function update(BlogTagRequest $request);

  public function delete(int $id);
}
