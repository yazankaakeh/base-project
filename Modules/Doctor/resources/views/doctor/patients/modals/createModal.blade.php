@php use Modules\Core\App\Enum\Gender;use Modules\Core\App\Enums\ActiveEnum;use Modules\Core\app\Models\Country;use Modules\Doctor\Enums\MaritalStatus;use Modules\Doctor\Enums\BloodType; @endphp
<div class="modal modal-xl fade" id="storeModal" tabindex="-1" aria-hidden="true" data-toggle="modal"
     data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data"
              action="{{route('doctor.patients.store')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.patients.createPatients')}}
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
                            <x-core::select :label="trans('doctor::doctor.patients.clinics')"
                                            :placeholder="trans('doctor::doctor.patients.clinics')"
                                            id="create_clinics_id"
                                            name="clinics_id"
                                            required="required"
                                            multiple="true"
                                            model="create_clinics_id"
                                            :options="$clinics"
                                            value="">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.age" id="create_age"
                                           name="age"
                                           type="number"
                                           required="required"
                                           model="create_age"
                                           value="{{old('age')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.children" id="create_children"
                                           name="children"
                                           type="text"
                                           required="required"
                                           model="create_children"
                                           value="{{old('children')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.phone" id="create_phone"
                                           name="phone"
                                           type="text"
                                           required="required"
                                           model="create_phone"
                                           value="{{old('phone')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.gender')"
                                            :placeholder="trans('doctor::doctor.patients.gender')"
                                            id="create_gender"
                                            name="gender"
                                            required="required"
                                            model="gender"
                                            :options="Gender::getAllEnumValuesKeysLabel()"
                                            value="{{old('gender')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.active')"
                                            :placeholder="trans('doctor::doctor.patients.active')"
                                            id="create_is_active"
                                            name="is_active"
                                            required="required"
                                            model="create_is_active"
                                            :options="ActiveEnum::getAllEnumValuesKeysLabel()"
                                            value="{{old('is_active')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.work" id="create_work"
                                           name="work"
                                           type="text"
                                           required="required"
                                           model="create_work"
                                           value="{{old('work')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.blood_type')"
                                            :placeholder="trans('doctor::doctor.patients.blood_type')"
                                            id="create_blood_type"
                                            name="blood_type"
                                            required="required"
                                            model="create_blood_type"
                                            :options="BloodType::getAllEnumValuesKeysLabel()"
                                            value="{{old('blood_type')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.nationality_id')"
                                            :placeholder="trans('doctor::doctor.patients.nationality_id')"
                                            id="create_nationality_id"
                                            name="nationality_id"
                                            required="required"
                                            model="create_nationality_id"
                                            :options="$countries"
                                            value="{{old('nationality_id')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.marital_status')"
                                            :placeholder="trans('doctor::doctor.patients.marital_status')"
                                            id="create_marital_status"
                                            name="marital_status"
                                            required="required"
                                            model="create_marital_status"
                                            :options="MaritalStatus::getAllEnumValuesKeysLabel()"
                                            value="{{old('marital_status')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.drug_allergies" id="create_drug_allergies"
                                           name="drug_allergies"
                                           type="text"
                                           required="required"
                                           model="create_drug_allergies"
                                           value="{{old('drug_allergies')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.disabilities" id="create_disabilities"
                                           name="disabilities"
                                           type="text"
                                           required="required"
                                           model="create_disabilities"
                                           value="{{old('disabilities')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.medical_history" id="create_medical_history"
                                           name="medical_history"
                                           type="text"
                                           required="required"
                                           model="create_medical_history"
                                           value="{{old('medical_history')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.surgical_history" id="create_surgical_history"
                                           name="surgical_history"
                                           type="text"
                                           required="required"
                                           model="create_surgical_history"
                                           value="{{old('surgical_history')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.accident_history" id="create_accident_history"
                                           name="accident_history"
                                           type="text"
                                           required="required"
                                           model="create_accident_history"
                                           value="{{old('accident_history')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.password" id="create_password"
                                           name="password"
                                           type="text"
                                           required=""
                                           model="create_password"
                                           value="{{old('password')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.email" id="create_email"
                                           name="email"
                                           type="text"
                                           required="required"
                                           model="create_email"
                                           value="{{old('email')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="usermanagement::user_management.user.create.img" id="create_img"
                                           name="img"
                                           type="file"
                                           required=""
                                           model="create_img"
                                           value="">
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
