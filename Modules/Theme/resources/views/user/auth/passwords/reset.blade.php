@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('theme::user/layouts/layoutMaster')

@section('title', trans('auth.reset.for'))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'], 'build/modules/theme')
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'], 'build/modules/theme')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js'], 'build/modules/theme')
@endsection

@section('page-script')
    @vite(['resources/assets/js/pages-auth.js'], 'build/modules/theme')
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Reset Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{url('/')}}" class="app-brand-link gap-2">
                <span
                        class="app-brand-logo demo">@includeIf('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
                                <span class="app-brand-text demo text-body fw-bold ms-1">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">{{trans('auth.reset.title')}}</h4>
                        <p class="mb-4">
                            {{trans('auth.reset.for')}} <span class="fw-medium">
                {{ $email ?? old('email') }}
              </span>
                        </p>
                        <form id="formResetPasswordAuthentication" method="POST"
                              action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">{{trans('auth.reset.newPassword')}}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer"><i
                                                class="ti tabler-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label"
                                       for="password_confirmation">{{trans('auth.reset.confirmPassword')}}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control"
                                           name="password_confirmation"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer">
                    <i class="ti tabler-eye-off"></i>
                  </span>
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>

                </span>
                                @enderror
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
                                {{trans('auth.reset.btn')}}
                            </button>
                            <div class="text-center">
                                <a href="{{route('login')}}">
                                    <i class="ti tabler-chevron-left scaleX-n1-rtl"></i>
                                    {{trans('auth.reset.login')}}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Reset Password -->
            </div>
        </div>
    </div>
@endsection
