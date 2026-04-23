@extends('theme::user.layouts.layoutFront')

@section('title', trans('auth::auth.verify_email'))

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Verify Email Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4">
                            <span class="app-brand-text demo text-body fw-bold">{{ config('app.name') }}</span>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">{{ trans('auth::auth.verify_email') }}</h4>
                        <p class="mb-4">
                            {{ trans('auth::auth.verify_email_message') }}
                            {{ trans('auth::auth.did_not_receive_email') }}
                        </p>

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form class="d-inline" method="POST" action="{{ route('admin.verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
                                {{ trans('auth::auth.request_another') }}
                            </button>
                        </form>

                        <div class="text-center">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link">
                                    {{ trans('auth::auth.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Verify Email Card -->
            </div>
        </div>
    </div>
@endsection