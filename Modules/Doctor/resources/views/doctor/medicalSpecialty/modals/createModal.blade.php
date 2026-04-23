@php use Modules\Core\App\Enums\ActiveEnum; @endphp
<div class="modal fade" id="storeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="createUser"
              action="{{route('doctor.medicalSpecialty.store')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.medicalSpecialty.createMedicalSpecialty')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <x-core::inputMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                             label="doctor::doctor.medicalSpecialty.name"
                                                             name="name"
                                                             type="text" id="create_name"/>

                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.medicalSpecialty.code" id="create_code"
                                           name="code"
                                           type="text"
                                           required="required"
                                           model="create_code"
                                           value="{{old('code')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.active')"
                                            :placeholder="trans('doctor::doctor.patients.active')"
                                            id="active"
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
                        {{trans('doctor::doctor.close')}}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{trans('doctor::doctor.save')}}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
