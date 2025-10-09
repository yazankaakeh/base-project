<?php

$page = 'sales-dashboard'; ?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('blog::blog.category.edit_title'))

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
                                <div class="table-responsive text-nowrap">
                                    <table class="table datanew">
                                        <thead>
                                        <tr>
                                            <th>{{trans('doctor::doctor.id')}}</th>
                                            <th>{{trans('doctor::doctor.clinic.name')}}</th>
                                            <th>{{trans('doctor::doctor.clinic.img')}}</th>
                                            <th>{{trans('customer.account.status')}}</th>
                                            <th>{{trans('admin.audits.action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        @foreach($data as $clinic)
                                            <tr>
                                                <td>{{$clinic->id}}</td>
                                                <td>{{$clinic->name}}</td>
                                                <td>
                                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-bs-placement="top"
                                                            class="avatar avatar-xl pull-up"
                                                            aria-label="{{$clinic->name}}"
                                                            data-bs-original-title="{{$clinic->name}}">
                                                            <img src="{{$clinic->getFirstMediaUrl('images')}}"
                                                                 alt="Avatar"
                                                                 class="rounded-circle">
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge text-bg-{{$clinic->is_active->class()}} me-1">{{$clinic->is_active->label()}} </span>
                                                </td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        @can('doctor.clinic.update')
                                                            <a type="button" data-bs-toggle="modal"
                                                               data-bs-target="#editModal"
                                                               class="me-2 btn btn-outline-primary text-primary p-2 btn-sm EditModalBTN"
                                                               data-id="{{$clinic->id}}"
                                                               data-img="{{$clinic->getFirstMediaUrl('images')}}"
                                                               data-name='@json($clinic->getTranslations('name'))'
                                                               data-active="{{$clinic->is_active}}">
                                                                <i data-feather="edit"
                                                                   class="ti tabler-edit icon-base"></i>
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$data->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection