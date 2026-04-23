<!-- BEGIN: Vendor JS-->
@vite(['resources/assets/vendor/js/dropdown-hover.js',
'resources/assets/vendor/js/mega-dropdown.js',
'resources/assets/vendor/libs/popper/popper.js',
'resources/assets/vendor/js/bootstrap.js',
'resources/assets/vendor/libs/node-waves/node-waves.js'], 'build/modules/theme')

@if ($configData['hasCustomizer'])
    @vite(['resources/assets/vendor/libs/pickr/pickr.js'], 'build/modules/theme')
@endif

@yield('vendor-script')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
@vite(['resources/assets/js/front-main.js'], 'build/modules/theme')
<!-- END: Theme JS-->

<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->

<!-- Stacked scripts (panels, carousels, etc.) -->
@stack('scripts')
<!-- END: Stacked scripts -->

<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
