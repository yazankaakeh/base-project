@php use Illuminate\Support\Str; @endphp
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
                @includeIf('doctor::doctor.medicalExamination.partials.singleFile',['file'=> $file])
            @endforeach
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
