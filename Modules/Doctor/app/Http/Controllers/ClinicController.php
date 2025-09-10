<?php

namespace Modules\Doctor\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Doctor\Http\Requests\ClinicRequest;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('doctor::index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClinicRequest $request) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(ClinicRequest $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
