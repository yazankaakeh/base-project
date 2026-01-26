@php
    $locale = app()->getLocale();
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
@endphp

<section class="section-py bg-light" id="panel-{{ $panel->id }}">
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

        {{-- Gallery Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-4">
                @foreach($panel->activeItems as $item)
                    @php
                        $caption = $item->getTranslation('title', $locale);
                        $itemDescription = $item->getTranslation('content', $locale);
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="gallery-item position-relative rounded-3 overflow-hidden cursor-pointer"
                             style="aspect-ratio: 1;"
                             data-bs-toggle="modal"
                             data-bs-target="#galleryModal{{ $panel->id }}"
                             data-image="{{ $itemImage }}"
                             data-caption="{{ $caption }}"
                             data-description="{{ $itemDescription }}">
                            @if($itemImage)
                                <img src="{{ $itemImage }}" alt="{{ $caption }}"
                                     class="w-100 h-100 object-fit-cover transition-all"
                                     style="transition: transform 0.3s ease;">
                            @else
                                <div class="w-100 h-100 bg-label-primary d-flex align-items-center justify-content-center">
                                    <i class="ti tabler-photo fs-1 text-primary"></i>
                                </div>
                            @endif
                            <div class="gallery-overlay position-absolute inset-0 d-flex flex-column justify-content-end p-3"
                                 style="background: linear-gradient(to top, rgba(9,44,76,0.8) 0%, transparent 60%);
                                        opacity: 0; transition: opacity 0.3s ease;">
                                @if($caption)
                                    <h6 class="text-white mb-1">{{ $caption }}</h6>
                                @endif
                                @if($itemDescription)
                                    <p class="text-white small mb-0 opacity-75">{{ Str::limit($itemDescription, 50) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Gallery Modal --}}
    <div class="modal fade" id="galleryModal{{ $panel->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal" style="z-index: 1;"></button>
                    <img src="" alt="" id="galleryModalImage{{ $panel->id }}"
                         class="img-fluid rounded-3" style="max-height: 80vh;">
                    <div class="text-white mt-3">
                        <h5 id="galleryModalCaption{{ $panel->id }}"></h5>
                        <p class="opacity-75" id="galleryModalDescription{{ $panel->id }}"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1 !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .inset-0 {
        top: 0; right: 0; bottom: 0; left: 0;
    }
</style>

<script>
    document.querySelectorAll('#panel-{{ $panel->id }} .gallery-item').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('galleryModalImage{{ $panel->id }}').src = this.dataset.image;
            document.getElementById('galleryModalCaption{{ $panel->id }}').textContent = this.dataset.caption;
            document.getElementById('galleryModalDescription{{ $panel->id }}').textContent = this.dataset.description;
        });
    });
</script>
