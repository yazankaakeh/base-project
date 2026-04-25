@php
    use Modules\Core\App\Models\ThemeSetting;

    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);

    // Panel settings
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;

    // Contact details
    $email = $panel->settings['email'] ?? null;
    $phone = $panel->settings['phone'] ?? null;
    $phone2 = $panel->settings['phone2'] ?? null;
    $address = $panel->settings['address'][$locale] ?? $panel->settings['address'] ?? null;
    $mapUrl = $panel->settings['map_url'] ?? null;
    $workingHours = $panel->settings['working_hours'][$locale] ?? $panel->settings['working_hours'] ?? null;
    $whatsapp = $panel->settings['whatsapp'] ?? null;

    // Social links
    $socialLinks = $panel->settings['social_links'] ?? [];

    // Get theme settings for website scope
    $themeSettings = ThemeSetting::getForScope('website');
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

<section class="panel-section panel-bg-subtle" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="container">
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

        <div class="row g-4 g-xl-5">
            {{-- Contact Form --}}
            <div class="col-lg-7 order-lg-2 panel-animate">
                <div class="panel-card" style="border: none; box-shadow: var(--panel-shadow);">
                    <div class="panel-card-body">
                        <h5 style="font-size: 1.25rem; font-weight: 700; color: var(--panel-text); margin-bottom: 24px;">
                            {{ __('Send us a message') }}
                        </h5>

                        <form action="#" method="POST" class="panel-form" id="contactForm{{ $panel->id }}">
                            @csrf
                            <input type="hidden" name="panel_id" value="{{ $panel->id }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Full Name') }} <span style="color: var(--panel-danger);">*</span></label>
                                    <input type="text" name="name" class="form-control" required placeholder="{{ __('Your name') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Email Address') }} <span style="color: var(--panel-danger);">*</span></label>
                                    <input type="email" name="email" class="form-control" required placeholder="{{ __('your@email.com') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Phone Number') }}</label>
                                    <input type="tel" name="phone" class="form-control" dir="ltr" placeholder="{{ __('Your phone') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Subject') }}</label>
                                    <input type="text" name="subject" class="form-control" placeholder="{{ __('How can we help?') }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">{{ __('Message') }} <span style="color: var(--panel-danger);">*</span></label>
                                    <textarea name="message" class="form-control" rows="5" required placeholder="{{ __('Write your message here...') }}"></textarea>
                                </div>

                                <div class="col-12 mt-2">
                                    <button type="submit" class="panel-btn panel-btn-primary panel-btn-lg">
                                        {{ __('Send Message') }}
                                        <i class="ti tabler-send"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Contact Info Sidebar --}}
            <div class="col-lg-5 order-lg-1 panel-animate" style="animation-delay: 0.1s;">
                <div class="panel-card h-100" style="border: none; box-shadow: var(--panel-shadow);">
                    <div class="panel-card-body d-flex flex-column">
                        <h5 style="font-size: 1.25rem; font-weight: 700; color: var(--panel-text); margin-bottom: 24px;">
                            {{ __('Get in Touch') }}
                        </h5>

                        <p style="color: var(--panel-text-muted); line-height: 1.7; margin-bottom: 28px;">
                            {{ __("Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.") }}
                        </p>

                        {{-- Contact Items --}}
                        <div class="flex-grow-1">
                            @if($email)
                                <div class="panel-contact-item">
                                    <div class="panel-contact-icon">
                                        <i class="ti tabler-mail"></i>
                                    </div>
                                    <div class="panel-contact-content">
                                        <h6>{{ __('Email') }}</h6>
                                        <a href="mailto:{{ $email }}">{{ $email }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($phone)
                                <div class="panel-contact-item">
                                    <div class="panel-contact-icon">
                                        <i class="ti tabler-phone"></i>
                                    </div>
                                    <div class="panel-contact-content">
                                        <h6>{{ __('Phone') }}</h6>
                                        <a href="tel:{{ $phone }}" dir="ltr">{{ $phone }}</a>
                                        @if($phone2)
                                            <br><a href="tel:{{ $phone2 }}" dir="ltr">{{ $phone2 }}</a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($whatsapp)
                                <div class="panel-contact-item">
                                    <div class="panel-contact-icon" style="background: rgba(37, 211, 102, 0.1); color: #25d366;">
                                        <i class="ti tabler-brand-whatsapp"></i>
                                    </div>
                                    <div class="panel-contact-content">
                                        <h6>{{ __('WhatsApp') }}</h6>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}" target="_blank" dir="ltr">{{ $whatsapp }}</a>
                                    </div>
                                </div>
                            @endif

                            @if($address)
                                <div class="panel-contact-item">
                                    <div class="panel-contact-icon">
                                        <i class="ti tabler-map-pin"></i>
                                    </div>
                                    <div class="panel-contact-content">
                                        <h6>{{ __('Address') }}</h6>
                                        <p>{{ $address }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($workingHours)
                                <div class="panel-contact-item">
                                    <div class="panel-contact-icon">
                                        <i class="ti tabler-clock"></i>
                                    </div>
                                    <div class="panel-contact-content">
                                        <h6>{{ __('Working Hours') }}</h6>
                                        <p>{{ $workingHours }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Social Links --}}
                        @if(!empty($socialLinks))
                            <div class="mt-4 pt-4" style="border-top: 1px solid var(--panel-border);">
                                <h6 style="font-size: 0.8125rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--panel-text-light); margin-bottom: 12px;">
                                    {{ __('Follow Us') }}
                                </h6>
                                <div class="panel-social-links">
                                    @foreach($socialLinks as $platform => $url)
                                        @if($url)
                                            <a href="{{ $url }}" target="_blank" rel="noopener" class="panel-social-link" title="{{ ucfirst($platform) }}">
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
        </div>

        {{-- Map Section --}}
        @if($mapUrl)
            <div class="mt-5 panel-animate" style="animation-delay: 0.2s;">
                <div style="border-radius: var(--panel-radius-lg); overflow: hidden; box-shadow: var(--panel-shadow);">
                    <iframe src="{{ $mapUrl }}"
                            width="100%"
                            height="350"
                            style="border: 0; display: block;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        @endif

        {{-- Contact Information Bar at Bottom --}}
        @if($email || $phone || $address)
            <div class="mt-5 pt-4 panel-animate" style="animation-delay: 0.3s;">
                <div class="panel-card" style="background: var(--panel-secondary); border: none;">
                    <div class="panel-card-body py-4">
                        <div class="row g-4 align-items-center">
                            @if($email)
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0;">
                                            <i class="ti tabler-mail" style="font-size: 1.25rem;"></i>
                                        </div>
                                        <div>
                                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px;">{{ __('Email Us') }}</div>
                                            <a href="mailto:{{ $email }}" style="color: #fff; text-decoration: none; font-weight: 500;">{{ $email }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($phone)
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0;">
                                            <i class="ti tabler-phone" style="font-size: 1.25rem;"></i>
                                        </div>
                                        <div>
                                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px;">{{ __('Call Us') }}</div>
                                            <a href="tel:{{ $phone }}" style="color: #fff; text-decoration: none; font-weight: 500;" dir="ltr">{{ $phone }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($address)
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; flex-shrink: 0;">
                                            <i class="ti tabler-map-pin" style="font-size: 1.25rem;"></i>
                                        </div>
                                        <div>
                                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px;">{{ __('Visit Us') }}</div>
                                            <span style="color: #fff; font-weight: 500;">{{ Str::limit($address, 40) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
