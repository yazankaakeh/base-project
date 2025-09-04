@extends('theme::admin.layout.mainlayout')

@section('title', 'Update Env')


@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="card">
                <h5 class="card-header">{{trans('core::core.env.titles.title')}}</h5>
                <div class="row mb-5">
                    <div class="w-100"></div>
                    <div class="card-body mx-3">
                        <div class="card-content">
                            <form action="{{route('admin.env.updateEnv')}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="my-3 d-flex align-items-center w-100">
                                        <h3 class="">{{trans('core::core.env.titles.recaptcha')}}</h3>
                                        <div class="form-check form-switch ms-auto">
                                            <input type="hidden" name="recaptcha" value="0">
                                            <input class="form-check-input" value="1" name="recaptcha" type="checkbox"
                                                   role="switch"
                                                   id="recaptcha">
                                            <label class="form-check-label" for="recaptcha">
                                                {{trans('core::core.env.titles.recaptcha')}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.recaptcha.site_key" id="RECAPTCHA_SITE_KEY"
                                                       name="RECAPTCHA_SITE_KEY"
                                                       type="text"
                                                       model="RECAPTCHA_SITE_KEY"
                                                       value="{{config('core.recaptcha.site_key')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.recaptcha.secret_key"
                                                       id="RECAPTCHA_SECRET_KEY"
                                                       name="RECAPTCHA_SECRET_KEY" type="text"
                                                       model="RECAPTCHA_SECRET_KEY"
                                                       value="{{config('core.recaptcha.secret_key')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.recaptcha.link" id="RECAPTCHA_LINK"
                                                       name="RECAPTCHA_LINK" type="text"
                                                       model="RECAPTCHA_LINK"
                                                       value="{{config('core.recaptcha.link')}}">
                                        </x-core::input>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="my-3 d-flex align-items-center w-100">
                                        <h3>{{trans('core::core.env.titles.smtp')}}</h3>
                                        <div class="form-check form-switch ms-auto">
                                            <input type="hidden" name="mail" value="0">
                                            <input class="form-check-input" value="1" name="mail" type="checkbox"
                                                   role="switch"
                                                   id="mail">
                                            <label class="form-check-label" for="mail">
                                                {{trans('core::core.env.titles.smtp')}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.mail.MAIL_MAILER" id="MAIL_MAILER"
                                                       name="MAIL_MAILER"
                                                       type="text"
                                                       model="MAIL_MAILER"
                                                       value="{{config('core.mail.MAIL_MAILER')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.mail.MAIL_HOST" id="MAIL_HOST"
                                                       name="MAIL_HOST"
                                                       type="text"
                                                       model="MAIL_HOST"
                                                       value="{{config('core.mail.MAIL_HOST')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.mail.MAIL_USERNAME" id="MAIL_USERNAME"
                                                       name="MAIL_USERNAME"
                                                       type="text"
                                                       model="MAIL_USERNAME"
                                                       value="{{config('core.mail.MAIL_USERNAME')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.mail.MAIL_PASSWORD" id="MAIL_PASSWORD"
                                                       name="MAIL_PASSWORD"
                                                       type="text"
                                                       model="MAIL_PASSWORD"
                                                       value="{{config('core.mail.MAIL_PASSWORD')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.mail.MAIL_ENCRYPTION" id="MAIL_ENCRYPTION"
                                                       name="MAIL_ENCRYPTION"
                                                       type="text"
                                                       model="MAIL_ENCRYPTION"
                                                       value="{{config('core.mail.MAIL_ENCRYPTION')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.mail.MAIL_FROM_ADDRESS"
                                                       id="MAIL_FROM_ADDRESS"
                                                       name="MAIL_FROM_ADDRESS"
                                                       type="text"
                                                       model="MAIL_FROM_ADDRESS"
                                                       value="{{config('core.mail.MAIL_FROM_ADDRESS')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.mail.MAIL_FROM_NAME" id="MAIL_FROM_NAME"
                                                       name="MAIL_FROM_NAME"
                                                       type="text"
                                                       model="MAIL_FROM_NAME"
                                                       value="{{config('core.mail.MAIL_FROM_NAME')}}">
                                        </x-core::input>
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-sm-6 mt-4 pt-1 text-end">
                                        <button class="btn btn-primary">
                                            {{trans('core::core.env.submit')}}
                                        </button>
                                    </div>
                                </div>

                                {{--<div class="row">
                                     <div class="my-3 d-flex align-items-center w-100">
                                        <h3>{{trans('core::core.env.titles.smtp')}}</h3>
                                        <div class="form-check form-switch ms-auto">
                                            <input type="hidden" name="firebase" value="0">
                                            <input class="form-check-input" value="1" name="firebase" type="checkbox"
                                                   role="switch"
                                                   id="firebase">
                                            <label class="form-check-label" for="firebase">
                                                {{trans('core::core.env.titles.firebase')}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.firebase.FIREBASE_API_KEY" id="FIREBASE_API_KEY"
                                                       name="FIREBASE_API_KEY"
                                                       type="text"
                                                       model="FIREBASE_API_KEY"
                                                       value="{{config('core.mail.FIREBASE_API_KEY')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.firebase.FIREBASE_AUTH_DOMAIN"
                                                       id="FIREBASE_AUTH_DOMAIN"
                                                       name="FIREBASE_AUTH_DOMAIN"
                                                       type="text"
                                                       model="FIREBASE_AUTH_DOMAIN"
                                                       value="{{config('core.mail.FIREBASE_AUTH_DOMAIN')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.firebase.FIREBASE_PROJECT_ID"
                                                       id="FIREBASE_PROJECT_ID"
                                                       name="FIREBASE_PROJECT_ID"
                                                       type="text"
                                                       model="FIREBASE_PROJECT_ID"
                                                       value="{{config('core.mail.FIREBASE_PROJECT_ID')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.firebase.FIREBASE_STORAGE_BUCKET"
                                                       id="FIREBASE_STORAGE_BUCKET"
                                                       name="FIREBASE_STORAGE_BUCKET"
                                                       type="text"
                                                       model="FIREBASE_STORAGE_BUCKET"
                                                       value="{{config('core.mail.FIREBASE_STORAGE_BUCKET')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.firebase.FIREBASE_MESSAGING_SENDER_ID"
                                                       id="FIREBASE_MESSAGING_SENDER_ID"
                                                       name="FIREBASE_MESSAGING_SENDER_ID"
                                                       type="text"
                                                       model="FIREBASE_MESSAGING_SENDER_ID"
                                                       value="{{config('core.mail.FIREBASE_MESSAGING_SENDER_ID')}}">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.firebase.FIREBASE_APP_ID" id="FIREBASE_APP_ID"
                                                       name="FIREBASE_APP_ID"
                                                       type="text"
                                                       model="FIREBASE_APP_ID"
                                                       value="{{config('core.mail.FIREBASE_APP_ID')}}">
                                        </x-core::input>
                                    </div>
                                </div>--}}
                            </form>
                            <form action="{{route('admin.env.sendTestEmail')}}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="my-3">
                                    <h3>{{trans('core::core.env.sendTestEmail')}}</h3>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <x-core::input label="core::core.env.email" id="email"
                                                       name="email"
                                                       type="text"
                                                       model="email"
                                                       value="">
                                        </x-core::input>
                                    </div>
                                    <div class="col-sm-6 mt-4 pt-1">
                                        <button type="submit" class="btn btn-primary">
                                            {{trans('core::core.env.submit')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Cards Action -->

@endsection
