<?php

$page = 'sales-dashboard'; ?>
@extends('theme::admin.layout.authlayout')
@section('title', trans('mps::mps.login.title'))
@section('content')
    <div class="account-content">
        <div class="login-wrapper bg-img">
            <div class="login-content">
                <div class="login-userset">
                    <div class="login-logo logo-normal">
                        <img src="{{ URL::asset('/build/img/logo.png') }}" alt="img">
                    </div>
                    <a class="login-logo logo-white">
                        <img src="{{ URL::asset('/build/img/logo-white.png') }}" alt="">
                    </a>
                    <div class="login-userheading">
                        <h3>
                            {{trans('mps::mps.login.title')}}
                        </h3>
                        <h4>
                            {{trans('mps::mps.login.description')}}
                        </h4>
                    </div>
                    <livewire:mps::login userType="admin"/>
                    <div class="form-sociallink">
                        <div class="pt-5 d-flex justify-content-center align-items-baseline copyright-text">
                            <p>
                                {!!  trans('mps::mps.login.footer',['year' => date('Y')])!!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
