@extends('theme::user.layouts.layoutFront')

@section('title', trans('auth::auth.forgot_password_title'))

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Forgot Password Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4">
                            <span class="app-brand-text demo text-body fw-bold">{{ config('app.name') }}</span>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">{{ trans('auth::auth.forgot_password_title') }}</h4>
                        <p class="mb-4">{{ trans('auth::auth.forgot_password_subtitle') }}</p>

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form id="formAuthentication" class="mb-3" action="{{ route('doctor.password.email') }}"
                              method="POST">
                            @csrf
                            <x-core::input
                                label="auth::auth.email"
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required="required" />
                            <button class="btn btn-primary d-grid w-100">{{ trans('auth::auth.send_reset_link') }}</button>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('doctor.login') }}"
                               class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                {{ trans('auth::auth.back_to_login') }}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password Card -->
            </div>
        </div>
    </div>
@endsection