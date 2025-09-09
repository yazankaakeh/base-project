<div class="modal fade" id="storeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="row g-3" enctype="multipart/form-data" id="formValidationExamples"
          action="{{route('blogTags.tags.store')}}"
          method="POST">
      @csrf
      @method('POST')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Add Tag</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <x-blog::inputMultiLanguageComponent :langs="$langs" :divClass="'col-lg-6 col-sm-12 col-md-6 mb-3'"
                                                 :label="'Name'"
                                                 :name="'name'"
                                                 :type="'text'" id="'name'" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary"
                  data-bs-dismiss="modal">{{trans('admin.close')}}</button>
          <button type="submit" class="btn btn-primary">{{trans('admin.save')}}</button>
        </div>
      </div>
    </form>
  </div>
</div>
