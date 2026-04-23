@php
    $page = 'cms-menus';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.menus.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <span class="badge badge-center bg-primary p-2 me-2">
                        <i class="ti tabler-menu-2 ti-sm"></i>
                    </span>
                    {{ trans('cms::cms.menus.title') }}
                </h4>
                <p class="text-muted mb-0">Manage navigation menus for your website</p>
            </div>
            <a href="{{ route('menus.create') }}" class="btn btn-primary">
                <i class="ti tabler-plus me-1"></i>{{ trans('cms::cms.menus.create') }}
            </a>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="ti tabler-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-center bg-label-primary p-3">
                                <i class="ti tabler-menu-2 ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $data->total() }}</h3>
                                <span class="text-muted">Total Menus</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-center bg-label-success p-3">
                                <i class="ti tabler-eye ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $data->where('is_active', true)->count() }}</h3>
                                <span class="text-muted">Active Menus</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-center bg-label-info p-3">
                                <i class="ti tabler-list ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $data->sum('all_items_count') }}</h3>
                                <span class="text-muted">Total Items</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge badge-center bg-label-warning p-3">
                                <i class="ti tabler-map-pin ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $data->whereNotNull('location')->unique('location')->count() }}</h3>
                                <span class="text-muted">Locations</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Menus Table --}}
        <div class="card">
            <div class="card-header border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Menus</h5>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Menu</th>
                            <th>Slug</th>
                            <th>Location</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $menu)
                            <tr>
                                <td>
                                    <span class="text-muted">{{ $menu->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @php
                                            $locationColors = [
                                                'header' => 'primary',
                                                'footer' => 'info',
                                                'sidebar' => 'warning',
                                                'mobile' => 'secondary',
                                            ];
                                            $iconMap = [
                                                'header' => 'layout-navbar',
                                                'footer' => 'layout-bottombar',
                                                'sidebar' => 'layout-sidebar',
                                                'mobile' => 'device-mobile',
                                            ];
                                            $color = $locationColors[$menu->location] ?? 'secondary';
                                            $icon = $iconMap[$menu->location] ?? 'menu-2';
                                        @endphp
                                        <span class="badge badge-center bg-label-{{ $color }} p-2">
                                            <i class="ti tabler-{{ $icon }} ti-sm"></i>
                                        </span>
                                        <div>
                                            <div class="fw-medium">
                                                {{ $menu->getTranslation('name', app()->getLocale()) }}
                                            </div>
                                            <small class="text-muted">
                                                Created {{ $menu->created_at?->diffForHumans() ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="bg-label-secondary px-2 py-1 rounded">{{ $menu->slug }}</code>
                                </td>
                                <td>
                                    @if($menu->location)
                                        <span class="badge bg-label-{{ $color }}">
                                            <i class="ti tabler-{{ $icon }} me-1"></i>
                                            {{ ucfirst($menu->location) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-label-info">
                                        <i class="ti tabler-list me-1"></i>
                                        {{ $menu->all_items_count }} {{ Str::plural('item', $menu->all_items_count) }}
                                    </span>
                                </td>
                                <td>
                                    @if($menu->is_active)
                                        <span class="badge bg-success">
                                            <i class="ti tabler-eye me-1"></i>
                                            {{ trans('cms::cms.menus.active') }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="ti tabler-eye-off me-1"></i>
                                            {{ trans('cms::cms.menus.inactive') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('menus.edit', $menu->id) }}"
                                           class="btn btn-icon btn-sm btn-label-primary"
                                           title="Edit Menu">
                                            <i class="ti tabler-edit"></i>
                                        </a>
                                        <form action="{{ route('menus.destroy', $menu->id) }}"
                                              method="post"
                                              class="d-inline"
                                              onsubmit="return confirm('{{ trans('cms::cms.common.confirm_delete') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-icon btn-sm btn-label-danger"
                                                    title="Delete">
                                                <i class="ti tabler-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="mb-3">
                                        <span class="badge badge-center bg-label-secondary rounded-circle p-4">
                                            <i class="ti tabler-menu-2 display-5"></i>
                                        </span>
                                    </div>
                                    <h5 class="text-muted">No menus yet</h5>
                                    <p class="text-muted mb-3">Create your first navigation menu to get started</p>
                                    <a href="{{ route('menus.create') }}" class="btn btn-primary">
                                        <i class="ti tabler-plus me-1"></i>Create Menu
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($data->hasPages())
                <div class="card-footer">
                    {{ $data->links() }}
                </div>
            @endif
        </div>

        {{-- Quick Tips --}}
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ti tabler-bulb text-warning me-2"></i>
                    Quick Tips
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="d-flex gap-3">
                            <span class="badge badge-center bg-label-primary p-2 flex-shrink-0" style="height: fit-content;">
                                <i class="ti tabler-layout-navbar"></i>
                            </span>
                            <div>
                                <h6 class="mb-1">Header Menu</h6>
                                <small class="text-muted">Use location "header" for the main navigation at the top of your website.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3">
                            <span class="badge badge-center bg-label-info p-2 flex-shrink-0" style="height: fit-content;">
                                <i class="ti tabler-layout-bottombar"></i>
                            </span>
                            <div>
                                <h6 class="mb-1">Footer Menu</h6>
                                <small class="text-muted">Use location "footer" for links displayed in the website footer.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-3">
                            <span class="badge badge-center bg-label-warning p-2 flex-shrink-0" style="height: fit-content;">
                                <i class="ti tabler-code"></i>
                            </span>
                            <div>
                                <h6 class="mb-1">Using in Code</h6>
                                <small class="text-muted">Access menus using: <code>Menu::findBySlug('slug')</code></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
