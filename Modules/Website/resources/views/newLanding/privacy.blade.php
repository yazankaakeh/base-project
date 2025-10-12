@php
    use Modules\Theme\Helpers\Helpers;$configData = Helpers::appClasses();
@endphp

@extends('theme::user.layouts.layoutFront')

@section('title', trans('newLandingPage.privacy.title'))

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/fonts/fontawesome.scss', 'resources/assets/vendor/scss/pages/page-icons.scss'], 'build/modules/theme')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss', 'resources/assets/vendor/libs/swiper/swiper.scss'], 'build/modules/theme')
@endsection

<!-- Page Styles -->
@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-landing.scss'], 'build/modules/theme')
    @vite(['resources/assets/vendor/scss/pages/page-icons.scss'], 'build/modules/theme')
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.js', 'resources/assets/vendor/libs/swiper/swiper.js'], 'build/modules/theme')
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/front-page-landing.js'], 'build/modules/theme')
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
