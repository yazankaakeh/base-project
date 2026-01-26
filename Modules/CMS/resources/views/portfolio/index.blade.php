@php
    use Modules\Core\App\Enums\LanguageEnum;
    $page = 'cms-portfolios';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.portfolio.title'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">
                    <span class="badge badge-center bg-primary p-2 me-2">
                        <i class="ti tabler-briefcase ti-sm"></i>
                    </span>
                    {{ trans('cms::cms.portfolio.title') }}
                </h4>
                <p class="text-muted mb-0">Showcase your best work and projects</p>
            </div>
            <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary">
                <i class="ti tabler-plus me-1"></i>Add Portfolio
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
                                <i class="ti tabler-briefcase ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $portfolios->total() }}</h3>
                                <span class="text-muted">Total Projects</span>
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
                                <h3 class="mb-0">{{ $portfolios->where('is_active', true)->count() }}</h3>
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
                                <i class="ti tabler-star ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ $portfolios->where('is_featured', true)->count() }}</h3>
                                <span class="text-muted">Featured</span>
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
                                <i class="ti tabler-chart-bar ti-md"></i>
                            </span>
                            <div>
                                <h3 class="mb-0">{{ number_format($portfolios->sum('views_count')) }}</h3>
                                <span class="text-muted">Total Views</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Portfolio Table --}}
        <div class="card">
            <div class="card-header border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Portfolios</h5>
                    <div class="d-flex gap-2">
                        <small class="text-muted">
                            <i class="ti tabler-grip-vertical me-1"></i>
                            Drag rows to reorder
                        </small>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Order</th>
                            <th style="width: 80px;">Image</th>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Client</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Featured</th>
                            <th class="text-center">Views</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="portfolios-sortable">
                        @forelse($portfolios as $portfolio)
                            <tr data-id="{{ $portfolio->id }}">
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted draggable" style="cursor: move;">
                                            <i class="ti tabler-grip-vertical"></i>
                                        </span>
                                        <span class="badge bg-label-secondary">{{ $portfolio->order }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($portfolio->featured_image_thumb)
                                        <img src="{{ $portfolio->featured_image_thumb }}"
                                             alt="{{ $portfolio->getTranslation('title', 'en') }}"
                                             class="rounded shadow-sm"
                                             style="width: 60px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 45px;">
                                            <i class="ti tabler-photo text-secondary"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.portfolios.show', $portfolio->id) }}"
                                           class="fw-semibold text-body">
                                            {{ $portfolio->getTranslation('title', app()->getLocale()) }}
                                        </a>
                                        <small class="text-muted">
                                            <code>{{ $portfolio->slug }}</code>
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    @if($portfolio->getTranslation('category', app()->getLocale()))
                                        <span class="badge bg-label-info">
                                            <i class="ti tabler-tag me-1"></i>
                                            {{ $portfolio->getTranslation('category', app()->getLocale()) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($portfolio->client_name)
                                        <div class="d-flex flex-column">
                                            <span>{{ $portfolio->client_name }}</span>
                                            @if($portfolio->client_company)
                                                <small class="text-muted">{{ $portfolio->client_company }}</small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-icon btn-sm btn-{{ $portfolio->is_active ? 'success' : 'secondary' }} toggle-status"
                                            data-id="{{ $portfolio->id }}"
                                            title="{{ $portfolio->is_active ? 'Active - Click to deactivate' : 'Inactive - Click to activate' }}">
                                        <i class="ti tabler-{{ $portfolio->is_active ? 'eye' : 'eye-off' }}"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-icon btn-sm btn-{{ $portfolio->is_featured ? 'warning' : 'outline-secondary' }} toggle-featured"
                                            data-id="{{ $portfolio->id }}"
                                            title="{{ $portfolio->is_featured ? 'Featured - Click to unfeature' : 'Not Featured - Click to feature' }}">
                                        <i class="ti tabler-star{{ $portfolio->is_featured ? '-filled' : '' }}"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-label-primary">
                                        <i class="ti tabler-chart-bar me-1"></i>
                                        {{ number_format($portfolio->views_count) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('portfolio.show', $portfolio->slug) }}"
                                           target="_blank"
                                           class="btn btn-icon btn-sm btn-label-info"
                                           title="View on Website">
                                            <i class="ti tabler-external-link"></i>
                                        </a>
                                        <a href="{{ route('admin.portfolios.show', $portfolio->id) }}"
                                           class="btn btn-icon btn-sm btn-label-secondary"
                                           title="View Details">
                                            <i class="ti tabler-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                                           class="btn btn-icon btn-sm btn-label-primary"
                                           title="Edit">
                                            <i class="ti tabler-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.portfolios.duplicate', $portfolio->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-icon btn-sm btn-label-warning"
                                                    title="Duplicate">
                                                <i class="ti tabler-copy"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this portfolio?')">
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
                                <td colspan="9" class="text-center py-5">
                                    <div class="mb-3">
                                        <span class="badge badge-center bg-label-secondary rounded-circle p-4">
                                            <i class="ti tabler-briefcase-off display-5"></i>
                                        </span>
                                    </div>
                                    <h5 class="text-muted">No portfolios yet</h5>
                                    <p class="text-muted mb-3">Start showcasing your best work</p>
                                    <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary">
                                        <i class="ti tabler-plus me-1"></i>Add Your First Portfolio
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($portfolios->hasPages())
                <div class="card-footer">
                    {{ $portfolios->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Status
            document.querySelectorAll('.toggle-status').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const button = this;

                    fetch(`{{ url('admin/portfolios') }}/${id}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            button.classList.toggle('btn-success', data.is_active);
                            button.classList.toggle('btn-secondary', !data.is_active);
                            button.querySelector('i').className = `ti tabler-${data.is_active ? 'eye' : 'eye-off'}`;
                            button.title = data.is_active ? 'Active - Click to deactivate' : 'Inactive - Click to activate';
                        }
                    });
                });
            });

            // Toggle Featured
            document.querySelectorAll('.toggle-featured').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const button = this;

                    fetch(`{{ url('admin/portfolios') }}/${id}/toggle-featured`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            button.classList.toggle('btn-warning', data.is_featured);
                            button.classList.toggle('btn-outline-secondary', !data.is_featured);
                            button.querySelector('i').className = `ti tabler-star${data.is_featured ? '-filled' : ''}`;
                            button.title = data.is_featured ? 'Featured - Click to unfeature' : 'Not Featured - Click to feature';
                        }
                    });
                });
            });

            // Sortable
            if (typeof Sortable !== 'undefined') {
                const sortableEl = document.getElementById('portfolios-sortable');
                if (sortableEl) {
                    new Sortable(sortableEl, {
                        handle: '.draggable',
                        animation: 150,
                        ghostClass: 'table-primary',
                        onEnd: function() {
                            const ids = Array.from(sortableEl.querySelectorAll('tr[data-id]'))
                                .map(tr => parseInt(tr.dataset.id));

                            fetch('{{ route('admin.portfolios.reorder') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({ order: ids })
                            });
                        }
                    });
                }
            }
        });
    </script>
@endpush
