@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ar', 'he', 'fa']);
    $title = $panel->getTranslation('title', $locale);
    $badge = $panel->settings['badge'][$locale] ?? null;
    $description = $panel->settings['description'][$locale] ?? null;
@endphp

@once
    @include('website::panels._panels-styles')
@endonce

<section class="panel-section panel-bg-white" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
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

        {{-- Gallery Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-3">
                @foreach($panel->activeItems as $index => $item)
                    @php
                        $caption = $item->getTranslation('title', $locale);
                        $itemDescription = $item->getTranslation('content', $locale);
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3 panel-animate">
                        <div class="panel-gallery-item"
                             data-bs-toggle="modal"
                             data-bs-target="#galleryModal{{ $panel->id }}"
                             data-image="{{ $itemImage }}"
                             data-caption="{{ $caption }}"
                             data-description="{{ $itemDescription }}">
                            @if($itemImage)
                                <img src="{{ $itemImage }}" alt="{{ $caption }}" loading="lazy">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: var(--panel-bg-muted);">
                                    <i class="ti tabler-photo" style="font-size: 2rem; color: var(--panel-text-light);"></i>
                                </div>
                            @endif
                            <div class="panel-gallery-zoom">
                                <i class="ti tabler-zoom-in"></i>
                            </div>
                            @if($caption)
                                <div class="panel-gallery-overlay">
                                    <h6 style="font-size: 0.9375rem; margin-bottom: 0;">{{ $caption }}</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Gallery Modal --}}
    <div class="modal fade" id="galleryModal{{ $panel->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background: transparent; border: none;">
                <div class="modal-body p-0 text-center position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute"
                            data-bs-dismiss="modal" aria-label="Close"
                            style="top: -40px; {{ $isRtl ? 'left' : 'right' }}: 0; z-index: 10;"></button>
                    <img src="" alt="" id="galleryModalImage{{ $panel->id }}"
                         class="img-fluid" style="max-height: 80vh; border-radius: var(--panel-radius-lg); box-shadow: var(--panel-shadow-lg);">
                    <div class="text-white mt-4">
                        <h5 id="galleryModalCaption{{ $panel->id }}" style="margin-bottom: 8px;"></h5>
                        <p id="galleryModalDescription{{ $panel->id }}" style="opacity: 0.8; margin: 0;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    'use strict';

    function initGallery() {
        var galleryItems = document.querySelectorAll('#panel-{{ $panel->id }} .panel-gallery-item');
        var modalImage = document.getElementById('galleryModalImage{{ $panel->id }}');
        var modalCaption = document.getElementById('galleryModalCaption{{ $panel->id }}');
        var modalDescription = document.getElementById('galleryModalDescription{{ $panel->id }}');

        if (!modalImage) return;

        galleryItems.forEach(function(item) {
            item.addEventListener('click', function() {
                modalImage.src = this.dataset.image || '';
                modalImage.alt = this.dataset.caption || '';
                if (modalCaption) modalCaption.textContent = this.dataset.caption || '';
                if (modalDescription) modalDescription.textContent = this.dataset.description || '';
            });
        });

        var modal = document.getElementById('galleryModal{{ $panel->id }}');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                modalImage.src = '';
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initGallery);
    } else {
        initGallery();
    }
})();
</script>
