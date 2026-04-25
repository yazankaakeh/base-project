<?php $page = 'sales-dashboard'; ?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('adminmanagement::admin_management.user.title'))

{{-- Vendor Styles --}}
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

{{-- Vendor Scripts --}}
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

            // Auto-submit the filter form when role/status selects change so
            // the admin doesn't have to click "Apply".
            document.querySelectorAll('[data-auto-submit]').forEach(el => {
                el.addEventListener('change', () => el.form.requestSubmit());
            });
        });
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

{{-- Page Scripts --}}
@section('page-script')
    @includeIf('usermanagement::users.modals.createModal')
    @includeIf('usermanagement::users.modals.editModal')
    @includeIf('usermanagement::users.modals.isActiveModal')
    @vite(['resources/assets/js/forms-file-upload.js'], 'build/modules/theme')
@endsection

@section('content')
    @php
        use Modules\AdminManagement\Enums\ActiveAdminEnum;

        $fallbackAvatar = asset('codliy/images/avatar-fallback.png');
        $hasFilters     = filled($filters['q'] ?? '')
                        || filled($filters['role'] ?? null)
                        || in_array($filters['status'] ?? null, ['0', '1', 0, 1], true);

        $statsItems = [
            ['key' => 'total',    'icon' => 'ti tabler-users',          'tone' => 'primary',   'value' => $stats['total']    ?? 0],
            ['key' => 'active',   'icon' => 'ti tabler-user-check',     'tone' => 'success',   'value' => $stats['active']   ?? 0],
            ['key' => 'inactive', 'icon' => 'ti tabler-user-off',       'tone' => 'danger',    'value' => $stats['inactive'] ?? 0],
            ['key' => 'roles',    'icon' => 'ti tabler-shield-lock',    'tone' => 'info',      'value' => $stats['roles']    ?? 0],
        ];
    @endphp

    <div class="page-wrapper">
        <div class="content">

            {{-- ====================================================== --}}
            {{-- Page Header: title, subtitle, primary action           --}}
            {{-- ====================================================== --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h4 class="mb-1 d-flex align-items-center gap-2">
                        <i class="ti tabler-users-group text-primary"></i>
                        {{ trans('adminmanagement::admin_management.user.title') }}
                    </h4>
                    <p class="text-muted mb-0 small">
                        {{ trans('adminmanagement::admin_management.user.subtitle') }}
                    </p>
                </div>
                @can('admin.user_management.store')
                    <button type="button"
                            data-bs-toggle="modal" data-bs-target="#storeModal"
                            class="btn btn-primary d-inline-flex align-items-center gap-1">
                        <i class="ti tabler-plus"></i>
                        {{ trans('adminmanagement::admin_management.user.createLabel') }}
                    </button>
                @endcan
            </div>

            {{-- ====================================================== --}}
            {{-- KPI cards — counts from the unfiltered admin list so    --}}
            {{-- numbers stay stable while the user types in search.    --}}
            {{-- ====================================================== --}}
            <div class="row g-3 mb-4">
                @foreach($statsItems as $s)
                    <div class="col-6 col-md-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded-3 bg-label-{{ $s['tone'] }}">
                                        <i class="{{ $s['icon'] }} ti-md"></i>
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-muted small text-truncate">
                                        {{ trans('adminmanagement::admin_management.user.stats.' . $s['key']) }}
                                    </div>
                                    <div class="h4 mb-0 fw-bold">{{ number_format($s['value']) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ====================================================== --}}
            {{-- Filters + Table                                         --}}
            {{-- ====================================================== --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <form method="get" action="{{ route('admin.user_management.index') }}"
                          class="row g-2 align-items-center">

                        {{-- Search --}}
                        <div class="col-12 col-lg-5">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="ti tabler-search"></i>
                                </span>
                                <input type="search"
                                       name="q"
                                       value="{{ $filters['q'] ?? '' }}"
                                       class="form-control border-start-0"
                                       placeholder="{{ trans('adminmanagement::admin_management.user.search') }}"
                                       autocomplete="off">
                            </div>
                        </div>

                        {{-- Role filter --}}
                        <div class="col-6 col-lg-3">
                            <select name="role" data-auto-submit class="form-select">
                                <option value="">{{ trans('adminmanagement::admin_management.user.all_roles') }}</option>
                                @foreach($roles as $id => $name)
                                    <option value="{{ $id }}" @selected((string)($filters['role'] ?? '') === (string) $id)>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status filter --}}
                        <div class="col-6 col-lg-2">
                            <select name="status" data-auto-submit class="form-select">
                                <option value="">{{ trans('adminmanagement::admin_management.user.all_statuses') }}</option>
                                <option value="1" @selected((string)($filters['status'] ?? '') === '1')>
                                    {{ trans('adminmanagement::admin_management.ActiveAdminEnum.1') }}
                                </option>
                                <option value="0" @selected((string)($filters['status'] ?? '') === '0')>
                                    {{ trans('adminmanagement::admin_management.ActiveAdminEnum.0') }}
                                </option>
                            </select>
                        </div>

                        {{-- Actions --}}
                        <div class="col-12 col-lg-2 d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="ti tabler-filter me-1"></i>
                                {{ trans('adminmanagement::admin_management.audits.filter') }}
                            </button>
                            @if($hasFilters)
                                <a href="{{ route('admin.user_management.index') }}"
                                   class="btn btn-outline-secondary"
                                   title="{{ trans('adminmanagement::admin_management.user.reset') }}">
                                    <i class="ti tabler-x"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    @if($users->total() === 0)
                        {{-- ---- Empty state ---- --}}
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="ti tabler-users-off display-4 text-muted"></i>
                            </div>
                            <h5 class="mb-1">{{ trans('adminmanagement::admin_management.user.no_results') }}</h5>
                            <p class="text-muted mb-3">{{ trans('adminmanagement::admin_management.user.no_results_hint') }}</p>
                            @if($hasFilters)
                                <a href="{{ route('admin.user_management.index') }}" class="btn btn-outline-primary">
                                    <i class="ti tabler-refresh me-1"></i>
                                    {{ trans('adminmanagement::admin_management.user.reset') }}
                                </a>
                            @endif
                        </div>
                    @else
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>{{ trans('adminmanagement::admin_management.user.name') }}</th>
                                <th>{{ trans('adminmanagement::admin_management.user.role') }}</th>
                                <th>{{ trans('adminmanagement::admin_management.user.status') }}</th>
                                <th class="text-end pe-4">
                                    {{ trans('adminmanagement::admin_management.user.actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                @php
                                    $avatar = $user->img ? asset('storage/' . $user->img) : $fallbackAvatar;
                                    $roleName = $user->roles?->first()?->name;
                                    $isProtected = $user->id === 1;
                                    $isActive = $user->is_active instanceof ActiveAdminEnum
                                        ? $user->is_active === ActiveAdminEnum::ACTIVE
                                        : (int) $user->is_active === 1;
                                @endphp
                                <tr>
                                    <td class="ps-4 text-muted small">#{{ $user->id }}</td>

                                    {{-- Avatar + name + email in one column --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $avatar }}"
                                                 alt="{{ $user->name }}"
                                                 class="rounded-circle"
                                                 width="40" height="40"
                                                 style="object-fit: cover;"
                                                 onerror="this.onerror=null;this.src='{{ $fallbackAvatar }}';">
                                            <div class="min-w-0">
                                                <div class="fw-semibold d-flex align-items-center gap-2">
                                                    <span class="text-truncate" style="max-width: 260px;">
                                                        {{ $user->name ?: '—' }}
                                                    </span>
                                                    @if($isProtected)
                                                        <span class="badge bg-label-warning" title="{{ __('Super admin — cannot be modified') }}">
                                                            <i class="ti tabler-lock ti-xs"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-muted small text-truncate" style="max-width: 260px;">
                                                    {{ $user->email ?: '—' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Role as a pill --}}
                                    <td>
                                        @if($roleName)
                                            <span class="badge bg-label-info">
                                                <i class="ti tabler-shield ti-xs me-1"></i>{{ $roleName }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>

                                    {{-- Status with colored dot --}}
                                    <td>
                                        <span class="badge bg-label-{{ $isActive ? 'success' : 'danger' }} d-inline-flex align-items-center gap-1">
                                            <span class="rounded-circle d-inline-block"
                                                  style="width:6px;height:6px;background:currentColor;"></span>
                                            {{ $user->is_active?->label() ?? '—' }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-end pe-4">
                                        @if(!$isProtected)
                                            <div class="btn-group" role="group" aria-label="User actions">
                                                @can('admin.user_management.update')
                                                    <a type="button" data-bs-toggle="modal"
                                                       data-bs-target="#editModal"
                                                       class="btn btn-sm btn-icon btn-outline-primary EditModalBTN"
                                                       title="{{ trans('adminmanagement::admin_management.user.edit.title') }}"
                                                       data-id="{{ $user->id }}"
                                                       data-name="{{ $user->name }}"
                                                       data-email="{{ $user->email }}"
                                                       data-active="{{ $user->is_active?->value ?? 0 }}"
                                                       data-img="{{ $user->img }}"
                                                       data-role="{{ $user->roles?->first()?->id }}">
                                                        <i class="ti tabler-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('admin.user_management.status')
                                                    <a type="button" data-bs-toggle="modal"
                                                       data-bs-target="#isActiveModal"
                                                       class="btn btn-sm btn-icon btn-outline-{{ $isActive ? 'danger' : 'success' }} IsActiveModalBTN"
                                                       title="{{ trans('adminmanagement::admin_management.user.editUserStatus') }}"
                                                       data-id="{{ $user->id }}"
                                                       data-name="{{ $user->name }}"
                                                       data-email="{{ $user->email }}"
                                                       data-active="{{ $user->is_active?->value ?? 0 }}">
                                                        <i class="ti {{ $isActive ? 'tabler-user-off' : 'tabler-user-check' }}"></i>
                                                    </a>
                                                @endcan
                                            </div>
                                        @else
                                            <span class="text-muted small">
                                                <i class="ti tabler-lock"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="card-footer bg-transparent border-top py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <small class="text-muted">
                            {{ __('Showing') }}
                            <strong>{{ $users->firstItem() }}</strong>–<strong>{{ $users->lastItem() }}</strong>
                            {{ __('of') }} <strong>{{ $users->total() }}</strong>
                        </small>
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
