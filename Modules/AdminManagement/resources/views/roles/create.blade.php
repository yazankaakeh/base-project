@extends('theme::user.layouts.horizontalLayout')
@section('title', trans('adminmanagement::admin_management.roles.create.title'))
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="">
                        <form action="{{route('admin.role_management.store')}}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <div class="d-flex justify-content-between">
                                                <h2 class="">
                                                    {{trans('adminmanagement::admin_management.roles.create.title')}}
                                                </h2>
                                            </div>
                                        </div>
                                        {{-- <div class="mt-3">
                                           <label for="name" class="form-label">{{trans('name')}}</label>
                                           <input id="name" type="text" value="{{old('name',$item->name)}}" name="name"
                                                  class="form-control w-full"
                                                  placeholder="Input text">
                                         </div>
                                         <div class="mt-3">
                                           <label for="guard" class="form-label">{{trans('guard')}}</label>
                                           <input id="guard" type="text" disabled value="{{old('guard',$item->guard_name)}}"
                                                  name="email" class="form-control w-full"
                                                  placeholder="Input text">
                                         </div>--}}
                                        <div class="card-body">
                                            <div class="col-12 mt-3">
                                                <x-core::input
                                                        label="adminmanagement::admin_management.roles.create.name"
                                                        placeholder="adminmanagement::admin_management.roles.create.name"
                                                        id="name"
                                                        name="name"
                                                        type="text"
                                                        required="required"
                                                        model="name"
                                                        value="{{old('name')}}">

                                                </x-core::input>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <x-core::input
                                                        label="adminmanagement::admin_management.roles.create.guard"
                                                        placeholder="adminmanagement::admin_management.roles.create.guard"
                                                        id="guard"
                                                        name="guard"
                                                        type="text"
                                                        required="required"
                                                        disabled="disabled"
                                                        model="guard"
                                                        value="doctor">

                                                </x-core::input>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <label for="allCheckBoxes">
                                                    {{trans('adminmanagement::admin_management.roles.create.allCheckBoxes')}}
                                                </label>
                                                <div class="form-switch text-end mx-6">
                                                    <input type="checkbox" id="allCheckBoxes"
                                                           class="form-check-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                @includeIf('adminmanagement::roles.partial._permission')
                            </div>
                            <div class="text-end mt-5">
                                <button type="submit"
                                        class="btn btn-primary w-24">{{trans('adminmanagement::admin_management.submit')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
