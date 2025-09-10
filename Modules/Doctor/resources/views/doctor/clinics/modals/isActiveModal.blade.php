<div class="modal fade" id="isActiveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="editStatusUser"
              action="{{route('admin.user_management.status')}}"
              method="POST">
            @csrf
            @method('DElETE')
            <input type="hidden" class="id" name="id" id="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        {{trans('usermanagement::user_management.user.editUserStatus')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" for="active_name">Name</label>
                            <input readonly type="text" name="name" class="form-control name" id="active_name"
                                   required/>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" for="active_email">Email</label>
                            <input readonly type="email" name="email" id="active_email" class="form-control email"
                                   required/>
                        </div>
                        <div class="col-6 mb-3" style="margin-top: 2rem !important;">
                            <input type="checkbox" name="is_active" class="form-check-input active" id="active_active"/>
                            <label class="form-check-label" for="active_active">Active</label>
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
    $(document).ready(function () {
        // Your modal HTML structure here

        // Your button click event
        $('.IsActiveModalBTN').on('click', function () {
            let dataId = $(this).data('id');
            let name = $(this).data('name');
            let email = $(this).data('email');
            let active = $(this).data('active');
            // If you want to get the input value as well
            $('#isActiveModal .id').val(dataId);
            $('#isActiveModal .name').val(name);
            $('#isActiveModal .email').val(email);
            $('#isActiveModal .active').prop('checked', active);
        });

    });
</script>
