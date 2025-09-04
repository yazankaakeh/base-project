<?php

use Modules\Core\App\Enums\AddressEnum;

return [
    'enums' => [
        'AddressEnum' => [
            AddressEnum::USER->value => 'Kullanıcı',
            AddressEnum::ADMIN->value => 'Yönetici',
        ],
    ],
    'validation' => [
        'password_mismatch' => 'Şifreleriniz eşleşmiyor',
    ],
    'sidebar' => [
        'dashboard' => 'Kontrol Paneli',
        'accounting' => 'Muhasebe',
        'paymentReports' => 'Ödeme Raporları',
        'extracts' => 'Ekstreler',
        'consensus' => 'Mutabakat',
        'protectionAccountReport' => 'Koruma Hesabı Raporu',
        'paMoneyTransfer' => 'Koruma Hesabı Transferi',
        'payments' => 'Ödemeler',
        'refund' => 'İade',
        'createPayment' => 'Ödeme Oluştur',
        'users' => 'Kullanıcılar',
        'clients' => 'Müşteriler',
        'userManagement' => 'Müşteri Yönetimi',
        'posFraudManagement' => 'POS Fraud Yönetimi',
        'fraudManagement' => 'Fraud Yönetimi',
        'fraudTransactions' => 'Fraud İşlemleri',
        'fraudScenarios' => 'Fraud Senaryoları',
        'POSSettings' => 'POS Ayarları',
        'banks' => 'Bankalar',
        'agreements' => 'Sözleşmeler',
        'complaints' => 'Şikayetler',
        'documents' => 'Belgeler',
        'settings' => 'Ayarlar',
        'adminManagement' => 'Kullanıcı Yönetimi',
        'updateSMTP' => 'SMTP Güncelle',
        'auditingLog' => 'Denetim Günlüğü',
        'roles' => 'Roller',
    ],
    'env' => [
        'save' => 'Kaydet',
        'sendTestEmail' => 'Test E-postası Gönder',
        'submit' => 'Gönder',
        'cancel' => 'İptal',
        'email' => 'E-posta',
        'titles' => [
            'title' => 'Ortam Ayarlarını Güncelle',
            'recaptcha' => 'RECAPTCHA V3',
            'smtp' => 'SMTP',
            'firebase' => 'Firebase',
        ],
        'recaptcha' => [
            'site_key' => 'SİTE ANAHTARI',
            'secret_key' => 'GİZLİ ANAHTAR',
            'link' => 'BAĞLANTI',
        ],
        'mail' => [
            'MAIL_MAILER' => 'MAIL GÖNDERİCİ',
            'MAIL_HOST' => 'MAIL SUNUCUSU',
            'MAIL_USERNAME' => 'MAIL KULLANICI ADI',
            'MAIL_PASSWORD' => 'MAIL ŞİFRESİ',
            'MAIL_ENCRYPTION' => 'MAIL ŞİFRELEME',
            'MAIL_FROM_ADDRESS' => 'MAIL GÖNDEREN ADRESİ',
            'MAIL_FROM_NAME' => 'MAIL GÖNDEREN ADI',
        ],
        'firebase' => [
            'FIREBASE_API_KEY' => 'FIREBASE API ANAHTARI',
            'FIREBASE_AUTH_DOMAIN' => 'FIREBASE YETKİLENDİRME ALANI',
            'FIREBASE_PROJECT_ID' => 'FIREBASE PROJE ID',
            'FIREBASE_STORAGE_BUCKET' => 'FIREBASE DEPOLAMA ALANI',
            'FIREBASE_MESSAGING_SENDER_ID' => 'FIREBASE MESAJLAŞMA GÖNDERİCİ ID',
            'FIREBASE_APP_ID' => 'FIREBASE UYGULAMA ID',
        ],
    ],
];
