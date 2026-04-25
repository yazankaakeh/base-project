<div wire:ignore.self data-livewire="{{$componentName}}">
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
            <div class="card-title mb-0">
                <h5 class="">{{trans('doctor::doctor.medicalExaminations.medicines')}}</h5>
            </div>
            <div class="d-inline">
                <button class="btn btn-icon rounded-pill btn-info"
                        data-bs-toggle="modal" data-bs-target="#storeModalMedicine">
                    <i class="ti tabler-plus"></i>
                </button>

            </div>

        </div>
        <div class="card-body">
            <div class="card-content">
                @foreach($medicinesData as $index => $medicine)
                    <div class="row my-3">
                        <div class="col-3">
                            <x-core::select
                                    :label="trans('doctor::doctor.medicalExaminations.drugName')"
                                    :placeholder="trans('doctor::doctor.medicalExaminations.drugName')"
                                    id="medicinesData.{{$index}}.medicine_id"
                                    name="medicinesData.{{$index}}.medicine_id"
                                    model="medicinesData.{{$index}}.medicine_id"
                                    required="required"
                                    :options="$medicines"
                                    value="{{old('medicine_id')}}">
                            </x-core::select>
                        </div>
                        <div class="col">
                            <x-core::input label="doctor::doctor.medicalExaminations.dose"
                                           id="medicinesData.{{$index}}.dose"
                                           name="medicinesData.{{$index}}.dose"
                                           model="medicinesData.{{$index}}.dose"
                                           type="text"
                                           required="required"
                                           value="{{old('dose')}}">
                            </x-core::input>
                        </div>
                        <div class="col">
                            <x-core::input label="doctor::doctor.medicalExaminations.dosage"
                                           id="medicinesData.{{$index}}.dosage"
                                           name="medicinesData.{{$index}}.dosage"
                                           model="medicinesData.{{$index}}.dosage"
                                           type="text"
                                           required="required"
                                           value="{{old('dosage')}}">
                            </x-core::input>
                        </div>
                        <div class="col-3">
                            <x-core::select
                                    :label="trans('doctor::doctor.medicalExaminations.howToDrink')"
                                    :placeholder="trans('doctor::doctor.medicalExaminations.howToDrink')"
                                    id="medicinesData.{{$index}}.dosage_form_id"
                                    name="medicinesData.{{$index}}.dosage_form_id"
                                    model="medicinesData.{{$index}}.dosage_form_id"
                                    required="required"
                                    :options="$dosageForms"
                                    value="{{old('dosage_form_id')}}">
                            </x-core::select>
                        </div>
                        <div class="col">
                            <x-core::input label="doctor::doctor.medicalExaminations.duration"
                                           id="medicinesData.{{$index}}.duration"
                                           name="medicinesData.{{$index}}.duration"
                                           model="medicinesData.{{$index}}.duration"
                                           type="text"
                                           required="required"
                                           value="{{old('duration')}}">
                            </x-core::input>
                        </div>
                        <div class="col">
                            <x-core::textarea label="doctor::doctor.medicalExaminations.note"
                                              required=""
                                              id="medicinesData.{{$index}}.note"
                                              name="medicinesData.{{$index}}.note"
                                              model="medicinesData.{{$index}}.note"
                                              value="{{old('note')}}"
                                              type="text">
                            </x-core::textarea>
                        </div>
                        <div class="col align-content-end">
                            <button class="btn btn-icon rounded-pill btn-primary" wire:click="increase()">
                                <i class="ti tabler-copy-plus"></i>
                            </button>
                            <button wire:click="decrease({{$index}})" class="btn my-2 btn-icon btn-danger">
                                <i class="ti tabler-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
                <div class="row my-3">
                    <div class="col text-end">
                        <button wire:click="save" class="btn btn-primary">
                            {{trans('doctor::doctor.save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
