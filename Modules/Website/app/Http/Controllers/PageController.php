<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Modules\CMS\Models\Page;

class PageController extends Controller
{
    /**
     * Display the specified CMS page.
     */
    public function show(string $slug): View
    {
        $locale = app()->getLocale();

        $page = Page::published()
            ->bySlug($slug)
            ->with([
                'activePanels.activeItems.media',
                'activePanels.media',
                'media',
                'parent.children' => function ($query) {
                    $query->published()->orderBy('order');
                },
                'children' => function ($query) {
                    $query->published()->orderBy('order');
                },
            ])
            ->firstOrFail();

        return view('website::page.show', compact('page', 'locale'));
    }
}
