<?php

$page = 'sales-dashboard'; ?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('usermanagement::user_management.user.title'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">Admins</h5>
                            <h5 class="">
                                @can('admin.user_management.store')
                                    <button type="button"
                                            data-bs-toggle="modal" data-bs-target="#storeModal"
                                            class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i>
                                        Create
                                    </button>
                                @endcan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <div class="table-responsive text-nowrap">
                                    <table class="table  datanew">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>img</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>
                                                    {{$user->roles?->first()?->name}}
                                                </td>
                                                <td>
                                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-bs-placement="top"
                                                            class="avatar avatar-xs pull-up"
                                                            aria-label="{{$user->name}}"
                                                            data-bs-original-title="{{$user->name}}">
                                                            <img src="{{$user->img}}" alt="Avatar"
                                                                 class="rounded-circle">
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <span class="badge {{$user->is_active->class()}} me-1">{{$user->is_active->label()}} </span>
                                                </td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        @if($user->id != 1)
                                                            @can('admin.user_management.update')
                                                                <a type="button" data-bs-toggle="modal"
                                                                   data-bs-target="#editModal"
                                                                   class="me-2 edit-icon  p-2 btn-sm EditModalBTN"
                                                                   data-id="{{$user->id}}"
                                                                   data-name="{{$user->name}}"
                                                                   data-email="{{$user->email}}"
                                                                   data-active="{{$user->is_active}}"
                                                                   data-img="{{$user->img}}"
                                                                   data-role="{{$user->roles?->first()?->id}}">
                                                                    <i data-feather="edit" class="feather-edit"></i>
                                                                </a>
                                                            @endcan
                                                            @can('admin.user_management.status')
                                                                <a type="button" data-bs-toggle="modal"
                                                                   data-bs-target="#isActiveModal"
                                                                   class="me-2 p-2 btn-sm IsActiveModalBTN"
                                                                   data-id="{{$user->id}}"
                                                                   data-name="{{$user->name}}"
                                                                   data-email="{{$user->email}}"
                                                                   data-active="{{$user->is_active}}">
                                                                    <i class="feather-user"></i>
                                                                </a>
                                                            @endcan
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$users->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
    @includeIf('usermanagement::users.modals.createModal')
    @includeIf('usermanagement::users.modals.editModal')
    @includeIf('usermanagement::users.modals.isActiveModal')
@endsection