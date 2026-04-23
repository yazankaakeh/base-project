@php use Modules\Theme\Helpers\Helpers; @endphp
@isset($pageConfigs)
    {!! Helpers::updatePageConfig($pageConfigs) !!}
@endisset

@php
    $configData = Helpers::appClasses();

    /* Display elements */
    $customizerHidden = $customizerHidden ?? '';
@endphp

@extends('theme::user/layouts/commonMaster')

@section('layoutContent')
    <!-- Content -->
    @yield('content')
    <!--/ Content -->
@endsection
