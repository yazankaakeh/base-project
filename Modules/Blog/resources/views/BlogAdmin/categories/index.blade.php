@extends('admin/layouts/layoutMaster')

@section('title', 'Blog - Add Categories')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
  <link rel="stylesheet"
        href="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/pickr/pickr-themes.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bloodhound/bloodhound.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/pickr/pickr.js')}}"></script>
  @php
    use Modules\Blog\Enum\Languages;
    $langs = Languages::cases();
  @endphp
  @includeIf('blog::BlogAdmin.categories.modals.createModal',['langs'=>$langs])
  @includeIf('blog::BlogAdmin.categories.modals.editModal',['langs'=>$langs])
  <script>
    $(document).ready(function() {
      /*$('.select2').select2({
        dropdownParent: modal
      });*/

    });

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
  <script src="{{asset('assets/js/forms-selects.js')}}"></script>
  <script src="{{asset('assets/js/forms-typeahead.js')}}"></script>
  <script src="{{asset('assets/js/forms-pickers.js')}}"></script>
@endsection

@section('content')

  <div class="row mb-5">
    <div class="col-12">
      <h4 class="py-3 mb-4"><span class="text-muted fw-light">Blog /</span> Categories
      </h4>
      <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
          <h5 class="">Categories</h5>
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
                  <th>Parent</th>
                  <th>Name en</th>
                  <th>Name ar</th>
                  <th>Name tr</th>
                  <th>img</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($categories as $category)
                  <tr>
                    <td>{{$category->id}}</td>
                    <td>
                         <span class="badge bg-label-secondary me-1">
                        {{$category->parent?->getTranslation('en','name')??'--'}}
                      </span>
                    </td>
                    <td>{{$category->getTranslation('en','name')}}</td>
                    <td>{{$category->getTranslation('ar','name')}}</td>
                    <td>{{$category->getTranslation('tr','name')}}</td>
                    <td>
                      <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                            class="avatar avatar-xs pull-up" aria-label="{{$category->getTranslation('en','name')}}"
                            data-bs-original-title="{{$category->getTranslation('en','name')}}">
                          <img
                            src="{{$category->img}}"
                            alt="Avatar" class="rounded-circle">
                        </li>
                      </ul>
                    </td>
                    <td>
                      <span class="badge {{$category->is_active == 1 ? 'bg-label-success' : 'bg-label-danger'}} me-1">
                        {{$category->is_active == 1 ? 'Active' : 'Not Active'}}
                      </span>
                    </td>
                    <td>{{date('d-m-Y', strtotime( $category->created_at))}}</td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                            class="ti tabler-dots-vertical"></i></button>
                        <div class="dropdown-menu">
                          <button type="button"
                                  data-bs-toggle="modal" data-bs-target="#editModal"
                                  data-id="{{$category->id}}"
                                  data-name-tr="{{$category->getTranslation('tr','name')}}"
                                  data-name-ar="{{$category->getTranslation('ar','name')}}"
                                  data-name-en="{{$category->getTranslation('en','name')}}"
                                  data-is-active="{{$category->is_active}}"
                                  data-parent-id="{{$category->parent_id}}"
                                  data-description-tr="{{$category->getTranslation('tr','description')}}"
                                  data-description-ar="{{$category->getTranslation('ar','description')}}"
                                  data-description-en="{{$category->getTranslation('en','description')}}"
                                  data-img="{{$category->img}}"
                                  class="dropdown-item EditModalBTN">
                            <i class="ti tabler-pencil me-1"></i>
                            Edit
                          </button>
                          <a href="javascript:void(0)" onclick="DeleteRole(this)"
                             class="dropdown-item deleteButton">
                            <i class="ti tabler-trash me-1"></i>
                            Delete
                            <form action="{{route('blogTags.tags.destroy',['tag'=>$category])}}"
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
              {{$categories->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
