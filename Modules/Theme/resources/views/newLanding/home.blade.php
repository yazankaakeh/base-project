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
        {{-- Always include Hero section --}}
        @includeIf('theme::newLanding.panels.hero')

        {{-- Dynamic panels from CMS --}}
        @if(isset($panelsData) && $panelsData->count() > 0)
            @foreach($panelsData as $panel)
                @php
                    $items = collect($panel['items'] ?? []);
                    $panelType = $panel['type'];
                @endphp

                @switch($panelType)
                    @case('features')
                        @include('theme::newLanding.panels.features', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('team')
                        @include('theme::newLanding.panels.landingTeam', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('reviews')
                        @include('theme::newLanding.panels.landingReviews', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('faq')
                        @include('theme::newLanding.panels.landingFAQ', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('cta')
                        @include('theme::newLanding.panels.landingCTA', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('contact')
                        @include('theme::newLanding.panels.landingContact', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('stats')
                        @include('theme::newLanding.panels.landingFunFacts', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('gallery')
                        @includeIf('theme::newLanding.panels.gallery', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('carousel')
                        @include('theme::newLanding.panels.carousel', ['panel' => $panel, 'items' => $items])
                        @break
                    @case('custom')
                        @includeIf('theme::newLanding.panels.custom', ['panel' => $panel, 'items' => $items])
                        @break
                @endswitch
            @endforeach
        @else
            {{-- Fallback to static includes if no panels in database --}}
            @includeIf('theme::newLanding.panels.features')
            @includeIf('theme::newLanding.panels.whyTagiy')
            @includeIf('theme::newLanding.panels.getNfc')
            @includeIf('theme::newLanding.panels.landingTeam')
            @includeIf('theme::newLanding.panels.getStarted')
            @includeIf('theme::newLanding.panels.landingContact')
        @endif
    </div>
@endsection
