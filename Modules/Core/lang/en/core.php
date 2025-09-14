<?php

use Modules\Core\App\Enums\ActiveEnum;

return [
    'enum' => [
        'ActiveClinic' => [
            ActiveEnum::ACTIVE->value => 'Active',
            ActiveEnum::INACTIVE->value => 'Inactive',
        ],
    ],
    'env' => [
        'save' => 'Save',
        'sendTestEmail' => 'send Test Email',
        'submit' => 'Submit',
        'email' => 'Email',
        'titles' => [
            'title' => 'Update Environment',
            'recaptcha' => 'RECAPTCHA V3',
            'smtp' => 'SMTP',
            'firebase' => 'Fire Base',
        ],
        'recaptcha' => [
            'site_key' => 'SITE KEY',
            'secret_key' => 'SECRET KEY',
            'link' => 'LINK',
        ],
        'mail' => [
            'MAIL_MAILER' => 'MAIL MAILER',
            'MAIL_HOST' => 'MAIL HOST',
            'MAIL_USERNAME' => 'MAIL USERNAME',
            'MAIL_PASSWORD' => 'MAIL PASSWORD',
            'MAIL_ENCRYPTION' => 'MAIL ENCRYPTION',
            'MAIL_FROM_ADDRESS' => 'MAIL FROM_ADDRESS',
            'MAIL_FROM_NAME' => 'MAIL FROM_NAME',
        ],
        'firebase' => [
            'FIREBASE_API_KEY' => 'FIREBASE API KEY',
            'FIREBASE_AUTH_DOMAIN' => 'FIREBASE AUTH DOMAIN',
            'FIREBASE_PROJECT_ID' => 'FIREBASE PROJECT_ D',
            'FIREBASE_STORAGE_BUCKET' => 'FIREBASE STORAGE BUCKET',
            'FIREBASE_MESSAGING_SENDER_ID' => 'FIREBASE MESSAGING SENDER ID',
            'FIREBASE_APP_ID' => 'FIREBASE APP ID',
        ],

    ],
];
