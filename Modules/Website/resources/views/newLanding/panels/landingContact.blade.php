@php
    // Support both dynamic panel data and fallback to sections
    if (isset($panel)) {
        $contactBadge = $panel['settings']['badge'][$locale] ?? trans('newLandingPage.contactSection.titleSm');
        $contactTitle = $panel['title'][$locale] ?? trans('newLandingPage.contactSection.title1');
        $contactDescription = $panel['settings']['description'][$locale] ?? trans('newLandingPage.contactSection.desc');
        $contactEmail = $panel['settings']['email'] ?? 'support@tagiy.com';
        $contactPhone = $panel['settings']['phone'] ?? '';
    } else {
        $contact = $sections['contact'] ?? [];
        $contactBadge = $contact['badge'][$locale] ?? trans('newLandingPage.contactSection.titleSm');
        $contactTitle = $contact['title'][$locale] ?? trans('newLandingPage.contactSection.title1');
        $contactDescription = $contact['description'][$locale] ?? trans('newLandingPage.contactSection.desc');
        $contactEmail = $contact['email'] ?? 'support@tagiy.com';
        $contactPhone = $contact['phone'] ?? '';
    }
@endphp

<section id="contactUs" class="section-py bg-body landing-contact">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge bg-label-primary">
                {{ $contactBadge }}
            </span>
        </div>
        <h4 class="text-center mb-1">
            <span class="position-relative fw-extrabold z-1">
                {{ $contactTitle }}
                <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="laptop charging"
                     class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
        </h4>
        <p class="text-center mb-12 pb-md-4">
            {{ $contactDescription }}
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
                                        <h6 class="mb-0"><a href="mailto:{{ $contactEmail }}" class="text-heading">{{ $contactEmail }}</a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            @if($contactPhone)
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="d-flex align-items-center">
                                        <div class="badge bg-label-success rounded p-1_5 me-3"><i
                                                class="icon-base ti tabler-phone icon-lg"></i></div>
                                        <div>
                                            <p class="mb-0">{{trans('newLandingPage.contactSection.more')}}</p>
                                            <h6 class="mb-0"><a href="tel:{{ $contactPhone }}" class="text-heading">{{ $contactPhone }}</a></h6>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                  <x-core::input
                      label="newLandingPage.contactSection.fullName"
                      type="text"
                      name="fullName"
                      id="contact-form-fullname"
                      value="{{ old('fullName') }}"
                      placeholder="{{ trans('newLandingPage.contactSection.fullNamePlaceHolder') }}" />
                </div>
                <div class="col-md-6">
                  <x-core::input
                      label="newLandingPage.contactSection.email"
                      type="text"
                      name="email"
                      id="contact-form-email"
                      value="{{ old('email') }}"
                      placeholder="johndoe@gmail.com" />
                </div>
                <div class="col-12">
                  <x-core::textarea
                      label="newLandingPage.contactSection.message"
                      name="message"
                      id="contact-form-message"
                      value="{{ old('message') }}"
                      rows="7"
                      placeholder="{{ trans('newLandingPage.contactSection.messagePlaceHolder') }}" />
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
