<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Website\Actions\Blog\ClapBlogPostAction;
use Modules\Website\Actions\Blog\GetBlogPostAction;
use Modules\Website\Actions\Blog\GetBlogPostsAction;
use Modules\Website\Actions\Blog\GetCategoryPostsAction;
use Modules\Website\Actions\Blog\GetTagPostsAction;

class BlogFrontController extends Controller
{
    public function index(Request $request, GetBlogPostsAction $action): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $data = $action->handle($request);

        return view('website::blog.index', $data);
    }

    public function show(int $id, GetBlogPostAction $action): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $sessionId = session()->getId();
        $data = $action->handle($id, $sessionId);

        return view('website::blog.show', $data);
    }

    public function category(int $id, GetCategoryPostsAction $action): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $data = $action->handle($id);

        return view('website::blog.category', $data);
    }

    public function tag(int $id, GetTagPostsAction $action): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $data = $action->handle($id);

        return view('website::blog.tag', $data);
    }

    public function clap(Request $request, int $id, ClapBlogPostAction $action): JsonResponse
    {
        $result = $action->handle($request, $id);

        $statusCode = $result['success'] ? 200 : 429;

        return response()->json($result, $statusCode);
    }
}
