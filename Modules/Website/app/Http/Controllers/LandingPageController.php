<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\CMS\Actions\Page\GetHomePageAction;
use Modules\CMS\Repository\Panel\PanelInterface;

class LandingPageController extends Controller
{
    public function home(GetHomePageAction $action, PanelInterface $panelRepository): View|\Illuminate\Foundation\Application|Factory|Application
    {
        // Fetch the landing page from CMS using Action
        $landingPage = $action->handleOrFail();

        // Get current locale
        $locale = app()->getLocale();

        // Extract meta_data sections (used when the home page has NO CMS panels —
        // this keeps the out-of-box Codliy landing intact for fresh installs).
        $sections = $landingPage->meta_data ?? [];

        // Fetch active panels (Eloquent) with their items for the landing page.
        // We pass them directly so the unified dispatcher (website::panels.render)
        // can render them the same way as any other CMS page.
        $panels = $panelRepository->getActiveByPage($landingPage->id);

        // Keep `$panelsData` as a lightweight array mirror for any legacy
        // partials that still read from it. New/updated partials should use
        // `$panels` (Eloquent) via the dispatcher instead.
        $panelsData = $panels->map(function ($panel) {
            return [
                'id'        => $panel->id,
                'type'      => $panel->type->value,
                'title'     => $panel->title ?? [],
                'settings'  => $panel->settings ?? [],
                'is_active' => $panel->is_active,
                'order'     => $panel->order,
                'media'     => [
                    'panel_image'   => $panel->getFirstMediaUrl('panel_image') ?: null,
                    'panel_gallery' => $panel->getMedia('panel_gallery')->map(fn($m) => $m->getUrl())->toArray(),
                ],
                'items' => $panel->activeItems->map(function ($item) {
                    return [
                        'id'        => $item->id,
                        'type'      => $item->type->value,
                        'title'     => $item->title ?? [],
                        'content'   => $item->content ?? [],
                        'data'      => $item->data ?? [],
                        'is_active' => $item->is_active,
                        'order'     => $item->order,
                        'media'     => [
                            'item_image'   => $item->getFirstMediaUrl('item_image') ?: null,
                            'item_gallery' => $item->getMedia('item_gallery')->map(fn($m) => $m->getUrl())->toArray(),
                        ],
                    ];
                })->toArray(),
            ];
        });

        return view('website::newLanding.home', compact(
            'landingPage',
            'sections',
            'locale',
            'panels',
            'panelsData',
        ));
    }

    public function privacy(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('website::newLanding.privacy');
    }

    public function hiHelloInfo(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('website::landing.hiHelloInfo');
    }

    public function hiHelloCreate(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('website::landing.hiHelloInfoCreate');
    }

    public function comingSoon(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('website::landing.soon');
    }

    public function hiHelloBlog(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('website::landing.blog');
    }

}
