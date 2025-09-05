<div>
  <div class="form-one__control form-one__control--full">
    <input type="hidden" name="{{$name}}" wire:model="{{$name}}"
           id="{{$id}}">

  </div><!-- /.form-one__control -->

  @push('pricing-script')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('core.recaptcha.site_key') }}"></script>
    <script>
      refreshRecaptcha();
      setTimeout(() => {
        interval = setInterval(function() {
          refreshRecaptcha();
        }, 90 * 1000);
      }, 2000);

      function refreshRecaptcha() {
        grecaptcha.ready(function() {
          grecaptcha.execute('{{ config('core.recaptcha.site_key') }}', { action: 'submit' }).then(function(token) {
            document.getElementById('{{$id}}').value = token;
            let componentId = $('#{{$id}}').parents().closest('div[data-livewire]').data('livewire');
            if (typeof Livewire !== 'undefined') {
              Livewire.dispatch(`recaptchaUpdated_${componentId}`, { token: token }); // Dispatch event to Livewire
            }
            console.log('componentId' + componentId);
            console.log('token ' + token);
          });
        });
      }

      if (typeof Livewire !== 'undefined') {
        Livewire.on('refreshRecaptcha', (event) => {
          refreshRecaptcha();
        });
      }
    </script>
  @endpush
</div>
