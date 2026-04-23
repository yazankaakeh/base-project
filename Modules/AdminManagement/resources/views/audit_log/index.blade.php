@php use Modules\AdminManagement\Action\Auditing\RouteName; @endphp
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('adminmanagement::admin_management.audits.index'))

@section('content')
    @php
        $hasFilters = filled($filters['q'])
            || filled($filters['adminId'])
            || filled($filters['method'])
            || filled($filters['route_name'])
            || filled($filters['start_date'])
            || filled($filters['end_date']);

        // Color + label per HTTP verb so the table reads at a glance.
        $methodTone = [
            'GET'    => 'info',
            'POST'   => 'success',
            'PUT'    => 'warning',
            'PATCH'  => 'warning',
            'DELETE' => 'danger',
        ];

        $statCards = [
            ['key' => 'total',     'icon' => 'ti tabler-history',          'tone' => 'primary', 'value' => $stats['total']     ?? 0],
            ['key' => 'today',     'icon' => 'ti tabler-clock-hour-3',     'tone' => 'info',    'value' => $stats['today']     ?? 0],
            ['key' => 'admins',    'icon' => 'ti tabler-user-shield',      'tone' => 'success', 'value' => $stats['admins']    ?? 0],
            ['key' => 'mutations', 'icon' => 'ti tabler-edit-circle',      'tone' => 'warning', 'value' => $stats['mutations'] ?? 0],
        ];
    @endphp

    <div class="page-wrapper">
        <div class="content">

            {{-- ====================================================== --}}
            {{-- Page header                                             --}}
            {{-- ====================================================== --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h4 class="mb-1 d-flex align-items-center gap-2">
                        <i class="ti tabler-history text-primary"></i>
                        {{ trans('adminmanagement::admin_management.audits.index') }}
                    </h4>
                    <p class="text-muted mb-0 small">
                        {{ __('Every admin action recorded with who, what, when and where.') }}
                    </p>
                </div>
                @if($hasFilters)
                    <a href="{{ route('admin.audits.index') }}" class="btn btn-outline-secondary">
                        <i class="ti tabler-refresh me-1"></i>
                        {{ __('Clear filters') }}
                    </a>
                @endif
            </div>

            {{-- ====================================================== --}}
            {{-- KPI row                                                 --}}
            {{-- ====================================================== --}}
            <div class="row g-3 mb-4">
                @foreach($statCards as $s)
                    @php
                        $labels = [
                            'total'     => __('Total events'),
                            'today'     => __('Last 24 hours'),
                            'admins'    => __('Active admins'),
                            'mutations' => __('Write actions'),
                        ];
                    @endphp
                    <div class="col-6 col-md-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="avatar flex-shrink-0">
                                    <span class="avatar-initial rounded-3 bg-label-{{ $s['tone'] }}">
                                        <i class="{{ $s['icon'] }} ti-md"></i>
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-muted small text-truncate">{{ $labels[$s['key']] }}</div>
                                    <div class="h4 mb-0 fw-bold">{{ number_format($s['value']) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ====================================================== --}}
            {{-- Filter bar + table                                      --}}
            {{-- ====================================================== --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <form method="get" action="{{ route('admin.audits.index') }}" class="row g-2 align-items-center">

                        <div class="col-12 col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="ti tabler-search"></i>
                                </span>
                                <input type="search"
                                       name="q"
                                       value="{{ $filters['q'] }}"
                                       class="form-control border-start-0"
                                       placeholder="{{ __('Search URL, route, or IP') }}"
                                       autocomplete="off">
                            </div>
                        </div>

                        <div class="col-6 col-lg-2">
                            <select name="adminId" data-auto-submit class="form-select">
                                <option value="">{{ trans('adminmanagement::admin_management.audits.filterModal.adminId') }}</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" @selected((string) $filters['adminId'] === (string) $admin->id)>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-lg-2">
                            <select name="method" data-auto-submit class="form-select">
                                <option value="">{{ __('All methods') }}</option>
                                @foreach(['GET', 'POST', 'PUT', 'PATCH', 'DELETE'] as $m)
                                    <option value="{{ $m }}" @selected($filters['method'] === $m)>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-lg-2">
                            <input type="date"
                                   name="start_date"
                                   value="{{ $filters['start_date'] }}"
                                   class="form-control"
                                   placeholder="{{ __('From') }}"
                                   aria-label="{{ __('From date') }}">
                        </div>

                        <div class="col-6 col-lg-2">
                            <input type="date"
                                   name="end_date"
                                   value="{{ $filters['end_date'] }}"
                                   class="form-control"
                                   placeholder="{{ __('To') }}"
                                   aria-label="{{ __('To date') }}">
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                            @if($routes)
                                <select name="route_name" data-auto-submit class="form-select" style="max-width: 320px;">
                                    <option value="">{{ __('All routes') }}</option>
                                    @foreach($routes as $routeKey => $routeLabel)
                                        <option value="{{ $routeKey }}" @selected($filters['route_name'] === $routeKey)>
                                            {{ $routeLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <button type="submit" class="btn btn-primary">
                                <i class="ti tabler-filter me-1"></i>
                                {{ trans('adminmanagement::admin_management.audits.filter') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    @if($data->total() === 0)
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="ti tabler-history-toggle display-4 text-muted"></i>
                            </div>
                            <h5 class="mb-1">{{ __('No audit entries match your filters') }}</h5>
                            <p class="text-muted mb-3">{{ __('Try widening the date range or clearing filters.') }}</p>
                            @if($hasFilters)
                                <a href="{{ route('admin.audits.index') }}" class="btn btn-outline-primary">
                                    <i class="ti tabler-refresh me-1"></i>
                                    {{ __('Clear filters') }}
                                </a>
                            @endif
                        </div>
                    @else
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 60px;">#</th>
                                <th>{{ trans('adminmanagement::admin_management.audits.admin') }}</th>
                                <th style="width: 100px;">{{ __('Method') }}</th>
                                <th>{{ trans('adminmanagement::admin_management.audits.action') }}</th>
                                <th>{{ __('URL') }}</th>
                                <th style="width: 140px;">{{ trans('adminmanagement::admin_management.audits.ip') }}</th>
                                <th style="width: 180px;">{{ trans('adminmanagement::admin_management.audits.time') }}</th>
                                <th class="text-end pe-4" style="width: 120px;">{{ __('Details') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $audit)
                                @php
                                    $tone = $methodTone[strtoupper((string) $audit->method)] ?? 'secondary';
                                    $routeLabel = RouteName::GetRouteName($audit->route_name) ?: ($audit->route_name ?: '—');
                                    $hasPayload = !empty($audit->payload);
                                    $adminName = $audit->admin?->name ?: '—';
                                    $adminEmail = $audit->admin?->email;
                                @endphp
                                <tr>
                                    <td class="ps-4 text-muted small">#{{ $audit->id }}</td>

                                    {{-- Admin who performed the action --}}
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-truncate" style="max-width: 220px;">
                                                {{ $adminName }}
                                            </span>
                                            @if($adminEmail)
                                                <small class="text-muted text-truncate" style="max-width: 220px;">
                                                    {{ $adminEmail }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- HTTP method --}}
                                    <td>
                                        <span class="badge bg-label-{{ $tone }} text-uppercase">
                                            {{ $audit->method ?: '—' }}
                                        </span>
                                    </td>

                                    {{-- Route / action name --}}
                                    <td>
                                        <span class="text-body text-truncate d-inline-block" style="max-width: 260px;"
                                              title="{{ $audit->route_name }}">
                                            {{ $routeLabel }}
                                        </span>
                                    </td>

                                    {{-- URL, truncated --}}
                                    <td>
                                        @if($audit->url)
                                            <code class="text-muted small text-break"
                                                  title="{{ $audit->url }}"
                                                  style="max-width: 320px; display: inline-block;">
                                                {{ \Illuminate\Support\Str::limit($audit->url, 60) }}
                                            </code>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>

                                    {{-- IP address --}}
                                    <td>
                                        <code class="text-muted small">{{ $audit->ip ?: '—' }}</code>
                                    </td>

                                    {{-- Time (absolute + relative) --}}
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="small">
                                                {{ $audit->created_at?->format('Y-m-d H:i') ?? '—' }}
                                            </span>
                                            <small class="text-muted">
                                                {{ $audit->created_at?->diffForHumans() }}
                                            </small>
                                        </div>
                                    </td>

                                    {{-- Details (payload viewer) --}}
                                    <td class="text-end pe-4">
                                        <a type="button"
                                           data-bs-toggle="modal"
                                           data-bs-target="#payloadModal"
                                           class="btn btn-sm btn-outline-primary payload"
                                           data-id="{{ $audit->id }}"
                                           title="{{ trans('adminmanagement::admin_management.audits.getPayLoad') }}">
                                            <i class="ti tabler-eye me-1"></i>
                                            {{ __('View') }}
                                            @if($hasPayload)
                                                <span class="badge rounded-pill bg-primary ms-1">•</span>
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                @if($data->hasPages())
                    <div class="card-footer bg-transparent border-top py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <small class="text-muted">
                            {{ __('Showing') }}
                            <strong>{{ $data->firstItem() }}</strong>–<strong>{{ $data->lastItem() }}</strong>
                            {{ __('of') }} <strong>{{ $data->total() }}</strong>
                        </small>
                        {{ $data->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @includeIf('adminmanagement::audit_log.modals.payloadModal')
@endsection

@section('vendor-script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Auto-submit the filter form when certain selects change so
            // admins don't have to click the submit button on every tweak.
            document.querySelectorAll('[data-auto-submit]').forEach(el => {
                el.addEventListener('change', () => el.form.requestSubmit());
            });
        });

        // Lazy-load payload HTML into the modal body on click.
        $(document).on('click', '.payload', function () {
            const auditId = $(this).data('id');
            const body = $('.modal-content-payload');
            body.html('<div class="text-center py-5 text-muted"><div class="spinner-border spinner-border-sm me-2"></div> @php echo addslashes(__('Loading…')); @endphp</div>');

            $.ajax({
                url: '{{ route('admin.audits.getPayload') }}' + '/' + auditId,
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    body.html(response.payload);
                },
                error: function () {
                    body.html('<p class="text-danger m-0"><i class="ti tabler-alert-triangle me-1"></i>{{ __('Failed to load payload.') }}</p>');
                }
            });
        });
    </script>
@endsection
