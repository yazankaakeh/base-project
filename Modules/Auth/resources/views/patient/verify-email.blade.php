@extends('theme::user.layouts.layoutFront')

@section('title', __('Verify Email'))

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
                        <h4 class="mb-2">{{ __('Verify Your Email Address') }}</h4>
                        <p class="mb-4">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }}
                        </p>

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form class="d-inline" method="POST" action="{{ route('patient.verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
                                {{ __('Click here to request another') }}
                            </button>
                        </form>

                        <div class="text-center">
                            <form method="POST" action="{{ route('patient.logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link">
                                    {{ __('Logout') }}
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