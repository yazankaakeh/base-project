@php
  $configData = Helper::appClasses();
  $isFront = true;
@endphp

@section('layoutContent')
  @extends('customer/layouts/commonMaster')

  @includeIf('customer/layouts/sections/navbar/navbar-front')

  <!-- Sections:Start -->
  @yield('content')
  <!-- / Sections:End -->

  @includeIf('customer/layouts/sections/footer/footer-front')
@endsection
