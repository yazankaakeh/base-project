@php use Illuminate\Support\Str; @endphp
<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-2 mb-1">
            <h5 class="">
                <i style="margin-bottom: -6px" class="ti icon-26px tabler-files"></i>
                {{trans('doctor::doctor.parts.files.title')}}
            </h5>
        </div>
        <div class="card-body">
            <div class="card-content">

                @foreach($model->getMedia('attachments') as $file)
                    <div class="row my-3">
                        <div class="col-auto d-flex">
                            <form action="{{route('doctor.uploadFile.delete',['id'=>$file->id])}}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="button" class="btn-delete btn text-body mx-1 btn-sm btn-icon btn-danger">
                                    <i class="ti icon-base tabler-trash"></i>
                                </button>
                            </form>
                            <a class="btn mx-1 btn-sm btn-icon btn-primary" href="{{$file->getUrl()}}">
                                <i class="ti icon-base tabler-eye"></i>
                            </a>
                            <p class="mx-3 my-2">
                                {{Str::limit($file->getCustomProperty('original_name'), 20)}}
                            </p>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function (e) {
                    let form = this.closest('form');

                    Swal.fire({
                        title: '{{trans('doctor::doctor.areYouSure')}}',
                        text: '{{trans('doctor::doctor.parts.files.sADesc')}}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '{{trans('doctor::doctor.delete')}}',
                        cancelButtonText: '{{trans('doctor::doctor.cancel')}}',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
