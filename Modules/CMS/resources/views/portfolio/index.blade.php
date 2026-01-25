@php
    use Modules\Core\App\Enums\LanguageEnum;
    $page = 'cms-portfolios';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', 'Portfolios')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center pb-2 mb-1">
                            <h5 class="mb-0">
                                <i class="ti tabler-briefcase me-2"></i>
                                Portfolios
                            </h5>
                            <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary">
                                <i class="ti tabler-plus icon-base me-1"></i>
                                Add Portfolio
                            </a>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover datanew">
                                    <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th style="width: 80px;">Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Client</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Featured</th>
                                        <th class="text-center">Views</th>
                                        <th style="width: 180px;">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="portfolios-sortable">
                                    @forelse($portfolios as $portfolio)
                                        <tr data-id="{{ $portfolio->id }}">
                                            <td>
                                                <span class="text-muted draggable" style="cursor: move;">
                                                    <i class="ti tabler-grip-vertical"></i>
                                                </span>
                                                {{ $portfolio->order }}
                                            </td>
                                            <td>
                                                @if($portfolio->featured_image_thumb)
                                                    <img src="{{ $portfolio->featured_image_thumb }}"
                                                         alt="{{ $portfolio->getTranslation('title', 'en') }}"
                                                         class="rounded"
                                                         style="width: 60px; height: 45px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                         style="width: 60px; height: 45px;">
                                                        <i class="ti tabler-photo text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $portfolio->getTranslation('title', app()->getLocale()) }}
                                                </div>
                                                <small class="text-muted">
                                                    <code>{{ $portfolio->slug }}</code>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-label-info">
                                                    {{ $portfolio->getTranslation('category', app()->getLocale()) ?: '-' }}
                                                </span>
                                            </td>
                                            <td>{{ $portfolio->client_name ?: '-' }}</td>
                                            <td class="text-center">
                                                <button type="button"
                                                        class="btn btn-sm btn-{{ $portfolio->is_active ? 'success' : 'secondary' }} toggle-status"
                                                        data-id="{{ $portfolio->id }}"
                                                        title="{{ $portfolio->is_active ? 'Active' : 'Inactive' }}">
                                                    <i class="ti tabler-{{ $portfolio->is_active ? 'eye' : 'eye-off' }}"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                        class="btn btn-sm btn-{{ $portfolio->is_featured ? 'warning' : 'outline-secondary' }} toggle-featured"
                                                        data-id="{{ $portfolio->id }}"
                                                        title="{{ $portfolio->is_featured ? 'Featured' : 'Not Featured' }}">
                                                    <i class="ti tabler-star{{ $portfolio->is_featured ? '-filled' : '' }}"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-label-primary">
                                                    {{ number_format($portfolio->views_count) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('portfolio.show', $portfolio->slug) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="View on Website">
                                                        <i class="ti tabler-external-link"></i>
                                                    </a>
                                                    <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Edit">
                                                        <i class="ti tabler-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.portfolios.duplicate', $portfolio->id) }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-secondary"
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
                                                                class="btn btn-sm btn-outline-danger"
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
                                                <i class="ti tabler-briefcase-off" style="font-size: 3rem; opacity: 0.3;"></i>
                                                <p class="text-muted mt-3">No portfolios yet.</p>
                                                <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary">
                                                    <i class="ti tabler-plus me-1"></i> Add Your First Portfolio
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    {{ $portfolios->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            this.classList.toggle('btn-success', data.is_active);
                            this.classList.toggle('btn-secondary', !data.is_active);
                            this.querySelector('i').className = `ti tabler-${data.is_active ? 'eye' : 'eye-off'}`;
                        }
                    });
                });
            });

            // Toggle Featured
            document.querySelectorAll('.toggle-featured').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
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
                            this.classList.toggle('btn-warning', data.is_featured);
                            this.classList.toggle('btn-outline-secondary', !data.is_featured);
                            this.querySelector('i').className = `ti tabler-star${data.is_featured ? '-filled' : ''}`;
                        }
                    });
                });
            });

            // Sortable
            if (window.Sortable) {
                new Sortable(document.getElementById('portfolios-sortable'), {
                    handle: '.draggable',
                    animation: 150,
                    onEnd: function() {
                        const ids = Array.from(document.querySelectorAll('#portfolios-sortable tr[data-id]'))
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
        });
    </script>
@endpush
