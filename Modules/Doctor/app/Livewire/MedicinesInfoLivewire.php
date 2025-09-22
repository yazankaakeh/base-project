<?php

namespace Modules\Doctor\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;
use Modules\Core\app\Traits\OptimizeLivewireTrait;
use Modules\Doctor\Models\MedicalExamination;
use Modules\Doctor\Models\MedicalExaminationMedicine;
use Modules\Doctor\Models\Medicine;

class MedicinesInfoLivewire extends Component
{
    use OptimizeLivewireTrait;

    public string $componentName = 'MedicinesInfoLivewire';
    public mixed $medicines;
    public mixed $medicinesArray = [0];
    public int $medicalExaminationId;
    public MedicalExamination $medicalExamination;
    /** مصفوفة الصفوف المكررة */
    public array $medicinesData = [
        // صف افتراضي واحد
        [
            'medicine_id' => null,     // required | exists:medicines,id   (select2)
            'dosage' => null,     // required | string | max:100
            'type' => null,     // required | string | max:255
            'count' => 1,        // required | integer|min:1|max:1000
            'note' => null,     // nullable | string | max:500
        ],
    ];

    public function increase(): void
    {
        $this->medicinesData[] = [
            'medicine_id' => null,
            'dosage' => null,
            'type' => null,
            'count' => 1,
            'note' => null,
        ];
        $this->dispatch('reRenderSelect2');
        $this->dispatch('initSelect2');
    }

    public function mount($medicalExaminationId): void
    {
        $this->medicalExamination = MedicalExamination::query()->find($medicalExaminationId);

        $this->medicinesData = MedicalExaminationMedicine::query()->where([
            'medical_examination_id' => $this->medicalExamination->id,
        ])->get()->toArray();
    }


    public function decrease($index): void
    {
        unset($this->medicinesData[$index]);
        $this->medicinesData = array_values($this->medicinesData);
        $this->dispatch('reRenderSelect2');
        $this->dispatch('initSelect2');
    }

    public function save(): void
    {
        $validated = $this->validate();

        $syncPayload = [];

        foreach ($validated['medicinesData'] as $row) {
            $drugId = (int)$row['medicine_id'];
            $syncPayload[$drugId] = [
                'dosage' => $row['dosage'],
                'type' => $row['type'],
                'count' => (int)$row['count'],
                'note' => $row['note'],
            ];
        }

        $this->medicalExamination->medicines()->sync($syncPayload);

        $this->dispatch('toast:show', [
            'type' => 'success',
            'message' => 'تم حفظ الأدوية بنجاح.',
        ]);
    }

    public function render(): Factory|View
    {
        $this->medicines = Medicine::getMedicinesSelect2();
        return view('doctor::livewire.medicines-info-livewire');
    }

    protected function rules(): array
    {
        return [
            'medicinesData' => ['required', 'array', 'min:1'],
            'medicinesData.*.medicine_id' => ['required', 'integer', 'exists:medicines,id'],
            'medicinesData.*.dosage' => ['required', 'string', 'max:100'],
            'medicinesData.*.type' => ['required', 'string', 'max:255'],
            'medicinesData.*.count' => ['required', 'integer', 'min:1', 'max:1000'],
            'medicinesData.*.note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
