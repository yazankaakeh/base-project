<div>
    <input type="hidden" name="{{$name}}" id="{{$id}}">
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('core.recaptcha.site_key') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                refreshRecaptcha();
                setTimeout(() => {
                    interval = setInterval(function () {
                        refreshRecaptcha();
                    }, 90 * 1000);
                }, 2000);
            });

            function refreshRecaptcha() {
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.ready(function () {
                        grecaptcha.execute('{{ config('core.recaptcha.site_key') }}', {action: 'submit'}).then(function (token) {
                            document.getElementById('{{$id}}').value = token;
                            console.log('reCAPTCHA token updated for {{$id}}:', token);
                        });
                    });
                }
            }

            // Refresh token on form submit
            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (form.querySelector('#{{$id}}')) {
                    refreshRecaptcha();
                }
            });
        </script>
    @endpush
</div>
