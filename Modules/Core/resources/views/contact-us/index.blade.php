@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('core::core.contact_us.title'))

@section('content')
    @php
        $hasFilter = filled($filters['q'] ?? '');

        $statCards = [
            ['key' => 'total',       'icon' => 'ti tabler-inbox',              'tone' => 'primary'],
            ['key' => 'this_week',   'icon' => 'ti tabler-calendar-week',      'tone' => 'info'],
            ['key' => 'today',       'icon' => 'ti tabler-clock-hour-3',       'tone' => 'success'],
            ['key' => 'unique_from', 'icon' => 'ti tabler-users',              'tone' => 'warning'],
        ];
    @endphp

    <div class="page-wrapper">
        <div class="content">

            {{-- Header --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h4 class="mb-1 d-flex align-items-center gap-2">
                        <i class="ti tabler-mail-forward text-primary"></i>
                        {{ trans('core::core.contact_us.title') }}
                    </h4>
                    <p class="text-muted mb-0 small">
                        {{ trans('core::core.contact_us.subtitle') }}
                    </p>
                </div>
            </div>

            {{-- KPI cards --}}
            <div class="row g-3 mb-4">
                @foreach($statCards as $s)
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
                                        {{ trans('core::core.contact_us.stats.' . $s['key']) }}
                                    </div>
                                    <div class="h4 mb-0 fw-bold">{{ number_format($stats[$s['key']] ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Filter bar + inbox --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <form method="get" action="{{ route('admin.contact_us.index') }}"
                          class="row g-2 align-items-center">
                        <div class="col-12 col-md-8 col-lg-6">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="ti tabler-search"></i>
                                </span>
                                <input type="search"
                                       name="q"
                                       value="{{ $filters['q'] }}"
                                       class="form-control border-start-0"
                                       placeholder="{{ trans('core::core.contact_us.search') }}"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-6 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti tabler-search me-1"></i>{{ __('Search') }}
                            </button>
                            @if($hasFilter)
                                <a href="{{ route('admin.contact_us.index') }}"
                                   class="btn btn-outline-secondary">
                                    <i class="ti tabler-x me-1"></i>{{ trans('core::core.contact_us.reset') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    @if($messages->total() === 0)
                        {{-- Empty states --}}
                        <div class="text-center py-5">
                            @if($hasFilter)
                                <div class="mb-3">
                                    <i class="ti tabler-search-off display-4 text-muted"></i>
                                </div>
                                <h5 class="mb-1">{{ trans('core::core.contact_us.no_results') }}</h5>
                                <a href="{{ route('admin.contact_us.index') }}" class="btn btn-outline-primary mt-2">
                                    <i class="ti tabler-refresh me-1"></i>
                                    {{ trans('core::core.contact_us.reset') }}
                                </a>
                            @else
                                <div class="mb-3">
                                    <i class="ti tabler-mail-off display-4 text-muted"></i>
                                </div>
                                <h5 class="mb-1">{{ trans('core::core.contact_us.empty') }}</h5>
                                <p class="text-muted mb-0">{{ trans('core::core.contact_us.empty_hint') }}</p>
                            @endif
                        </div>
                    @else
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 60px;">#</th>
                                <th>{{ trans('core::core.contact_us.full_name') }}</th>
                                <th>{{ trans('core::core.contact_us.email') }}</th>
                                <th>{{ trans('core::core.contact_us.message') }}</th>
                                <th style="width: 180px;">{{ trans('core::core.contact_us.received') }}</th>
                                <th class="text-end pe-4" style="width: 140px;">
                                    {{ trans('core::core.contact_us.actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $msg)
                                <tr>
                                    <td class="ps-4 text-muted small">#{{ $msg->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="avatar avatar-sm">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    {{ strtoupper(mb_substr($msg->fullName, 0, 1)) }}
                                                </span>
                                            </span>
                                            <span class="fw-semibold text-truncate" style="max-width: 180px;">
                                                {{ $msg->fullName }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $msg->email }}" class="text-body">
                                            <i class="ti tabler-mail me-1 text-muted"></i>
                                            {{ $msg->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-muted text-truncate d-inline-block" style="max-width: 340px;"
                                              title="{{ $msg->message }}">
                                            {{ Str::limit($msg->message, 80) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="small">{{ $msg->created_at?->format('Y-m-d H:i') }}</span>
                                            <small class="text-muted">{{ $msg->created_at?->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.contact_us.show', $msg) }}"
                                               class="btn btn-sm btn-icon btn-outline-primary"
                                               title="{{ trans('core::core.contact_us.details') }}">
                                                <i class="ti tabler-eye"></i>
                                            </a>
                                            <a href="mailto:{{ $msg->email }}?subject=Re: your message"
                                               class="btn btn-sm btn-icon btn-outline-success"
                                               title="{{ trans('core::core.contact_us.reply') }}">
                                                <i class="ti tabler-mail-forward"></i>
                                            </a>
                                            <form action="{{ route('admin.contact_us.destroy', $msg) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('{{ trans('core::core.contact_us.delete_confirm') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-icon btn-outline-danger"
                                                        title="{{ trans('core::core.contact_us.delete') }}">
                                                    <i class="ti tabler-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                @if($messages->hasPages())
                    <div class="card-footer bg-transparent border-top py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <small class="text-muted">
                            {{ __('Showing') }}
                            <strong>{{ $messages->firstItem() }}</strong>–<strong>{{ $messages->lastItem() }}</strong>
                            {{ __('of') }} <strong>{{ $messages->total() }}</strong>
                        </small>
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
