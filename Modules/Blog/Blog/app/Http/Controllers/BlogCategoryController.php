<?php

namespace Modules\Blog\app\Http\Controllers;

use App\Enum\Pagination;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Blog\app\Http\Requests\BlogCategoryRequest;
use Modules\Blog\app\repository\BlogAdmin\BlogCategory\BlogCategoryInterface;
use Modules\Blog\app\repository\BlogAdmin\BlogCategory\BlogCategoryRepository;

class BlogCategoryController extends Controller
{
  public function __construct(public BlogCategoryInterface $blogCategoryRepository)
  {

  }

  /**
   * Display a listing of the resource.
   */
  public function index(): View|\Illuminate\Foundation\Application|Factory|Application
  {
    /** @var BlogCategoryRepository $repo */
    $repo = $this->blogCategoryRepository;
    return view('blog::BlogAdmin.categories.index',
      ['categories' => $repo->index()->paginate(Pagination::PAG->value)]);
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(BlogCategoryRequest $request): RedirectResponse
  {
    /** @var BlogCategoryRepository $repo */
    $repo = $this->blogCategoryRepository;
    $repo->store($request);
    return redirect()->route('blogCategory.category.index');
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(BlogCategoryRequest $request): RedirectResponse
  {
    /** @var BlogCategoryRepository $repo */
    $repo = $this->blogCategoryRepository;
    $repo->update($request);
    return redirect()->route('blogCategory.category.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    //
  }
}
