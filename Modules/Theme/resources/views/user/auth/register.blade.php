@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('theme::user/layouts/layoutMaster')

@section('title', trans('auth.register.title'))

@section('vendor-style')
    @vite(['Modules/Theme/resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['Modules/Theme/resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['Modules/Theme/resources/assets/vendor/libs/@form-validation/popular.js',
    'Modules/Theme/resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'Modules/Theme/resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['Modules/Theme/resources/assets/js/pages-auth.js'])
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{url('/')}}" class="app-brand-link gap-2">
                                <img src="{{asset('landing/assets/img/tagiy.svg')}}" alt="">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">{{trans('auth.register.title')}}</h4>
                        <p class="mb-4">{{trans('auth.register.desc')}}</p>

                        <form id="formAuthentication" class="mb-3" action="{{route('register')}}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label for="name" class="form-label">{{trans('auth.register.name')}}</label>
                                <input type="text" value="{{old('name')}}" class="form-control" id="name" name="name"
                                       placeholder="Enter your username"
                                       autofocus>
                                @error('username')
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{trans('auth.register.email')}}</label>
                                <input type="email" value="{{old('email')}}" class="form-control" id="email"
                                       name="email"
                                       placeholder="Enter your email">
                                @error('email')
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">{{trans('auth.register.password')}}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer"><i
                                                class="ti tabler-eye-off"></i></span>
                                </div>
                                @error('password')
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label"
                                       for="password_confirmation">{{trans('auth.register.confirmPassword')}}</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control"
                                           name="password_confirmation"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer"><i
                                                class="ti tabler-eye-off"></i></span>
                                </div>
                            </div>
                            @if(request('card_link'))
                                <input type="hidden" name="card_link" value="{{ request()->route('card_link') }}">
                            @endif
                            <x-core::recaptcha id="recaptcha" name="recaptcha"/>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                        {!! trans('auth.register.privacy', ['link' => route('landing.privacy')]) !!}
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100">
                                {{trans('auth.register.signUp')}}
                            </button>
                        </form>

                        <p class="text-center">
                            <span>{{trans('auth.register.signUp')}}</span>
                            <a
                                    href="{{request('card_link') ? route('custom-login',['card_link' =>request('card_link') ]) : route('login')}}">
                                <span>{{trans('auth.register.signIn')}}</span>
                            </a>
                        </p>

                        <div class="divider my-4">
                            <div class="divider-text">{{trans('auth.login.or')}}</div>
                        </div>

                        @includeIf('auth.partial.socials')
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
@endsection
