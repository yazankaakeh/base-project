<?php

return [
    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY', '6LdrCjsrAAAAAG3pALS1L_QrYVtb2_P4-0c5gchA'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', '6LdrCjsrAAAAANLAlU_85TIZ0urTWiO_MtQz0RZB'),
        'link' => env('RECAPTCHA_LINK', 'https://www.google.com/recaptcha/api/siteverify'),
    ],
    'mail' => [
        'MAIL_MAILER' => env('MAIL_MAILER'),
        'MAIL_HOST' => env('MAIL_HOST'),
        'MAIL_USERNAME' => env('MAIL_USERNAME'),
        'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
        'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
        'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
        'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
    ],
    'sms' => [
        'username' => env('SMS_USERNAME', '5322305681'),
        'password' => env('SMS_PASSWORD', '123654'),
        'url' => env('SMS_URL', 'http://panel.1telekom.com.tr/Api/Submit'),
    ],
    'iyzico' => [
        'api_key' => env('IYZICO_API_KEY'),
        'secret_key' => env('IYZICO_SECRET_KEY'),
        'base_url' => env('IYZICO_BASE_URL'),
    ],
    'firebase' => [
        'FIREBASE_API_KEY' => env('FIREBASE_API_KEY'),
        'FIREBASE_AUTH_DOMAIN' => env('FIREBASE_AUTH_DOMAIN'),
        'FIREBASE_PROJECT_ID' => env('FIREBASE_PROJECT_ID'),
        'FIREBASE_STORAGE_BUCKET' => env('FIREBASE_STORAGE_BUCKET'),
        'FIREBASE_MESSAGING_SENDER_ID' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'FIREBASE_APP_ID' => env('FIREBASE_APP_ID'),
    ],
];
