<?php

$page = 'sales-dashboard'; ?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('blog::blog.category.main_title'))

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
    @includeIf('doctor::doctor.clinics.modals.createModal')
    @includeIf('doctor::doctor.clinics.modals.editModal')
    @vite(['resources/assets/js/forms-file-upload.js'],'build/modules/theme')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{trans('customer.sidebar.clinic')}}</h5>
                            <h5 class="">
                                @can('doctor.clinic.store')
                                    <button type="button"
                                            data-bs-toggle="modal" data-bs-target="#storeModal"
                                            class="btn btn-primary">
                                        <i class="ti tabler-plus icon-base me-1"></i>
                                        {{trans('doctor::doctor.create')}}
                                    </button>
                                @endcan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <form enctype="multipart/form-data" id="createUser"
                                      action="{{route('admin.user_management.store')}}"
                                      method="POST">
                                    @csrf
                                    @foreach($data as $seo_setting)
                                        <x-core::input label="seo::seo.seo_settings.{{$seo_setting->key}}"
                                                       type="text"
                                                       :tooltip="trans('seo::seo.seo_settings.'.$seo_setting->key.'__desc')"
                                                       :value="$seo_setting->value"
                                                       :name="$seo_setting->key"
                                                       :id="$seo_setting->key">
                                        </x-core::input>
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection