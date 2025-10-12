<?php

namespace Modules\Theme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\CMS\Enums\PageTemplateEnum;
use Modules\CMS\Models\Page;

class LandingPageController extends Controller
{
    public function home(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        // Fetch the landing page from CMS
        $landingPage = Page::query()->published()
            ->where('template', PageTemplateEnum::LANDING)
            ->where('slug', 'home')
            ->firstOrFail();

        // Get current locale
        $locale = app()->getLocale();

        // Extract meta_data sections
        $sections = $landingPage->meta_data ?? [];

        return view('theme::newLanding.home', compact('landingPage', 'sections', 'locale'));
    }

    public function privacy(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('theme::newLanding.privacy');
    }

    public function hiHelloInfo(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('theme::landing.hiHelloInfo');
    }

    public function hiHelloCreate(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('theme::landing.hiHelloInfoCreate');
    }

    public function comingSoon(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('theme::landing.soon');
    }

    public function hiHelloBlog(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('theme::landing.blog');
    }


}
