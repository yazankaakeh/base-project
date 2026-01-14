@php
    $custom = $panel;
    $customTitle = $custom['title'][$locale] ?? 'Custom Section';
    $customContent = $custom['settings']['html_content'] ?? '';
@endphp

<!-- Custom: Start -->
<section id="customSection" class="section-py bg-body">
    <div class="container">
        @if($customTitle)
            <div class="text-center mb-4">
                <h4 class="fw-extrabold">{{ $customTitle }}</h4>
            </div>
        @endif

        @if($customContent)
            <div class="custom-content">
                {!! $customContent !!}
            </div>
        @else
            <div class="text-center py-5">
                <i class="ti ti-code display-1 text-muted"></i>
                <p class="text-muted mt-3">No custom content available.</p>
            </div>
        @endif
    </div>
</section>
<!-- Custom: End -->


