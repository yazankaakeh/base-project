@php
    use Modules\Theme\Helpers\Helpers;
    $configData = Helpers::appClasses();
    $isFront = true;
@endphp

@section('layoutContent')
    @extends('theme::user/layouts/commonMaster')

    @includeIf('theme::user/layouts/sections/navbar/navbar-front')

    <!-- Sections:Start -->
    @yield('content')
    <!-- / Sections:End -->

    @includeIf('theme::user/layouts/sections/footer/footer-front')

    {{-- Floating AI chat assistant (self-guards when disabled / misconfigured) --}}
    @includeIf('aichat::widget')
@endsection
