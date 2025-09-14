@extends('theme::user.layouts.horizontalLayout')
@section('title', trans('usermanagement::user_management.roles.edit.title'))

@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <form action="{{route('admin.role_management.update',['role_management'=>$item])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <div class="d-flex justify-content-between">
                                            <h2 class="">
                                                {{trans('usermanagement::user_management.roles.edit.title')}}
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 mt-3">
                                            <x-core::input
                                                    label="usermanagement::user_management.roles.create.name"
                                                    placeholder="usermanagement::user_management.roles.create.name"
                                                    id="name"
                                                    name="name"
                                                    type="text"
                                                    required="required"
                                                    disabled=""
                                                    model="name"
                                                    value="{{old('name',$item->name)}}">

                                            </x-core::input>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <x-core::input
                                                    label="usermanagement::user_management.roles.create.guard"
                                                    placeholder="usermanagement::user_management.roles.create.guard"
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
                                                {{trans('usermanagement::user_management.roles.create.allCheckBoxes')}}
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
                            @includeIf('usermanagement::roles.partial._permission')
                        </div>
                        <div class="text-end mt-5">
                            <button type="submit"
                                    class="btn btn-primary w-24">{{trans('usermanagement::user_management.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
