@php
    $gallery = $panel;
    $galleryBadge = $gallery['settings']['badge'][$locale] ?? 'Gallery';
    $galleryTitle = $gallery['title'][$locale] ?? 'Image Gallery';
    $galleryDescription = $gallery['settings']['description'][$locale] ?? 'Browse through our image gallery.';
    $galleryItems = $items ?? collect();
@endphp

<!-- Gallery: Start -->
<section id="landingGallery" class="section-py bg-body landing-gallery">
    <div class="container">
        <div class="text-center mb-4">
            <span class="badge bg-label-primary">{{ $galleryBadge }}</span>
        </div>
        <h4 class="text-center mb-1">
            <span class="position-relative fw-extrabold z-1">
                {{ $galleryTitle }}
                <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="gallery"
                     class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
        </h4>
        <p class="text-center mb-12">
            {{ $galleryDescription }}
        </p>

        @if($galleryItems->isNotEmpty())
            <div class="row g-4">
                @foreach($galleryItems as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            @if($item['media']['item_image'])
                                <img src="{{ $item['media']['item_image'] }}"
                                     class="card-img-top"
                                     alt="{{ $item['title'][$locale] ?? 'Gallery Image' }}"
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-label-primary d-flex align-items-center justify-content-center"
                                     style="height: 250px;">
                                    <i class="ti ti-photo display-4"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                @if($item['title'][$locale])
                                    <h5 class="card-title">{{ $item['title'][$locale] }}</h5>
                                @endif
                                @if($item['content'][$locale])
                                    <p class="card-text">{{ $item['content'][$locale] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="ti ti-photo display-1 text-muted"></i>
                <p class="text-muted mt-3">No gallery images available.</p>
            </div>
        @endif
    </div>
</section>
<!-- Gallery: End -->


