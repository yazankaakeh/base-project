<?php

namespace Modules\Doctor\Http\Controllers;

use App\Enum\Pagination;
use App\Http\Controllers\Controller;
use Modules\Doctor\Http\Requests\ClinicRequest;
use Modules\Doctor\Models\Clinic;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Clinic::query()->paginate(Pagination::PAG->value);
        return view('doctor::doctor.clinics.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClinicRequest $request)
    {
        /** @var Clinic $clinic */
        $clinic = Clinic::query()->create([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);
        if ($request->file('img')) {
            $clinic->addMedia($request->file('img'))->toMediaCollection('images');
        }
        return redirect()->route('doctor.clinic.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClinicRequest $request)
    {
        /** @var Clinic $clinic */
        $clinic = Clinic::query()->where('id', $request->id)->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
        ]);
        if ($request->file('img')) {
            $clinic->addMedia($request->file('img'))->toMediaCollection('images');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
