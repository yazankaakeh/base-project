<?php

namespace Modules\Website\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\CMS\Actions\Page\GetHomePageAction;

class LandingPageController extends Controller
{
    public function home(GetHomePageAction $action): View|\Illuminate\Foundation\Application|Factory|Application
    {
        // Fetch the landing page from CMS using Action
        $landingPage = $action->handleOrFail();

        // Get current locale
        $locale = app()->getLocale();

        // Extract meta_data sections
        $sections = $landingPage->meta_data ?? [];

        return view('website::newLanding.home', compact('landingPage', 'sections', 'locale'));
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
