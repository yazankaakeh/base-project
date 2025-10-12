@extends('theme::user.layouts.layoutFront')

@section('title', __('Forgot Password'))

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
                        <h4 class="mb-2">{{ __('Forgot Password?') }}</h4>
                        <p class="mb-4">{{ __('Enter your email and we will send you instructions to reset your password') }}</p>

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

                        <form id="formAuthentication" class="mb-3" action="{{ route('patient.password.email') }}"
                              method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                       name="email" value="{{ old('email') }}"
                                       placeholder="{{ __('Enter your email') }}"
                                       autofocus required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-primary d-grid w-100">{{ __('Send Reset Link') }}</button>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('patient.login') }}"
                               class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                {{ __('Back to login') }}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password Card -->
            </div>
        </div>
    </div>
@endsection