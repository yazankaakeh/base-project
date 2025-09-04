<?php

namespace Modules\Core\app\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ReCaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $googleConfig = config('core.recaptcha');
        try {
            $response = Http::asForm()->post($googleConfig['link'], [
                'secret' => $googleConfig['secret_key'],
                'response' => $value,
            ]);
            $responseData = $response->json();
            if (!$responseData['success']) {
                $fail('Failed reCAPTCHA validation.');
            }
        } catch (ConnectionException $e) {
            $fail('Failed reCAPTCHA validation. Error Message: '.$e->getMessage());
        }
    }
}
