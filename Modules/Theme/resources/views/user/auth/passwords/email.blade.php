@php
    $customizerHidden = 'customizer-hide';
@endphp
@extends('theme::user/layouts/layoutMaster')

@section('title', trans('auth.email.title'))

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
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{url('/')}}" class="app-brand-link gap-2">
                <span
                        class="app-brand-logo demo">@includeIf('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>

                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">{{trans('auth.email.title')}}</h4>
                        <p class="mb-4">{{trans('auth.email.desc')}}</p>
                        <form id="" class="mb-3" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <x-core::input
                                label="auth.email.email"
                                type="text"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                autofocus="autofocus" />
                            <button class="btn btn-primary d-grid w-100">{{trans('auth.email.sendResetLink')}}</button>
                            <x-core::recaptcha id="recaptcha" name="recaptcha"/>
                        </form>
                        <div class="text-center">
                            <a href="{{route('login')}}" class="d-flex align-items-center justify-content-center">
                                <i class="ti tabler-chevron-left scaleX-n1-rtl"></i>
                                {{trans('auth.email.signIn')}}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>
@endsection
