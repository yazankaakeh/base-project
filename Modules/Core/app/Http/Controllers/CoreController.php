<?php

namespace Modules\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('core::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('core::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * This is a scaffolded nwidart stub — no routes point at it yet.
     * Until wired up, fail loudly so we catch premature callers in dev
     * instead of silently returning null (which PHPStan flagged).
     */
    public function store(Request $request): RedirectResponse
    {
        abort(501, 'CoreController::store is not implemented.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('core::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('core::edit');
    }

    /**
     * Update the specified resource in storage. Scaffolded stub — see
     * store() for the rationale on why this aborts rather than returning null.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        abort(501, 'CoreController::update is not implemented.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
