@php
    use Modules\Theme\Helpers\Helpers;$configData = Helpers::appClasses();
@endphp

@extends('theme::user.layouts.layoutFront')

@section('title', 'Tagiy')

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
    <div data-bs-spy="scroll" class="scrollspy-example">
        @includeIf('theme::newLanding.panels.hero')
        <!-- Useful features: Start -->
        @includeIf('theme::newLanding.panels.features')
        <!-- Useful features: End -->

        <!-- whyTagiy: Start -->
        @includeIf('theme::newLanding.panels.whyTagiy')
        <!-- whyTagiy: End -->


        <!-- Get your NFC Business card: Start -->
        @includeIf('theme::newLanding.panels.getNfc')
        <!-- Get your NFC Business card: End -->

        <!-- Our great team: Start -->
        @includeIf('theme::newLanding.panels.landingTeam')
        <!-- Our great team: End -->

        <!-- Get your NFC Business card: Start -->
        @includeIf('theme::newLanding.panels.getStarted')
        <!-- Get your NFC Business card: End -->

        <!-- Contact Us: Start -->
        @includeIf('theme::newLanding.panels.landingContact')
        <!-- Contact Us: End -->
    </div>
@endsection
