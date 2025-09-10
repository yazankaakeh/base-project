@php use Modules\Doctor\Enums\ActiveClinic; @endphp
<div class="modal fade" id="storeModal" tabindex="-1" aria-hidden="true" data-toggle="modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="createUser"
              action="{{route('doctor.clinic.store')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.clinic.createClinic')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <x-core::inputMultiLanguageComponent divClass="col-lg-12 col-sm-12 col-md-6 mb-3"
                                                                 label="doctor::doctor.clinic.name"
                                                                 name="name"
                                                                 type="text" id="create_name"
                                                                 :language="app()->getLocale()"/>
                            {{-- <x-core::input label="doctor::doctor.clinic.name"
                                            placeholder="doctor::doctor.clinic.name"
                                            id="create_name"
                                            name="name"
                                            type="text"
                                            required="required"
                                            model="create_name"
                                            value="{{old('name')}}">

                            </x-core::input>--}}
                        </div>
                        <div class="col-6 mb-3">
                            <x-core::select :label="trans('doctor::doctor.clinic.active')"
                                            :placeholder="trans('doctor::doctor.clinic.active')"
                                            id="active"
                                            name="active"
                                            required="required"
                                            model="active"
                                            :options="ActiveClinic::getAllEnumValuesKeysLabel()"
                                            value="{{old('active')}}">

                            </x-core::select>
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
