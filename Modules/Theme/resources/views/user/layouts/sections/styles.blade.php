<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Fonts Icons -->
@vite(['resources/assets/vendor/fonts/iconify/iconify.css'], 'build/modules/theme')

<!-- BEGIN: Vendor CSS-->
@vite(['resources/assets/vendor/libs/node-waves/node-waves.scss'], 'build/modules/theme')

@if ($configData['hasCustomizer'])
    @vite(['resources/assets/vendor/libs/pickr/pickr-themes.scss'], 'build/modules/theme')
@endif

<!-- Core CSS -->
@vite(['resources/assets/vendor/scss/core.scss',
'resources/assets/css/demo.css',
'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss'], 'build/modules/theme')

<!-- Vendor Styles -->
@vite(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss',
'resources/assets/vendor/libs/typeahead-js/typeahead.scss'], 'build/modules/theme')
@yield('vendor-style')

<!-- Page Styles -->
@yield('page-style')

<!-- app CSS -->
@vite(['Modules/Theme/resources/css/app.css'])
<!-- END: app CSS-->
