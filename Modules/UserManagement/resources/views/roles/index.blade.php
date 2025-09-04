@extends('theme::admin.layout.mainlayout')

@section('title', trans('usermanagement::user_management.roles.title'))

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/block-ui/block-ui.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/sortablejs/sortable.js')}}"></script>
    <script>
        function DeleteRole(thisE) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, submit the form
                    /* $(thisE + ' .deleteForm').submit();*/
                    let form = $(thisE).find('.deleteForm');
                    form.submit();
                    console.log(form);
                }
            });
        }

    </script>
@endsection

@section('page-script')
    <script src="{{asset('assets/js/cards-actions.js')}}"></script>
@endsection

@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">
                                {{trans('usermanagement::user_management.roles.title')}}
                            </h5>
                            <h5 class="">
                                @can('admin.role_management.create')
                                    <a type="button" href="{{route('admin.role_management.create')}}"
                                       class="btn btn-primary">
                                        <i class="fe fe-plus-circle me-1"></i>
                                        {{trans('usermanagement::user_management.roles.createBtn')}}
                                    </a>
                                @endcan
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="card-content">
                                <div class="table-responsive text-nowrap">
                                    <table class="table datanew">
                                        <thead>
                                        <tr>
                                            <th>{{trans('usermanagement::user_management.roles.id')}}</th>
                                            <th>{{trans('usermanagement::user_management.roles.name')}}</th>
                                            <th>{{trans('usermanagement::user_management.roles.created_at')}}</th>
                                            <th>{{trans('usermanagement::user_management.roles.updated_at')}}</th>
                                            <th>{{trans('usermanagement::user_management.roles.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{{$role->id}}</td>
                                                <td>{{$role->name}}</td>
                                                <td>{{$role->created_at->format('y:m:d')}}</td>
                                                <td>{{$role->updated_at->format('y:m:d')}}</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        @if($role->id != 1)
                                                            @can('admin.role_management.edit')
                                                                <a href="{{route('admin.role_management.edit',['role_management'=>$role])}}"
                                                                   class="me-2 p-2 btn-sm">
                                                                    <i class="fe feather-edit me-1"></i>
                                                                </a>
                                                            @endcan
                                                            @can('admin.role_management.destroy')
                                                                <a href="javascript:void(0)" onclick="DeleteRole(this)"
                                                                   class="me-2 p-2 btn-sm deleteButton">
                                                                    <i class="fe feather-trash-2 me-1"></i>
                                                                    <form action="{{route('admin.role_management.destroy',['role_management'=>$role])}}"
                                                                          class="deleteForm" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </a>
                                                            @endcan
                                                        @endif
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$roles->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
