{{--
    Audit log payload viewer.

    Previously this modal was wrapped in a <form> that POSTed to
    route('admin.user_management.store'), so clicking "Submit" on an
    audit-log payload would attempt to create a user. We've replaced the
    form with a clean read-only dialog and removed the misleading submit
    button — auditors only need to view, not save.
--}}
<div class="modal fade" id="payloadModal" tabindex="-1" aria-hidden="true" aria-labelledby="payloadModalLabel">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2" id="payloadModalLabel">
                    <i class="ti tabler-file-search text-primary"></i>
                    {{ trans('adminmanagement::admin_management.audits.getPayLoad') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-content-payload">
                    <div class="text-center py-5 text-muted">
                        <div class="spinner-border spinner-border-sm me-2"></div>
                        {{ __('Loading…') }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                    {{ trans('adminmanagement::admin_management.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
