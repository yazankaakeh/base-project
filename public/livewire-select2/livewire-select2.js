function initializeSelect2(selector, placeholder, modalBootstrap) {
    if (modalBootstrap) {
        $(modalBootstrap).on('shown.bs.modal', function () {
            $(selector).select2({
                placeholder: placeholder,
                allowClear: true,
                tags: false,  // Allows typing
                dropdownParent: $(selector).parent()  // Ensures dropdown stays inside modal
            });
        });
    } else {
        $(selector).select2({
            placeholder: placeholder,
            allowClear: true,
            tags: false
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {

    /* $(document).on('change', '.datetimepicker', function () {
         let property = $(this).attr('id'); // Get property from data-property
         let values = $(this).val() || []; // Ensure it's always an array
         let componentId = $(this).closest('div[data-livewire]').data('livewire');

         if (property && values) {
             property = property.replace(/-/g, '.');
             console.log(`updateDatePicker_${componentId} property ${property} value ${values}`);
             Livewire.dispatch(`updateDatePicker_${componentId}`, {attribute: property, value: values});
         }
     });*/

    // needed necessary
    $(document).on('change', '.select2', function () {
        let property = $(this).attr('id'); // Get property from data-property
        let values = $(this).val() || []; // Ensure it's always an array
        let componentId = $(this).closest('div[data-livewire]').data('livewire');
        let onChangeEvent = $(this).data('change');
        if (onChangeEvent) {
            console.log(`onChangeEvent ${onChangeEvent} value ${values}`);
            Livewire.dispatch(`${onChangeEvent}`, {value: values});
        }
        if (property && values) {
            property = property.replace(/-/g, '.');
            console.log(`updateSelect2_${componentId} property ${property} value ${values}`);
            Livewire.dispatch(`updateSelect2_${componentId}`, {attribute: property, value: values});
        }

        /*$(this).val('').trigger('change');*/

    });
    // Ensure Select2 is re-initialized after Livewire updates
    document.addEventListener("livewire:navigated", () => {
        $('.select2').select2(); // Reinitialize Select2
    });

    /*$('.selectpicker').on('change', function () {
        let property = $(this).attr('id'); // Get property from data-property
        let values = $(this).val() || []; // Ensure it's always an array
        let componentId = $(this).parents().closest('div[data-livewire]').data('livewire');
        // Using .data() (convert to camelCase)
        property = property.replace(/-/g, '.');
        if (property && values) {
            console.log(`updateSelect2_${componentId} property ${property} value ${values}`);
            Livewire.dispatch(`updateSelectPicker_${componentId}`, {attribute: property, value: values});
        }
    });*/
});
document.addEventListener('reRenderSelect2', () => {
    Alpine.nextTick(() => {
        /*$('.datetimepicker').datetimepicker({
            changeMonth: true,   // Enables month dropdown
            dateFormat: 'yy-mm-dd', // Set format as YYYY-MM-DD
            changeYear: true,    // Enables year dropdown
            yearRange: '1900:2100' // Set range for year selection
        });
        $('.datetimepicker').on('keydown', function (e) {
            e.preventDefault(); // Prevent any keyboard input
        });
        $('.datetimepicker').attr('autocomplete', 'off');*/
        /*initialize_intlTelInput('#phone');*/

        // Destroy existing Select2 instances
        $('.select2').each(function () {
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });

        // Re-initialize Select2 with dynamic placeholders and options
        $('.select2').each(function () {
            const placeholder = $(this).attr('placeholder') || 'Select an option'; // Get placeholder from the element
            let hasErrorClass = $(this).hasClass('inputError'); // Check if inputError exists

            // Find the closest modal and set dropdownParent

            $(this).select2({
                placeholder: placeholder,
                allowClear: true,
                tags: false,
                dropdownParent: $(this).parent()
            });
            if (hasErrorClass) {
                $(this).next('.select2').find('.select2-selection').attr('style', 'border-color: #9b0000 !important');
            }
        });
    });
});

Livewire.on('showValidationErrorHtml', (errors) => {
    Swal.fire({
        icon: 'error',
        /*text: '{{trans('website.validationErrorsText')}}',
        title: '{{trans('website.validationErrorsTitle')}}',*/
        html: errors,
        /*confirmButtonText: '{{trans('website.sAlert.ok')}}',*/
        confirmButtonColor: '#000082'
    });
});

Livewire.on('showSuccess', (message) => {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        confirmButtonText: 'OK'
    });
});

Livewire.on('updateModalStatus', (event) => {
    $(event[0].modal).modal(event[0].status);
});

Livewire.on('addValueToSelect2', (payloadArr) => {
    const payload = Array.isArray(payloadArr) ? payloadArr[0] : payloadArr;
    const id = payload.id;                    // "finalDiagnosis"
    const incoming = (Array.isArray(payload.value) ? payload.value : [payload.value])
        .map(String);               // coerce to strings
    const multiple = !!payload.multiple;

    const safeId = `#${CSS && CSS.escape ? CSS.escape(id) : id.replace(/([ #;.:[\],=])/g, '\\$1')}`;
    const $el = $(safeId);
    if (!$el.length) return console.warn('Select2 not found:', safeId);

    // Ensure it's a multi-select if payload says so
    if (multiple && !$el.prop('multiple')) $el.prop('multiple', true);

    // Ensure Select2 is initialized
    if (!$el.hasClass('select2-hidden-accessible')) {
        $el.select2({width: '100%' /*, dropdownParent: $('#yourModalId')*/});
    }

    // Ensure each option exists before selecting
    incoming.forEach(v => {
        if ($el.find(`option[value="${v}"]`).length === 0) {
            // If you don't have display text, use the value as text
            $el.append(new Option(v, v, false, false));
        }
    });

    // Merge with current value to avoid losing existing selection (optional)
    const current = Array.isArray($el.val()) ? $el.val().map(String) : [];
    const union = Array.from(new Set([...current, ...incoming]));

    // Apply selection
    $el.val(union).trigger('change');
    console.log($el)
    console.log(union)
});

Livewire.on('show-success-modal', (event) => {
    console.log(event[0].title);
    $('#successMessage').text(event[0].title);
    $('#successModal').modal('show');
});