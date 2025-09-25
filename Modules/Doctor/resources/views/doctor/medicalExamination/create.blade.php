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
    @includeIf('doctor::doctor.medicalExamination.modals.uploadFileModal',['model'=>  $medicalExamination])
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
                    @includeIf('doctor::doctor.medicalExamination.partials.medicalPreview',['medicalExamination'=>$medicalExamination])
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

