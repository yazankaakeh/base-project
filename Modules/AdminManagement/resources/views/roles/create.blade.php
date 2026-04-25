@extends('theme::user.layouts.horizontalLayout')
@section('title', trans('adminmanagement::admin_management.roles.create.title'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <form action="{{ route('admin.role_management.store') }}" method="POST" id="roleForm">
                @csrf
                @method('POST')

                {{-- =============================================== --}}
                {{-- Page header: title + save/cancel actions        --}}
                {{-- =============================================== --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                    <div>
                        <h4 class="mb-1 d-flex align-items-center gap-2">
                            <i class="ti tabler-shield-plus text-primary"></i>
                            {{ trans('adminmanagement::admin_management.roles.create.title') }}
                        </h4>
                        <p class="text-muted mb-0 small">
                            {{ trans('adminmanagement::admin_management.roles.create.subtitle') }}
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.role_management.index') }}" class="btn btn-outline-secondary">
                            <i class="ti tabler-x me-1"></i>
                            {{ trans('adminmanagement::admin_management.roles.create.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti tabler-device-floppy me-1"></i>
                            {{ trans('adminmanagement::admin_management.roles.create.save') }}
                        </button>
                    </div>
                </div>

                <div class="row g-4">
                    {{-- =============================================== --}}
                    {{-- Left column: role basics                         --}}
                    {{-- =============================================== --}}
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm sticky-top" style="top: 80px;">
                            <div class="card-header bg-transparent border-bottom">
                                <h6 class="mb-0 d-flex align-items-center gap-2">
                                    <i class="ti tabler-id-badge-2 text-primary"></i>
                                    {{ __('Role details') }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <x-core::input
                                        label="adminmanagement::admin_management.roles.create.name"
                                        placeholder="adminmanagement::admin_management.roles.create.namePlaceholder"
                                        id="name"
                                        name="name"
                                        type="text"
                                        required="required"
                                        model="name"
                                        value="{{ old('name') }}"/>
                                </div>

                                <div class="mb-3">
                                    <x-core::input
                                        label="adminmanagement::admin_management.roles.create.guard"
                                        placeholder="adminmanagement::admin_management.roles.create.guard"
                                        id="guard"
                                        name="guard"
                                        type="text"
                                        required="required"
                                        disabled="disabled"
                                        model="guard"
                                        value="admin"/>
                                    <small class="text-muted">
                                        {{ __('Auto-set to "admin" — this role applies to the back-office guard.') }}
                                    </small>
                                </div>

                                {{-- Live counter: how many permissions are selected --}}
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-label-primary">
                                    <div>
                                        <div class="small text-uppercase" style="letter-spacing: 1px;">
                                            {{ trans('adminmanagement::admin_management.roles.create.selected') }}
                                        </div>
                                        <div class="h5 mb-0" id="permissionCount">0</div>
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input type="checkbox" id="allCheckBoxes" class="form-check-input">
                                        <label for="allCheckBoxes" class="form-check-label small ms-2">
                                            {{ trans('adminmanagement::admin_management.roles.create.allCheckBoxes') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================================== --}}
                    {{-- Right column: permission groups                  --}}
                    {{-- =============================================== --}}
                    <div class="col-lg-8">
                        {{-- Permission search (filters by translated label) --}}
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body py-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="ti tabler-search"></i>
                                    </span>
                                    <input type="search"
                                           id="permissionSearch"
                                           class="form-control border-start-0"
                                           placeholder="{{ trans('adminmanagement::admin_management.roles.create.searchPermissions') }}"
                                           autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3" id="permissionGroups">
                            @includeIf('adminmanagement::roles.partial._permission')
                        </div>

                        {{-- Empty search state --}}
                        <div id="permissionsEmpty" class="text-center py-5 d-none">
                            <i class="ti tabler-shield-off display-4 text-muted mb-2"></i>
                            <p class="text-muted mb-0">
                                {{ trans('adminmanagement::admin_management.roles.create.noPermissions') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Sticky mobile submit (visible on small screens) --}}
                <div class="d-lg-none mt-4 text-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti tabler-device-floppy me-1"></i>
                        {{ trans('adminmanagement::admin_management.roles.create.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
