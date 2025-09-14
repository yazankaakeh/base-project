@php use Modules\Core\App\Enums\ActiveEnum; @endphp
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-toggle="modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="editUser"
              action="{{route('doctor.clinic.update')}}"
              method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="id" id="editeId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.clinic.createClinic')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <x-core::inputMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                             label="doctor::doctor.clinic.name"
                                                             name="name"
                                                             type="text" id="name"/>

                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.clinic.active')"
                                            :placeholder="trans('doctor::doctor.clinic.active')"
                                            id="active"
                                            name="active"
                                            required="required"
                                            model="active"
                                            :options="ActiveEnum::getAllEnumValuesKeysLabel()"
                                            value="{{old('active')}}">

                            </x-core::select>
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
                                <li data-bs-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-bs-placement="top"
                                    class="avatar avatar-xl pull-up">
                                    <img src="" id="img_src" alt="Avatar" class="rounded-circle">
                                </li>
                            </ul>

                        </div>

                        {{--<div class="col-6 mb-3" style="margin-top: 2rem !important;">
                                <x-core::input label="usermanagement::user_management.user.create.isActive"
                                               id="editIsActive" name="is_active"
                                               type="checkbox"
                                               model="editIsActive"
                                               required=""
                                               class="form-check-input"
                                               value="on">
                                </x-core::input>
                            </div>--}}


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

        $('.EditModalBTN').on('click', function () {
            let dataId = $(this).data('id');
            let name = $(this).data('name');
            let img = $(this).data('img');
            //let active = $(this).data('active');
            let active = $(this).data('active');
            let nameTranslations;
            try {
                nameTranslations = JSON.parse($(this).attr('data-name') || '{}');
            } catch {
                nameTranslations = {};
            }
            console.log(nameTranslations);
            const modal = $('#editModal');
            Object.entries(nameTranslations).forEach(([locale, value]) => {
                modal.find(`[name="name[${locale}]"]`).val(value ?? '');
            });
            // If you want to get the input value as well
            $('#editModal #editeId').val(dataId);
            $('#editModal #name').val(name);
            $('#editModal #img_src').attr('src', img);
            // $('#editModal #active').prop('checked', active);
            $('#editModal #active').val(active);
        });
    });
</script>
