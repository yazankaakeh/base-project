{{--
    Permission group partial used by both roles.create and roles.edit.

    Each section = one card. Each card has:
      - Section title + count badge (selected / total) + "select all in this group" switch
      - Searchable list of individual permission toggles

    All toggling is delegated through [data-permission-toggle] so the JS at
    the bottom can keep section counts + global counts in lockstep without
    re-binding per render.
--}}
@foreach($permissions as $index => $permission)
    @php
        // Section label — falls back to a humanized version of the raw key
        // so a freshly-added module without lang entries still reads nicely.
        $sectionLabel = trans('adminmanagement::admin_management.sections.' . $index);
        if ($sectionLabel === 'adminmanagement::admin_management.sections.' . $index) {
            $sectionLabel = ucwords(str_replace(['_', '-'], ' ', $index));
        }
    @endphp
    <div class="col-md-6 col-xl-4 permission-group-col" data-section="{{ $index }}">
        <div class="card h-100 border-0 shadow-sm permission-group">
            <div class="card-header bg-transparent border-bottom py-3">
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <label for="group-{{ $index }}" class="d-flex align-items-center gap-2 mb-0 flex-grow-1 cursor-pointer">
                        <span class="avatar avatar-sm">
                            <span class="avatar-initial rounded-2 bg-label-primary">
                                <i class="ti tabler-shield ti-sm"></i>
                            </span>
                        </span>
                        <div class="min-w-0">
                            <div class="fw-semibold text-truncate">{{ $sectionLabel }}</div>
                            <small class="text-muted">
                                <span class="section-selected-count" data-section-count="{{ $index }}">0</span>
                                /
                                <span>{{ count($permission) }}</span>
                            </small>
                        </div>
                    </label>
                    <div class="form-check form-switch m-0" title="{{ trans('adminmanagement::admin_management.roles.create.selectAllSection') }}">
                        <input type="checkbox"
                               class="form-check-input section-toggle"
                               id="group-{{ $index }}"
                               data-section-toggle="{{ $index }}"
                               onclick="checkAll('{{ $index }}', this)">
                    </div>
                </div>
            </div>

            <div class="{{ $index }} card-body pt-2">
                @foreach($permission as $perm)
                    @php
                        $label = trans('adminmanagement::admin_management.permissions.' . str_replace('.', '-', $perm->name));
                        // Fallback when the permission isn't translated yet: surface the raw
                        // key so admins see *something* actionable instead of a broken string.
                        if ($label === 'adminmanagement::admin_management.permissions.' . str_replace('.', '-', $perm->name)) {
                            $label = str_replace(['admin-', '_', '-'], ['', ' ', ' '], $perm->name);
                            $label = ucwords($label);
                        }

                        $isChecked = (isset($userPermissions)  && in_array($perm->name, $userPermissions))
                                  || (isset($oldPermissions)   && in_array($perm->name, $oldPermissions));
                    @endphp
                    <div class="d-flex align-items-center justify-content-between py-2 permission-row"
                         data-label="{{ strtolower($label) }}">
                        <label for="{{ $perm->name }}" class="flex-grow-1 mb-0 small cursor-pointer text-truncate pe-2"
                               title="{{ $perm->name }}">
                            {{ $label }}
                        </label>
                        <div class="form-check form-switch m-0">
                            <input type="checkbox"
                                   class="form-check-input permission-toggle"
                                   data-permission-toggle
                                   data-section="{{ $index }}"
                                   onclick="checkBoxChild('{{ $index }}', this)"
                                   name="permissions[{{ $perm->name }}]"
                                   id="{{ $perm->name }}"
                                   value="{{ $perm->name }}"
                                   @checked($isChecked)>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach

@section('vendor-script')
    <script>
        /**
         * Role-permissions UX helpers.
         * Everything here is delegated against the document so adding a new
         * group via re-render wouldn't require re-binding.
         */
        (function () {
            // Pre-existing helpers kept as globals because the inline onclick
            // attributes on the switches reference them.
            window.checkAll = function (sectionKey, el) {
                const isChecked = $(el).is(':checked');
                $('.' + sectionKey + ' input[type="checkbox"]').prop('checked', isChecked);
                updateCounts();
            };

            window.checkBoxChild = function (sectionKey /*, el */) {
                const allChecked = $('.' + sectionKey + ' input[type="checkbox"]').toArray()
                    .every((input) => input.checked);
                $('#group-' + sectionKey).prop('checked', allChecked);
                updateCounts();
            };

            function updateCounts() {
                // Total checked
                const total = $('.permission-toggle:checked').length;
                $('#permissionCount').text(total);

                // Per-section
                $('[data-section-count]').each(function () {
                    const section = $(this).data('section-count');
                    const count = $('.permission-toggle[data-section="' + section + '"]:checked').length;
                    $(this).text(count);
                });
            }

            $(document).on('change', '.permission-toggle, .section-toggle', updateCounts);

            // "Select all permissions" master switch — unlike the per-section
            // one, this one flips EVERY permission plus every section switch.
            $(document).on('change', '#allCheckBoxes', function () {
                const isChecked = this.checked;
                $('.permission-toggle, .section-toggle').prop('checked', isChecked);
                updateCounts();
            });

            // Live search — filters permission rows AND hides groups that
            // have zero visible rows, with an empty state at the bottom.
            $(document).on('input', '#permissionSearch', function () {
                const query = $(this).val().toLowerCase().trim();
                let visibleGroups = 0;

                $('.permission-group-col').each(function () {
                    const $group = $(this);
                    let groupHasMatch = false;

                    $group.find('.permission-row').each(function () {
                        const label = $(this).data('label') || '';
                        const match = !query || label.indexOf(query) !== -1;
                        $(this).toggleClass('d-none', !match);
                        if (match) groupHasMatch = true;
                    });

                    $group.toggleClass('d-none', !groupHasMatch);
                    if (groupHasMatch) visibleGroups++;
                });

                $('#permissionsEmpty').toggleClass('d-none', visibleGroups > 0);
            });

            // On page load: sync section master switches + counts with
            // whatever is already checked (e.g. edit screen with existing perms).
            $(function () {
                $('[data-section-toggle]').each(function () {
                    const section = $(this).data('section-toggle');
                    checkBoxChild(section);
                });
                updateCounts();
            });
        })();
    </script>
    <style>
        .cursor-pointer { cursor: pointer; }
        .permission-group .card-body { max-height: 320px; overflow-y: auto; }
        .permission-group .card-body::-webkit-scrollbar { width: 6px; }
        .permission-group .card-body::-webkit-scrollbar-thumb {
            background: rgba(var(--bs-primary-rgb, 0, 86, 248), 0.2);
            border-radius: 3px;
        }
        .permission-row { border-bottom: 1px dashed rgba(var(--bs-primary-rgb, 0, 86, 248), 0.08); }
        .permission-row:last-child { border-bottom: 0; }
        .permission-group .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
    </style>
@endsection
