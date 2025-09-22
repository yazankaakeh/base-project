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
                <div class="row my-3">

                </div>
            </div>
        </div>
    </div>
</div>
