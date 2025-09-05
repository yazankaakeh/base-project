@php use App\Models\User; @endphp
<nav class="layout-navbar navbar navbar-expand-xl align-items-center" id="layout-navbar">
    <div class="container-xxl">
        <!--  Brand demo (display only for navbar-full and hide on below xl) -->
        <div class="navbar-brand app-brand demo d-xl-flex py-0 me-4 ms-0">
            <a href="https://tagiy.dev" class="app-brand-link">
                <span class="app-brand-logo demo"></span>
                <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

            <ul class="navbar-nav flex-row align-items-center ms-md-auto">

                <!-- Style Share -->
                @if(\Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user() instanceof User)

                    <li class="">
                        <a href="{{route('customer.home')}}" class="btn btn-outline-secondary text-body">
                            <i class="tabler-dashboard icon-base ti icon-22px me-1"></i>
                            {{trans('admin.sidebar.dashboard')}}
                        </a>
                    </li>
                @endif
                <!-- / Style Share-->

                <!-- Style Share -->
                @isset($card)
                    <li class="nav-item">
                        <a onclick="copyLink('{{$card->full_link}}')"
                           class="nav-link  hide-arrow btn btn-icon btn-text-secondary rounded-pill waves-effect">
                            <i class="tabler-share icon-base ti icon-22px"></i>
                            <span class="d-none ms-2">Share Button</span>
                        </a>
                    </li>
                @endisset
                <!-- / Style Share-->

                <!-- Language -->
                @includeIf('theme::user.layouts.sections.navbar.navbar-languages')
                <!--/ Language -->

                <!-- Style Switcher -->
                @includeIf('theme::user.layouts.sections.navbar.navbar-theme-switcher')
                <!-- / Style Switcher-->
            </ul>
        </div>
    </div>
</nav>
