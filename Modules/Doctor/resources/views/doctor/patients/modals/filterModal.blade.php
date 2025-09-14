@php use Modules\Core\App\Enum\Gender;use Modules\Core\app\Enums\UserStatusEnum;use Modules\Core\app\Models\Country;use Modules\Doctor\Enums\ActiveClinic;use Modules\Doctor\Enums\MaritalStatus;use Modules\Doctor\Enums\BloodType; @endphp
<div class="modal modal-xl fade" id="filterModal" tabindex="-1" aria-hidden="true" data-toggle="modal"
     data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data"
              action="{{route('doctor.patients.index')}}"
              method="get">

            <input type="hidden" name="id" id="editeId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.patients.filterPatients')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.name" id="filter_name"
                                           name="name"
                                           type="text"
                                           required="required"
                                           model="filter_name"
                                           value="{{old('name')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.clinics')"
                                            :placeholder="trans('doctor::doctor.patients.clinics')"
                                            id="filter_clinics_id"
                                            name="clinics_id"
                                            required="required"
                                            multiple="true"
                                            model="filter_clinics_id"
                                            :options="$clinics"
                                            value="{{old('clinics_id')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.minAge" id="minAge"
                                           name="minAge"
                                           type="number"
                                           required="required"
                                           model="minAge"
                                           value="{{old('minAge')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::input label="doctor::doctor.patients.maxAge" id="maxAge"
                                           name="maxAge"
                                           type="number"
                                           required="required"
                                           model="maxAge"
                                           value="{{old('maxAge')}}">
                            </x-core::input>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.gender')"
                                            :placeholder="trans('doctor::doctor.patients.gender')"
                                            id="filter_gender"
                                            name="gender"
                                            required="required"
                                            model="filter_gender"
                                            :options="Gender::getAllEnumValuesKeysLabel()"
                                            value="{{old('gender')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.active')"
                                            :placeholder="trans('doctor::doctor.patients.active')"
                                            id="filter_is_active"
                                            name="is_active"
                                            required="required"
                                            model="filter_is_active"
                                            :options="ActiveClinic::getAllEnumValuesKeysLabel()"
                                            value="{{old('is_active')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.blood_type')"
                                            :placeholder="trans('doctor::doctor.patients.blood_type')"
                                            id="filter_blood_type"
                                            name="blood_type"
                                            multiple="true"
                                            required="required"
                                            model="filter_blood_type"
                                            :options="BloodType::getAllEnumValuesKeysLabel()"
                                            value="{{old('blood_type')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.nationality_id')"
                                            :placeholder="trans('doctor::doctor.patients.nationality_id')"
                                            id="filter_nationality_id"
                                            name="nationality_id"
                                            multiple="true"
                                            required="required"
                                            model="filter_nationality_id"
                                            :options="$countries"
                                            value="{{old('nationality_id')}}">

                            </x-core::select>
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.patients.marital_status')"
                                            :placeholder="trans('doctor::doctor.patients.marital_status')"
                                            id="filter_marital_status"
                                            name="marital_status"
                                            required="required"
                                            model="filter_marital_status"
                                            :options="MaritalStatus::getAllEnumValuesKeysLabel()"
                                            value="{{old('marital_status')}}">

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
            let img = $(this).data('img');
            //let active = $(this).data('active');
            let age = $(this).data('age');
            let gender = $(this).data('gender');
            let work = $(this).data('work');
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
            $('#editModal #age').val(age);
            $('#editModal #work').val(work);
            $('#editModal #allergies').val(allergies);
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
