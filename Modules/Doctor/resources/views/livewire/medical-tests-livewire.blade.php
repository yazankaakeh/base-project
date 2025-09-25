<div wire:ignore.self data-livewire="{{$componentName}}">
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
            <h5 class="">{{$title}}</h5>
        </div>
        <div class="card-body">
            <div class="card-content">
                <div class="row" wire:ignore>
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

                    <div class="row my-3" wire:key="row-{{ $medicalTest->id }}">
                        <div class="col-5 mx-0 px-0">
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
                                    value="{{ $listMedicalTestsValues[$medicalTest->id]['value'] ?? null }}"
                            />
                        </div>
                        <div class="col-5 mx-0 me-1 px-0">
                            <x-core::input
                                    wire:key="debug-file-{{ $medicalTest->id }}"
                                    label="doctor::doctor.medicalExaminations.file"
                                    :labelValue="['name' => $medicalTest->medicalTest->name]"
                                    id="listMedicalTestsValues.{{$medicalTest->id}}.file"
                                    name="listMedicalTestsValues.{{$medicalTest->id}}.file"
                                    model="listMedicalTestsValues.{{$medicalTest->id}}.file"
                                    type="file"
                                    required="required"
                                    value="{{$listMedicalTestsValues[$medicalTest->id]['value'] ?? null}}">
                            </x-core::input>
                        </div>
                        <div class="col mx-0 px-0">
                            <button type="button" wire:click="saveMedicalTestDetails({{$medicalTest->id}})"
                                    class="btn my-5 btn-sm btn-icon btn-primary">
                                <i class="ti icon-base tabler-progress-check"></i>
                            </button>
                            @if($medicalTest->getMedia('attachment')?->first()?->getUrl())
                                <a href="{{$medicalTest->getMedia('attachment')?->first()?->getUrl()}}"
                                   target="_blank"
                                   class="btn my-5 btn-sm btn-icon btn-info">
                                    <i class="ti icon-base tabler-eye"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
