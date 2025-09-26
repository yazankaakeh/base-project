@php
    $page = 'sales-dashboard';
@endphp
@extends('theme::user.layouts.horizontalLayout')


<!-- Vendor Styles -->
@section('vendor-style')
    @livewireStyles
    @livewireScripts
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.scss'],
            'build/modules/theme')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
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
                    dropdownParent: $(this).closest('.modal'),
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
    @includeIf('doctor::doctor.medicalExamination.modals.uploadFileModal',['model' => $patient])
    @vite(['resources/assets/js/forms-file-upload.js'],'build/modules/theme')
@endsection
@section('title', trans('customer.sidebar.patients'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <p class="demo-inline-spacing">
                <button class="btn btn-primary" type="button"
                        data-bs-toggle="modal" data-bs-target="#uploadFile">
                    <i class="me-2 ti icon-base tabler-upload"></i>
                    {{trans('doctor::doctor.medicalExaminations.uploadFile')}}
                </button>
                <a target="_blank" class="btn btn-primary"
                   href="{{route('doctor.patients.downloadVCard',['id' => $patient->id])}}">
                    <i class="me-2 ti icon-base tabler-address-book"></i>
                    {{trans('doctor::doctor.patients.downloadVCard')}}
                </a>
            </p>
            <div class="row">
                <!-- User Sidebar -->
                <div class="col-xl-4 col-lg-4 col-md-5 order-1 order-md-0">
                    @includeIf('doctor::doctor.medicalExamination.partials.patientCard',['patient' => $patient])
                </div>

                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <ul class="nav nav-pills flex-column flex-md-row mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" role="tab" data-bs-toggle="tab"
                               data-bs-target="#medicalPreview"
                               aria-controls="medicalPreview" aria-selected="true">
                                <i class="ti tabler-user-check tabler-xs me-1"></i>
                                {{trans('doctor::doctor.medicalExaminations.card.medicalPreview')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" role="tab" data-bs-toggle="tab"
                               data-bs-target="#files"
                               aria-controls="files" aria-selected="false">
                                <i class="ti tabler-lock tabler-xs me-1"></i>
                                {{trans('doctor::doctor.parts.files.title')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab"
                               data-bs-target="#finalDiagnosis"
                               aria-controls="finalDiagnosis" aria-selected="false">
                                <i class="ti tabler-currency-dollar tabler-xs me-1"></i>
                                {{trans('doctor::doctor.medicalExaminations.card.finalDiagnosis')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab"
                               data-bs-target="#clinics"
                               aria-controls="clinics" aria-selected="false">
                                <i class="ti tabler-bell tabler-xs me-1"></i>
                                {{trans('doctor::doctor.patients.clinics')}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content m-0 p-0">
                        <div class="tab-pane rounded-pill fade show active" id="medicalPreview" role="tabpanel">
                            <div class="row text-start card">
                                @foreach($medicalExaminations as $medicalExamination)
                                    <div class="card-text mb-3">
                                        @includeIf('doctor::doctor.medicalExamination.partials.medicalExamination',['medicalExam' => $medicalExamination])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="files" role="tabpanel">
                            <div class="row text-start card">
                                @includeIf('doctor::doctor.medicalExamination.partials.files',['model'=> $patient])
                            </div>
                        </div>
                        <div class="tab-pane fade" id="finalDiagnosis" role="tabpanel">
                            <div class="row text-start card">
                                <h5 class="card-header card-title">
                                    {{trans('doctor::doctor.medicalExaminations.card.finalDiagnosis')}}</h5>
                                <div class="card-text my-4">

                                    @foreach($patient->final_diagnosis_names as $finalDiagnose)
                                        <span class="badge text-bg-danger m-2 h5">{{$finalDiagnose}}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="clinics" role="tabpanel">
                            <div class="row text-start card">
                                <h5 class="card-header card-title">{{trans('doctor::doctor.patients.clinics')}}</h5>
                                <div class="card-text my-4">
                                    @foreach($patient->clinics as $clinic)
                                        <span class="badge h5 m-2"> {{$clinic->name}} </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ User Content -->
            </div>
        </div>
    </div>
@endsection