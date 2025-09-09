<?php

namespace Modules\Blog\app\repository\BlogAdmin\BlogTag;

use Illuminate\Database\Eloquent\Builder;
use Modules\Blog\app\Http\Requests\BlogTagRequest;
use Modules\Blog\app\Models\BlogTag;

class BlogTagRepository implements BlogTagInterface
{

  public function store(BlogTagRequest $request): void
  {
    /** @var BlogTag $tag */
    $tag = BlogTag::query()->create();
    foreach ($request->langs as $locale => $attributes) {
      $tag->storeOrUpdateTranslation($locale, $attributes);
    }
  }

  public function index(): Builder
  {
    return BlogTag::query()
      ->with('Translations');
  }

  public function update(BlogTagRequest $request): void
  {
    /** @var BlogTag $tag */
    $tag = BlogTag::query()->find($request->id);
    foreach ($request->langs as $locale => $attributes) {
      $tag->storeOrUpdateTranslation($locale, $attributes);
    }
  }


  public function delete(int $id): void
  {
    /*  @var BlogTag $blogTag */
    $blogTag = BlogTag::query()->find($id);
    $posts = $blogTag->Posts;
    if ($posts->count() > 0) {
      $blogTag->Posts()->detach($posts);
    }
    $blogTag->deleteTranslation();
    $blogTag->delete();
  }
}
