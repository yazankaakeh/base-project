<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="row g-3" enctype="multipart/form-data" id="formValidationExamples"
          action="{{route('blogTags.tags.update')}}"
          method="POST">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="editeId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <x-blog::inputMultiLanguageComponent :langs="$langs" :divClass="'col-lg-6 col-sm-12 col-md-6 mb-3'"
                                                 :label="'Name'"
                                                 :name="'name'"
                                                 :type="'text'" id="edit_name" />
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
      // If you want to get the input value as well
      $('#editModal #editeId').val(dataId);
      $('#editModal #edit_name_tr').val(name_tr);
      $('#editModal #edit_name_ar').val(name_ar);
      $('#editModal #edit_name_en').val(name_en);
      $('#editModal #role').val(role);
    });

  });
</script>
