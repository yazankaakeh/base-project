<section id="theHow" class="section-py landing-team">
  <div class="container">
    <div class="text-center mb-4">
      <span class="badge bg-label-primary">
        {{trans('newLandingPage.howItWorksSection.titleSm')}}
      </span>
    </div>
    <h4 class="text-center pb-4">
        <span class="position-relative fw-extrabold z-1">
          {{trans('newLandingPage.howItWorksSection.title1')}}
          <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="laptop charging"
               class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
        </span>
      {{trans('newLandingPage.howItWorksSection.title2')}}
    </h4>
    <div class="row gy-12 mt-4">
      <div class="col-lg-3 col-sm-6">
        <div class="card mt-3 mt-lg-0 shadow-none">
          <div
            class="bg-customGetTagiyCard border border-bottom-0 border-label-info position-relative team-image-box">
            <img src="{{ asset('assets/img/front-pages/landing-page/Image1.png') }}"
                 class="position-absolute card-img-position bottom-0 start-50" alt="human image" />
          </div>
          <div class="card-body border border-top-0 border-label-info text-center">
            <h5 class="card-title mb-0">{{trans('newLandingPage.howItWorksSection.cardTitle1')}}</h5>
            <p class="text-body-secondary mb-0">{{trans('newLandingPage.howItWorksSection.cardDesc1')}}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="card mt-3 mt-lg-0 shadow-none">
          <div
            class="bg-customCreateAccount border border-bottom-0 border-label-info position-relative team-image-box">
            <img src="{{ asset('assets/img/front-pages/landing-page/Image2.png') }}"
                 class="position-absolute card-img-position bottom-0 start-50" alt="human image" />
          </div>
          <div class="card-body border border-top-0 border-label-info text-center">
            <h5 class="card-title mb-0">{{trans('newLandingPage.howItWorksSection.cardTitle2')}}</h5>
            <p class="text-body-secondary mb-0">{{trans('newLandingPage.howItWorksSection.cardDesc2')}}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="card mt-3 mt-lg-0 shadow-none">
          <div
            class="bg-customCustomizeProfile border border-bottom-0 border-label-info position-relative team-image-box">
            <img src="{{ asset('assets/img/front-pages/landing-page/Image3.png') }}"
                 class="position-absolute card-img-position bottom-0 start-50" alt="human image" />
          </div>
          <div class="card-body border border-top-0 border-label-info text-center">
            <h5 class="card-title mb-0">{{trans('newLandingPage.howItWorksSection.cardTitle3')}}</h5>
            <p class="text-body-secondary mb-0">{{trans('newLandingPage.howItWorksSection.cardDesc3')}}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="card mt-3 mt-lg-0 shadow-none">
          <div class="bg-label-info border border-bottom-0 border-label-info position-relative team-image-box">
            <img src="{{ asset('assets/img/front-pages/landing-page/Image4.png') }}"
                 class="position-absolute card-img-position bottom-0 start-50" alt="human image" />
          </div>
          <div class="card-body border border-top-0 border-label-info text-center">
            <h5 class="card-title mb-0">{{trans('newLandingPage.howItWorksSection.cardTitle4')}}</h5>
            <p class="text-body-secondary mb-0">{{trans('newLandingPage.howItWorksSection.cardDesc4')}}</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
