{{-- Codliy · Why Codliy — craft-forward rationale section --}}
<section class="codliy-section bg-codliy position-relative">
  <div class="container position-relative">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="codliy-section__kicker">{{ trans('newLandingPage.whySection.kicker', [], app()->getLocale()) }}</div>
        <h2 class="codliy-section__title mb-3">
          {{ trans('newLandingPage.whySection.title') }}
        </h2>
        <p class="codliy-section__sub mb-4">
          {{ trans('newLandingPage.whySection.desc1') }}
        </p>
        <p class="codliy-section__sub mb-0">
          {{ trans('newLandingPage.whySection.desc2') }}
        </p>

        <ul class="list-unstyled mt-4 mb-0">
          <li class="d-flex align-items-start gap-3 mb-3 text-codliy-soft">
            <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                  style="width:28px;height:28px;background:rgba(0,86,248,0.2);color:#3B82F6;flex:0 0 28px">
              <i class="ti tabler-check"></i>
            </span>
            <span>{{ trans('newLandingPage.whySection.bullet1', [], app()->getLocale()) }}</span>
          </li>
          <li class="d-flex align-items-start gap-3 mb-3 text-codliy-soft">
            <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                  style="width:28px;height:28px;background:rgba(0,86,248,0.2);color:#3B82F6;flex:0 0 28px">
              <i class="ti tabler-check"></i>
            </span>
            <span>{{ trans('newLandingPage.whySection.bullet2', [], app()->getLocale()) }}</span>
          </li>
          <li class="d-flex align-items-start gap-3 text-codliy-soft">
            <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                  style="width:28px;height:28px;background:rgba(0,86,248,0.2);color:#3B82F6;flex:0 0 28px">
              <i class="ti tabler-check"></i>
            </span>
            <span>{{ trans('newLandingPage.whySection.bullet3', [], app()->getLocale()) }}</span>
          </li>
        </ul>
      </div>

      <div class="col-lg-6">
        <div class="codliy-card p-0 overflow-hidden">
          <img src="{{ asset('codliy/images/hero.png') }}"
               alt="Codliy systems diagram"
               class="img-fluid w-100" style="display:block"/>
        </div>
      </div>
    </div>
  </div>
</section>
