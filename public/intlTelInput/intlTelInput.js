// start intlTelInput
function initialize_intlTelInput($selector) {
  //https://github.com/jackocnr/intl-tel-input#demo-and-examples

  if ($($selector).length == 0)
    return;

  $($selector)
    .css('direction', 'unset')
    .attr('data-rule-validateintltelinput', false); // tel input set true to allow custom validation

  let input = document.querySelector($selector);
  let $name = input.name;
  if (!$(`[data-valmsg-for="${$name}"]`).length) {
    $($selector).after(`<span class="text-danger field-validation-valid" data-valmsg-for="${$name}" data-valmsg-replace="true"></span>`);
  }

  let preferredCountries = ['TR'];

  let iti = window.intlTelInput(input, {
    initialCountry: preferredCountries[0],
    //initialCountry: "auto",
    //geoIpLookup: function (success, failure) {
    //    fetch('https://iplist.cc/api/')
    //        .then((resp) => resp.json())
    //        .then((ipapi_resp) => {
    //            let countryCode = (ipapi_resp && ipapi_resp.countrycode) ? ipapi_resp.countrycode : preferredCountries[0];
    //            success(countryCode);
    //        }).catch((error) => {
    //            success(preferredCountries[0]);
    //        });
    //},
    //onlyCountries: ["SY", "TR"],
    //excludeCountries: [],

    geoIpLookup: function(success, failure) {
      fetch('https://ipwho.is/')
        .then(res => res.json())
        .then(data => {
          success(data.country_code); // e.g. "IQ"
        })
        .catch(() => {
          success('US');
        });
    },
    placeholderNumberType: 'MOBILE',
    separateDialCode: true,
    nationalMode: true,
    //autoHideDialCode: true,
    preferredCountries: preferredCountries,
    formatOnDisplay: true,
    customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
      return 'e.g. ' + selectedCountryPlaceholder;
    },
    utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js'
  });

  iti.promise.then(() => {
    //for the first display in edit mode it remove +9 so we add this to fix
    validate_intlTelInput(iti);

    $(`#${iti.telInput.id}`).css('padding-left', '64px');
  });

  input.addEventListener('blur', function() {
    validate_intlTelInput(iti);
  });
  input.addEventListener('change', function() {
    validate_intlTelInput(iti);
  });
  input.addEventListener('input', function() {
    validate_intlTelInput(iti);
  });

  //if input has  data-rule-validateintltelinput='true'  then will be validated
  if ($($selector).attr('data-rule-validateintltelinput')) {
    $.validator.addMethod('validateintltelinput', function(value, element) {
      validate_intlTelInput(iti);

      return $($selector).val().length > 0 ? iti.isValidNumber() : true;
    }, intlTelInput_localize('Invalid_number'));
  }
}

//validate_intlTelInput
function validate_intlTelInput(iti) {
  $input = document.getElementById(iti.telInput.id);
  $name = $input.name;
  $id = $input.id;
  $msg = $(`[data-valmsg-for="${$name}"]`);

  $input.classList.remove('error');
  $input.classList.remove('valid');
  $input.classList.remove('input-validation-error');

  $msg.empty().removeClass('field-validation-valid').removeClass('field-validation-error');

  $input.value = iti.getNumber();

  if ($input.value.trim()) {
    if (iti.isValidNumber()) {
      $($input).attr('aria-invalid', false).addClass('valid');

      $msg.addClass('field-validation-valid');
    } else {
      $input.classList.add('error');

      $($input).attr('aria-invalid', true).addClass('input-validation-error');

      // here, the index maps to the error code returned from getValidationError - see readme
      let errorMap = [intlTelInput_localize('Invalid_number'), intlTelInput_localize('Invalid_country code'), intlTelInput_localize('Too_short'), intlTelInput_localize('Too_long'), intlTelInput_localize('Invalid_number')];

      $msg.addClass('field-validation-error')
        .append(`<span id="${$id}-error" class="">${iti.getValidationError() > 4 ? intlTelInput_localize('Invalid_number') : errorMap[iti.getValidationError()]}</span>`);
    }
  }
}

//intlTelInput_localize
function intlTelInput_localize(key) {
  return localized_data_intlTelInput[`${key}`];
}

// end intlTelInput
