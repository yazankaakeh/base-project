<?php

namespace Modules\Blog\app\Http\Controllers;

use App\Enum\Pagination;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Blog\app\Http\Requests\BlogTagRequest;
use Modules\Blog\app\repository\BlogAdmin\BlogTag\BlogTagInterface;
use Modules\Blog\App\repository\BlogAdmin\BlogTag\BlogTagRepository;

class BlogTagController extends Controller
{
  public function __construct(public BlogTagInterface $blogTagRepository)
  {

  }

  /**
   * Display a listing of the resource.
   */
  public function index(): View|\Illuminate\Foundation\Application|Factory|Application
  {
    /** @var BlogTagRepository $repo */
    $repo = $this->blogTagRepository;
    $tags = $repo->index()->paginate(Pagination::PAG->value);
    return view('blog::BlogAdmin.tags.index', compact('tags'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(BlogTagRequest $request): RedirectResponse
  {
    /** @var BlogTagRepository $repo */
    $repo = $this->blogTagRepository;
    $repo->update($request);
    return redirect()->route('blogTags.tags.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id): RedirectResponse
  {
    /** @var BlogTagRepository $repo */
    $repo = $this->blogTagRepository;
    $repo->delete($id);
    return redirect()->route('blogTags.tags.index');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(BlogTagRequest $request): RedirectResponse
  {
    /** @var BlogTagRepository $repo */
    $repo = $this->blogTagRepository;
    $repo->store($request);
    return redirect()->route('blogTags.tags.index');
  }
}
