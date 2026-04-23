@php $page = 'dashboard'; @endphp
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('admin.sidebar.dashboard'))

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">{{ config('app.name') }} /</span>
        {{ trans('admin.sidebar.dashboard') }}
    </h4>

    {{-- Welcome strip -------------------------------------------------- --}}
    <div class="card mb-4 codliy-dash-hero">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="mb-1">{{ __('Welcome back') }}, {{ auth()->user()->name ?? __('Admin') }}!</h5>
                <p class="mb-0 text-white-75">
                    {{ __('Here\'s a quick snapshot of your site.') }}
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @if(\Illuminate\Support\Facades\Route::has('admin.theme.settings.index'))
                    <a href="{{ route('admin.theme.settings.index') }}" class="btn btn-light btn-sm">
                        <i class="ti tabler-palette me-1"></i>{{ __('Theme') }}
                    </a>
                @endif
                @if(\Illuminate\Support\Facades\Route::has('admin.user_management.index'))
                    <a href="{{ route('admin.user_management.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="ti tabler-users me-1"></i>{{ __('Users') }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Stat cards ---------------------------------------------------- --}}
    <div class="row g-4 mb-4">
        @php
            $cards = [
                ['label' => __('Administrators'),   'value' => $stats['admins'],      'icon' => 'tabler-user-shield', 'tone' => 'primary'],
                ['label' => __('Blog posts'),        'value' => $stats['blog_posts'],  'icon' => 'tabler-article',     'tone' => 'info'],
                ['label' => __('Tags'),              'value' => $stats['blog_tags'],   'icon' => 'tabler-tags',        'tone' => 'warning'],
                ['label' => __('CMS pages'),         'value' => $stats['cms_pages'],   'icon' => 'tabler-file-text',   'tone' => 'success'],
                ['label' => __('AI conversations'),  'value' => $stats['ai_chats'],    'icon' => 'tabler-messages',    'tone' => 'primary'],
                ['label' => __('AI messages'),       'value' => $stats['ai_messages'], 'icon' => 'tabler-message-2',   'tone' => 'info'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="col-sm-6 col-xl-4">
                <div class="card h-100 codliy-stat-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <span class="codliy-stat-card__icon bg-label-{{ $card['tone'] }}">
                            <i class="ti {{ $card['icon'] }}"></i>
                        </span>
                        <div class="flex-grow-1">
                            <div class="text-muted small text-uppercase">{{ $card['label'] }}</div>
                            <div class="h3 mb-0 fw-bold">{{ number_format($card['value']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Recent admins + quick actions -------------------------------- --}}
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Recent administrators') }}</h5>
                    @if(\Illuminate\Support\Facades\Route::has('admin.user_management.index'))
                        <a href="{{ route('admin.user_management.index') }}" class="btn btn-sm btn-outline-primary">
                            {{ __('View all') }}
                        </a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th class="text-end">{{ __('Joined') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($recentAdmins as $admin)
                            <tr>
                                <td class="fw-semibold">{{ $admin->name }}</td>
                                <td class="text-muted">{{ $admin->email }}</td>
                                <td>
                                    @if($admin->is_active)
                                        <span class="badge bg-label-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-label-secondary">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="text-end text-muted small">
                                    {{ optional($admin->created_at)->diffForHumans() ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    {{ __('No administrators yet.') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header"><h5 class="mb-0">{{ __('Quick actions') }}</h5></div>
                <div class="card-body d-flex flex-column gap-2">
                    @php
                        $shortcuts = array_filter([
                            \Illuminate\Support\Facades\Route::has('admin.theme.settings.index')
                                ? ['label' => __('Theme settings'),   'icon' => 'tabler-palette',     'url' => route('admin.theme.settings.index')] : null,
                            \Illuminate\Support\Facades\Route::has('admin.role_management.index')
                                ? ['label' => __('Roles & permissions'), 'icon' => 'tabler-shield-lock', 'url' => route('admin.role_management.index')] : null,
                            \Illuminate\Support\Facades\Route::has('admin.audits.index')
                                ? ['label' => __('Audit log'),        'icon' => 'tabler-history',     'url' => route('admin.audits.index')] : null,
                            \Illuminate\Support\Facades\Route::has('admin.blogs.index')
                                ? ['label' => __('Blog posts'),       'icon' => 'tabler-article',     'url' => route('admin.blogs.index')] : null,
                            \Illuminate\Support\Facades\Route::has('admin.cms.pages.index')
                                ? ['label' => __('CMS pages'),        'icon' => 'tabler-file-text',   'url' => route('admin.cms.pages.index')] : null,
                        ]);
                    @endphp

                    @forelse($shortcuts as $shortcut)
                        <a href="{{ $shortcut['url'] }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-between">
                            <span><i class="ti {{ $shortcut['icon'] }} me-2"></i>{{ $shortcut['label'] }}</span>
                            <i class="ti tabler-arrow-right scaleX-n1-rtl"></i>
                        </a>
                    @empty
                        <p class="text-muted mb-0">{{ __('No shortcuts available.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Dashboard-only polish; every color routes through theme tokens so
           admin-driven ThemeSetting changes still flow through. */
        .codliy-dash-hero {
            background: var(--codliy-primary-gradient, var(--codliy-primary, var(--bs-primary)));
            color: #fff;
            border: none;
        }
        .codliy-dash-hero .text-white-75 { color: rgba(255, 255, 255, 0.78); }
        .codliy-dash-hero h5 { color: #fff; }

        .codliy-stat-card {
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            border: 1px solid rgba(var(--bs-primary-rgb, 0, 86, 248), 0.06);
        }
        .codliy-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(var(--bs-primary-rgb, 0, 86, 248), 0.1);
        }
        .codliy-stat-card__icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
    </style>
@endsection
