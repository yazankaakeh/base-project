@php use Modules\Core\App\Enums\ActiveEnum; @endphp
<div class="modal fade" id="uploadFile" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form class="row g-3" enctype="multipart/form-data" id="createUser"
              action="{{route('doctor.uploadFile.index')}}"
              method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{trans('doctor::doctor.modalUploadFile.title')}}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input type="hidden" name="model" value="{{get_class($model)}}">
                            <input type="hidden" name="model_id" value="{{$model->id}}">
                            <x-core::input
                                    label="doctor::doctor.modalUploadFile.files"
                                    id="files"
                                    name="files[]"
                                    model="files"
                                    type="file"
                                    required="required"
                                    multiple="multiple"
                                    value="{{ old('files') }}"
                            />
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
