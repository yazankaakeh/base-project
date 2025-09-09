<?php

namespace Modules\Blog\app\repository\BlogAdmin\BlogCategory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Modules\Blog\app\Http\Requests\BlogCategoryRequest;
use Modules\Blog\app\Models\BlogCategory;

class BlogCategoryRepository implements BlogCategoryInterface
{

  public function store(BlogCategoryRequest $request): void
  {
    $img = uploadFile($request->file('img'), '/img/categories');
    $slug = Str::slug($request->langs['en']['name'], "-");
    /** @var BlogCategory $category */
    $category = BlogCategory::query()->create([
      'parent_id' => $request->parent_id,
      'img' => $img,
      'slug' => $slug,
      'is_active' => $request->is_active == 'on' ? 1 : 0
    ]);
    foreach ($request->langs as $locale => $attributes) {
      $category->storeOrUpdateTranslation($locale, $attributes);
    }
  }

  public function index(): Builder
  {
    return BlogCategory::query()
      ->with('translations')
      ->with('parent');
  }

  public function update(BlogCategoryRequest $request): void
  {
    /** @var BlogCategory $category */
    $category = BlogCategory::query()->find($request->id);
    if ($request->file('img')) {
      deleteFile($category->img);
      $img = uploadFile($request->file('img'), '/img/categories');
      $category->img = $img;
    }
    $slug = Str::slug($request->langs['en']['name'], "-");
    $category->parent_id = $request->parent_id;
    $category->slug = $slug;
    $category->is_active = $request->is_active == 'on' ? 1 : 0;
    $category->save();
    foreach ($request->langs as $locale => $attributes) {
      $category->storeOrUpdateTranslation($locale, $attributes);
    }
  }

  public function delete()
  {
  }
}
