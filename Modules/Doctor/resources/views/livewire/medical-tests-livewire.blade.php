<div wire:ignore.self data-livewire="{{$componentName}}">
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
            <h5 class="">{{$title}}</h5>
        </div>
        <div class="card-body">
            <div class="card-content">
                <div class="row">
                    <x-core::select
                            :label="$title"
                            :placeholder="$title"
                            :id="$name"
                            :name="$name"
                            :model="$name"
                            required="required"
                            :multiple="true"
                            :onChangeEvent="$onChangeEvent"
                            :onChange="$onChangeEvent"
                            :options="$medicalTests"
                            :values="$addedMedicalTests">
                    </x-core::select>
                </div>
                @foreach($listMedicalTests as $medicalTest)
                    <div class="row my-3">
                        <div class="col-5">
                            @php
                                $label = str(__('doctor::doctor.medicalExaminations.value', ['medicalTest' => $medicalTest->name]));
                            @endphp
                            <x-core::input
                                    label="doctor::doctor.medicalExaminations.value"
                                    :labelValue="['name' => $medicalTest->medicalTest->name]"
                                    id="listMedicalTestsValues.{{ $medicalTest->id }}.value"
                                    name="listMedicalTestsValues.{{ $medicalTest->id }}.value"
                                    model="listMedicalTestsValues.{{ $medicalTest->id }}.value"
                                    type="text"
                                    required="required"
                                    value="{{ old('value') }}"
                            />
                        </div>
                        <div class="col-5">
                            <x-core::input
                                    label="doctor::doctor.medicalExaminations.file"
                                    :labelValue="['name' => $medicalTest->medicalTest->name]"
                                    id="listMedicalTestsValues.{{$medicalTest->id}}.file"
                                    name="listMedicalTestsValues.{{$medicalTest->id}}.file"
                                    model="listMedicalTestsValues.{{$medicalTest->id}}.file"
                                    type="file"
                                    required="required"
                                    value="{{old('value')}}">
                            </x-core::input>
                        </div>
                        <div class="col-1">
                            <button class="btn my-5 btn-sm btn-primary">
                                <i class="ti icon-base tabler-progress-check"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
