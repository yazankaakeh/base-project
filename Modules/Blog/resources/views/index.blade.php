@extends('admin/layouts/layoutMaster')

@section('title', 'Blog -  Post')

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
  @includeIf('blog::BlogAdmin.posts.modals.createModal',['langs'=>$langs])
  @includeIf('blog::BlogAdmin.posts.modals.editModal',['langs'=>$langs])
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
  <script
    src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic-with-plugins@1.0.0/build/ckeditor.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
  <script>
    ClassicEditor
      .create(document.querySelector('#editor'), {
        ckfinder: {},
        toolbar: {
          items: [
            'heading', '|',
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
            'insertTable', 'mediaEmbed', '|',
            'imageUpload', 'imageInsert', 'imageResize', 'imageStyle:inline',
            'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight', '|',
            'undo', 'redo'
          ]
        },
        image: {
          resizeUnit: '%',
          toolbar: [
            'imageStyle:inline',
            'imageStyle:alignLeft',
            'imageStyle:alignCenter',
            'imageStyle:alignRight',
            '|',
            'imageTextAlternative',
            'imageResize'
          ]
        },
        table: {
          contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        }
      })
      .catch(error => {
        console.error(error);
      });
  </script>
@endsection

@section('content')

  <div class="row mb-5">
    <div class="col-12">
      <h4 class="py-3 mb-4"><span class="text-muted fw-light">Blog /</span> Categories
      </h4>
      <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
          <h5 class="">Posts</h5>
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

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
