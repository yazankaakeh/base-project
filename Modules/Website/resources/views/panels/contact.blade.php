@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
    $email = $panel->settings['email'] ?? null;
    $phone = $panel->settings['phone'] ?? null;
    $address = $panel->settings['address'][$locale] ?? $panel->settings['address'] ?? null;
    $mapUrl = $panel->settings['map_url'] ?? null;
@endphp

<section class="section-py bg-body" id="panel-{{ $panel->id }}">
    <div class="container">
        {{-- Section Header --}}
        <div class="text-center mb-5">
            @if($badge)
                <span class="badge bg-label-primary rounded-pill px-3 py-2 mb-3">{{ $badge }}</span>
            @endif
            @if($title)
                <h2 class="display-6 fw-bold mb-3">{{ $title }}</h2>
            @endif
            @if($description)
                <p class="text-muted mx-auto" style="max-width: 600px;">{{ $description }}</p>
            @endif
        </div>

        <div class="row g-4">
            {{-- Contact Info --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="mb-4">{{ __('Contact Information') }}</h5>

                        @if($email)
                            <div class="d-flex align-items-start mb-4">
                                <div class="bg-label-primary rounded-3 p-3 me-3">
                                    <i class="ti tabler-mail text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ __('Email') }}</h6>
                                    <a href="mailto:{{ $email }}" class="text-muted">{{ $email }}</a>
                                </div>
                            </div>
                        @endif

                        @if($phone)
                            <div class="d-flex align-items-start mb-4">
                                <div class="bg-label-primary rounded-3 p-3 me-3">
                                    <i class="ti tabler-phone text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ __('Phone') }}</h6>
                                    <a href="tel:{{ $phone }}" class="text-muted">{{ $phone }}</a>
                                </div>
                            </div>
                        @endif

                        @if($address)
                            <div class="d-flex align-items-start">
                                <div class="bg-label-primary rounded-3 p-3 me-3">
                                    <i class="ti tabler-map-pin text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ __('Address') }}</h6>
                                    <p class="text-muted mb-0">{{ $address }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-4">{{ __('Send us a message') }}</h5>
                        <form action="#" method="POST" class="contact-form">
                            @csrf
                            <input type="hidden" name="panel_id" value="{{ $panel->id }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ __('Subject') }}</label>
                                    <input type="text" name="subject" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ __('Message') }} <span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary px-5">
                                        <i class="ti tabler-send me-2"></i>{{ __('Send Message') }}
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
            <div class="mt-5 rounded-3 overflow-hidden shadow-sm">
                <iframe src="{{ $mapUrl }}" width="100%" height="400" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        @endif
    </div>
</section>
