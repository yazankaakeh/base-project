<?php

use Modules\Core\App\Enums\AddressEnum;

return [
    'enums' => [
        'AddressEnum' => [
            AddressEnum::USER->value => 'User',
            AddressEnum::ADMIN->value => 'Admin',
        ],
    ],
    'validation' => [
        'password_mismatch' => 'Your passwords do not match',
    ],
    'sidebar' => [
        'dashboard' => 'Dashboard',
        'accounting' => 'Accounting',
        'paymentReports' => 'Payment Reports',
        'extracts' => 'Extracts',
        'consensus' => 'Consensus',
        'protectionAccountReport' => 'Protection Account Report',
        'paMoneyTransfer' => 'PA Money Transfer',
        'payments' => 'Payments',
        'refund' => 'Refund',
        'createPayment' => 'Create Payment',
        'users' => 'Users',
        'clients' => 'Clients',
        'userManagement' => 'Client Management',
        'posFraudManagement' => 'POS Fraud Management',
        'fraudManagement' => 'Fraud Management',
        'fraudTransactions' => 'Fraud Transactions',
        'fraudScenarios' => 'Fraud Scenarios',
        'POSSettings' => 'POS Settings',
        'banks' => 'Banks',
        'agreements' => 'Agreements',
        'complaints' => 'Complaints',
        'documents' => 'Documents',
        'settings' => 'Settings',
        'adminManagement' => 'User Management',
        'updateSMTP' => 'Update SMTP',
        'auditingLog' => 'Auditing Log',
        'roles' => 'Roles',
        'apiIntegration' => 'API Integration',
    ],
    'env' => [
        'save' => 'Save',
        'sendTestEmail' => 'send Test Email',
        'submit' => 'Submit',
        'cancel' => 'Cancel',
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
