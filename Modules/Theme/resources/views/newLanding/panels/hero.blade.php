<!-- Hero: Start -->
<section id="hero-animation">
    <div id="landingHero" class="section-py landing-hero position-relative">
        <img src="{{ asset('assets/img/front-pages/backgrounds/hero-bg.png') }}" alt="hero background"
             class="position-absolute top-0 start-50 translate-middle-x object-fit-cover w-100 h-100" data-speed="1"/>
        <div class="container">
            <div class="hero-text-box text-center position-relative">
                <h1 class="text-primary hero-title display-6 fw-extrabold">
                    {{trans('newLandingPage.heroSection.title')}}
                </h1>
                <h2 class="hero-sub-title h6 mb-6">
                    {!! trans('newLandingPage.heroSection.description') !!}
                </h2>
                <div class="landing-hero-btn d-inline-block position-relative">
                    {{--<span class="hero-btn-item position-absolute d-none d-md-flex fw-medium">Join community <img
                        src="{{ asset('assets/img/front-pages/icons/Join-community-arrow.png') }}" alt="Join community arrow"
                        class="scaleX-n1-rtl" /></span>--}}
                    <a href="#landingPricing" class="btn btn-primary btn-lg">
                        {{trans('newLandingPage.heroSection.getStarted')}}
                    </a>
                </div>
            </div>
            <div id="heroDashboardAnimation" class="hero-animation-img">
                <a href="#" target="_blank">
                    <div id="heroAnimationImg" class="position-relative hero-dashboard-img">
                        <img
                                src="{{ asset('assets/img/front-pages/landing-page/hero-dashboard-' . $configData['theme'] . '.png') }}"
                                alt="hero dashboard" class="animation-img"
                                data-app-light-img="front-pages/landing-page/hero-dashboard-light.png"
                                data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png"/>
                        <img
                                src="{{ asset('assets/img/front-pages/landing-page/hero-elements-' . $configData['theme'] . '-new.png') }}"
                                alt="hero elements"
                                class="position-absolute hero-elements-img animation-img top-0 start-0"
                                data-app-light-img="front-pages/landing-page/hero-elements-light.png"
                                data-app-dark-img="front-pages/landing-page/hero-elements-dark.png"/>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="landing-hero-blank"></div>
</section>
<!-- Hero: End -->
<!-- Hero: Start -->
{{--<section id="heroSection">
  <div id="landingHero" class="section-py landing-hero position-relative">
    --}}{{--<img src="{{ asset('assets/img/front-pages/backgrounds/hero-bg.png') }}" alt="hero background"
         class="position-absolute top-0 start-50 translate-middle-x object-fit-cover w-100 h-100" data-speed="1" />
    --}}{{--
    <div class="container">
      <div class="hero-text-box text-center position-relative">
        <h1 class="text-primary hero-title display-6 fw-extrabold">
          {{trans('newLandingPage.heroSection.title')}}
        </h1>
        <h2 class="hero-sub-title h6 mb-6">
          {!! trans('newLandingPage.heroSection.description') !!}
        </h2>
        <div class="landing-hero-btn d-inline-block position-relative">
          --}}{{--<span class="hero-btn-item position-absolute d-none d-md-flex fw-medium">
            {{trans('newLandingPage.heroSection.join')}}
            <img src="{{ asset('assets/img/front-pages/icons/Join-community-arrow.png') }}" alt="Join community arrow"
                 class="scaleX-n1-rtl" /></span>--}}{{--
          <a href="#landingPricing" class="btn btn-primary btn-lg">
            {{trans('newLandingPage.heroSection.getStarted')}}
          </a>
        </div>
      </div>
      <div id="heroDashboardAnimation" class="hero-animation-img">
        <a href="{{ route('register') }}" target="_blank">
          <div id="heroAnimationImg" class="position-relative hero-dashboard-img">
            <img
              src="{{ asset('assets/img/front-pages/landing-page/hero-dashboard-' . $configData['theme'] . '.png') }}"
              alt="hero dashboard" class="animation-img"
              data-app-light-img="front-pages/landing-page/hero-dashboard-light1.png"
              data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" />
            <img
              src="{{ asset('assets/img/front-pages/landing-page/hero-elements-' . $configData['theme'] . '.png') }}"
              alt="hero elements" class="position-absolute hero-elements-img animation-img top-0 start-0"
              data-app-light-img="front-pages/landing-page/hero-elements-light1.png"
              data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="landing-hero-blank"></div>
</section>--}}
<!-- Hero: End -->
