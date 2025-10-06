<div class="modal fade" id="payloadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="formValidationExamples"
              action="{{route('admin.user_management.store')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel1"> {{trans('usermanagement::user_management.audits.getPayLoad')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row modal-content-payload">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary"
                            data-bs-dismiss="modal">{{trans('usermanagement::user_management.close')}}</button>
                    <button type="submit" id="filter"
                            class="btn btn-primary">{{trans('usermanagement::user_management.submit')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
