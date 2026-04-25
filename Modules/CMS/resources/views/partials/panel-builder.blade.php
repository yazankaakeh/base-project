@php
    use Modules\CMS\Enums\PanelTypeEnum;
@endphp

        <!-- Panel Builder Section -->
<div class="card my-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ trans('cms::cms.panels.title') }}</h5>
        <button type="button" class="btn btn-sm btn-primary" id="add-panel-btn" data-bs-toggle="modal"
                data-bs-target="#addPanelModal" {{ empty($pageId) ? 'disabled' : '' }}>
            <i class="ti tabler-plus"></i> {{ trans('cms::cms.panels.add_panel') }}
        </button>
    </div>
    <div class="card-body">
        <div id="panels-container" data-page-id="{{ $pageId ?? '' }}">
            <!-- Panels will be loaded here via JavaScript -->
            @if(empty($pageId))
                <div class="text-center py-5">
                    <i class="ti tabler-layout-grid-add" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">Please save the page first before adding panels.</p>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti tabler-layout-grid-add" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">{{ trans('cms::cms.panels.no_panels') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Panel Modal -->
<div class="modal fade" id="addPanelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('cms::cms.panels.select_panel_type') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    @foreach(PanelTypeEnum::cases() as $panelType)
                        <div class="col-md-6 col-lg-4">
                            <div class="card panel-type-card cursor-pointer h-100 panel-type-option"
                                 data-panel-type="{{ $panelType->value }}" style="transition: all 0.3s;">
                                <div class="card-body text-center">
                                    <i class="{{ $panelType->icon() }}"
                                       style="font-size: 2.5rem; color: var(--bs-primary);"></i>
                                    <h6 class="mt-3 mb-2">{{ $panelType->label() }}</h6>
                                    <p class="text-muted small mb-0">{{ $panelType->description() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .panel-type-card {
        border: 2px solid transparent;
    }

    .panel-type-card:hover {
        border-color: var(--bs-primary);
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .cursor-move {
        cursor: move;
    }

    .panel-ghost {
        opacity: 0.4;
        background: #f8f9fa;
    }

    .panel-drag-handle {
        cursor: grab;
    }

    .panel-drag-handle:active {
        cursor: grabbing;
    }
</style>

<script>
    // Add hover effects for panel type cards
    document.addEventListener('DOMContentLoaded', function () {
        const panelTypeCards = document.querySelectorAll('.panel-type-option');

        panelTypeCards.forEach(card => {
            card.addEventListener('click', function () {
                // Visual feedback
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    });
</script>
