@php
$page = 'cms-pages';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.pages.title'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{ trans('cms::cms.pages.title') }}</h5>
                            <div class="d-flex gap-2">
                                @php
                                    $homePage = $data->firstWhere('slug', 'home');
                                @endphp
                                @if($homePage)
                                    <a href="{{ route('cms.home.edit') }}" class="btn btn-label-success">
                                        <i class="ti tabler-home icon-base me-1"></i>
                                        Edit Home Page
                                    </a>
                                @endif
                                <a href="{{ route('cms.create') }}" class="btn btn-primary">
                                    <i class="ti tabler-plus icon-base me-1"></i>
                                    {{ trans('cms::cms.pages.create') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="card-content">
                                <div class="table-responsive text-nowrap">
                                    <table class="table datanew">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('cms::cms.pages.id') }}</th>
                                            <th>{{ trans('cms::cms.common.title') }}</th>
                                            <th>{{ trans('cms::cms.pages.slug') }}</th>
                                            <th>{{ trans('cms::cms.pages.status') }}</th>
                                            <th>{{ trans('cms::cms.pages.template') }}</th>
                                            <th>{{ trans('cms::cms.pages.actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        @foreach($data as $page)
                                            <tr class="{{ $page->slug === 'home' ? 'table-success' : '' }}">
                                                <td>{{ $page->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($page->slug === 'home')
                                                            <i class="ti tabler-home me-2 text-success"></i>
                                                        @endif
                                                        {{ $page->getTranslation('title', app()->getLocale()) }}
                                                    </div>
                                                </td>
                                                <td><code>{{ $page->slug }}</code></td>
                                                <td>
                                                    <span class="badge bg-{{ $page->status->class() }}">
                                                        {{ $page->status->label() }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-label-info">{{ $page->template->label() }}</span>
                                                </td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action d-flex">
                                                        <a href="{{ route('cms.edit', $page->id) }}" class="me-2 btn btn-outline-primary text-primary p-2 btn-sm">
                                                            <i data-feather="edit" class="ti tabler-edit icon-base"></i>
                                                        </a>
                                                        @if($page->slug !== 'home')
                                                            <form action="{{ route('cms.destroy', $page->id) }}" method="post" onsubmit="return confirm('{{ trans('cms::cms.common.confirm_delete') }}')"
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger text-danger p-2 btn-sm">
                                                                    <i class="ti tabler-trash icon-base"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button type="button" class="btn btn-outline-secondary text-muted p-2 btn-sm" disabled title="{{ trans('cms::cms.pages.cannot_delete_home') }}">
                                                                <i class="ti tabler-lock icon-base"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ $data->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
