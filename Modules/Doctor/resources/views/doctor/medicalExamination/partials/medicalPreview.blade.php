<div class="card">
    <div class="card-header d-flex justify-content-between pb-2 mb-1">
        <h5 class="">{{trans('doctor::doctor.medicalExaminations.medicalPreviewInfo')}}</h5>
    </div>
    <div class="card-body">
        <div class="card-content">
            <form action="{{route('doctor.medicalExamination.submit')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" value="{{$medicalExamination->id}}" name="id">
                <div class="row mb-3">
                    <x-core::input label="doctor::doctor.medicalExaminations.reasonOfVisiting"
                                   id="reason_of_visiting" name="reason_of_visiting"
                                   type="text" model="reason_of_visiting"
                                   :value="old('reason_of_visiting',$medicalExamination->reason_of_visiting)">
                    </x-core::input>
                </div>
                <div class="row my-3">
                    <x-core::textarea label="doctor::doctor.medicalExaminations.clinical_examination"
                                      id="clinical_examination" name="clinical_examination"
                                      type="text" model="clinical_examination"
                                      :value="old('clinical_examination',$medicalExamination->clinical_examination)">
                    </x-core::textarea>
                </div>
                <div class="row my-3">
                    <div class="col-6">
                        <x-core::input label="doctor::doctor.medicalExaminations.impression"
                                       id="impression" name="impression"
                                       type="text" model="impression"
                                       :value="old('impression',$medicalExamination->impression)">
                        </x-core::input>
                    </div>
                    <div class="col-6">
                        <x-core::input label="doctor::doctor.medicalExaminations.request_for_action"
                                       id="request_for_action" name="request_for_action"
                                       type="text" model="request_for_action"
                                       required=""
                                       :value="old('request_for_action',$medicalExamination->request_for_action)">
                        </x-core::input>
                    </div>
                </div>
                <div class="row my-3">
                    <x-core::textarea label="doctor::doctor.medicalExaminations.note"
                                      required=""
                                      id="note" name="note" :value="old('note',$medicalExamination->note)"
                                      type="text" model="note">
                    </x-core::textarea>
                </div>
                <div class="row my-3">
                    <div class="col text-end">
                        <button class="btn btn-success">
                            <i class="ti me-2 icon-base tabler-progress-check"></i>
                            {{trans('doctor::doctor.save')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>