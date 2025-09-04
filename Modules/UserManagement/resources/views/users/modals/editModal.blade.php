<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-toggle="modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="editUser"
              action="{{route('admin.user_management.update')}}"
              method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editeId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('usermanagement::user_management.user.edit.title')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.name"
                                           placeholder="usermanagement::user_management.user.create.name"
                                           id="name"
                                           name="name"
                                           type="text"
                                           required="required"
                                           model="name"
                                           value="{{old('name')}}">

                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.email"
                                           placeholder="usermanagement::user_management.user.create.email"
                                           id="email"
                                           name="email"
                                           type="email"
                                           required="required"
                                           model="email"
                                           value="{{old('email')}}">

                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.phone"
                                           placeholder="usermanagement::user_management.user.create.phone"
                                           id="phone"
                                           name="phone"
                                           type="text"
                                           required="required"
                                           model="phone"
                                           value="{{old('phone')}}">

                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('usermanagement::user_management.user.create.role')"
                                            :placeholder="trans('usermanagement::user_management.user.create.role')"
                                            id="role"
                                            name="role"
                                            required="required"
                                            model="role"
                                            :options="$roles"
                                            value="{{old('role')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.password"
                                           placeholder="usermanagement::user_management.user.create.password"
                                           id="password"
                                           name="password"
                                           type="password"
                                           required=""
                                           model="password"
                                           value="{{old('password')}}">

                            </x-core::input>
                        </div>
                        <div class="col-6">
                            <x-core::input label="usermanagement::user_management.user.create.password_confirmation"
                                           placeholder="usermanagement::user_management.user.create.password_confirmation"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           type="password_confirmation"
                                           required=""
                                           model="password_confirmation"
                                           value="{{old('password_confirmation')}}">

                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3" style="margin-top: 2rem !important;">
                            <x-core::input label="usermanagement::user_management.user.create.isActive"
                                           id="editIsActive" name="is_active"
                                           type="checkbox"
                                           model="editIsActive"
                                           required=""
                                           class="form-check-input"
                                           value="on">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.img" id="img"
                                           name="img"
                                           type="file"
                                           required=""
                                           model="img"
                                           value="">
                            </x-core::input>
                        </div>
                        <div class="col-6 mt-4">
                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                <li style="width: 3rem;height: 3rem" data-bs-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-bs-placement="top"
                                    class="avatar avatar-xs pull-up">
                                    <img src="" id="img_src" alt="Avatar" class="rounded-circle">
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        {{trans('usermanagement::user_management.close')}}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{trans('usermanagement::user_management.save')}}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Your modal HTML structure here

        // Your button click event
        $('.EditModalBTN').on('click', function () {
            let dataId = $(this).data('id');
            let name = $(this).data('name');
            let email = $(this).data('email');
            let img = $(this).data('img');
            let active = $(this).data('active');
            let role = $(this).data('role');
            // If you want to get the input value as well
            $('#editModal #editeId').val(dataId);
            $('#editModal #name').val(name);
            $('#editModal #email').val(email);
            $('#editModal #img_src').attr('src', img);
            $('#editModal #active').prop('checked', active);
            $('#editModal #role').val(role);
        });
    });
</script>
