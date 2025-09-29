<div data-livewire="{{$componentName}}">
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
            <h5 class="">{{$title}}</h5>
            <button data-bs-toggle="modal" data-bs-target="#storeModalMedicalTest"
                    class="btn btn-info rounded-pill btn-icon">
                <i class="ti tabler-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="card-content">

                <button data-bs-toggle="modal" data-bs-target="#{{$name}}"
                        class="btn btn-instagram rounded-pill">
                    {{trans('doctor::doctor.medicalExaminations.addMedicalTest')}}
                    <i class="ti icon-base tabler-plus"></i>
                </button>


            </div>
        </div>
    </div>

    <div class="modal modal-lg fade" wire:ignore.self id="{{$name}}" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.modalUploadFile.title')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row my-3">
                        @foreach($medicalTests as $index => $medicalTest)
                            @php
                                $checked = in_array($index, $addedMedicalTests);
                            @endphp
                            <div class="col-lg-4 my-4 col-md-4 col-sm-12">
                                <x-core::input
                                        :label="$medicalTest"
                                        :class="$checked ? 'text-success' : 'text-danger'"
                                        id="listMedicalTests_{{$index}}"
                                        name="listMedicalTests[]"

                                        model="listMedicalTests"
                                        type="checkbox"
                                        value="{{$index}}"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        {{trans('doctor::doctor.cancel')}}
                    </button>
                    <button type="submit" wire:click="submit()" class="btn btn-primary">
                        {{trans('doctor::doctor.save')}}
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>
