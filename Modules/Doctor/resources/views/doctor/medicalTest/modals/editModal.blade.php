@php use Modules\Core\App\Enums\ActiveEnum; @endphp
<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="editUser"
              action="{{route('doctor.medicalTest.update')}}"
              method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="id" id="editeId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.medicalTest.updateMedicalTest')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.medicalTest.name" id="name"
                                           name="name"
                                           type="text"
                                           required="required"
                                           model="name"
                                           value="{{old('name')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.medicalTest.unit" id="unit"
                                           name="unit"
                                           type="text"
                                           required="required"
                                           model="unit"
                                           value="{{old('unit')}}">
                            </x-core::input>
                        </div>
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
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.medicalTest.type')"
                                            :placeholder="trans('doctor::doctor.medicalTest.type')"
                                            id="type"
                                            name="type"
                                            required="required"
                                            model="type"
                                            :options="MedicalTestTypeEnum::getAllEnumValuesKeysLabel()"
                                            value="{{old('type')}}">

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
            let name = $(this).data('name');
            //let active = $(this).data('active');
            let active = $(this).data('active');
            let unit = $(this).data('unit');
            // If you want to get the input value as well
            $('#editModal #editeId').val(dataId);
            $('#editModal #name').val(name);
            $('#editModal #unit').val(unit);
            $('#editModal #is_active').val(active).trigger('change');
        });
    });
</script>
