@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('theme::user.layouts.layoutFront')

@section('title', trans('auth.login.title', ['name' => config('variables.templateName')]))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'], 'build/modules/theme')
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'], 'build/modules/theme')
    <style>
        /* Codliy-branded auth shell — every color here resolves through the
           ThemeSetting pipeline (--codliy-* / --bs-primary). */
        .codliy-auth {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            padding: 3rem 0;
            background: var(--codliy-bg-dark);
            position: relative;
            overflow: hidden;
        }
        .codliy-auth::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.18), transparent 55%),
                radial-gradient(circle at 80% 80%, rgba(var(--codliy-accent-rgb, 59, 130, 246), 0.14), transparent 55%);
            pointer-events: none;
        }
        .codliy-auth__shell {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr;
            background: rgba(13, 23, 55, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        @media (min-width: 992px) {
            .codliy-auth__shell { grid-template-columns: 1.05fr 1fr; }
        }
        .codliy-auth__pitch {
            display: none;
            padding: 3rem;
            background: var(--codliy-primary-gradient);
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        @media (min-width: 992px) {
            .codliy-auth__pitch { display: flex; flex-direction: column; justify-content: space-between; }
        }
        .codliy-auth__pitch::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15), transparent 60%);
            pointer-events: none;
        }
        .codliy-auth__kicker {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        .codliy-auth__title {
            color: #fff;
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 700;
            letter-spacing: -0.5px;
            line-height: 1.15;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        .codliy-auth__sub {
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.98rem;
            line-height: 1.7;
            max-width: 360px;
            position: relative;
            z-index: 1;
        }
        .codliy-auth__meta {
            display: flex;
            gap: 1.25rem;
            flex-wrap: wrap;
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.85rem;
            position: relative;
            z-index: 1;
        }
        .codliy-auth__meta i { margin-inline-end: 0.35rem; color: rgba(255, 255, 255, 0.9); }

        .codliy-auth__panel {
            padding: 2.5rem clamp(1.5rem, 4vw, 3rem);
            color: var(--codliy-text-soft);
        }
        .codliy-auth__brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.8rem;
        }
        .codliy-auth__brand img { max-height: 40px; }
        .codliy-auth__heading {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--codliy-text-soft);
            letter-spacing: -0.3px;
            margin-bottom: 0.3rem;
        }
        .codliy-auth__lead {
            color: var(--codliy-text-mute);
            font-size: 0.95rem;
            margin-bottom: 1.8rem;
        }
        .codliy-auth__panel .form-label {
            color: var(--codliy-text-soft);
            font-weight: 500;
            font-size: 0.88rem;
            letter-spacing: 0.1px;
        }
        .codliy-auth__panel .form-control,
        .codliy-auth__panel .input-group-text {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--codliy-text-soft);
            padding: 0.7rem 0.9rem;
            border-radius: 10px;
            transition: border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }
        .codliy-auth__panel .form-control::placeholder { color: rgba(217, 217, 217, 0.45); }
        .codliy-auth__panel .form-control:focus {
            border-color: var(--codliy-primary);
            box-shadow: 0 0 0 3px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.18);
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
        }
        .codliy-auth__panel .input-group-merge .form-control {
            border-right: none;
        }
        .codliy-auth__panel .input-group-merge .input-group-text {
            border-left: none;
            color: var(--codliy-text-mute);
        }
        .codliy-auth__panel .form-check-input {
            background-color: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.2);
        }
        .codliy-auth__panel .form-check-input:checked {
            background-color: var(--codliy-primary);
            border-color: var(--codliy-primary);
        }
        .codliy-auth__panel .form-check-label { color: var(--codliy-text-mute); font-size: 0.9rem; }
        .codliy-auth__panel .btn-primary,
        .codliy-auth__panel .btn-codliy {
            background: var(--codliy-primary);
            border: 1px solid var(--codliy-primary);
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.1px;
            border-radius: 10px;
            padding: 0.8rem 1.2rem;
            transition: all 0.18s ease;
        }
        .codliy-auth__panel .btn-primary:hover,
        .codliy-auth__panel .btn-codliy:hover {
            background: var(--codliy-accent);
            border-color: var(--codliy-accent);
            transform: translateY(-1px);
            box-shadow: 0 10px 26px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.35);
        }
        .codliy-auth__footer {
            color: var(--codliy-text-mute);
            font-size: 0.9rem;
            margin-top: 1.25rem;
        }
        .codliy-auth__footer a {
            color: var(--codliy-primary);
            text-decoration: none;
            font-weight: 500;
        }
        .codliy-auth__footer a:hover { color: var(--codliy-accent); }

        /* Light-mode refinement */
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth,
        [data-layout-mode="light_mode"] .codliy-auth {
            background: #F6F8FC;
        }
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__shell,
        [data-layout-mode="light_mode"] .codliy-auth__shell {
            background: #ffffff;
            border-color: rgba(10, 31, 77, 0.08);
        }
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__panel,
        [data-layout-mode="light_mode"] .codliy-auth__panel {
            color: #0a1220;
        }
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__heading,
        [data-layout-mode="light_mode"] .codliy-auth__heading { color: #0a1220; }
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__lead,
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__panel .form-check-label,
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__footer,
        [data-layout-mode="light_mode"] .codliy-auth__lead,
        [data-layout-mode="light_mode"] .codliy-auth__panel .form-check-label,
        [data-layout-mode="light_mode"] .codliy-auth__footer { color: #5B6670; }
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__panel .form-label,
        [data-layout-mode="light_mode"] .codliy-auth__panel .form-label { color: #0a1220; }
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__panel .form-control,
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__panel .input-group-text,
        [data-layout-mode="light_mode"] .codliy-auth__panel .form-control,
        [data-layout-mode="light_mode"] .codliy-auth__panel .input-group-text {
            background: #F6F8FC;
            border-color: rgba(10, 31, 77, 0.12);
            color: #0a1220;
        }
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__panel .form-control::placeholder,
        [data-layout-mode="light_mode"] .codliy-auth__panel .form-control::placeholder { color: #8A94B0; }
        [data-bs-theme="light"]:not([data-layout-mode="dark_mode"]) .codliy-auth__panel .form-check-input,
        [data-layout-mode="light_mode"] .codliy-auth__panel .form-check-input {
            background-color: #ffffff;
            border-color: rgba(10, 31, 77, 0.25);
        }

        /* RTL */
        [dir="rtl"] .codliy-auth__meta i,
        [data-direction="rtl"] .codliy-auth__meta i {
            margin-inline-end: 0;
            margin-inline-start: 0.35rem;
        }
    </style>
@endsection

@section('vendor-script')
    @vite([
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js'], 'build/modules/theme')
@endsection

@section('page-script')
    @vite(['resources/assets/js/pages-auth.js'], 'build/modules/theme')
@endsection


@section('content')
    <section class="codliy-auth">
        <div class="container-xxl">
            <div class="codliy-auth__shell mx-auto" style="max-width: 1040px;">
                {{-- Pitch panel (desktop only) --}}
                <aside class="codliy-auth__pitch">
                    <div>
                        <div class="codliy-auth__kicker">{{ strtoupper(config('app.name', 'Codliy')) }} · CONTROL ROOM</div>
                        <h2 class="codliy-auth__title">{{ trans('auth.login.title', ['name' => config('variables.templateName')]) }}</h2>
                        <p class="codliy-auth__sub">{{ trans('auth.login.desc') }}</p>
                    </div>
                    <div class="codliy-auth__meta">
                        <span><i class="ti tabler-shield-check"></i> Secure session</span>
                        <span><i class="ti tabler-bolt"></i> Single sign-on ready</span>
                    </div>
                </aside>

                {{-- Form panel --}}
                <div class="codliy-auth__panel">
                    <div class="codliy-auth__brand">
                        <a href="{{ url('/') }}" class="d-inline-flex align-items-center text-decoration-none">
                            <img src="{{ asset('codliy/images/logo.png') }}" alt="{{ config('app.name', 'Codliy') }}">
                        </a>
                    </div>

                    <h4 class="codliy-auth__heading">
                        {{ trans('auth.login.title', ['name' => config('variables.templateName')]) }}
                    </h4>
                    <p class="codliy-auth__lead">
                        {{ trans('auth.login.desc') }}
                    </p>

                    <form method="POST" id="formAuthentication" action="{{ route('admin.login.submit') }}" class="mb-3">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="email">{{ trans('auth.login.email') }}</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="jon_doe@gmail.com"
                                value="{{ old('email') }}"
                                autofocus>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">{{ trans('auth.login.password') }}</label>
                                {{-- <a href="{{ route('password.request') }}"><small>{{ trans('auth.login.forgotPassword') }}</small></a> --}}
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password"
                                    class="form-control"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password">
                                <span class="input-group-text cursor-pointer"><i class="ti tabler-eye-off"></i></span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                                <label class="form-check-label" for="remember-me">
                                    {{ trans('auth.login.rememberMe') }}
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-core::recaptcha id="recaptcha" name="recaptcha"/>
                            @error('recaptcha')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button class="btn btn-primary d-grid w-100" type="submit">
                            {{ trans('auth.login.signIn') }}
                        </button>
                    </form>

                    <p class="codliy-auth__footer text-center mb-0">
                        <span>{{ trans('auth.login.newToPlatform') }}</span>
                        {{-- <a href="{{ route('register') }}">{{ trans('auth.login.createAccount') }}</a> --}}
                    </p>

                    <div class="mt-3">
                        <x-auth::social-login-buttons user-type="admin" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
