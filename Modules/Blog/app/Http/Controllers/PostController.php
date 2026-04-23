<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Blog\Http\Requests\PostRequest;
use Modules\Blog\Models\BlogCategory;
use Modules\Blog\Models\BlogPostTags;
use Modules\Blog\Repository\Post\PostInterface;

class PostController extends Controller
{
    public function __construct(public PostInterface $posts) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->posts->index();
        return view('blog::posts.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $relatedPostsOptions = $this->posts->getRelatedOptions();
        $tagOptions          = $this->getTagOptions();
        $categoryOptions     = $this->getCategoryOptions();

        return view('blog::posts.create', compact('relatedPostsOptions', 'tagOptions', 'categoryOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $this->posts->store($request);
        return redirect()->route('admin.posts.index')->with('success', trans('core::core.env.save'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = $this->posts->find($id);
        $relatedPostsOptions = $this->posts->getRelatedOptions($id);
        $tagOptions          = $this->getTagOptions();
        $categoryOptions     = $this->getCategoryOptions();

        return view('blog::posts.edit', compact('post', 'relatedPostsOptions', 'tagOptions', 'categoryOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, $id)
    {
        $this->posts->update($id, $request);
        return redirect()->route('admin.posts.index')->with('success', trans('core::core.env.save'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->posts->destroy($id);
        return redirect()->route('admin.posts.index')->with('success', trans('core::core.env.save'));
    }

    /**
     * Get tag options for select dropdown.
     */
    private function getTagOptions(): array
    {
        return BlogPostTags::all()->mapWithKeys(function ($tag) {
            $name = $tag->getTranslation('name', app()->getLocale());
            return [$tag->id => $name ?: 'Tag ' . $tag->id];
        })->toArray();
    }

    /**
     * Get category options for the post category select.
     * Returns [id => translated_title] for the active locale, sorted
     * alphabetically. The BlogCategory model's translatable field is
     * `title` (not `name`), so we read that; falls back to the fallback
     * locale then to a "Category {id}" placeholder so admins always see
     * something meaningful even for untranslated records.
     */
    private function getCategoryOptions(): array
    {
        $locale   = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        return BlogCategory::query()
            ->get()
            ->mapWithKeys(function (BlogCategory $category) use ($locale, $fallback) {
                $title = $category->getTranslation('title', $locale)
                    ?: $category->getTranslation('title', $fallback);

                return [$category->id => is_string($title) && filled($title)
                    ? $title
                    : 'Category #' . $category->id];
            })
            ->sort()
            ->toArray();
    }
}
