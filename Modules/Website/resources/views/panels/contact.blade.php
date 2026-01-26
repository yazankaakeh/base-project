@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
    $email = $panel->settings['email'] ?? null;
    $phone = $panel->settings['phone'] ?? null;
    $address = $panel->settings['address'][$locale] ?? $panel->settings['address'] ?? null;
    $mapUrl = $panel->settings['map_url'] ?? null;
    $workingHours = $panel->settings['working_hours'][$locale] ?? $panel->settings['working_hours'] ?? null;
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

<section class="panel-section panel-bg-white position-relative" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    {{-- Decorative Elements --}}
    <div class="panel-shape" style="width: 300px; height: 300px; top: -100px; {{ $isRtl ? 'left' : 'right' }}: -100px; background: rgba(var(--panel-primary-rgb), 0.04);"></div>
    <div class="panel-shape" style="width: 150px; height: 150px; bottom: 10%; {{ $isRtl ? 'right' : 'left' }}: 5%; background: rgba(var(--panel-primary-rgb), 0.06); animation-delay: 2s;"></div>

    <div class="container position-relative">
        {{-- Section Header --}}
        <div class="panel-header">
            @if($badge)
                <span class="panel-badge">{{ $badge }}</span>
            @endif
            @if($title)
                <h2 class="panel-title">{{ $title }}</h2>
            @endif
            @if($description)
                <p class="panel-description">{{ $description }}</p>
            @endif
        </div>

        <div class="row g-4 g-lg-5">
            {{-- Contact Info --}}
            <div class="col-lg-5 panel-animate">
                <div class="panel-card h-100">
                    <div class="panel-card-body">
                        <h5 class="mb-4" style="color: var(--panel-secondary); font-weight: 700;">
                            {{ __('Contact Information') }}
                        </h5>

                        @if($email)
                            <div class="panel-contact-info">
                                <div class="panel-contact-icon">
                                    <i class="ti tabler-mail"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1" style="color: var(--panel-secondary); font-weight: 600;">{{ __('Email') }}</h6>
                                    <a href="mailto:{{ $email }}" style="color: var(--panel-gray); text-decoration: none;">
                                        {{ $email }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($phone)
                            <div class="panel-contact-info">
                                <div class="panel-contact-icon">
                                    <i class="ti tabler-phone"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1" style="color: var(--panel-secondary); font-weight: 600;">{{ __('Phone') }}</h6>
                                    <a href="tel:{{ $phone }}" style="color: var(--panel-gray); text-decoration: none;" dir="ltr">
                                        {{ $phone }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($address)
                            <div class="panel-contact-info">
                                <div class="panel-contact-icon">
                                    <i class="ti tabler-map-pin"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1" style="color: var(--panel-secondary); font-weight: 600;">{{ __('Address') }}</h6>
                                    <p class="mb-0" style="color: var(--panel-gray);">{{ $address }}</p>
                                </div>
                            </div>
                        @endif

                        @if($workingHours)
                            <div class="panel-contact-info mb-0">
                                <div class="panel-contact-icon">
                                    <i class="ti tabler-clock"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1" style="color: var(--panel-secondary); font-weight: 600;">{{ __('Working Hours') }}</h6>
                                    <p class="mb-0" style="color: var(--panel-gray);">{{ $workingHours }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Social Links --}}
                        @if(!empty($panel->settings['social_links']))
                            <div class="mt-4 pt-3 border-top">
                                <h6 class="mb-3" style="color: var(--panel-secondary); font-weight: 600;">{{ __('Follow Us') }}</h6>
                                <div class="panel-social-links justify-content-start">
                                    @foreach($panel->settings['social_links'] as $platform => $url)
                                        @if($url)
                                            <a href="{{ $url }}" target="_blank" rel="noopener" class="panel-social-link">
                                                <i class="ti tabler-brand-{{ $platform }}"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="col-lg-7 panel-animate" style="animation-delay: 0.2s;">
                <div class="panel-card">
                    <div class="panel-card-body">
                        <h5 class="mb-4" style="color: var(--panel-secondary); font-weight: 700;">
                            {{ __('Send us a message') }}
                        </h5>
                        <form action="#" method="POST" class="panel-form contact-form" id="contactForm{{ $panel->id }}">
                            @csrf
                            <input type="hidden" name="panel_id" value="{{ $panel->id }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Name') }} <span style="color: var(--panel-danger);">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                           placeholder="{{ __('Your name') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Email') }} <span style="color: var(--panel-danger);">*</span></label>
                                    <input type="email" name="email" class="form-control" required
                                           placeholder="{{ __('your@email.com') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Phone') }}</label>
                                    <input type="tel" name="phone" class="form-control" dir="ltr"
                                           placeholder="{{ __('Your phone number') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Subject') }}</label>
                                    <input type="text" name="subject" class="form-control"
                                           placeholder="{{ __('Message subject') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ __('Message') }} <span style="color: var(--panel-danger);">*</span></label>
                                    <textarea name="message" class="form-control" rows="5" required
                                              placeholder="{{ __('Write your message here...') }}"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="panel-btn panel-btn-primary">
                                        <i class="ti tabler-send"></i>
                                        {{ __('Send Message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Map --}}
        @if($mapUrl)
            <div class="mt-5 pt-3 panel-animate" style="animation-delay: 0.4s;">
                <div class="rounded-4 overflow-hidden" style="box-shadow: var(--panel-shadow);">
                    <iframe src="{{ $mapUrl }}" width="100%" height="400" style="border:0; display: block;"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        @endif
    </div>
</section>
