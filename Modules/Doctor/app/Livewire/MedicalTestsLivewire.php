<?php

namespace Modules\Doctor\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Core\app\Traits\OptimizeLivewireTrait;
use Modules\Doctor\Enums\MedicalTestTypeEnum;
use Modules\Doctor\Models\MedicalExamination;
use Modules\Doctor\Models\MedicalExaminationMedicalTest;
use Modules\Doctor\Models\MedicalTest;
use Throwable;

class MedicalTestsLivewire extends Component
{
    use OptimizeLivewireTrait;

    public string $title;
    public string $onChangeEvent;
    public string $componentName;
    public int $medicalExaminationId;
    public MedicalExamination $medicalExamination;
    public mixed $medicalTests;
    public mixed $addedMedicalTests;
    public string $name;
    public MedicalTestTypeEnum $type;
    public mixed $listMedicalTests = [];
    public array $listMedicalTestsValues = [
        'value',
        'file',
    ];


    /**
     * @throws Throwable
     */
    #[On('laboratoryTestsUpdated')]
    public function laboratoryTestsUpdated($value): void
    {
        if ($value) {
            $this->addedMedicalTests[] = $value;
            $this->syncTestsForType(
                $this->medicalExamination,
                MedicalTestTypeEnum::LABORATORY_TESTS->value,
                $value,  // array of IDs the user selected for LAB
            );
            $this->updateMedicalTests();
            $this->dispatch('initSelect2');
        }
        $this->dispatch('reRenderSelect2');
    }

    /**
     * @throws Throwable
     */
    public function syncTestsForType(MedicalExamination $exam, string $typeValue, array $ids): void
    {
        DB::transaction(function () use ($exam, $typeValue, $ids) {
            // allow only IDs that really belong to this type
            $desired = MedicalTest::query()
                ->where('type', $typeValue)
                ->whereIn('id', $ids)
                ->pluck('id')
                ->all();

            // read current attached IDs for THIS type via the scoped relation
            $current = $exam
                ->medicalTests()
                ->where('medical_tests.type', $typeValue)
                ->pluck('medical_tests.id')
                ->all();

            $desired = array_values(array_unique(array_map('intval', $desired)));
            $current = array_values(array_unique(array_map('intval', $current)));

            $toAttach = array_diff($desired, $current);
            $toDetach = array_diff($current, $desired);

            if ($toDetach) {
                // detach ONLY these IDs (other types remain intact)
                $exam->medicalTests()->detach($toDetach);
            }
            if ($toAttach) {
                $exam->medicalTests()->attach($toAttach);
            }
        });
    }

    public function updateMedicalTests(): void
    {
        $this->listMedicalTests = MedicalExaminationMedicalTest::query()->whereHas('medicalTest', function ($query) {
            $query->where('type', $this->type);
        })->get();
    }

    /**
     * @throws Throwable
     */
    #[On('radiologyTestsUpdated')]
    public function radiologyTestsUpdated($value): void
    {
        if ($value) {
            $this->addedMedicalTests[] = $value;
            //$this->medicalExamination->radiologyTests()->sync($value);
            $this->syncTestsForType(
                $this->medicalExamination,
                MedicalTestTypeEnum::RADIOLOGY_TESTS->value,
                $value,  // array of IDs the user selected for LAB
            );
            $this->updateMedicalTests();
            $this->dispatch('initSelect2');
        }
        $this->dispatch('reRenderSelect2');
    }

    public function mount($medicalExaminationId): void
    {
        $this->medicalExamination = MedicalExamination::query()->find($medicalExaminationId);
        if ($this->type == MedicalTestTypeEnum::LABORATORY_TESTS) {
            $addedMedicalTests = $this->medicalExamination->medicalTests->where(
                'type',
                MedicalTestTypeEnum::LABORATORY_TESTS,
            )->pluck('id')->toArray();
            $medicalTests = MedicalTest::getLaboratorySelect2();
            $this->onChangeEvent = 'laboratoryTestsUpdated';
        } else {
            $this->onChangeEvent = 'radiologyTestsUpdated';
            $addedMedicalTests = $this->medicalExamination->medicalTests->where(
                'type',
                MedicalTestTypeEnum::RADIOLOGY_TESTS,
            )->pluck('id')->toArray();
            $medicalTests = MedicalTest::getRadiologySelect2();
        }
        $this->medicalTests = $medicalTests;
        $this->addedMedicalTests = $addedMedicalTests;
        $this->addValueToSelect2($this->name, $this->addedMedicalTests, true);
        $this->updateMedicalTests();
        $this->componentName = 'MedicalTestsLivewire'.$this->type->label();
    }

    public function render(): Factory|View
    {
        return view('doctor::livewire.medical-tests-livewire');
    }
}
