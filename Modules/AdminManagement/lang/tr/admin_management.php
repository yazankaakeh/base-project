<?php

use Modules\AdminManagement\Enums\ActiveAdminEnum;

return [
    'ActiveAdminEnum' => [
        ActiveAdminEnum::ACTIVE->value => 'Aktif',
        ActiveAdminEnum::DE_ACTIVE->value => 'Pasif',
    ],
    'user' => [
        'title' => 'Kullanıcı Yönetimi',
        'editUserStatus' => 'Kullanıcı Durumunu Düzenle',
        'edit' => [
            'title' => 'Kullanıcıyı Düzenle',
        ],
        'create' => [
            'title' => 'Kullanıcı Oluştur',
            'img' => 'Resim',
            'password' => 'Şifre',
            'password_confirmation' => 'Şifre Onayı',
            'isActive' => 'Aktif',
            'name' => 'Ad',
            'email' => 'E-posta',
            'role' => 'Rol',
            'phone' => 'Telefon',
        ],
    ],
    'roles' => [
        'title' => 'Roller',
        'createBtn' => 'Oluştur',
        'id' => 'ID',
        'name' => 'Ad',
        'created_at' => 'Oluşturulma Tarihi',
        'updated_at' => 'Güncellenme Tarihi',
        'actions' => 'İşlemler',
        'create' => [
            'title' => 'Rol Oluştur',
            'name' => 'Ad',
            'guard' => 'Koruma',
            'allCheckBoxes' => 'Tüm Kutular',
        ],
        'edit' => [
            'title' => 'Rolü Düzenle',
        ],
    ],
    'audits' => [
        'index' => 'Denetim Günlükleri',
        'getPayLoad' => 'Yükü Al',
        'filter' => 'Filtrele',
        'admin' => 'Yönetici',
        'action' => 'İşlem',
        'ip' => 'IP Adresi',
        'time' => 'Zaman',
        'changes' => 'Değişiklikler',
        'filterModal' => [
            'all' => 'Tümü',
            'index' => 'Filtrele',
            'adminId' => 'Yönetici',
            'date' => 'Tarih',
            'routeName' => 'Rota Adı',
        ],
    ],
    'submit' => 'Gönder',
    'close' => 'Kapat',
    'save' => 'Değişiklikleri kaydet',
    'pleaseSelectOne' => 'Lütfen birini seçin',
    'permissions' => [
        // Admin Management Permissions
        'admin-user_management-index' => 'Kullanıcı Yönetimini Görüntüle',
        'admin-user_management-store' => 'Kullanıcı Oluştur',
        'admin-user_management-update' => 'Kullanıcıyı Güncelle',
        'admin-user_management-status' => 'Kullanıcıyı Sil/Durumunu Değiştir',

        'admin-audits-index' => 'Denetim Günlüklerini Görüntüle',
        'admin-audits-getPayload' => 'Denetim Günlüğü Detaylarını Görüntüle',

        'admin-role_management-index' => 'Rol Yönetimini Görüntüle',
        'admin-role_management-create' => 'Rol Oluştur',
        'admin-role_management-store' => 'Rol Kaydet',
        'admin-role_management-edit' => 'Rolü Düzenle',
        'admin-role_management-update' => 'Rolü Güncelle',
        'admin-role_management-destroy' => 'Rolü Sil',

        // Blog Permissions
        'doctor-categories-index' => 'Kategorileri Görüntüle',
        'doctor-categories-create' => 'Kategori Oluştur',
        'doctor-categories-store' => 'Kategori Kaydet',
        'doctor-categories-show' => 'Kategori Detaylarını Görüntüle',
        'doctor-categories-edit' => 'Kategoriyi Düzenle',
        'doctor-categories-update' => 'Kategoriyi Güncelle',
        'doctor-categories-destroy' => 'Kategoriyi Sil',

        'doctor-posts-index' => 'Gönderileri Görüntüle',
        'doctor-posts-create' => 'Gönderi Oluştur',
        'doctor-posts-store' => 'Gönderi Kaydet',
        'doctor-posts-show' => 'Gönderi Detaylarını Görüntüle',
        'doctor-posts-edit' => 'Gönderiyi Düzenle',
        'doctor-posts-update' => 'Gönderiyi Güncelle',
        'doctor-posts-destroy' => 'Gönderiyi Sil',

        'doctor-quillUpload-store' => 'Editöre Resim Yükle',

        'doctor-tags-index' => 'Etiketleri Görüntüle',
        'doctor-tags-create' => 'Etiket Oluştur',
        'doctor-tags-store' => 'Etiket Kaydet',
        'doctor-tags-show' => 'Etiket Detaylarını Görüntüle',
        'doctor-tags-edit' => 'Etiketi Düzenle',
        'doctor-tags-update' => 'Etiketi Güncelle',
        'doctor-tags-destroy' => 'Etiketi Sil',
        'doctor-tags-storeAjax' => 'AJAX ile Etiket Oluştur',
        'doctor-tags-options' => 'Etiket Seçeneklerini Al',

        // CMS Permissions
        'cms-home-edit' => 'Ana Sayfayı Düzenle',
        'cms-home-update' => 'Ana Sayfayı Güncelle',

        'cms-index' => 'CMS Sayfalarını Görüntüle',
        'cms-create' => 'CMS Sayfası Oluştur',
        'cms-store' => 'CMS Sayfası Kaydet',
        'cms-show' => 'CMS Sayfası Detaylarını Görüntüle',
        'cms-edit' => 'CMS Sayfasını Düzenle',
        'cms-update' => 'CMS Sayfasını Güncelle',
        'cms-destroy' => 'CMS Sayfasını Sil',

        'menus-index' => 'Menüleri Görüntüle',
        'menus-create' => 'Menü Oluştur',
        'menus-store' => 'Menü Kaydet',
        'menus-show' => 'Menü Detaylarını Görüntüle',
        'menus-edit' => 'Menüyü Düzenle',
        'menus-update' => 'Menüyü Güncelle',
        'menus-destroy' => 'Menüyü Sil',

        // Doctor Permissions
        'doctor-dashboard' => 'Kontrol Paneli Görüntüle',

        'doctor-clinic-index' => 'Klinik Görüntüle',
        'doctor-clinic-store' => 'Klinik Bilgilerini Kaydet',
        'doctor-clinic-update' => 'Klinik Bilgilerini Güncelle',

        'doctor-patients-index' => 'Hastaları Görüntüle',
        'doctor-patients-store' => 'Hasta Oluştur',
        'doctor-patients-update' => 'Hastayı Güncelle',
        'doctor-patients-show' => 'Hasta Detaylarını Görüntüle',
        'doctor-patients-downloadVCard' => 'Hasta Kartını İndir',

        'doctor-medicalTest-index' => 'Tıbbi Testleri Görüntüle',
        'doctor-medicalTest-store' => 'Tıbbi Test Oluştur',
        'doctor-medicalTest-update' => 'Tıbbi Testi Güncelle',

        'doctor-medicine-index' => 'İlaçları Görüntüle',
        'doctor-medicine-store' => 'İlaç Oluştur',
        'doctor-medicine-update' => 'İlacı Güncelle',

        'doctor-medicalSpecialty-index' => 'Tıbbi Uzmanlıkları Görüntüle',
        'doctor-medicalSpecialty-store' => 'Tıbbi Uzmanlık Oluştur',
        'doctor-medicalSpecialty-update' => 'Tıbbi Uzmanlığı Güncelle',

        'doctor-vitalSign-index' => 'Vital Bulguları Görüntüle',
        'doctor-vitalSign-store' => 'Vital Bulgu Oluştur',
        'doctor-vitalSign-update' => 'Vital Bulguyu Güncelle',

        'doctor-finalDiagnosis-index' => 'Son Tanıları Görüntüle',
        'doctor-finalDiagnosis-store' => 'Son Tanı Oluştur',
        'doctor-finalDiagnosis-update' => 'Son Tanıyı Güncelle',

        'doctor-dosageForm-index' => 'Dozaj Formlarını Görüntüle',
        'doctor-dosageForm-store' => 'Dozaj Formu Oluştur',
        'doctor-dosageForm-update' => 'Dozaj Formunu Güncelle',

        'doctor-medicalExamination-create' => 'Tıbbi Muayene Oluştur',
        'doctor-medicalExamination-store' => 'Tıbbi Muayene Kaydet',
        'doctor-medicalExamination-submit' => 'Tıbbi Muayene Gönder',
        'doctor-medicalExamination-show' => 'Tıbbi Muayene Görüntüle',
        'doctor-medicalExamination-index' => 'Tıbbi Muayeneleri Görüntüle',

        'doctor-uploadFile-index' => 'Dosya Yükle',
        'doctor-uploadFile-delete' => 'Dosyaları Sil',

        'doctor-pdf-downloadMedicines' => 'İlaçlar PDF İndir',
        'doctor-pdf-downloadMedicalTest' => 'Tıbbi Test PDF İndir',
        'doctor-pdf-downloadMedicinesPharmacy' => 'Eczane İlaçları PDF İndir',
    ],
    'sections' => [
        'admin' => 'Yönetici Yönetimi',
        'audits' => 'Denetimler',
        'role_management' => 'Rol Yönetimi',
        'user_management' => 'Kullanıcı Yönetimi',
        'categories' => 'Kategoriler',
        'posts' => 'Gönderiler',
        'tags' => 'Etiketler',
        'cms' => 'CMS',
        'menus' => 'Menüler',
        'dashboard' => 'Kontrol Paneli',
        'clinic' => 'Klinik',
        'patients' => 'Hastalar',
        'medicalTest' => 'Tıbbi Testler',
        'medicine' => 'İlaçlar',
        'medicalSpecialty' => 'Tıbbi Uzmanlıklar',
        'vitalSign' => 'Vital Bulgular',
        'finalDiagnosis' => 'Son Tanılar',
        'dosageForm' => 'Dozaj Formları',
        'medicalExamination' => 'Tıbbi Muayeneler',
        'uploadFile' => 'Dosya Yükleme',
        'pdf' => 'PDF Raporları',
    ],
];
