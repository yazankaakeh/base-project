<?php

namespace Modules\Doctor\Http\Controllers;

use App\Enum\Pagination;
use App\Http\Controllers\Controller;
use Modules\Core\App\Enums\ActiveEnum;
use Modules\Doctor\Enums\MedicalExaminationStatusEnum;
use Modules\Doctor\Models\MedicalExamination;
use Modules\Doctor\Models\Patient;

class MedicalExaminationController extends Controller
{
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
            ->where(['id' => $patientId, 'is_active' => ActiveEnum::ACTIVE->value])
            ->first();
        $medicalExamination = MedicalExamination::query()->updateOrCreate([
            'patient_id' => $patientId,
            'status' => MedicalExaminationStatusEnum::PENDING->value,
            'doctor_id' => auth()->id(),
        ], ['clinic_id' => $patient->clinics->first()->id]);
        return redirect()->route('doctor.medicalExamination.create', $medicalExamination->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($medicalExaminationId)
    {
        /** @var MedicalExamination $medicalExamination */
        $medicalExamination = MedicalExamination::query()->findOrFail($medicalExaminationId);
        $patient = $medicalExamination->patient;
        return view(
            'doctor::doctor.medicalExamination.create',
            compact('patient', 'medicalExamination'),
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
