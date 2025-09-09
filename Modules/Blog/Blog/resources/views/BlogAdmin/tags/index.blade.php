@extends('admin/layouts/layoutMaster')

@section('title', 'Blog - Add Tags')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/block-ui/block-ui.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sortablejs/sortable.js')}}"></script>
  @php
    use Modules\Blog\Enum\Languages;
    $langs = Languages::cases();
  @endphp
  @includeIf('blog::BlogAdmin.tags.modals.createModal',['langs'=>$langs])
  @includeIf('blog::BlogAdmin.tags.modals.editModal',['langs'=>$langs])
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

  <h4 class="py-3 mb-4"><span class="text-muted fw-light">Blog /</span> Tags
  </h4>
  <div class="row mb-5">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
          <h5 class="">Tags</h5>
          <h5 class="">
            <button type="button"
                    data-bs-toggle="modal" data-bs-target="#storeModal"
                    class="btn btn-primary">
              <i class="ti tabler-plus me-1"></i>
              {{trans('admin.create')}}
            </button>
          </h5>
        </div>

        <div class="card-body">
          <div class="card-content">
            <div class="table-responsive text-nowrap">
              <table class="table">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name en</th>
                  <th>Name ar</th>
                  <th>Name tr</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($tags as $tag)
                  <tr>
                    <td>{{$tag->id}}</td>
                    <td>{{$tag->getTranslation('en','name')}}</td>
                    <td>{{$tag->getTranslation('ar','name')}}</td>
                    <td>{{$tag->getTranslation('tr','name')}}</td>
                    <td>{{$tag->created_at}}</td>
                    <td>{{$tag->updated_at}}</td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                            class="ti tabler-dots-vertical"></i></button>
                        <div class="dropdown-menu">
                          <button type="button"
                                  data-bs-toggle="modal" data-bs-target="#editModal"
                                  data-id="{{$tag->id}}"
                                  data-name-tr="{{$tag->getTranslation('tr','name')}}"
                                  data-name-ar="{{$tag->getTranslation('ar','name')}}"
                                  data-name-en="{{$tag->getTranslation('en','name')}}"
                                  class="dropdown-item EditModalBTN">
                            <i class="ti tabler-pencil me-1"></i>
                            Edit
                          </button>
                          <a href="javascript:void(0)" onclick="DeleteRole(this)"
                             class="dropdown-item deleteButton">
                            <i class="ti tabler-trash me-1"></i>
                            Delete
                            <form action="{{route('blogTags.tags.destroy',['tag'=>$tag])}}"
                                  class="deleteForm" method="POST">
                              @csrf
                              @method('DELETE')
                            </form>
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              {{$tags->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
