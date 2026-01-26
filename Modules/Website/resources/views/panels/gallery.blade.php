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

<section class="panel-section panel-bg-gradient-light position-relative" id="panel-{{ $panel->id }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    {{-- Decorative Elements --}}
    <div class="panel-shape" style="width: 250px; height: 250px; top: -80px; {{ $isRtl ? 'left' : 'right' }}: -80px; background: rgba(var(--panel-primary-rgb), 0.05);"></div>

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

        {{-- Gallery Grid --}}
        @if($panel->activeItems->count() > 0)
            <div class="row g-3 g-md-4">
                @foreach($panel->activeItems as $index => $item)
                    @php
                        $caption = $item->getTranslation('title', $locale);
                        $itemDescription = $item->getTranslation('content', $locale);
                        $itemImage = $item->getFirstMediaUrl('item_image');
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3 panel-animate" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="panel-gallery-item"
                             data-bs-toggle="modal"
                             data-bs-target="#galleryModal{{ $panel->id }}"
                             data-image="{{ $itemImage }}"
                             data-caption="{{ $caption }}"
                             data-description="{{ $itemDescription }}">
                            @if($itemImage)
                                <img src="{{ $itemImage }}" alt="{{ $caption }}" loading="lazy">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                                     style="background: rgba(var(--panel-primary-rgb), 0.1);">
                                    <i class="ti tabler-photo fs-1" style="color: var(--panel-primary);"></i>
                                </div>
                            @endif
                            {{-- Zoom Icon --}}
                            <div class="panel-gallery-zoom">
                                <i class="ti tabler-zoom-in"></i>
                            </div>
                            {{-- Overlay with caption --}}
                            <div class="panel-gallery-overlay">
                                @if($caption)
                                    <h6 class="mb-1">{{ $caption }}</h6>
                                @endif
                                @if($itemDescription)
                                    <p class="small mb-0 opacity-75">{{ Str::limit($itemDescription, 50) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Gallery Modal --}}
    <div class="modal fade" id="galleryModal{{ $panel->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body p-0 text-center position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute"
                            data-bs-dismiss="modal" aria-label="Close"
                            style="top: -40px; {{ $isRtl ? 'left' : 'right' }}: 0; z-index: 10;"></button>
                    <img src="" alt="" id="galleryModalImage{{ $panel->id }}"
                         class="img-fluid rounded-4" style="max-height: 80vh; box-shadow: 0 20px 60px rgba(0,0,0,0.4);">
                    <div class="text-white mt-4">
                        <h5 id="galleryModalCaption{{ $panel->id }}" class="mb-2"></h5>
                        <p class="opacity-75 mb-0" id="galleryModalDescription{{ $panel->id }}"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('#panel-{{ $panel->id }} .panel-gallery-item');
    const modalImage = document.getElementById('galleryModalImage{{ $panel->id }}');
    const modalCaption = document.getElementById('galleryModalCaption{{ $panel->id }}');
    const modalDescription = document.getElementById('galleryModalDescription{{ $panel->id }}');

    galleryItems.forEach(item => {
        item.addEventListener('click', function() {
            modalImage.src = this.dataset.image || '';
            modalImage.alt = this.dataset.caption || '';
            modalCaption.textContent = this.dataset.caption || '';
            modalDescription.textContent = this.dataset.description || '';
        });
    });

    // Reset modal on close
    document.getElementById('galleryModal{{ $panel->id }}')?.addEventListener('hidden.bs.modal', function() {
        modalImage.src = '';
    });
});
</script>
