@extends('theme::user.layouts.layoutFront')

@section('title', __('Patient Login'))

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Login Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4">
                            <span class="app-brand-text demo text-body fw-bold">{{ config('app.name') }}</span>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">{{ __('Patient Login') }}</h4>
                        <p class="mb-4">{{ __('Please sign in to your account') }}</p>

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

                        <form id="formAuthentication" class="mb-3" action="{{ route('patient.login.post') }}"
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

                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">{{ __('Password') }}</label>
                                    <a href="{{ route('patient.password.request') }}">
                                        <small>{{ __('Forgot Password?') }}</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password" required/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Sign in') }}</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>{{ __('New on our platform?') }}</span>
                            <a href="{{ route('patient.register') }}">
                                <span>{{ __('Create an account') }}</span>
                            </a>
                        </p>

                        <p class="text-center">
                            <span>{{ __('Are you a doctor?') }}</span>
                            <a href="{{ route('doctor.login') }}">
                                <span>{{ __('Doctor Login') }}</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Login Card -->
            </div>
        </div>
    </div>
@endsection