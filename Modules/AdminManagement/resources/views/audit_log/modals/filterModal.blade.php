@php

    /* @var Admin $doctors */
    use Modules\AdminManagement\Action\Auditing\RouteName;use Modules\AdminManagement\app\Models\Admin;use Modules\AdminManagement\Models\AuditLog;
    $doctors = AuditLog::GetDoctors();

    $startDate = app('request')->input('start_date');
    $endDate = app('request')->input('end_date');
    $route_names = RouteName::Routes();
@endphp

        <!-- Main modal -->
<div id="filterModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title"
                    id="exampleModalLabel1">{{trans('adminmanagement::admin_management.audits.filterModal.index')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="col-md-12 col-12 mb-4">
                    <div class="col-md-12 mb-4">
                        <label for="doctorId"
                               class="form-label">{{trans('adminmanagement::admin_management.audits.filterModal.adminId')}}</label>
                        <select id="doctorId" class="select2 form-select form-select-lg" data-allow-clear="true">
                            <option value="all">
                                {{trans('adminmanagement::admin_management.pleaseSelectOne')}}
                            </option>
                            @foreach($doctors as $index => $doctor)
                                <option value="{{$doctor->id}}"
                                        @if($doctor->id == app('request')->input('doctorId') ) selected @endIf >
                                    {{ $doctor->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-md-12 col-12 mb-4">
                    <label for="bs-rangepicker-basic"
                           class="form-label">{{trans('adminmanagement::admin_management.audits.filterModal.date')}}</label>
                    <input type="text" id="bs-rangepicker-basic" class="form-control date-range"/>
                </div>

                <div class="col-md-12 col-12 mb-4">
                    <label class="form-label" for="routeName">
                        {{trans('adminmanagement::admin_management.audits.filterModal.routeName')}}
                    </label>
                    <select id="routeName" class="select2 form-select form-select-lg" data-allow-clear="true">
                        <option value="all">
                            {{trans('adminmanagement::admin_management.pleaseSelectOne')}}
                        </option>
                        @foreach($route_names as $index => $route)
                            <option value="{{$index}}"
                                    @if($index == app('request')->input('route_name') ) selected @endIf >
                                {{ $route}}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary"
                        data-bs-dismiss="modal">{{trans('adminmanagement::admin_management.close')}}</button>
                <button type="submit" id="filter"
                        class="btn btn-primary">{{trans('adminmanagement::admin_management.submit')}}</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Modal Content -->
