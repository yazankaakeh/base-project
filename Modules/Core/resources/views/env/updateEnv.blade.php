<?php

$page = 'sales-dashboard';
?>
@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('core::core.env.titles.title'))

<!-- Vendor Styles -->
@section('vendor-style')
    @livewireStyles
    @livewireScripts
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.scss'],
            'build/modules/theme')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
            'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
            'resources/assets/vendor/libs/select2/select2.scss',
            'resources/assets/vendor/libs/@form-validation/form-validation.scss'],
            'build/modules/theme')
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/dropzone/dropzone.js'], 'build/modules/theme')
    @vite([ 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
            'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
            'resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/libs/@form-validation/popular.js',
            'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
            'resources/assets/vendor/libs/@form-validation/auto-focus.js'],
            'build/modules/theme')
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between pb-2 mb-1">
                            <h5 class="">{{ trans('core::core.env.titles.title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <!-- Success/Error Messages -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endif

                                <form action="{{ route('admin.env.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')

                                    <!-- RECAPTCHA Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h4 class="mb-3">{{ trans('core::core.env.titles.recaptcha') }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.recaptcha.site_key"
                                                    id="RECAPTCHA_SITE_KEY"
                                                    name="RECAPTCHA_SITE_KEY"
                                                    type="text"
                                                    :value="config('services.recaptcha.site_key')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.recaptcha.secret_key"
                                                    id="RECAPTCHA_SECRET_KEY"
                                                    name="RECAPTCHA_SECRET_KEY"
                                                    type="text"
                                                    :value="config('services.recaptcha.secret_key')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.recaptcha.link"
                                                    id="RECAPTCHA_LINK"
                                                    name="RECAPTCHA_LINK"
                                                    type="text"
                                                    :value="config('services.recaptcha.link')">
                                            </x-core::input>
                                        </div>
                                    </div>

                                    <!-- SMTP Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h4 class="mb-3">{{ trans('core::core.env.titles.smtp') }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.mail.MAIL_MAILER"
                                                    id="MAIL_MAILER"
                                                    name="MAIL_MAILER"
                                                    type="text"
                                                    :value="config('mail.mailer')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.mail.MAIL_HOST"
                                                    id="MAIL_HOST"
                                                    name="MAIL_HOST"
                                                    type="text"
                                                    :value="config('mail.host')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.mail.MAIL_USERNAME"
                                                    id="MAIL_USERNAME"
                                                    name="MAIL_USERNAME"
                                                    type="text"
                                                    :value="config('mail.username')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.mail.MAIL_PASSWORD"
                                                    id="MAIL_PASSWORD"
                                                    name="MAIL_PASSWORD"
                                                    type="password"
                                                    :value="config('mail.password')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.mail.MAIL_ENCRYPTION"
                                                    id="MAIL_ENCRYPTION"
                                                    name="MAIL_ENCRYPTION"
                                                    type="text"
                                                    :value="config('mail.encryption')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.mail.MAIL_FROM_ADDRESS"
                                                    id="MAIL_FROM_ADDRESS"
                                                    name="MAIL_FROM_ADDRESS"
                                                    type="email"
                                                    :value="config('mail.from.address')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.mail.MAIL_FROM_NAME"
                                                    id="MAIL_FROM_NAME"
                                                    name="MAIL_FROM_NAME"
                                                    type="text"
                                                    :value="config('mail.from.name')">
                                            </x-core::input>
                                        </div>
                                    </div>

                                    <!-- Firebase Section -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h4 class="mb-3">{{ trans('core::core.env.titles.firebase') }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.firebase.FIREBASE_API_KEY"
                                                    id="FIREBASE_API_KEY"
                                                    name="FIREBASE_API_KEY"
                                                    type="text"
                                                    :value="config('services.firebase.api_key')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.firebase.FIREBASE_AUTH_DOMAIN"
                                                    id="FIREBASE_AUTH_DOMAIN"
                                                    name="FIREBASE_AUTH_DOMAIN"
                                                    type="text"
                                                    :value="config('services.firebase.auth_domain')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.firebase.FIREBASE_PROJECT_ID"
                                                    id="FIREBASE_PROJECT_ID"
                                                    name="FIREBASE_PROJECT_ID"
                                                    type="text"
                                                    :value="config('services.firebase.project_id')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.firebase.FIREBASE_STORAGE_BUCKET"
                                                    id="FIREBASE_STORAGE_BUCKET"
                                                    name="FIREBASE_STORAGE_BUCKET"
                                                    type="text"
                                                    :value="config('services.firebase.storage_bucket')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.firebase.FIREBASE_MESSAGING_SENDER_ID"
                                                    id="FIREBASE_MESSAGING_SENDER_ID"
                                                    name="FIREBASE_MESSAGING_SENDER_ID"
                                                    type="text"
                                                    :value="config('services.firebase.messaging_sender_id')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.firebase.FIREBASE_APP_ID"
                                                    id="FIREBASE_APP_ID"
                                                    name="FIREBASE_APP_ID"
                                                    type="text"
                                                    :value="config('services.firebase.app_id')">
                                            </x-core::input>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="FIREBASE_SERVICE_ACCOUNT_FILE" class="form-label">
                                                    {{ trans('core::core.env.firebase.FIREBASE_SERVICE_ACCOUNT_FILE') }}
                                                </label>
                                                <input type="file"
                                                       class="form-control"
                                                       id="FIREBASE_SERVICE_ACCOUNT_FILE"
                                                       name="FIREBASE_SERVICE_ACCOUNT_FILE"
                                                       accept=".json">
                                                <div class="form-text">
                                                    {{ trans('core::core.env.firebase.FIREBASE_SERVICE_ACCOUNT_FILE_HELP') }}
                                                </div>
                                                @if(file_exists(base_path('storage/firebase-service-account.json')))
                                                    <div class="text-success mt-1">
                                                        <i class="ti tabler-check me-1"></i>
                                                        {{ trans('core::core.env.firebase.FIREBASE_SERVICE_ACCOUNT_FILE_EXISTS') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti tabler-device-floppy me-1"></i>
                                            {{ trans('core::core.env.submit') }}
                                        </button>
                                    </div>
                                </form>

                                <!-- Test Email Section -->
                                <hr class="my-4">
                                <form action="{{ route('admin.env.sendTestEmail') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="mb-3">{{ trans('core::core.env.sendTestEmail') }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <x-core::input
                                                    label="core::core.env.email"
                                                    id="email"
                                                    name="email"
                                                    type="email"
                                                    required="required">
                                            </x-core::input>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <button type="submit" class="btn btn-outline-primary">
                                                <i class="ti tabler-mail me-1"></i>
                                                {{ trans('core::core.env.submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Firebase Notification Testing Section -->
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="mb-3">{{ trans('core::core.env.firebase.testNotifications') }}</h4>
                                    </div>

                                    <!-- Push Token Management -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">{{ trans('core::core.env.firebase.pushTokenManagement') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <form id="pushTokenForm">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="push_token" class="form-label">
                                                            {{ trans('core::core.env.firebase.pushToken') }}
                                                        </label>
                                                        <input type="text"
                                                               class="form-control"
                                                               id="push_token"
                                                               name="push_token"
                                                               placeholder="{{ trans('core::core.env.firebase.pushTokenPlaceholder') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="platform" class="form-label">
                                                            {{ trans('core::core.env.firebase.platform') }}
                                                        </label>
                                                        <select class="form-select" id="platform" name="platform">
                                                            <option value="web">{{ trans('core::core.env.firebase.platformWeb') }}</option>
                                                            <option value="android">{{ trans('core::core.env.firebase.platformAndroid') }}</option>
                                                            <option value="ios">{{ trans('core::core.env.firebase.platformIos') }}</option>
                                                        </select>
                                                    </div>
                                                    <button type="button" class="btn btn-primary" onclick="savePushToken()">
                                                        <i class="ti tabler-device-floppy me-1"></i>
                                                        {{ trans('core::core.env.firebase.saveToken') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Test Notification -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">{{ trans('core::core.env.firebase.testNotification') }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <form id="testNotificationForm">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="notification_title" class="form-label">
                                                            {{ trans('core::core.env.firebase.notificationTitle') }}
                                                        </label>
                                                        <input type="text"
                                                               class="form-control"
                                                               id="notification_title"
                                                               name="title"
                                                               value="{{ trans('core::core.env.firebase.testNotificationTitle') }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="notification_body" class="form-label">
                                                            {{ trans('core::core.env.firebase.notificationBody') }}
                                                        </label>
                                                        <textarea class="form-control"
                                                                  id="notification_body"
                                                                  name="body"
                                                                  rows="3">{{ trans('core::core.env.firebase.testNotificationBody') }}</textarea>
                                                    </div>
                                                    <button type="button" class="btn btn-success" onclick="sendTestNotification()">
                                                        <i class="ti tabler-send me-1"></i>
                                                        {{ trans('core::core.env.firebase.sendTestNotification') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
<script>
    // Save Push Token
    function savePushToken() {
        const form = document.getElementById('pushTokenForm');
        const formData = new FormData(form);

        fetch('{{ route("admin.firebase.saveToken") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                form.reset();
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while saving the token.');
        });
    }

    // Send Test Notification
    function sendTestNotification() {
        const form = document.getElementById('testNotificationForm');
        const formData = new FormData(form);

        fetch('{{ route("admin.firebase.sendTestNotification") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'An error occurred while sending the notification.');
        });
    }

    // Show Alert
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Remove existing alerts
        document.querySelectorAll('.alert').forEach(alert => alert.remove());

        // Add new alert at the top of the content
        const content = document.querySelector('.content');
        content.insertAdjacentHTML('afterbegin', alertHtml);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }

    // Initialize Firebase for Web Push (if needed)
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Firebase is configured
        const firebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}"
        };

        if (firebaseConfig.apiKey && firebaseConfig.projectId) {
            console.log('Firebase configuration loaded:', firebaseConfig);

            // Request permission for notifications
            if ('Notification' in window && 'serviceWorker' in navigator) {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        console.log('Notification permission granted');
                    }
                });
            }
        }
    });
</script>
@endsection
