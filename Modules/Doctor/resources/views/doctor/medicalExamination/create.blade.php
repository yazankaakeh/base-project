@php
    $page = 'sales-dashboard';
@endphp
@extends('theme::user.layouts.horizontalLayout')

<!-- Vendor Styles -->
@section('vendor-style')
    @livewireStyles
    @livewireScripts

    @vite([
    'resources/assets/vendor/libs/dropzone/dropzone.scss',
    'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'],
            'build/modules/theme')
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('.select2').each(function () {
                $(this).select2({
                    allowClear: true,
                    tags: false
                });
            });
        })
    </script>
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.js'],
'build/modules/theme')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js'],
'build/modules/theme')

@endsection

<!-- Page Scripts -->
@section('page-script')
    <script src="{{asset('livewire-select2/livewire-select2.js')}}"></script>
    @vite(['resources/assets/js/forms-file-upload.js'],'build/modules/theme')
    @includeIf('doctor::doctor.medicalExamination.modals.uploadFileModal',['model'=> MedicalExamination::class,'model_id' => $medicalExamination->id])
@endsection

@section('title', trans('customer.sidebar.medicalExaminations'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <livewire:doctor::vital-signs-livewire :medicalExamination="$medicalExamination"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    @includeIf('doctor::doctor.medicalExamination.partials.patientCard',['patient'=> $patient])
                    @includeIf('doctor::doctor.medicalExamination.partials.files',['model'=> $medicalExamination])
                    <div class="my-4">
                        <livewire:doctor::final-diagnosis-patient-livewire
                                :patientId="$patient->id"
                                name="finalDiagnose"
                                :medicalExamination="$medicalExamination"/>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{trans('doctor::doctor.medicalExaminations.medicalPreviewInfo')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <div class="row mb-3">
                                    <x-core::input label="doctor::doctor.medicalExaminations.reasonOfVisiting"
                                                   id="reason_of_visiting" name="reason_of_visiting"
                                                   type="text" model="reason_of_visiting">
                                    </x-core::input>
                                </div>
                                <div class="row my-3">
                                    <x-core::textarea label="doctor::doctor.medicalExaminations.clinical_examination"
                                                      id="clinical_examination" name="clinical_examination"
                                                      type="text" model="clinical_examination">
                                    </x-core::textarea>
                                </div>
                                <div class="row my-3">
                                    <div class="col-6">
                                        <x-core::input label="doctor::doctor.medicalExaminations.impression"
                                                       id="impression" name="impression"
                                                       type="text" model="impression">
                                        </x-core::input>
                                    </div>
                                    <div class="col-6">
                                        <x-core::input label="doctor::doctor.medicalExaminations.request_for_action"
                                                       id="request_for_action" name="request_for_action"
                                                       type="text" model="request_for_action">
                                        </x-core::input>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <x-core::textarea label="doctor::doctor.medicalExaminations.note"
                                                      id="note" name="note"
                                                      type="text" model="note">
                                    </x-core::textarea>
                                </div>
                                <div class="row my-3">
                                    <div class="col text-end">
                                        <button class="btn btn-success">
                                            <i class="ti me-2 icon-base tabler-progress-check"></i>
                                            {{trans('doctor::doctor.save')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-6">
                            <livewire:doctor::medical-tests-livewire
                                    :medicalExamination="$medicalExamination"
                                    :title="trans('doctor::doctor.medicalExaminations.laboratoryTests')"
                                    :type="\Modules\Doctor\Enums\MedicalTestTypeEnum::LABORATORY_TESTS"
                                    name="laboratoryTests"/>
                        </div>
                        <div class="col-6">
                            <livewire:doctor::medical-tests-livewire
                                    :medicalExamination="$medicalExamination"
                                    :title="trans('doctor::doctor.medicalExaminations.radiologyTests')"
                                    :type="\Modules\Doctor\Enums\MedicalTestTypeEnum::RADIOLOGY_TESTS"
                                    name="radiologyTests"/>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-12">
                            <livewire:doctor::medicines-info-livewire
                                    :medicalExamination="$medicalExamination"/>
                        </div>
                    </div>
                    <div class="row">
                        {{--<div class="col-12 my-4">
                            <livewire:doctor::final-diagnosis-patient-livewire
                                    :patientId="$patient->id"
                                    name="finalDiagnose"
                                    :medicalExamination="$medicalExamination"/>
                        </div>--}}
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($medicalExaminations as $medicalExam)
                    <div class="col-6 my-3">
                        @includeIf('doctor::doctor.medicalExamination.partials.medicalExamination',['medicalExam'=>$medicalExam])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

