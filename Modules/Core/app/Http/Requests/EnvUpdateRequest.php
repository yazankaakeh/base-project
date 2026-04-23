<?php

namespace Modules\Core\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnvUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // RECAPTCHA Settings
            'RECAPTCHA_SITE_KEY' => 'nullable|string|max:255',
            'RECAPTCHA_SECRET_KEY' => 'nullable|string|max:255',
            'RECAPTCHA_LINK' => 'nullable|string|max:255',

            // Email Settings
            'MAIL_MAILER' => 'nullable|string|max:255',
            'MAIL_HOST' => 'nullable|string|max:255',
            'MAIL_PORT' => 'nullable|string|max:255',
            'MAIL_USERNAME' => 'nullable|string|max:255',
            'MAIL_PASSWORD' => 'nullable|string|max:255',
            'MAIL_ENCRYPTION' => 'nullable|string|max:255',
            'MAIL_FROM_ADDRESS' => 'nullable|email|max:255',
            'MAIL_FROM_NAME' => 'nullable|string|max:255',

            // Firebase Settings
            'FIREBASE_API_KEY' => 'nullable|string|max:255',
            'FIREBASE_AUTH_DOMAIN' => 'nullable|string|max:255',
            'FIREBASE_PROJECT_ID' => 'nullable|string|max:255',
            'FIREBASE_STORAGE_BUCKET' => 'nullable|string|max:255',
            'FIREBASE_MESSAGING_SENDER_ID' => 'nullable|string|max:255',
            'FIREBASE_APP_ID' => 'nullable|string|max:255',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
