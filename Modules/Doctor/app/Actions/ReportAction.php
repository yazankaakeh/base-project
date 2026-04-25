<?php

namespace Modules\Doctor\Actions;

use Modules\Doctor\Models\Clinic;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Models\MedicalExamination;
use Modules\Doctor\Models\Patient;

class ReportAction
{
    public static function getReports($doctorId): array
    {
        $numberOfDoctors = Doctor::query()->count();
        $numberOfPatients = Patient::query()->count();
        $numberOfClinics = Clinic::query()->count();
        $numberOfMedicalPreviews = MedicalExamination::query()->count();

        return [
            'numberOfDoctors' => $numberOfDoctors,
            'numberOfPatients' => $numberOfPatients,
            'numberOfClinics' => $numberOfClinics,
            'numberOfMedicalPreviews' => $numberOfMedicalPreviews,
        ];
    }
}
