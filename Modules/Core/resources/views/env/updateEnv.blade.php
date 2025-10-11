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

                                <form action="{{ route('doctor.env.update') }}" method="POST">
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
                                <form action="{{ route('doctor.env.sendTestEmail') }}" method="POST">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
