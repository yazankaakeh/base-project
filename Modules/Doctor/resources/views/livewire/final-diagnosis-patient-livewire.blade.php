<div wire:ignore.self data-livewire="{{$componentName}}">
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
            <h5 class="">{{trans('doctor::doctor.medicalExaminations.finalDiagnosisInfo')}}</h5>
        </div>
        <div class="card-body">
            <div class="card-content">
                <div class="row">
                    <x-core::select
                            :label="trans('doctor::doctor.medicalExaminations.finalDiagnosisInfo')"
                            :placeholder="trans('doctor::doctor.medicalExaminations.finalDiagnosisInfo')"
                            :id="$name"
                            :name="$name"
                            :model="$name"
                            required="required"
                            :multiple="true"
                            :onChangeEvent="$onChangeEvent"
                            :onChange="$onChangeEvent"
                            :options="$finalDiagnosis">
                    </x-core::select>
                </div>
                <div class="row my-4">
                    {{--@foreach($selectedFinalDiagnosis as $selectedFinalDiagnose)
                        <div class="col">
                            <div class="badge badge-primary">
                                {{$selectedFinalDiagnose->finalDiagnose->name}}
                            </div>
                        </div>
                    @endforeach--}}

                </div>
            </div>
        </div>
    </div>
</div>
