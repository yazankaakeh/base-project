<?php

namespace Modules\Theme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class LandingPageController extends Controller
{
    public function home(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('theme::newLanding.home');
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
