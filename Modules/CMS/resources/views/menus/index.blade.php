@php
$page = 'cms-menus';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('cms::cms.menus.title'))

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{ trans('cms::cms.menus.title') }}</h5>
                            <h5 class="">
                                <a href="{{ route('menus.create') }}" class="btn btn-primary">
                                    <i class="ti tabler-plus icon-base me-1"></i>
                                    {{ trans('cms::cms.menus.create') }}
                                </a>
                            </h5>
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
                                            <th>{{ trans('cms::cms.menus.id') }}</th>
                                            <th>{{ trans('cms::cms.menus.name') }}</th>
                                            <th>{{ trans('cms::cms.menus.slug') }}</th>
                                            <th>{{ trans('cms::cms.menus.location') }}</th>
                                            <th>{{ trans('cms::cms.menus.items') }}</th>
                                            <th>{{ trans('cms::cms.menus.status') }}</th>
                                            <th>{{ trans('cms::cms.menus.actions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        @foreach($data as $menu)
                                            <tr>
                                                <td>{{ $menu->id }}</td>
                                                <td>{{ $menu->getTranslation('name', app()->getLocale()) }}</td>
                                                <td><code>{{ $menu->slug }}</code></td>
                                                <td>{{ $menu->location ?? '-' }}</td>
                                                <td>{{ trans('cms::cms.menus.items_count', ['count' => $menu->all_items_count]) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $menu->is_active ? 'success' : 'secondary' }}">
                                                        {{ $menu->is_active ? trans('cms::cms.menus.active') : trans('cms::cms.menus.inactive') }}
                                                    </span>
                                                </td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action d-flex">
                                                        <a href="{{ route('menus.edit', $menu->id) }}" class="me-2 btn btn-outline-primary text-primary p-2 btn-sm">
                                                            <i data-feather="edit" class="ti tabler-edit icon-base"></i>
                                                        </a>
                                                        <form action="{{ route('menus.destroy', $menu->id) }}" method="post" onsubmit="return confirm('{{ trans('cms::cms.common.confirm_delete') }}')"
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger text-danger p-2 btn-sm">
                                                                <i class="ti tabler-trash icon-base"></i>
                                                            </button>
                                                        </form>
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
