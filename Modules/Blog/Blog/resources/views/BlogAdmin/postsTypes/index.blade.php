@extends('admin/layouts/layoutMaster')

@section('title', 'Cards Actions- UI elements')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}" />
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

  <h4 class="py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Roles
  </h4>
  <div class="row mb-5">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
          <h5 class="">Roles</h5>
          <h5 class="">
            <a type="button" href="{{route('role_management.create')}}"
               class="btn btn-primary">
              <i class="ti tabler-plus me-1"></i>
              Create
            </a>
          </h5>
        </div>

        <div class="card-body">
          <div class="card-content">
            <div class="table-responsive text-nowrap">
              <table class="table">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($roles as $role)
                  <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->created_at}}</td>
                    <td>{{$role->updated_at}}</td>
                    <td>
                      @if($role->id != 1)
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                              class="ti tabler-dots-vertical"></i></button>
                          <div class="dropdown-menu">
                            <a href="{{route('role_management.edit',['role_management'=>$role])}}"
                               class="dropdown-item">
                              <i class="ti tabler-pencil me-1"></i>
                              Edit
                            </a>
                            <a href="javascript:void(0)" onclick="DeleteRole(this)"
                               class="dropdown-item deleteButton">
                              <i class="ti tabler-trash me-1"></i>
                              Delete
                              <form action="{{route('role_management.destroy',['role_management'=>$role])}}"
                                    class="deleteForm" method="POST">
                                @csrf
                                @method('DELETE')
                              </form>
                            </a>
                          </div>
                        </div>
                      @endif
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

@endsection
