<section class="section-py landing-cta position-relative p-lg-0 pb-0">
  <img
    src="{{asset('assets/img/front-pages/backgrounds/cta-bg-' . $configData['theme'] . '-1.png')}}"
    class="position-absolute bottom-0 end-0 scaleX-n1-rtl h-100 w-100 z-n1" alt="cta image"
    data-app-light-img="front-pages/backgrounds/cta-bg-light-1.png"
    data-app-dark-img="front-pages/backgrounds/cta-bg-dark-1.png" style="visibility: visible;">
  <div class="container">
    <div class="position-relative">
      <div class="d-flex justify-content-between flex-column-reverse flex-lg-row">
        <div class="text-center align-items-center pt-12 text-lg-start">
          <h4 class="text-primary mb-2">
            {{trans('newLandingPage.getNFCSection.title')}}
          </h4>
          <p class="text-body mb-6 mb-md-11">
            {{trans('newLandingPage.getNFCSection.desc')}}
          </p>
          <a href="https://web.whatsapp.com/send?phone=905444506918" class="btn btn-primary">
            {{trans('newLandingPage.getNFCSection.btn')}}
          </a>
        </div>
        <!-- image -->
        <div class="text-center">
          <img src="{{ asset('assets/img/front-pages/misc/getNfcCard.png') }}"
               class="img-fluid me-lg-5 pe-lg-1 mb-3 mb-lg-0" alt="Api Key Image"
               data-app-light-img="illustrations/getNfcCard.png"
               data-app-dark-img="illustrations/getNfcCard.png" />
        </div>
      </div>
    </div>
  </div>
</section>
