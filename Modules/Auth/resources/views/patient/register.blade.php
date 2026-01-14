@extends('theme::user.layouts.layoutFront')

@section('title', trans('auth::auth.patient_registration'))

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4">
                            <span class="app-brand-text demo text-body fw-bold">{{ config('app.name') }}</span>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">{{ trans('auth::auth.patient_registration') }}</h4>
                        <p class="mb-4">{{ trans('auth::auth.patient_registration_subtitle') }}</p>

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

                        <form id="formAuthentication" class="mb-3" action="{{ route('patient.register.post') }}"
                              method="POST">
                            @csrf

                            <x-core::input
                                label="auth::auth.full_name"
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                required="required" />

                            <x-core::input
                                label="auth::auth.email"
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required="required" />

                            <x-core::input
                                label="auth::auth.phone"
                                type="text"
                                name="phone"
                                id="phone"
                                value="{{ old('phone') }}"
                                required="required" />

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">{{ trans('auth::auth.password') }}</label>
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

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password-confirm">{{ trans('auth::auth.confirm_password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password-confirm" class="form-control"
                                           name="password_confirmation"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password" required/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">{{ trans('auth::auth.sign_up') }}</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>{{ trans('auth::auth.already_have_account') }}</span>
                            <a href="{{ route('patient.login') }}">
                                <span>{{ trans('auth::auth.sign_in_instead') }}</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Register Card -->
            </div>
        </div>
    </div>
@endsection