@php
  $configData = Helper::appClasses();
@endphp

@extends('customer.layouts.layoutFront')

@section('title', trans('newLandingPage.privacy.title'))

<!-- Vendor Styles -->
@section('vendor-style')
  @vite(['resources/assets/vendor/fonts/fontawesome.scss', 'resources/assets/vendor/scss/pages/page-icons.scss'])
  @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss', 'resources/assets/vendor/libs/swiper/swiper.scss'])
@endsection

<!-- Page Styles -->
@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/front-page-landing.scss'])
  @vite('resources/assets/vendor/scss/pages/page-icons.scss')
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite(['resources/assets/vendor/libs/nouislider/nouislider.js', 'resources/assets/vendor/libs/swiper/swiper.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
  @vite(['resources/assets/js/front-page-landing.js'])
@endsection

@section('content')
  <div data-bs-spy="scroll" class="scrollspy-example container">
    <section class="section-py pb-0">
      <div class="row">
        <div class="col-12">
          <h1>
            {{trans('newLandingPage.privacy.title')}}
          </h1>
          <pre style="font-family: inherit; white-space: pre-wrap; word-wrap: break-word;">
            {{trans('newLandingPage.privacy.desc')}}
          </pre>
        </div>
      </div>
    </section>
    <section class="section-py py-0">
      <div class="row">
        <div class="col-12">
          <h1>
            {{trans('newLandingPage.terms.title')}}
          </h1>
          <pre style="font-family: inherit; white-space: pre-wrap; word-wrap: break-word;">
            {{trans('newLandingPage.terms.desc')}}
          </pre>
        </div>
      </div>
    </section>
    <section class="section-py py-0">
      <div class="row">
        <div class="col-12">
          <h1>
            {{trans('newLandingPage.refund.title')}}
          </h1>
          <pre style="font-family: inherit; white-space: pre-wrap; word-wrap: break-word;">
            {{trans('newLandingPage.refund.desc')}}
          </pre>
        </div>
      </div>
    </section>


  </div>
@endsection
