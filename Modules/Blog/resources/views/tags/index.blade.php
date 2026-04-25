<?php

use Modules\Core\App\Enums\LanguageEnum;

$page = 'sales-dashboard'; ?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('blog::blog.tag.main_title'))

<!-- Vendor Styles -->
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

<!-- Vendor Scripts -->
@section('vendor-script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('.select2').each(function () {
                $(this).select2({
                    allowClear: true,
                    tags: false
                });
            });
        })
    </script>
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.js'], 'build/modules/theme')
    @vite([ 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
            'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
            'resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/libs/@form-validation/popular.js',
            'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
            'resources/assets/vendor/libs/@form-validation/auto-focus.js'],
            'build/modules/theme')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{trans('blog::blog.tag.main_title')}}</h5>
                            <h5 class="">
                                <button type="button"
                                        data-bs-toggle="modal" data-bs-target="#createTagModal"
                                        class="btn btn-primary">
                                    <i class="ti tabler-plus icon-base me-1"></i>
                                    {{trans('blog::blog.tag.create')}}
                                </button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <!-- Success/Error Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('blog::blog.tag.name') }}</th>
                                                <th>{{ trans('core::core.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data as $tag)
                                                <tr>
                                                    <td>
                                                        @foreach(LanguageEnum::values() as $lang)
                                                            <div class="mb-1">
                                                                <strong>{{ strtoupper($lang) }}:</strong>
                                                                {{ $tag->getTranslation('name', $lang) ?: 'N/A' }}
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                    data-bs-toggle="modal" data-bs-target="#editTagModal"
                                                                    data-tag-id="{{ $tag->id }}"
                                                                    data-tag-name="{{ json_encode($tag->getTranslations('name')) }}">
                                                                <i class="ti tabler-edit"></i>
                                                            </button>
                                                            <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST"
                                                                  style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                    <i class="ti tabler-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center">{{ trans('blog::blog.tag.no_tags') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $data->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Tag Modal -->
    <div class="modal fade" id="createTagModal" tabindex="-1" aria-labelledby="createTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.tags.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTagModalLabel">{{ trans('blog::blog.tag.create') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach(LanguageEnum::values() as $lang)
                            <div class="mb-3">
                                <x-core::input
                                    :label="trans('blog::blog.tag.name') . ' (' . strtoupper($lang) . ')'"
                                    type="text"
                                    :name="'name[' . $lang . ']'"
                                    :id="'name_' . $lang"
                                    required="required">
                                </x-core::input>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('core::core.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('core::core.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tag Modal -->
    <div class="modal fade" id="editTagModal" tabindex="-1" aria-labelledby="editTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editTagForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTagModalLabel">{{ trans('blog::blog.tag.edit') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach(LanguageEnum::values() as $lang)
                            <div class="mb-3">
                                <x-core::input
                                    :label="trans('blog::blog.tag.name') . ' (' . strtoupper($lang) . ')'"
                                    type="text"
                                    :name="'name[' . $lang . ']'"
                                    :id="'edit_name_' . $lang"
                                    required="required">
                                </x-core::input>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('core::core.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('core::core.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle edit modal
        $('#editTagModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const tagId = button.data('tag-id');
            const tagNames = button.data('tag-name');

            const modal = $(this);
            modal.find('#editTagForm').attr('action', '{{ route("admin.tags.update", ":id") }}'.replace(':id', tagId));

            // Populate form fields
            @foreach(LanguageEnum::values() as $lang)
                modal.find('#edit_name_{{ $lang }}').val(tagNames['{{ $lang }}'] || '');
            @endforeach
        });
    </script>
@endsection
