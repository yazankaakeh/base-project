function initializeSelect2(selector, placeholder, modalBootstrap) {
  if (modalBootstrap) {
    $(modalBootstrap).on('shown.bs.modal', function() {
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

document.addEventListener('reRenderSelect2', () => {
  Alpine.nextTick(() => {
    $('.datePicker').datepicker({
      changeMonth: true,   // Enables month dropdown
      dateFormat: 'yy-mm-dd', // Set format as YYYY-MM-DD
      changeYear: true,    // Enables year dropdown
      yearRange: '1900:2100' // Set range for year selection
    });
    $('.datePicker').on('keydown', function(e) {
      e.preventDefault(); // Prevent any keyboard input
    });
    $('.datePicker').attr('autocomplete', 'off');
    initialize_intlTelInput('#phone');

    // Destroy existing Select2 instances
    $('.select2').each(function() {
      if ($(this).hasClass('select2-hidden-accessible')) {
        $(this).select2('destroy');
      }
    });

    // Re-initialize Select2 with dynamic placeholders and options
    $('.select2').each(function() {
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

Livewire.on('addValueToSelect2', (event) => {
  console.log('addValueToSelect2', event);
  id = event[0].id.replace('-', '.');
  let selectElement = $(id);
  selectElement.select2('destroy'); // Destroy old instance
  selectElement.select2(); // Reinitialize Select2
  selectElement.val(event[0].value);
  selectElement.trigger('change.select2'); // Update UI
});

Livewire.on('show-success-modal', (event) => {
  console.log(event[0].title);
  $('#successMessage').text(event[0].title);
  $('#successModal').modal('show');
});
