@php use Modules\Core\App\Enums\ActiveEnum; @endphp
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" data-toggle="modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="editUser"
              action="{{route('doctor.vitalSign.update')}}"
              method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="id" id="editeId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.vitalSign.updateMedicine')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <x-core::inputMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                             label="doctor::doctor.medicalSpecialty.name"
                                                             name="name"
                                                             type="text" id="name"/>

                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.active')"
                                            :placeholder="trans('doctor::doctor.patients.active')"
                                            id="is_active"
                                            name="is_active"
                                            required="required"
                                            model="is_active"
                                            :options="ActiveEnum::getAllEnumValuesKeysLabel()"
                                            value="{{old('active')}}">

                            </x-core::select>
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

        $('.EditModalBTN').on('click', function () {
            let dataId = $(this).data('id');
            let code = $(this).data('code');
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
            $('#editModal #code').val(code);
            // $('#editModal #active').prop('checked', active);
            $('#editModal #is_active').val(active);
        });
    });
</script>
