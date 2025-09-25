<?php

namespace Modules\Doctor\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Doctor\Models\MedicalExamination;
use Modules\Doctor\Traits\PDFTrait;
use Spatie\Browsershot\Browsershot;
use Throwable;

class PDFController extends Controller
{
    use PDFTrait;

    // Helper: inject built pdf.css if you're using html() mode

    /**
     * @throws Throwable
     */
    public function downloadMedicines(int $id)
    {
        $medicalExamination = MedicalExamination::query()
            ->with('patient')
            ->with('medicines')
            ->find($id);
        $html = view('doctor::pdf.medicines', compact('medicalExamination'))
            ->render();

        $pdf = Browsershot::html($this->injectPdfCss($html))
            ->showBackground()
            ->format('A4')
            ->margins(12, 12, 20, 12)
            ->waitUntilNetworkIdle()
            ->pdf();

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename=invoice-{$medicalExamination->id}.pdf",
        ]);
    }

    /**
     * @throws Throwable
     */
    public function downloadMedicalTest(int $id)
    {
        $medicalExamination = MedicalExamination::query()
            ->with('patient')
            ->with('medicalTests')
            ->find($id);
        $html = view('doctor::pdf.medical_test', compact('medicalExamination'))
            ->render();

        $pdf = Browsershot::html($this->injectPdfCss($html))
            ->showBackground()
            ->format('A4')
            ->margins(12, 12, 20, 12)
            ->waitUntilNetworkIdle()
            ->pdf();

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename=invoice-{$medicalExamination->id}.pdf",
        ]);
    }

}
