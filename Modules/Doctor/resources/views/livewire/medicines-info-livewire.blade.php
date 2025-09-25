<div wire:ignore.self data-livewire="{{$componentName}}">
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
            <div class="card-title mb-0">
                <h5 class="">{{trans('doctor::doctor.medicalExaminations.medicines')}}</h5>
            </div>
            <button class="btn btn-icon rounded-pill btn-primary" wire:click="increase()">
                <i class="ti tabler-plus"></i>
            </button>
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
                            <x-core::input label="doctor::doctor.medicalExaminations.repetition"
                                           id="medicinesData.{{$index}}.dosage"
                                           name="medicinesData.{{$index}}.dosage"
                                           model="medicinesData.{{$index}}.dosage"
                                           type="text"
                                           required="required"
                                           value="{{old('dosage')}}">
                            </x-core::input>
                        </div>
                        <div class="col">
                            <x-core::input label="doctor::doctor.medicalExaminations.howToDrink"
                                           id="medicinesData.{{$index}}.type"
                                           name="medicinesData.{{$index}}.type"
                                           model="medicinesData.{{$index}}.type"
                                           type="text"
                                           required="required"
                                           value="{{old('type')}}">
                            </x-core::input>
                        </div>
                        <div class="col">
                            <x-core::input label="doctor::doctor.medicalExaminations.number"
                                           id="medicinesData.{{$index}}.count"
                                           name="medicinesData.{{$index}}.count"
                                           model="medicinesData.{{$index}}.count"
                                           type="text"
                                           required="required"
                                           value="{{old('count')}}">
                            </x-core::input>
                        </div>
                        <div class="col">
                            <x-core::input label="doctor::doctor.medicalExaminations.note"
                                           id="medicinesData.{{$index}}.note"
                                           name="medicinesData.{{$index}}.note"
                                           model="medicinesData.{{$index}}.note"
                                           type="text"
                                           required="required"
                                           value="{{old('note')}}">
                            </x-core::input>
                        </div>
                        <div class="col align-content-end">
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
