@extends('admin/layouts/layoutMaster')

@section('title', 'Update Env')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
  <link rel="stylesheet"
        href="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/pickr/pickr-themes.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bloodhound/bloodhound.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/pickr/pickr.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/cards-actions.js')}}"></script>
  <script src="{{asset('assets/js/forms-selects.js')}}"></script>
  <script src="{{asset('assets/js/forms-typeahead.js')}}"></script>
  <script src="{{asset('assets/js/forms-pickers.js')}}"></script>
@endsection

@section('content')

  <div class="card-header d-flex justify-content-between pb-2 mb-1">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Settings /</span> Update Env
    </h4>
  </div>
  <div class="card">
    <h5 class="card-header">{{trans('core::core.env.titles.title')}}</h5>
    <div class="row mb-5">
      <div class="w-100"></div>
      <div class="card-body">
        <form action="{{route('env.updateEnv')}}" method="POST">
          @csrf
          @method('POST')
          <div class="row">
            <div class="my-3">
              <h3>{{trans('core::core.env.titles.recaptcha')}}</h3>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.recaptcha.site_key" id="RECAPTCHA_SITE_KEY"
                             name="RECAPTCHA_SITE_KEY"
                             type="text"
                             model="RECAPTCHA_SITE_KEY"
                             value="{{config('core::services.recaptcha.site_key')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.recaptcha.secret_key" id="RECAPTCHA_SECRET_KEY"
                             name="RECAPTCHA_SECRET_KEY" type="text"
                             model="RECAPTCHA_SECRET_KEY"
                             value="{{config('core::services.recaptcha.secret_key')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.recaptcha.link" id="RECAPTCHA_LINK"
                             name="RECAPTCHA_LINK" type="text"
                             model="RECAPTCHA_LINK"
                             value="{{config('core::services.recaptcha.link')}}">
              </x-core::input>
            </div>
          </div>
          <div class="row">
            <div class="my-3">
              <h3>{{trans('core::core.env.titles.smtp')}}</h3>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.mail.MAIL_MAILER" id="MAIL_MAILER"
                             name="MAIL_MAILER"
                             type="text"
                             model="MAIL_MAILER"
                             value="{{config('core::services.mail.MAIL_MAILER')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.mail.MAIL_HOST" id="MAIL_HOST" name="MAIL_HOST"
                             type="text"
                             model="MAIL_HOST"
                             value="{{config('core::services.mail.MAIL_HOST')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.mail.MAIL_USERNAME" id="MAIL_USERNAME"
                             name="MAIL_USERNAME"
                             type="text"
                             model="MAIL_USERNAME"
                             value="{{config('core::services.mail.MAIL_USERNAME')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.mail.MAIL_PASSWORD" id="MAIL_PASSWORD"
                             name="MAIL_PASSWORD"
                             type="text"
                             model="MAIL_PASSWORD"
                             value="{{config('core::services.mail.MAIL_PASSWORD')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.mail.MAIL_ENCRYPTION" id="MAIL_ENCRYPTION"
                             name="MAIL_ENCRYPTION"
                             type="text"
                             model="MAIL_ENCRYPTION"
                             value="{{config('core::services.mail.MAIL_ENCRYPTION')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.mail.MAIL_FROM_ADDRESS" id="MAIL_FROM_ADDRESS"
                             name="MAIL_FROM_ADDRESS"
                             type="text"
                             model="MAIL_FROM_ADDRESS"
                             value="{{config('core::services.mail.MAIL_FROM_ADDRESS')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.mail.MAIL_FROM_NAME" id="MAIL_FROM_NAME"
                             name="MAIL_FROM_NAME"
                             type="text"
                             model="MAIL_FROM_NAME"
                             value="{{config('core::services.mail.MAIL_FROM_NAME')}}">
              </x-core::input>
            </div>
          </div>
          <div class="row">
            <div class="my-3">
              <h3>{{trans('core::core.env.titles.firebase')}}</h3>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.firebase.FIREBASE_API_KEY" id="FIREBASE_API_KEY"
                             name="FIREBASE_API_KEY"
                             type="text"
                             model="FIREBASE_API_KEY"
                             value="{{config('core::services.mail.FIREBASE_API_KEY')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.firebase.FIREBASE_AUTH_DOMAIN"
                             id="FIREBASE_AUTH_DOMAIN"
                             name="FIREBASE_AUTH_DOMAIN"
                             type="text"
                             model="FIREBASE_AUTH_DOMAIN"
                             value="{{config('core::services.mail.FIREBASE_AUTH_DOMAIN')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.firebase.FIREBASE_PROJECT_ID"
                             id="FIREBASE_PROJECT_ID"
                             name="FIREBASE_PROJECT_ID"
                             type="text"
                             model="FIREBASE_PROJECT_ID"
                             value="{{config('core::services.mail.FIREBASE_PROJECT_ID')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.firebase.FIREBASE_STORAGE_BUCKET"
                             id="FIREBASE_STORAGE_BUCKET"
                             name="FIREBASE_STORAGE_BUCKET"
                             type="text"
                             model="FIREBASE_STORAGE_BUCKET"
                             value="{{config('core::services.mail.FIREBASE_STORAGE_BUCKET')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.firebase.FIREBASE_MESSAGING_SENDER_ID"
                             id="FIREBASE_MESSAGING_SENDER_ID"
                             name="FIREBASE_MESSAGING_SENDER_ID"
                             type="text"
                             model="FIREBASE_MESSAGING_SENDER_ID"
                             value="{{config('core::services.mail.FIREBASE_MESSAGING_SENDER_ID')}}">
              </x-core::input>
            </div>
            <div class="col-sm-6">
              <x-core::input label="core::core.env.firebase.FIREBASE_APP_ID" id="FIREBASE_APP_ID"
                             name="FIREBASE_APP_ID"
                             type="text"
                             model="FIREBASE_APP_ID"
                             value="{{config('core::services.mail.FIREBASE_APP_ID')}}">
              </x-core::input>
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-sm-6 mt-4 text-start pt-1">
              <button class="btn btn-primary">
                {{trans('core::core.env.submit')}}
              </button>
            </div>
          </div>
        </form>
        <form action="{{route('env.sendTestEmail')}}" method="POST">
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
  <!--/ Cards Action -->

@endsection
