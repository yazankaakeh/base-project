<div class="modal fade" id="storeModal" tabindex="-1" aria-hidden="true" data-toggle="modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="createUser"
              action="{{route('admin.user_management.store')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('usermanagement::user_management.user.create.title')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.name"
                                           placeholder="usermanagement::user_management.user.create.name"
                                           id="create_name"
                                           name="name"
                                           type="text"
                                           required="required"
                                           model="create_name"
                                           value="{{old('name')}}">

                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.email"
                                           placeholder="usermanagement::user_management.user.create.email"
                                           id="create_email"
                                           name="email"
                                           type="text"
                                           required="required"
                                           model="create_email"
                                           value="{{old('email')}}">

                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.phone"
                                           placeholder="usermanagement::user_management.user.create.phone"
                                           id="create_phone"
                                           name="phone"
                                           type="text"
                                           required="required"
                                           model="create_phone"
                                           value="{{old('phone')}}">

                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('usermanagement::user_management.user.create.role')"
                                            :placeholder="trans('usermanagement::user_management.user.create.role')"
                                            id="create_role"
                                            name="role"
                                            required="required"
                                            model="create_role"
                                            :options="$roles"
                                            value="{{old('role')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.img" id="create_img"
                                           name="img"
                                           type="file"
                                           required="required"
                                           model="create_img"
                                           value="">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.password"
                                           id="create_password" name="password"
                                           type="password"
                                           model="create_password"
                                           required="required"
                                           value="">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.password_confirmation"
                                           id="create_password_confirmation" name="password_confirmation"
                                           type="password"
                                           model="create_password_confirmation"
                                           required="required"
                                           value="">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.isActive"
                                           id="create_active" name="is_active"
                                           type="checkbox"
                                           model="create_active"
                                           required=""
                                           class="form-check-input"
                                           value="on">
                            </x-core::input>
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
