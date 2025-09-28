@php use Modules\Core\App\Enums\ActiveEnum;use Modules\Doctor\Enums\MedicalTestTypeEnum; @endphp
<div class="modal fade" id="storeModalMedicalTest" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="createUser"
              action="{{route('doctor.medicalTest.store')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.medicalTest.createMedicalTest')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.medicalTest.name" id="create_name"
                                           name="name"
                                           type="text"
                                           required="required"
                                           model="create_name"
                                           value="{{old('name')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.medicalTest.unit" id="create_unit"
                                           name="unit"
                                           type="text"
                                           required="required"
                                           model="create_unit"
                                           value="{{old('unit')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.active')"
                                            :placeholder="trans('doctor::doctor.patients.active')"
                                            id="create_is_active"
                                            name="is_active"
                                            required="required"
                                            model="create_is_active"
                                            :options="ActiveEnum::getAllEnumValuesKeysLabel()"
                                            value="{{old('active')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.medicalTest.type')"
                                            :placeholder="trans('doctor::doctor.medicalTest.type')"
                                            id="create_type"
                                            name="type"
                                            required="required"
                                            model="create_type"
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
