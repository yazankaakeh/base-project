@php
    $contact = $sections['contact'] ?? [];
    $contactBadge       = $contact['badge'][$locale]       ?? trans('newLandingPage.contactSection.titleSm');
    $contactTitle       = $contact['title'][$locale]       ?? trans('newLandingPage.contactSection.title1');
    $contactDescription = $contact['description'][$locale] ?? trans('newLandingPage.contactSection.desc');
    $contactEmail       = $contact['email']                ?? 'hello@codliy.com';
    $contactPhone       = $contact['phone']                ?? '';
@endphp

<section id="contactUs" class="codliy-section bg-codliy position-relative">
    <div class="container position-relative">
        <div class="text-center mb-5">
            <div class="codliy-section__kicker">{{ $contactBadge }}</div>
            <h2 class="codliy-section__title">{{ $contactTitle }}</h2>
            <p class="codliy-section__sub mx-auto">{{ $contactDescription }}</p>
        </div>

        <div class="row g-5 justify-content-center">
            <div class="col-lg-5">
                <div class="codliy-card h-100">
                    <div class="codliy-card__eyebrow">REACH</div>
                    <h3 class="codliy-card__title mb-4">
                        {{ trans('newLandingPage.contactSection.directTitle', [], app()->getLocale()) }}
                    </h3>

                    <div class="d-flex align-items-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 me-3"
                             style="width:44px;height:44px;background:rgba(var(--codliy-primary-rgb), 0.15);color:var(--codliy-primary);flex:0 0 44px">
                            <i class="ti tabler-mail icon-lg"></i>
                        </div>
                        <div>
                            <div class="text-codliy-mute small mb-1">
                                {{ trans('newLandingPage.contactSection.support') }}
                            </div>
                            <a href="mailto:{{ $contactEmail }}" class="text-codliy-soft fw-medium">{{ $contactEmail }}</a>
                        </div>
                    </div>

                    @if($contactPhone)
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-3 me-3"
                                 style="width:44px;height:44px;background:rgba(var(--codliy-primary-rgb), 0.15);color:var(--codliy-primary);flex:0 0 44px">
                                <i class="ti tabler-phone icon-lg"></i>
                            </div>
                            <div>
                                <div class="text-codliy-mute small mb-1">
                                    {{ trans('newLandingPage.contactSection.more') }}
                                </div>
                                <a href="tel:{{ $contactPhone }}" class="text-codliy-soft fw-medium">{{ $contactPhone }}</a>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex align-items-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 me-3"
                             style="width:44px;height:44px;background:rgba(var(--codliy-primary-rgb), 0.15);color:var(--codliy-primary);flex:0 0 44px">
                            <i class="ti tabler-map-pin icon-lg"></i>
                        </div>
                        <div>
                            <div class="text-codliy-mute small mb-1">
                                {{ trans('newLandingPage.contactSection.studio', [], app()->getLocale()) }}
                            </div>
                            <div class="text-codliy-soft fw-medium">Istanbul, Türkiye</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="codliy-card h-100">
                    <div class="codliy-card__eyebrow">WRITE US</div>
                    <h3 class="codliy-card__title mb-2">
                        {{ trans('newLandingPage.contactSection.contactTitle') }}
                    </h3>
                    <p class="codliy-card__body mb-4">
                        {{ trans('newLandingPage.contactSection.contactDesc') }}
                    </p>

                    <form action="{{ route('env.submitContactForm') }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="row g-3">
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
                                    placeholder="hello@codliy.com" />
                            </div>
                            <div class="col-12">
                                <x-core::textarea
                                    label="newLandingPage.contactSection.message"
                                    name="message"
                                    id="contact-form-message"
                                    value="{{ old('message') }}"
                                    rows="6"
                                    placeholder="{{ trans('newLandingPage.contactSection.messagePlaceHolder') }}" />
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-codliy">
                                    {{ trans('newLandingPage.contactSection.submit') }}
                                </button>
                            </div>
                            @error('recaptcha')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <x-core::recaptcha id="recaptcha" name="recaptcha" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
