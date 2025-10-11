@php use Modules\Core\App\Enums\LanguageEnum; @endphp
        <!-- Tag Creation Modal -->
<div class="modal fade" id="createTagModal" tabindex="-1" aria-labelledby="createTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="createTagForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTagModalLabel">{{ trans('blog::blog.tag.create') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach(LanguageEnum::values() as $lang)
                        <div class="mb-3">
                            <x-core::input
                                    :label="trans('blog::blog.tag.name') . ' (' . strtoupper($lang) . ')'"
                                    type="text"
                                    :name="'name[' . $lang . ']'"
                                    :id="'tagName_' . $lang"
                                    required="required">
                            </x-core::input>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ trans('core::core.close') }}</button>
                    <button type="submit" class="btn btn-primary" id="saveTagBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        {{ trans('core::core.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Handle tag creation form submission
        $('#createTagForm').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const saveBtn = $('#saveTagBtn');
            const spinner = saveBtn.find('.spinner-border');

            // Collect all language data
            const tagNames = {};
            let hasError = false;

            @foreach(LanguageEnum::values() as $lang)
            const name_{{ $lang }} = $('#tagName_{{ $lang }}').val().trim();
            if (!name_{{ $lang }}) {
                $('#tagName_{{ $lang }}').addClass('is-invalid');
                // Find the error message element for this input
                const errorElement = $('#tagName_{{ $lang }}').closest('.mb-3').find('.text-danger');
                if (errorElement.length) {
                    errorElement.text('Tag name in {{ strtoupper($lang) }} is required');
                }
                hasError = true;
            } else {
                $('#tagName_{{ $lang }}').removeClass('is-invalid');
                tagNames['{{ $lang }}'] = name_{{ $lang }};
            }
            @endforeach

            if (hasError) {
                return;
            }

            // Show loading state
            saveBtn.prop('disabled', true);
            spinner.removeClass('d-none');

            // AJAX request to create tag
            $.ajax({
                url: '{{ route("doctor.tags.storeAjax") }}',
                method: 'POST',
                data: {
                    name: tagNames,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        // Add new option to select
                        const newOption = new Option(response.tag.name, response.tag.id, true, true);
                        $('#tags').append(newOption).trigger('change');

                        // Show success message
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Tag created successfully!');
                        }

                        // Close modal and reset form
                        $('#createTagModal').modal('hide');
                        form[0].reset();
                        @foreach(LanguageEnum::values() as $lang)
                        $('#tagName_{{ $lang }}').removeClass('is-invalid');
                        $('#tagName_{{ $lang }}').closest('.mb-3').find('.text-danger').text('');
                        @endforeach
                    }
                },
                error: function (xhr) {
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        // Clear previous errors
                        @foreach(LanguageEnum::values() as $lang)
                        $('#tagName_{{ $lang }}').removeClass('is-invalid');
                        $('#tagName_{{ $lang }}').closest('.mb-3').find('.text-danger').text('');
                        @endforeach

                        // Show specific field errors
                        @foreach(LanguageEnum::values() as $lang)
                        if (errors['name.{{ $lang }}']) {
                            $('#tagName_{{ $lang }}').addClass('is-invalid');
                            const errorElement = $('#tagName_{{ $lang }}').closest('.mb-3').find('.text-danger');
                            if (errorElement.length) {
                                errorElement.text(errors['name.{{ $lang }}'][0]);
                            }
                        }
                        @endforeach
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to create tag');
                        }
                    }
                },
                complete: function () {
                    // Reset button state
                    saveBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                }
            });
        });

        // Clear validation on input for all language fields
        @foreach(LanguageEnum::values() as $lang)
        $('#tagName_{{ $lang }}').on('input', function () {
            $(this).removeClass('is-invalid');
            $(this).closest('.mb-3').find('.text-danger').text('');
        });
        @endforeach

        // Reset form when modal is hidden
        $('#createTagModal').on('hidden.bs.modal', function () {
            $('#createTagForm')[0].reset();
            @foreach(LanguageEnum::values() as $lang)
            $('#tagName_{{ $lang }}').removeClass('is-invalid');
            $('#tagName_{{ $lang }}').closest('.mb-3').find('.text-danger').text('');
            @endforeach
        });
    });
</script>
