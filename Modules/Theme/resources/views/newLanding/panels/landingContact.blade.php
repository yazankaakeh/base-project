<section id="contactUs" class="section-py bg-body landing-contact">
  <div class="container">
    <div class="text-center mb-4">
      <span class="badge bg-label-primary">
        {{trans('newLandingPage.contactSection.titleSm')}}
      </span>
    </div>
    <h4 class="text-center mb-1">
        <span class="position-relative fw-extrabold z-1">
          {{trans('newLandingPage.contactSection.title1')}}
          <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="laptop charging"
               class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
        </span>
      {{trans('newLandingPage.contactSection.title2')}}
    </h4>
    <p class="text-center mb-12 pb-md-4">
      {{trans('newLandingPage.contactSection.desc')}}
    </p>
    <div class="row g-6">
      <div class="col-lg-5">
        <div class="contact-img-box position-relative border p-2 h-100">
          <img src="{{ asset('assets/img/front-pages/icons/contact-border.png') }}" alt="contact border"
               class="contact-border-img position-absolute d-none d-lg-block scaleX-n1-rtl" />
          <img src="{{ asset('assets/img/front-pages/landing-page/contact-customer-service.png') }}"
               alt="contact customer service" class="contact-img w-100 scaleX-n1-rtl" />
          <div class="p-4 pb-2">
            <div class="row g-4">
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="d-flex align-items-center">
                  <div class="badge bg-label-primary rounded p-1_5 me-3"><i
                      class="icon-base ti tabler-mail icon-lg"></i></div>
                  <div>
                    <p class="mb-0">{{trans('newLandingPage.contactSection.support')}}</p>
                    <h6 class="mb-0"><a href="mailto:support@tagiy.com" class="text-heading">support@tagiy.com</a>
                    </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="d-flex align-items-center">
                  <div class="badge bg-label-success rounded p-1_5 me-3"><i
                      class="icon-base ti tabler-mail icon-lg"></i></div>
                  <div>
                    <p class="mb-0">{{trans('newLandingPage.contactSection.more')}}</p>
                    <h6 class="mb-0"><a href="mailto:info@tagiy.com" class="text-heading">info@tagiy.com</a></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="card h-100">
          <div class="card-body">
            <h4 class="mb-2">{{trans('newLandingPage.contactSection.contactTitle')}}</h4>
            <p class="mb-6">
              {{--If you would like to discuss anything related to payment, account, licensing,<br
                class="d-none d-lg-block" />
              partnerships, or have pre-sales questions, you’re at the right place.--}}
              {{trans('newLandingPage.contactSection.contactDesc')}}
            </p>
            <form action="{{route('env.submitContactForm')}}" method="POST">
              @method('POST')
              @csrf
              <div class="row g-4">
                <div class="col-md-6">
                  <label class="form-label" for="contact-form-fullname">
                    {{trans('newLandingPage.contactSection.fullName')}}
                  </label>
                  <input type="text" name="fullName" class="form-control" id="contact-form-fullname"
                         placeholder="{{trans('newLandingPage.contactSection.fullNamePlaceHolder')}}" />
                  @error('fullName')
                  <span class="error">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="contact-form-email">
                    {{trans('newLandingPage.contactSection.email')}}
                  </label>
                  <input type="text" name="email" id="contact-form-email" class="form-control"
                         placeholder="johndoe@gmail.com" />
                  @error('email')
                  <span class="error">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-12">
                  <label class="form-label" for="contact-form-message">
                    {{trans('newLandingPage.contactSection.message')}}
                  </label>
                  <textarea id="contact-form-message" name="message" class="form-control" rows="7"
                            placeholder="{{trans('newLandingPage.contactSection.messagePlaceHolder')}}"></textarea>
                  @error('message')
                  <span class="error">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary">
                    {{trans('newLandingPage.contactSection.submit')}}
                  </button>
                </div>
                @error('recaptcha')
                <span class="error">{{ $message }}</span>
                @enderror
              </div>
              <x-core::recaptcha id="recaptcha" name="recaptcha" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
