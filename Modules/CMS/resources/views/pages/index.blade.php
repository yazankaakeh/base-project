@php
    $page = 'cms-pages';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.pages.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <span class="badge badge-center bg-primary p-2 me-2">
                        <i class="ti tabler-file-text ti-sm"></i>
                    </span>
                    {{ trans('cms::cms.pages.title') }}
                </h4>
                <p class="text-muted mb-0">Manage your website pages and content</p>
            </div>
            <div class="d-flex gap-2">
                @php $homePage = $data->firstWhere('slug', 'home'); @endphp
                @if($homePage)
                    <a href="{{ route('cms.home.edit') }}" class="btn btn-label-success">
                        <i class="ti tabler-home me-1"></i>Edit Home Page
                    </a>
                @endif
                <a href="{{ route('cms.create') }}" class="btn btn-primary">
                    <i class="ti tabler-plus me-1"></i>{{ trans('cms::cms.pages.create') }}
                </a>
            </div>
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
                                <i class="ti tabler-files ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $data->total() }}</h3>
                                <span class="text-muted">Total Pages</span>
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
                                <h3 class="mb-0">{{ $data->where('status', \Modules\CMS\Enums\PageStatusEnum::PUBLISHED)->count() }}</h3>
                                <span class="text-muted">Published</span>
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
                                <i class="ti tabler-pencil ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $data->where('status', \Modules\CMS\Enums\PageStatusEnum::DRAFT)->count() }}</h3>
                                <span class="text-muted">Drafts</span>
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
                                <i class="ti tabler-layout ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $data->whereNotNull('use_panel_builder')->where('use_panel_builder', true)->count() }}</h3>
                                <span class="text-muted">With Panels</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pages Table --}}
        <div class="card">
            <div class="card-header border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Pages</h5>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>Page</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Template</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $pageItem)
                            <tr class="{{ $pageItem->slug === 'home' ? 'table-primary' : '' }}">
                                <td>
                                    <span class="text-muted">{{ $pageItem->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($pageItem->slug === 'home')
                                            <span class="badge badge-center bg-success p-2">
                                                <i class="ti tabler-home ti-sm"></i>
                                            </span>
                                        @elseif($pageItem->getFirstMediaUrl('featured_image'))
                                            <img src="{{ $pageItem->getFirstMediaUrl('featured_image', 'thumb') ?: $pageItem->getFirstMediaUrl('featured_image') }}"
                                                 class="rounded"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <span class="badge badge-center bg-label-secondary p-2">
                                                <i class="ti tabler-file ti-sm"></i>
                                            </span>
                                        @endif
                                        <div>
                                            <div class="fw-medium">
                                                {{ $pageItem->getTranslation('title', app()->getLocale()) }}
                                                @if($pageItem->slug === 'home')
                                                    <span class="badge bg-success ms-1">Home</span>
                                                @endif
                                            </div>
                                            @if($pageItem->parent)
                                                <small class="text-muted">
                                                    <i class="ti tabler-corner-down-right me-1"></i>
                                                    Parent: {{ $pageItem->parent->getTranslation('title', app()->getLocale()) }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <code class="bg-label-secondary px-2 py-1 rounded">{{ $pageItem->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $pageItem->status->class() }}">
                                        <i class="ti tabler-{{ $pageItem->status === \Modules\CMS\Enums\PageStatusEnum::PUBLISHED ? 'eye' : ($pageItem->status === \Modules\CMS\Enums\PageStatusEnum::DRAFT ? 'pencil' : 'archive') }} me-1"></i>
                                        {{ $pageItem->status->label() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">
                                        <i class="ti tabler-layout me-1"></i>{{ $pageItem->template->label() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        @if($pageItem->slug !== 'home')
                                            <a href="{{ url('page/' . $pageItem->slug) }}"
                                               target="_blank"
                                               class="btn btn-icon btn-sm btn-label-info"
                                               title="View Page">
                                                <i class="ti tabler-external-link"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('cms.edit', $pageItem->id) }}"
                                           class="btn btn-icon btn-sm btn-label-primary"
                                           title="Edit">
                                            <i class="ti tabler-edit"></i>
                                        </a>
                                        @if($pageItem->slug !== 'home')
                                            <form action="{{ route('cms.destroy', $pageItem->id) }}"
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
                                        @else
                                            <button type="button"
                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                    disabled
                                                    title="{{ trans('cms::cms.pages.cannot_delete_home') }}">
                                                <i class="ti tabler-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="mb-3">
                                        <span class="badge badge-center bg-label-secondary rounded-circle p-4">
                                            <i class="ti tabler-file-off display-5"></i>
                                        </span>
                                    </div>
                                    <h5 class="text-muted">No pages yet</h5>
                                    <p class="text-muted mb-3">Create your first page to get started</p>
                                    <a href="{{ route('cms.create') }}" class="btn btn-primary">
                                        <i class="ti tabler-plus me-1"></i>Create Page
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
    </div>
@endsection
