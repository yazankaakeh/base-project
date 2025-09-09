<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="row g-3" enctype="multipart/form-data" id="formValidationExamples"
          action="{{route('blogCategory.category.update')}}"
          method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="editeId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Edit Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-12 mb-3">
              <label class="form-label" for="parentId">Parent</label>
              <select name="parent_id" class="form-select select2"
                      data-allow-clear="true" id="parentId">
                <option value="">Select One</option>
               
              </select>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-12 mb-3">
              <label class="form-label" for="create_img">Img</label>
              <input type="file" class="form-control" id="create_img" name="img">
            </div>
          </div>
          <div class="mb-3">
            <div class="card-header pt-1">
              <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                          data-bs-target="#edit_en" aria-controls="edit_en" aria-selected="true">
                    en
                  </button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                          data-bs-target="#edit_ar" aria-controls="edit_ar"
                          aria-selected="false">
                    ar
                  </button>
                </li>
                <li class="nav-item">
                  <button type="button" data-bs-target="#edit_tr" aria-controls="edit_tr" class="nav-link"
                          data-bs-toggle="tab"
                          role="tab" aria-selected="false">
                    tr
                  </button>
                </li>
              </ul>
            </div>
            <div class="card-body pt-3">
              <div class="tab-content p-0">
                <div class="tab-pane fade show active" id="edit_en" role="tabpanel">
                  <div class="row">
                    <x-blog::inputMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                         label="Name"
                                                         name="name"
                                                         type="text" id="edit_name" required language="en" />
                    <x-blog::textareaMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                            label="Description"
                                                            name="description"
                                                            type="text" id="edit_description" required language="en" />
                  </div>
                </div>
                <div class="tab-pane fade" id="edit_ar" role="tabpanel">
                  <div class="row">
                    <x-blog::inputMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                         label="Name"
                                                         name="name"
                                                         type="text" id="edit_name" language="ar" />
                    <x-blog::textareaMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                            label="Description"
                                                            name="description"
                                                            type="text" id="edit_description" language="ar" />
                  </div>
                </div>
                <div class="tab-pane fade" id="edit_tr" role="tabpanel">
                  <div class="row">
                    <x-blog::inputMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                         label="Name"
                                                         name="name"
                                                         type="text" id="edit_name" language="tr" />
                    <x-blog::textareaMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                            label="Description"
                                                            name="description"
                                                            type="text" id="edit_description" language="tr" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-12 mb-3">
              <input type="checkbox" name="is_active" class="form-check-input" id="edit_active" />
              <label class="form-check-label" for="edit_active">Active</label>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-12">
              <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li style="width: 3rem;height: 3rem" data-bs-toggle="tooltip" data-popup="tooltip-custom"
                    data-bs-placement="top"
                    class="avatar avatar-xs pull-up">
                  <img
                    src="" id="img_src"
                    alt="Avatar" class="rounded-circle">
                </li>
              </ul>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
    // Your modal HTML structure here

    // Your button click event
    $('.EditModalBTN').on('click', function() {
      let dataId = $(this).data('id');
      let name_ar = $(this).data('name-ar');
      let name_en = $(this).data('name-en');
      let name_tr = $(this).data('name-tr');
      let is_active = $(this).data('is-active');
      let parent_id = $(this).data('parent-id');
      let img = $(this).data('img');
      let description_ar = $(this).data('description-ar');
      let description_en = $(this).data('description-en');
      let description_tr = $(this).data('description-tr');
      // If you want to get the input value as well
      $('#editModal #editeId').val(dataId);
      $('#editModal #edit_name_tr').val(name_tr);
      $('#editModal #edit_name_ar').val(name_ar);
      $('#editModal #edit_name_en').val(name_en);
      $('#editModal #edit_description_tr').val(description_tr);
      $('#editModal #edit_description_en').val(description_en);
      $('#editModal #edit_description_ar').val(description_ar);
      $('#editModal #edit_active').prop('checked', is_active);
      $('#editModal #img_src').attr('src', img);
      $('#editModal #parentId').val(parent_id).trigger('change');

    });

  });
</script>
