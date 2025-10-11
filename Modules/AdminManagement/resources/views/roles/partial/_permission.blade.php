@foreach($permissions as $index=> $permission)
    <div class="col-md-4 col-lg-4 col-sm-12">
        <div class="card mb-4">

            <div class="card-header d-flex justify-content-between pb-2 mb-1">
                <h5 class="">
                    <label for="{{$index}}">
                        {{ trans('adminmanagement::admin_management.sections.'.$index)}}
                    </label>
                </h5>

                <div class="form-switch text-end">
                    <input type="checkbox" class="form-check-input"
                           id="{{$index}}" onclick="checkAll('{{$index}}',this)">
                </div>
            </div>
            <div class="{{$index}}">
                <div class="card-body pt-0">
                    @foreach($permission as $perm)

                        <div class="d-flex justify-content-between pb-2 mb-1">
                            <label for="{{$perm->name}}">
                                {{ trans('adminmanagement::admin_management.permissions.'.str_replace('.', '-', $perm->name))}}
                            </label>

                            <div class="form-switch text-end mx-6">
                                <input type="checkbox" onclick="checkBoxChild('{{$index}}', this)"
                                       class="form-check-input"
                                       name="permissions[{{$perm->name}}]"
                                       @if(isset($userPermissions))
                                           @if(in_array($perm->name,$userPermissions))
                                               checked
                                       @endif
                                       @endif
                                       @if(isset($oldPermissions))
                                           {{in_array($perm->name, $oldPermissions)  ? 'checked' : ''}}
                                       @endif
                                       id="{{$perm->name}}"
                                       value="{{$perm->name}}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach
@section('vendor-script')
    <script>
        function checkAll(checkBoxClass, el) {
            $('.' + checkBoxClass + ' input').each(function () {
                console.log($(el).is(':checked'));
                let isChecked = $(el).is(':checked');
                $(this).attr('checked', isChecked);
                $(this).prop('checked', isChecked);
            });
        }

        function checkBoxChild(checkBoxClass) {
            console.log(checkBoxClass);
            let isChecked = true;
            $('.' + checkBoxClass + ' input').each(function () {
                console.log(!$(this).is(':checked'));
                if (!$(this).is(':checked'))
                    isChecked = false;
            });

            $('#' + checkBoxClass + '').prop('checked', isChecked);

        }

        $(document).ready(function () {
            @foreach($permissions as $index => $permission)
            checkBoxChild('{{$index}}');
            @endforeach
            $('#allCheckBoxes').click(function () {
                let allCheckBoxes = $('input[type=\'checkbox\']');
                let isChecked = $(this).is(':checked');
                console.log(isChecked);
                allCheckBoxes.prop('checked', isChecked);
                allCheckBoxes.attr('checked', isChecked);
            });
        });
    </script>

@endsection
