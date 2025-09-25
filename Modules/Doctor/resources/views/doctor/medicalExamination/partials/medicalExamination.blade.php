@php use Spatie\MediaLibrary\MediaCollections\Models\Media; @endphp
<div class="card text-center">
    <div class="card-header px-0 pt-0">
        <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active waves-effect" role="tab" data-bs-toggle="tab"
                            data-bs-target="#medicalPreview-{{$medicalExam->id}}"
                            aria-controls="medicalPreview-{{$medicalExam->id}}" aria-selected="true">
                        {{trans('doctor::doctor.medicalExaminations.card.medicalPreview')}}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                            data-bs-target="#finalDiagnosisTap-{{$medicalExam->id}}"
                            aria-controls="finalDiagnosisTap-{{$medicalExam->id}}" aria-selected="true">
                        {{trans('doctor::doctor.medicalExaminations.card.finalDiagnosis')}}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                            data-bs-target="#vitalSigns-{{$medicalExam->id}}"
                            aria-controls="vitalSigns-{{$medicalExam->id}}" aria-selected="false"
                            tabindex="-1">
                        {{trans('doctor::doctor.medicalExaminations.card.vitalSigns')}}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                            data-bs-target="#medicines-{{$medicalExam->id}}"
                            aria-controls="medicines-{{$medicalExam->id}}" aria-selected="false"
                            tabindex="-1">
                        {{trans('doctor::doctor.medicalExaminations.card.medicines')}}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link waves-effect" role="tab" data-bs-toggle="tab"
                            data-bs-target="#medicalTest-{{$medicalExam->id}}"
                            aria-controls="medicalTest-{{$medicalExam->id}}" aria-selected="false"
                            tabindex="-1">
                        {{trans('doctor::doctor.medicalExaminations.card.medicalTest')}}
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content p-0">
            <div class="tab-pane fade show active" id="medicalPreview-{{$medicalExam->id}}" role="tabpanel">
                <div class="row text-start">
                    <div class="card-header mx-0 px-2 d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h4 class="card-title">
                                {{trans('doctor::doctor.medicalExaminations.card.medicalPreview')}}
                            </h4>
                        </div>
                        <a href="{{route('doctor.medicalExamination.create',['medicalExaminationId' => $medicalExam->id])}}"
                           class="btn btn-icon btn-primary">
                            <i class="ti tabler-eye"></i>
                        </a>
                    </div>
                    <div class="card-text">
                        <ul class="list-unstyled mb-6">
                            @if($medicalExam->reason_of_visiting)
                                <li class="mb-2">
                                    <span class="h6">{{trans('doctor::doctor.medicalExaminations.reasonOfVisiting')}}:</span>
                                    <span class="badge">{{$medicalExam->reason_of_visiting}}</span>
                                </li>
                            @endif
                            <li class="mb-2">
                                <span class="h6">{{trans('doctor::doctor.medicalExaminations.createdAt')}}:</span>
                                <span>{{$medicalExam->created_at}}</span>
                            </li>
                            @if($medicalExam->clinical_examination)

                                <li class="mb-2">
                                    <span class="h6">{{trans('doctor::doctor.medicalExaminations.clinical_examination')}}:</span>
                                    <span>{{$medicalExam->clinical_examination}}</span>
                                </li>
                            @endif
                            @if($medicalExam->impression)

                                <li class="mb-2">
                                    <span class="h6">{{trans('doctor::doctor.medicalExaminations.impression')}}:</span>
                                    <span>{{$medicalExam->impression}}</span>
                                </li>
                            @endif
                            @if($medicalExam->request_for_action)

                                <li class="mb-2">
                                    <span class="h6">{{trans('doctor::doctor.medicalExaminations.request_for_action')}}:</span>
                                    <span>{{$medicalExam->request_for_action}}</span>
                                </li>
                            @endif
                            @if($medicalExam->note)

                                <li class="mb-2">
                                    <span class="h6">{{trans('doctor::doctor.medicalExaminations.note')}}:</span>
                                    <span>{{$medicalExam->note}}</span>
                                </li>
                            @endif
                        </ul>
                        <h5>
                            <i style="margin-bottom: -6px" class="ti icon-26px tabler-files"></i>
                            {{trans('doctor::doctor.parts.files.title')}}
                        </h5>
                        @foreach($medicalExam->getMedia('attachments') as $file)
                            @includeIf('doctor::doctor.medicalExamination.partials.singleFile',['file'=> $file])
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="vitalSigns-{{$medicalExam->id}}" role="tabpanel">
                <div class="row text-start">
                    <h5 class="card-title">{{trans('doctor::doctor.medicalExaminations.card.vitalSigns')}}</h5>
                    <div class="card-text">
                        <ul class="list-unstyled mb-6">
                            @foreach($medicalExam->vitalSigns as $vitalSign)
                                <li class="mb-2">
                                    <span class="h6">{{$vitalSign->name}}:</span>
                                    <span>{{$vitalSign->pivot->value}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="finalDiagnosisTap-{{$medicalExam->id}}" role="tabpanel">
                <div class="row text-start">
                    <h5 class="card-title">{{trans('doctor::doctor.medicalExaminations.card.finalDiagnosis')}}</h5>
                    <div class="card-text">
                        @foreach($medicalExam->finalDiagnosis as $finalDiagnose)
                            <span class="badge text-bg-danger m-2">{{$finalDiagnose->name}}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="medicines-{{$medicalExam->id}}" role="tabpanel">
                <div class="row text-start">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h6 class="card-title">{{trans('doctor::doctor.medicalExaminations.card.medicines')}}</h6>
                        </div>
                        <div class="dropdown">
                            <a class="btn btn-success btn-icon rounded-pill border-0 waves-effect"
                               href="{{route('doctor.pdf.downloadMedicines',['id'=>$medicalExam->id])}}"
                               target="_blank">
                                <i class="icon-base ti tabler-file-type-pdf icon-22px"></i>
                            </a>
                        </div>
                    </div>
                    <ul class="list-unstyled mb-6">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                <tr>
                                    <th>{{trans('doctor::doctor.medicalExaminations.drugName')}}</th>
                                    <th>{{trans('doctor::doctor.medicalExaminations.howToDrink')}}</th>
                                    <th>{{trans('doctor::doctor.medicalExaminations.repetition')}}</th>
                                    <th>{{trans('doctor::doctor.medicalExaminations.number')}}</th>
                                    <th>{{trans('doctor::doctor.medicalExaminations.note')}}</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                @foreach($medicalExam->medicines as $medicine)
                                    <tr>
                                        <td>{{$medicine->name}}</td>
                                        <td>{{$medicine->pivot->type}}</td>
                                        <td>{{$medicine->pivot->dosage}}</td>
                                        <td>{{$medicine->pivot->count}}</td>
                                        <td>{{$medicine->pivot->note}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="medicalTest-{{$medicalExam->id}}" role="tabpanel">
                <div class="row text-start">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="card-title">{{trans('doctor::doctor.medicalExaminations.card.medicalTest')}}</h5>
                        </div>
                        <div class="dropdown">
                            <a class="btn btn-success btn-icon rounded-pill border-0 waves-effect"
                               href="{{route('doctor.pdf.downloadMedicalTest',['id'=>$medicalExam->id])}}"
                               target="_blank">
                                <i class="icon-base ti tabler-file-type-pdf icon-22px"></i>
                            </a>
                        </div>
                    </div>
                    <ul class="list-unstyled mb-6">
                        <div class="table-responsive">
                            <table class="table datanew">
                                <thead>
                                <tr>
                                    <th>{{trans('doctor::doctor.patients.name')}}</th>
                                    <th>{{trans('doctor::doctor.medicalExaminations.card.medicalTestResult')}}</th>
                                    <th>{{trans('doctor::doctor.medicalExaminations.card.medicalTestType')}}</th>
                                    <th>{{trans('admin.audits.action')}}</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                @foreach($medicalExam->medicalTests as $medicalTest)
                                    <tr>
                                        <td>{{$medicalTest->name}}</td>
                                        <td>{{$medicalTest->pivot->value}}</td>
                                        <td>
                                            <span class="badge text-bg-{{$medicalTest->type->class()}}">
                                              {{$medicalTest->type->label()}}
                                            </span>
                                        </td>
                                        <td class="action-table-data">
                                            @if($medicalTest->pivot?->getFirstMediaUrl('attachment'))
                                                <div class="edit-delete-action">
                                                    @can('doctor.patients.show')
                                                        <a type="button" target="_blank"
                                                           href="{{$medicalTest->pivot?->getFirstMediaUrl('attachment')}}"
                                                           class="text-primary btn-icon EditModalBTN">
                                                            <i data-feather="show"
                                                               class="ti tabler-file-text icon-base"></i>
                                                        </a>
                                                    @endcan
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>