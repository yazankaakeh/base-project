@php
    use Modules\CMS\Enums\PanelTypeEnum;use Modules\Core\App\Enums\LanguageEnum;
    use Illuminate\Support\Str;
@endphp

<div class="panel-builder" wire:id="{{ $this->getId() }}">
    {{-- Header Section --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 d-flex align-items-center gap-2">
                        <span class="badge badge-center bg-primary p-2">
                            <i class="ti tabler-layout-grid ti-sm"></i>
                        </span>
                        Page Builder
                    </h5>
                    <small class="text-muted">Drag and drop panels to build your page layout</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span
                        class="badge bg-label-info">{{ count($panels) }} {{ Str::plural('panel', count($panels)) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Add New Panel Section --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-label-primary py-3">
            <h6 class="mb-0 text-primary">
                <i class="ti tabler-plus me-2"></i>Add New Panel
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-medium">Panel Type <span class="text-danger">*</span></label>
                    <select class="form-select" wire:model.live="newPanel.type">
                        <option value="">Select panel type...</option>
                        @foreach($panelTypes as $type)
                            <option value="{{ $type->value }}">
                                {{ $type->label() }} - {{ $type->description() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @foreach(LanguageEnum::values() as $lang)
                    <div class="col-md-2">
                        <label class="form-label fw-medium">
                            Title ({{ strtoupper($lang) }})
                            @if($lang === 'en')
                                <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="text"
                               class="form-control"
                               placeholder="Panel title..."
                               wire:model="newPanel.title.{{ $lang }}">
                    </div>
                @endforeach
                <div class="col-md-2">
                    <button class="btn btn-primary w-100"
                            wire:click="createPanel"
                            wire:loading.attr="disabled"
                            wire:loading.class="disabled"
                            @if(empty($newPanel['type'])) disabled @endif>
                        <span wire:loading.remove wire:target="createPanel">
                            <i class="ti tabler-plus me-1"></i>Add Panel
                        </span>
                        <span wire:loading wire:target="createPanel">
                            <span class="spinner-border spinner-border-sm me-1"></span>Adding...
                        </span>
                    </button>
                </div>
            </div>

            {{-- Panel Type Preview --}}
            @if($newPanel['type'])
                @php $selectedType = PanelTypeEnum::tryFrom($newPanel['type']); @endphp
                @if($selectedType)
                    <div class="alert alert-primary mt-3 mb-0 d-flex align-items-center gap-3">
                        <i class="ti {{ $selectedType->icon() }} fs-3"></i>
                        <div>
                            <strong>{{ $selectedType->label() }}</strong>
                            <p class="mb-0 small">{{ $selectedType->description() }}</p>
                            @if($selectedType->hasItems())
                                <span class="badge bg-primary mt-1">Supports items</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    {{-- Panels List --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="ti tabler-stack-2 me-2 text-primary"></i>Page Panels
                </h6>
                @if(count($panels) > 1)
                    <small class="text-muted">
                        <i class="ti tabler-arrows-move me-1"></i>Drag to reorder
                    </small>
                @endif
            </div>
        </div>
        <div class="card-body p-0">
            @if(empty($panels))
                <div class="text-center py-5">
                    <div class="mb-3">
                        <span class="badge badge-center bg-label-secondary rounded-circle p-4">
                            <i class="ti tabler-layout-off display-5"></i>
                        </span>
                    </div>
                    <h5 class="text-muted">No panels yet</h5>
                    <p class="text-muted mb-0">Add your first panel using the form above</p>
                </div>
            @else
                <div id="panels-sortable" wire:ignore.self>
                    @foreach($panels as $panelIndex => $panel)
                        @php $panelType = PanelTypeEnum::tryFrom($panel['type']); @endphp
                        <div class="panel-item border-bottom" data-panel-id="{{ $panel['id'] }}"
                             wire:key="panel-{{ $panel['id'] }}">
                            {{-- Panel Header --}}
                            <div
                                class="d-flex align-items-center justify-content-between p-3 {{ !$panel['is_active'] ? 'bg-light opacity-75' : '' }}">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="panel-drag-handle text-muted" style="cursor: grab;"
                                          title="Drag to reorder">
                                        <i class="ti tabler-grip-vertical fs-4"></i>
                                    </span>
                                    <span class="badge badge-center bg-label-primary p-2">
                                        <i class="ti {{ $panelType?->icon() ?? 'tabler-layout' }} ti-sm"></i>
                                    </span>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <strong>{{ $panel['type_label'] }}</strong>
                                            @if(!empty($panel['title'][app()->getLocale()]))
                                                <span class="text-muted">•</span>
                                                <span
                                                    class="text-muted">{{ $panel['title'][app()->getLocale()] }}</span>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <span
                                                class="badge bg-{{ $panel['is_active'] ? 'success' : 'secondary' }} badge-sm">
                                                <i class="ti tabler-{{ $panel['is_active'] ? 'eye' : 'eye-off' }} me-1"></i>
                                                {{ $panel['is_active'] ? 'Active' : 'Inactive' }}
                                            </span>
                                            @if($panel['can_have_items'])
                                                <span class="badge bg-label-info badge-sm">
                                                    {{ count($panel['items']) }} {{ Str::plural('item', count($panel['items'])) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button
                                        class="btn btn-icon btn-sm btn-label-{{ $panel['is_active'] ? 'warning' : 'success' }}"
                                        wire:click="togglePanel({{ $panel['id'] }})"
                                        title="{{ $panel['is_active'] ? 'Deactivate' : 'Activate' }}">
                                        <i class="ti tabler-{{ $panel['is_active'] ? 'eye-off' : 'eye' }}"></i>
                                    </button>
                                    <button class="btn btn-icon btn-sm btn-label-primary"
                                            wire:click.prevent="editPanel({{ $panel['id'] }})"
                                            title="Edit Panel">
                                        <i class="ti tabler-edit"></i>
                                    </button>
                                    <button class="btn btn-icon btn-sm btn-label-danger"
                                            wire:click="deletePanel({{ $panel['id'] }})"
                                            onclick="return confirm('Delete this panel and all its items?')"
                                            title="Delete Panel">
                                        <i class="ti tabler-trash"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Panel Items Section --}}
                            @if($panel['can_have_items'])
                                <div class="bg-light border-top">
                                    {{-- Add Item Form --}}
                                    <div class="p-3 border-bottom bg-white">
                                        <div class="row g-2 align-items-end">
                                            <div class="col-md-2">
                                                <label class="form-label small mb-1">Type</label>
                                                <select class="form-select form-select-sm"
                                                        wire:model.live="newItemType.{{ $panel['id'] }}">
                                                    <option value="">Select...</option>
                                                    @foreach($itemTypes as $type)
                                                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @foreach(LanguageEnum::values() as $lang)
                                                <div class="col-md-2">
                                                    <label class="form-label small mb-1">Title ({{ strtoupper($lang) }}
                                                        )</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                           placeholder="Item title..."
                                                           wire:model="newItemTitle.{{ $panel['id'] }}.{{ $lang }}">
                                                </div>
                                            @endforeach
                                            <div class="col-md-2">
                                                <label class="form-label small mb-1">Image</label>
                                                <input type="file" class="form-control form-control-sm"
                                                       wire:model="newItemImage.{{ $panel['id'] }}"
                                                       accept="image/*">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-sm btn-primary w-100"
                                                        wire:click="createItem({{ $panel['id'] }})"
                                                        wire:loading.attr="disabled"
                                                        wire:target="createItem({{ $panel['id'] }})">
                                                    <span wire:loading.remove
                                                          wire:target="createItem({{ $panel['id'] }})">
                                                        <i class="ti tabler-plus me-1"></i>Add
                                                    </span>
                                                    <span wire:loading wire:target="createItem({{ $panel['id'] }})">
                                                        <span class="spinner-border spinner-border-sm"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Dynamic Fields Based on Type --}}
                                        @php $itemType = $newItemType[$panel['id']] ?? null; @endphp
                                        @if($itemType)
                                            <div class="row g-2 mt-2 pt-2 border-top">
                                                @if($itemType === 'feature_card')
                                                    <div class="col-md-3">
                                                        <label class="form-label small mb-1">Icon Class</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="ti tabler-star"
                                                               wire:model="newItemData.{{ $panel['id'] }}.icon">
                                                    </div>
                                                @elseif($itemType === 'team_member')
                                                    <div class="col-md-3">
                                                        <label class="form-label small mb-1">Name</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="Full name"
                                                               wire:model="newItemData.{{ $panel['id'] }}.name">
                                                    </div>
                                                    @foreach(LanguageEnum::values() as $lang)
                                                        <div class="col-md-2">
                                                            <label class="form-label small mb-1">Role
                                                                ({{ strtoupper($lang) }})</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="Role"
                                                                   wire:model="newItemData.{{ $panel['id'] }}.role.{{ $lang }}">
                                                        </div>
                                                    @endforeach
                                                @elseif($itemType === 'review')
                                                    <div class="col-md-3">
                                                        <label class="form-label small mb-1">Reviewer</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="Name"
                                                               wire:model="newItemData.{{ $panel['id'] }}.name">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label small mb-1">Rating</label>
                                                        <select class="form-select form-select-sm"
                                                                wire:model="newItemData.{{ $panel['id'] }}.rating">
                                                            <option value="">Select...</option>
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                    Star{{ $i > 1 ? 's' : '' }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                @elseif($itemType === 'stat')
                                                    <div class="col-md-2">
                                                        <label class="form-label small mb-1">Value</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="100+"
                                                               wire:model="newItemData.{{ $panel['id'] }}.value">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label small mb-1">Icon</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="ti tabler-users"
                                                               wire:model="newItemData.{{ $panel['id'] }}.icon">
                                                    </div>
                                                @endif

                                                @foreach(LanguageEnum::values() as $lang)
                                                    <div class="col">
                                                        <label class="form-label small mb-1">Description
                                                            ({{ strtoupper($lang) }})</label>
                                                        <textarea class="form-control form-control-sm" rows="1"
                                                                  wire:model="newItemContent.{{ $panel['id'] }}.{{ $lang }}"
                                                                  placeholder="Description..."></textarea>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Items List --}}
                                    @if(empty($panel['items']))
                                        <div class="text-center py-4">
                                            <i class="ti tabler-box-off text-muted fs-1 opacity-50"></i>
                                            <p class="text-muted small mb-0 mt-2">No items. Add one above.</p>
                                        </div>
                                    @else
                                        <ul class="list-unstyled mb-0 items-sortable" data-panel-id="{{ $panel['id'] }}"
                                            wire:ignore.self>
                                            @foreach($panel['items'] as $item)
                                                <li class="d-flex align-items-center justify-content-between p-2 px-3 border-bottom bg-white"
                                                    data-item-id="{{ $item['id'] }}" wire:key="item-{{ $item['id'] }}">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="item-drag-handle text-muted" style="cursor: grab;">
                                                            <i class="ti tabler-grip-vertical"></i>
                                                        </span>
                                                        @if($item['media_url'])
                                                            <img src="{{ $item['media_url'] }}"
                                                                 class="rounded border"
                                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <div
                                                                class="rounded bg-label-secondary d-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px;">
                                                                <i class="ti tabler-photo"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-medium">
                                                                {{ $item['title'][app()->getLocale()] ?? '(Untitled)' }}
                                                            </div>
                                                            @if(!empty($item['content'][app()->getLocale()]))
                                                                <small class="text-muted">
                                                                    {{ Str::limit($item['content'][app()->getLocale()], 60) }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span
                                                            class="badge bg-{{ $item['is_active'] ? 'success' : 'secondary' }}">
                                                            {{ $item['is_active'] ? 'Active' : 'Hidden' }}
                                                        </span>
                                                        <div class="btn-group btn-group-sm">
                                                            <button
                                                                class="btn btn-label-{{ $item['is_active'] ? 'warning' : 'success' }}"
                                                                wire:click="toggleItemStatus({{ $item['id'] }})"
                                                                title="{{ $item['is_active'] ? 'Hide' : 'Show' }}">
                                                                <i class="ti tabler-{{ $item['is_active'] ? 'eye-off' : 'eye' }}"></i>
                                                            </button>
                                                            <button class="btn btn-label-primary"
                                                                    wire:click.prevent="editItem({{ $item['id'] }})"
                                                                    title="Edit">
                                                                <i class="ti tabler-edit"></i>
                                                            </button>
                                                            <button class="btn btn-label-danger"
                                                                    wire:click="deleteItem({{ $item['id'] }})"
                                                                    onclick="return confirm('Delete this item?')"
                                                                    title="Delete">
                                                                <i class="ti tabler-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Edit Panel Modal --}}
    @if($showEditPanelModal)
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="ti tabler-edit me-2"></i>
                            Edit
                            Panel: {{ PanelTypeEnum::tryFrom($editingPanel['type'] ?? '')?->label() ?? 'Panel' }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white"
                                wire:click="$set('showEditPanelModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Title --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="ti tabler-heading me-1"></i>Panel Title
                            </label>
                            <div class="row g-2">
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                            <input type="text" class="form-control"
                                                   wire:model="editingPanel.title.{{ $lang }}"
                                                   placeholder="Title in {{ strtoupper($lang) }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Badge --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="ti tabler-badge me-1"></i>Section Badge
                                <small class="fw-normal text-muted ms-1">(optional)</small>
                            </label>
                            <div class="row g-2">
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                            <input type="text" class="form-control"
                                                   wire:model="editingPanel.settings.badge.{{ $lang }}"
                                                   placeholder="e.g., Our Services">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Small text displayed above the section title</small>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="ti tabler-align-left me-1"></i>Section Description
                                <small class="fw-normal text-muted ms-1">(optional)</small>
                            </label>
                            @foreach(LanguageEnum::values() as $lang)
                                <div class="input-group mb-2">
                                    <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                    <textarea class="form-control" rows="2"
                                              wire:model="editingPanel.settings.description.{{ $lang }}"
                                              placeholder="Description in {{ strtoupper($lang) }}"></textarea>
                                </div>
                            @endforeach
                        </div>

                        {{-- Status --}}
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   wire:model="editingPanel.is_active"
                                   id="editPanelActive">
                            <label class="form-check-label" for="editPanelActive">
                                <strong>Active</strong> - Panel is visible on the website
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary"
                                wire:click.prevent="$set('showEditPanelModal', false)">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" wire:click.prevent="saveEditedPanel">
                            <i class="ti tabler-check me-1"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Edit Item Modal --}}
    @if($showEditItemModal)
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="ti tabler-edit me-2"></i>Edit Item
                        </h5>
                        <button type="button" class="btn-close btn-close-white"
                                wire:click="$set('showEditItemModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Title --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="ti tabler-heading me-1"></i>Item Title
                            </label>
                            <div class="row g-2">
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                            <input type="text" class="form-control"
                                                   wire:model="editPanelItem.title.{{ $lang }}"
                                                   placeholder="Title">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="ti tabler-align-left me-1"></i>Content / Description
                            </label>
                            @foreach(LanguageEnum::values() as $lang)
                                <div class="input-group mb-2">
                                    <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                    <textarea class="form-control" rows="2"
                                              wire:model="editPanelItem.content.{{ $lang }}"
                                              placeholder="Content in {{ strtoupper($lang) }}"></textarea>
                                </div>
                            @endforeach
                        </div>

                        {{-- Additional Data --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="ti tabler-settings me-1"></i>Additional Settings
                            </label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small">Icon Class</label>
                                    <input type="text" class="form-control"
                                           wire:model="editPanelItem.data.icon"
                                           placeholder="ti tabler-star">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Name</label>
                                    <input type="text" class="form-control"
                                           wire:model="editPanelItem.data.name"
                                           placeholder="Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Value</label>
                                    <input type="text" class="form-control"
                                           wire:model="editPanelItem.data.value"
                                           placeholder="Value">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Rating</label>
                                    <select class="form-select" wire:model="editPanelItem.data.rating">
                                        <option value="">Select...</option>
                                        @for($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-md-4">
                                        <label class="form-label small">Role ({{ strtoupper($lang) }})</label>
                                        <input type="text" class="form-control"
                                               wire:model="editPanelItem.data.role_{{ $lang }}"
                                               placeholder="Role">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   wire:model="editPanelItem.is_active"
                                   id="editItemActive">
                            <label class="form-check-label" for="editItemActive">
                                <strong>Active</strong> - Item is visible on the website
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary"
                                wire:click.prevent="$set('showEditItemModal', false)">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" wire:click.prevent="saveEditedItem">
                            <i class="ti tabler-check me-1"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @script
    <script>
        let panelsSortable = null;
        let itemsSortables = new Map();

        function initSortables() {
            // Destroy existing
            if (panelsSortable) {
                panelsSortable.destroy();
                panelsSortable = null;
            }
            itemsSortables.forEach(s => s.destroy());
            itemsSortables.clear();

            // Panels sortable
            const panelsRoot = document.getElementById('panels-sortable');
            if (panelsRoot && window.Sortable) {
                panelsSortable = new Sortable(panelsRoot, {
                    handle: '.panel-drag-handle',
                    animation: 200,
                    ghostClass: 'bg-label-primary',
                    chosenClass: 'shadow-lg',
                    onEnd: function () {
                        const ids = Array.from(panelsRoot.querySelectorAll('[data-panel-id]'))
                            .map(el => parseInt(el.getAttribute('data-panel-id')));
                        $wire.call('reorderPanels', ids);
                    }
                });
            }

            // Items sortables
            document.querySelectorAll('.items-sortable').forEach(el => {
                if (window.Sortable) {
                    const panelId = parseInt(el.getAttribute('data-panel-id'));
                    const sortable = new Sortable(el, {
                        handle: '.item-drag-handle',
                        animation: 200,
                        ghostClass: 'bg-label-info',
                        onEnd: function () {
                            const ids = Array.from(el.querySelectorAll('[data-item-id]'))
                                .map(li => parseInt(li.getAttribute('data-item-id')));
                            $wire.call('reorderItems', panelId, ids);
                        }
                    });
                    itemsSortables.set(panelId, sortable);
                }
            });
        }

        // Initialize on component load
        setTimeout(initSortables, 100);

        // Re-initialize after Livewire updates
        $wire.on('panelsUpdated', () => {
            setTimeout(initSortables, 150);
        });

        // Also reinitialize on Livewire morph (DOM updates)
        Livewire.hook('morph.updated', () => {
            setTimeout(initSortables, 150);
        });

        // Escape key closes modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                $wire.call('closeAllModals');
            }
        });
    </script>
    @endscript

    <style>
        .panel-builder .panel-item {
            transition: all 0.2s ease;
        }

        .panel-builder .panel-item:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.02);
        }

        .panel-drag-handle:hover,
        .item-drag-handle:hover {
            color: var(--bs-primary) !important;
        }

        .badge-sm {
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
        }
    </style>
</div>


