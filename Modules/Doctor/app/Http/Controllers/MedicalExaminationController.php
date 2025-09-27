<?php

namespace Modules\Doctor\Http\Controllers;

use App\Enum\Pagination;
use App\Http\Controllers\Controller;
use Modules\Doctor\Enums\MedicalExaminationStatusEnum;
use Modules\Doctor\Http\Requests\MedicalExaminationRequest;
use Modules\Doctor\Models\MedicalExamination;
use Modules\Doctor\Models\Patient;

class MedicalExaminationController extends Controller
{
    public function submit(MedicalExaminationRequest $request)
    {
        $data = $request->validated();
        $data['status'] = MedicalExaminationStatusEnum::DONE->value;
        MedicalExamination::query()->where('id', $request->id)
            ->update($data);

        return redirect()->back()->with('success', 'Medical Examination updated successfully');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MedicalExamination::query()->with('patient')->paginate(Pagination::PAG->value);
        return view('doctor::doctor.medicalExamination.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($patientId)
    {
        $patient = Patient::query()
            ->with('clinics')
            ->where(['id' => $patientId/*, 'is_active' => ActiveEnum::ACTIVE->value*/])
            ->first();
        $medicalExamination = MedicalExamination::query()->updateOrCreate([
            'patient_id' => $patientId,
            'status' => MedicalExaminationStatusEnum::PENDING->value,
            'doctor_id' => auth()->id(),
        ], ['clinic_id' => $patient?->clinics?->first()->id]);
        return redirect()->route('doctor.medicalExamination.create', $medicalExamination->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($medicalExaminationId)
    {
        /** @var MedicalExamination $medicalExamination */
        $medicalExamination = MedicalExamination::query()
            ->with('media')->with('patient')
            ->findOrFail($medicalExaminationId);
        $patient = $medicalExamination->patient;
        $medicalExaminations = MedicalExamination::patientMedicalExaminations($patient->id)->get();
        return view(
            'doctor::doctor.medicalExamination.create',
            compact('patient', 'medicalExamination', 'medicalExaminations'),
        );
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('doctor::doctor.medicalExamination.show');
    }
}
