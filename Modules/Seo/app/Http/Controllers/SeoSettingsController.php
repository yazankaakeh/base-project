<?php

namespace Modules\Seo\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Seo\Http\Requests\SeoSettingsRequest;
use Modules\Seo\Models\SeoSettings;

class SeoSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SeoSettings::query()->get();
        return view('seo::index', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeoSettingsRequest $request) {}


}
