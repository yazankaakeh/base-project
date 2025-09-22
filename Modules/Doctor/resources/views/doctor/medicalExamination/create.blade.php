<?php

use Modules\Core\App\Enums\ActiveEnum;
use Modules\Core\app\Helpers\FileUploadHelper;

$page = 'sales-dashboard'; ?>
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
    {{--
      @vite(['resources/assets/js/form-wizard-numbered.js', 'resources/assets/js/form-wizard-validation.js'])
    --}}
@endsection
@section('title', trans('customer.sidebar.medicalExaminations'))

@php

    $phone   = $patient->phone ?? '';            // رقم المريض
    $digits  = FileUploadHelper::digits_only($phone);              // للتيليغرام (app)
    $waUrl   = FileUploadHelper::wa_link($phone, '90');            // غيّر 90 إلى 964 مثلاً للعراق إذا لازم
    $telUrl  = 'tel:' . $phone;
    $tgApp   = 'tg://resolve?phone=' . $digits;  // يفتح تطبيق تيليغرام مباشرةً
   // $tgWeb   = $patient->telegram_username ?? null; // إذا عندك يوزرنيم بالموديل

@endphp
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <livewire:doctor::vital-signs-livewire :medicalExaminationId="$medicalExamination->id"/>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-6">
                        <div class="card-body pt-12">
                            <div class="user-avatar-section">
                                <div class=" d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mb-4"
                                         src="{{$patient->getFirstMediaUrl('images') != null ? $patient->getFirstMediaUrl('images') : asset('assets/img/avatars/3.png')}}"
                                         height="120" width="120" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h5>{{$patient->name}}</h5>
                                        <span class="badge bg-{{$patient->is_active->class()}}">
                                             {{$patient->is_active->label()}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
                                <div class="d-flex align-items-center me-5 gap-4">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-label-primary rounded">
                                            <i class="icon-base ti tabler-checkbox icon-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{$patient->medicalExamination->count()}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-4">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-label-primary rounded">
                                            <i class="icon-base ti tabler-briefcase icon-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{$patient->work}}</h5>
                                    </div>
                                </div>
                            </div>
                            <h5 class="pb-4 border-bottom mb-4">{{trans('doctor::doctor.medicalExaminations.patientDetails')}}</h5>
                            <div class="info-container">
                                <ul class="list-unstyled mb-6">
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.id')}}:</span>
                                        <span>{{$patient->id}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.name')}}:</span>
                                        <span>{{$patient->name}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6 text-{{$patient->gender->class()}}">{{trans('doctor::doctor.patients.gender')}}:</span>
                                        <span class="text-{{$patient->gender->class()}}">{{$patient->gender->label()}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.age')}}:</span>
                                        <span>{{$patient->age}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.nationality_id')}}:</span>
                                        <span>{{$patient->nationality->name}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.email')}}:</span>
                                        <a href="mailto:{{$patient->email}}">{{$patient->email}}</a>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.phone')}}:</span>
                                        <span>
                                            <div class="btn-group">
                                                <button type="button"
                                                        class="btn btn-outline-primary dropdown-toggle waves-effect"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">{{$patient->phone}}</button>
                                                <ul class="dropdown-menu" style="">
                                                    <li>
                                                        <a class="dropdown-item waves-effect"
                                                           href="{{$waUrl}}">
                                                            <i class="ti icon-base tabler-brand-whatsapp"></i>
                                                            WhatsApp
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item waves-effect"
                                                           href="{{$tgApp}}">
                                                            <i class="ti icon-base tabler-brand-telegram"></i>
                                                            Telegram
                                                        </a>
                                                    </li>
                                                     <li>
                                                        <a class="dropdown-item waves-effect"
                                                           href="tel:{{$patient->phone}}">
                                                            <i class="ti icon-base tabler-phone"></i>
                                                            Phone
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            </span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.children')}}:</span>
                                        <span>{{$patient->children}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6 text-{{$patient->blood_type->class()}}">{{trans('doctor::doctor.patients.blood_type')}}:</span>
                                        <span class="text-{{$patient->blood_type->class()}}">{{$patient->blood_type->label()}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6 text-{{$patient->marital_status->class()}}">{{trans('doctor::doctor.patients.marital_status')}}:</span>
                                        <span class="text-{{$patient->marital_status->class()}}">{{$patient->marital_status->label()}}</span>
                                    </li>

                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.drug_allergies')}}:</span>
                                        <span>{{$patient->drug_allergies}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.disabilities')}}:</span>
                                        <span>{{$patient->disabilities}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.medical_history')}}:</span>
                                        <span>{{$patient->medical_history}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.surgical_history')}}:</span>
                                        <span>{{$patient->surgical_history}}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">{{trans('doctor::doctor.patients.accident_history')}}:</span>
                                        <span>{{$patient->accident_history}}</span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-center">
                                    <a href="javascript:" class="btn btn-primary me-4 waves-effect waves-light"
                                       data-bs-target="#editUser"
                                       data-bs-toggle="modal">{{trans('doctor::doctor.edit')}}</a>
                                    <a href="javascript:"
                                       class="btn btn-label-danger suspend-user waves-effect">{{trans('doctor::doctor.deactivate')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{trans('doctor::doctor.medicalExaminations.patientInfo')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <div class="d-flex">
                                    <p>
                                        {{trans('doctor::doctor.id')}}:
                                    </p>
                                    <p class="mx-2 text-end">
                                        {{$patient->id}}
                                    </p>
                                </div>
                                <div class="d-flex">
                                    <p>
                                        {{trans('doctor::doctor.patients.name')}}:
                                    </p>
                                    <p class="mx-2 text-end">
                                        {{$patient->name}}
                                    </p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-{{$patient->gender->class()}}">
                                        {{trans('doctor::doctor.patients.gender')}}:
                                    </p>
                                    <p class="mx-2 text-end text-{{$patient->gender->class()}}">
                                        {{$patient->gender->label()}}
                                    </p>
                                </div>
                                <div class="d-flex">
                                    <p>
                                        {{trans('doctor::doctor.patients.age')}}:
                                    </p>
                                    <p class="mx-2 text-end">
                                        {{$patient->age}}
                                    </p>
                                </div>
                                <div class="d-flex">
                                    <p>
                                        {{trans('doctor::doctor.patients.nationality_id')}}:
                                    </p>
                                    <p class="mx-2 text-end">
                                        {{$patient->nationality->name}}
                                    </p>
                                </div>
                                @if($patient->email)
                                    <div class="d-flex">
                                        <p>
                                            {{trans('doctor::doctor.patients.email')}}:
                                        </p>
                                        <p class="mx-2 text-end">
                                            {{$patient->email}}
                                        </p>
                                    </div>
                                @endif
                                @if($patient->work)
                                    <div class="d-flex">
                                        <p>
                                            {{trans('doctor::doctor.patients.work')}}:
                                        </p>
                                        <p class="mx-2 text-end">
                                            {{$patient->work}}
                                        </p>
                                    </div>
                                @endif
                                @if($patient->children)
                                    <div class="d-flex">
                                        <p>
                                            {{trans('doctor::doctor.patients.children')}}:
                                        </p>
                                        <p class="mx-2 text-end">
                                            {{$patient->children}}
                                        </p>
                                    </div>
                                @endif
                                <div class="d-flex">
                                    <p class="text-{{$patient->blood_type->class()}}">
                                        {{trans('doctor::doctor.patients.blood_type')}}:
                                    </p>
                                    <p class="mx-2 text-end text-{{$patient->blood_type->class()}}">
                                        {{$patient->blood_type->label()}}
                                    </p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-{{$patient->marital_status->class()}}">
                                        {{trans('doctor::doctor.patients.marital_status')}}:
                                    </p>
                                    <p class="mx-2 text-end text-{{$patient->marital_status->class()}}">
                                        {{$patient->marital_status->label()}}
                                    </p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-{{$patient->is_active->class()}}">
                                        {{trans('doctor::doctor.patients.active')}}:
                                    </p>
                                    <p class="mx-2 text-end text-{{$patient->is_active->class()}}">
                                        {{$patient->is_active->label()}}
                                    </p>
                                </div>
                                @if($patient->drug_allergies)
                                    <div class="d-flex">
                                        <p>
                                            {{trans('doctor::doctor.patients.drug_allergies')}}:
                                        </p>
                                        <p class="mx-2 text-end">
                                            {{$patient->drug_allergies}}
                                        </p>
                                    </div>
                                @endif
                                @if($patient->disabilities)
                                    <div class="d-flex">
                                        <p>
                                            {{trans('doctor::doctor.patients.disabilities')}}:
                                        </p>
                                        <p class="mx-2 text-end">
                                            {{$patient->disabilities}}
                                        </p>
                                    </div>
                                @endif
                                @if($patient->medical_history)
                                    <div class="d-flex">
                                        <p>
                                            {{trans('doctor::doctor.patients.medical_history')}}:
                                        </p>
                                        <p class="mx-2 text-end">
                                            {{$patient->medical_history}}
                                        </p>
                                    </div>
                                @endif
                                @if($patient->surgical_history)
                                    <div class="d-flex">
                                        <p>
                                            {{trans('doctor::doctor.patients.surgical_history')}}:
                                        </p>
                                        <p class="mx-2 text-end">
                                            {{$patient->surgical_history}}
                                        </p>
                                    </div>
                                @endif
                                @if($patient->accident_history)
                                    <div class="d-flex">
                                        <p class="my-0 py-0">
                                            {{trans('doctor::doctor.patients.accident_history')}}:
                                        </p>
                                        <p class="my-0 py-0 mx-2 text-end">
                                            {{$patient->accident_history}}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>--}}
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{trans('doctor::doctor.medicalExaminations.medicalPreviewInfo')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <div class="row">
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
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-6">
                            <livewire:doctor::medical-tests-livewire
                                    :medicalExaminationId="$medicalExamination->id"
                                    :title="trans('doctor::doctor.medicalExaminations.laboratoryTests')"
                                    :type="\Modules\Doctor\Enums\MedicalTestTypeEnum::LABORATORY_TESTS"
                                    name="laboratoryTests"/>
                        </div>
                        <div class="col-6">
                            <livewire:doctor::medical-tests-livewire
                                    :medicalExaminationId="$medicalExamination->id"
                                    :title="trans('doctor::doctor.medicalExaminations.radiologyTests')"
                                    :type="\Modules\Doctor\Enums\MedicalTestTypeEnum::RADIOLOGY_TESTS"
                                    name="radiologyTests"/>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-12">
                            <livewire:doctor::medicines-info-livewire
                                    :medicalExaminationId="$medicalExamination->id"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 my-4">
                            <livewire:doctor::final-diagnosis-patient-livewire
                                    :patientId="$patient->id"
                                    name="finalDiagnose"
                                    :medicalExaminationId="$medicalExamination->id"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

