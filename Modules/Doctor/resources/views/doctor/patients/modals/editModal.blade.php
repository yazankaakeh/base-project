@php use Modules\Core\App\Enum\Gender;use Modules\Core\App\Enums\ActiveEnum;use Modules\Core\app\Models\Country;use Modules\Doctor\Enums\MaritalStatus;use Modules\Doctor\Enums\BloodType; @endphp
<div class="modal modal-xl fade" id="editModal" tabindex="-1" aria-hidden="true" data-toggle="modal"
     data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="editUser"
              action="{{route('doctor.patients.update')}}"
              method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="id" id="editeId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.patients.updatePatients')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.name" id="name"
                                           name="name"
                                           type="text"
                                           required="required"
                                           model="name"
                                           value="{{old('name')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.phone" id="phone"
                                           name="phone"
                                           type="text"
                                           required="required"
                                           model="phone"
                                           value="{{old('phone')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.clinics')"
                                            :placeholder="trans('doctor::doctor.patients.clinics')"
                                            id="clinics_id"
                                            name="clinics_id[]"
                                            required="required"
                                            multiple="true"
                                            model="clinics_id"
                                            :options="$clinics"
                                            value="">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.age" id="age"
                                           name="age"
                                           type="date"
                                           required="required"
                                           model="age"
                                           value="{{old('age')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.children" id="children"
                                           name="children"
                                           type="text"
                                           required="required"
                                           model="children"
                                           value="{{old('children')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.gender')"
                                            :placeholder="trans('doctor::doctor.patients.gender')"
                                            id="gender"
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
                                            id="is_active"
                                            name="is_active"
                                            required="required"
                                            model="is_active"
                                            :options="ActiveEnum::getAllEnumValuesKeysLabel()"
                                            value="{{old('is_active')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.work" id="work"
                                           name="work"
                                           type="text"
                                           required="required"
                                           model="work"
                                           value="{{old('work')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.blood_type')"
                                            :placeholder="trans('doctor::doctor.patients.blood_type')"
                                            id="blood_type"
                                            name="blood_type"
                                            required="required"
                                            model="blood_type"
                                            :options="BloodType::getAllEnumValuesKeysLabel()"
                                            value="{{old('blood_type')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.nationality_id')"
                                            :placeholder="trans('doctor::doctor.patients.nationality_id')"
                                            id="nationality_id"
                                            name="nationality_id"
                                            required="required"
                                            model="nationality_id"
                                            :options="$countries"
                                            value="{{old('nationality_id')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.marital_status')"
                                            :placeholder="trans('doctor::doctor.patients.marital_status')"
                                            id="marital_status"
                                            name="marital_status"
                                            required="required"
                                            model="marital_status"
                                            :options="MaritalStatus::getAllEnumValuesKeysLabel()"
                                            value="{{old('marital_status')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.drug_allergies" id="drug_allergies"
                                           name="drug_allergies"
                                           type="text"
                                           required="required"
                                           model="drug_allergies"
                                           value="{{old('drug_allergies')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.disabilities" id="disabilities"
                                           name="disabilities"
                                           type="text"
                                           required="required"
                                           model="disabilities"
                                           value="{{old('disabilities')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.medical_history" id="medical_history"
                                           name="medical_history"
                                           type="text"
                                           required="required"
                                           model="medical_history"
                                           value="{{old('medical_history')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.surgical_history" id="surgical_history"
                                           name="surgical_history"
                                           type="text"
                                           required="required"
                                           model="surgical_history"
                                           value="{{old('surgical_history')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.accident_history" id="accident_history"
                                           name="accident_history"
                                           type="text"
                                           required="required"
                                           model="accident_history"
                                           value="{{old('accident_history')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.password" id="password"
                                           name="password"
                                           type="text"
                                           required=""
                                           model="password"
                                           value="{{old('password')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.email" id="email"
                                           name="email"
                                           type="text"
                                           required="required"
                                           model="email"
                                           value="{{old('email')}}">
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
                                <li data-bs-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-bs-placement="top"
                                    class="avatar avatar-xl pull-up">
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

        $('.EditModalBTN').on('click', function () {
            let dataId = $(this).data('id');
            let name = $(this).data('name');
            let img = $(this).data('img');
            //let active = $(this).data('active');
            let age = $(this).data('age');
            let gender = $(this).data('gender');
            let work = $(this).data('work');
            let clinics = $(this).data('clinics');
            let phone = $(this).data('phone');
            let allergies = $(this).data('drug-allergies');
            let blood_type = $(this).data('blood-type');
            let disabilities = $(this).data('disabilities');
            let medical_history = $(this).data('medical-history');
            let marital_status = $(this).data('marital-status');
            let drug_allergies = $(this).data('drug-allergies');
            let surgical_history = $(this).data('surgical-history');
            let accident_history = $(this).data('accident-history');
            let active = $(this).data('active');
            let children = $(this).data('children');
            let email = $(this).data('email');
            let nationalityId = $(this).data('nationalityid');
            // If you want to get the input value as well
            $('#editModal #editeId').val(dataId);
            $('#editModal #name').val(name);
            $('#editModal #img_src').attr('src', img);
            $('#editModal #is_active').val(active).trigger('change');
            $('#editModal #gender').val(gender).trigger('change');
            $('#editModal #blood_type').val(blood_type).trigger('change');
            $('#editModal #marital_status').val(marital_status).trigger('change');
            $('#editModal #nationality_id').val(nationalityId).trigger('change');
            $('#editModal #clinics_id').val(clinics).trigger('change');
            $('#editModal #age').val(age);
            $('#editModal #work').val(work);
            $('#editModal #allergies').val(allergies);
            $('#editModal #phone').val(phone);
            $('#editModal #disabilities').val(disabilities);
            $('#editModal #medical_history').val(medical_history);
            $('#editModal #surgical_history').val(surgical_history);
            $('#editModal #accident_history').val(accident_history);
            $('#editModal #drug_allergies').val(drug_allergies);
            $('#editModal #children').val(children);
            $('#editModal #email').val(email);
        });
    });
</script>
