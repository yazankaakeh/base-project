@php use Modules\Core\App\Enums\ActiveEnum; @endphp
<div class="modal fade" id="storeModalMedicine" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="createUser"
              action="{{route('doctor.medicine.store')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.medicine.createMedicine')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.name" id="create_name"
                                           name="name"
                                           type="text"
                                           required="required"
                                           model="create_name"
                                           value="{{old('name')}}">
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
