@php use Modules\Core\App\Enums\LanguageEnum; use Illuminate\Support\Str; @endphp
<div data-livewire="{{$componentName}}">
    <div class="card my-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Panels</h5>
            <div class="d-flex gap-2 flex-wrap">
                <select class="form-select form-select-sm" wire:model="newPanel.type" style="width: 220px;">
                    <option value="">Select panel type</option>
                    @foreach($panelTypes as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                    @endforeach
                </select>
                <div class="d-flex align-items-center">
                    <div class="input-group input-group-sm">
                        @foreach(LanguageEnum::values() as $lang)
                            <input type="text" class="form-control" style="max-width: 160px;"
                                   placeholder="Title ({{ strtoupper($lang) }})"
                                   wire:model.defer="newPanel.title.{{ $lang }}">
                        @endforeach
                    </div>
                </div>
                <button class="btn btn-sm btn-primary" wire:click="createPanel" wire:loading.attr="disabled">
                    <i class="ti tabler-plus"></i> Add panel
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(empty($panels))
                <div class="text-center py-5">
                    <i class="ti tabler-layout-grid-add" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">No panels yet. Add a panel to get started.</p>
                </div>
            @else
                <div class="list-group" id="panels-sortable">
                    @foreach($panels as $panelIndex => $panel)
                        <div class="list-group-item mb-3 border rounded" data-panel-id="{{ $panel['id'] }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted draggable" title="Drag to reorder" style="cursor: move;">
                                        <i class="ti tabler-grip-vertical"></i>
                                    </span>
                                    <i class="ti {{ \Modules\CMS\Enums\PanelTypeEnum::from($panel['type'])->icon() }} text-primary"></i>
                                    <strong>{{ $panel['type_label'] }}</strong>
                                    @if(!empty($panel['title'][app()->getLocale()]))
                                        <span class="text-muted">- {{ $panel['title'][app()->getLocale()] }}</span>
                                    @endif
                                    <span class="badge bg-{{ $panel['is_active'] ? 'success' : 'secondary' }}">
                                        {{ $panel['is_active'] ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary"
                                            wire:click="togglePanel({{ $panel['id'] }})"
                                            title="{{ $panel['is_active'] ? 'Deactivate' : 'Activate' }}">
                                        @if($panel['is_active'])
                                            <i class="ti tabler-eye-off"></i>
                                        @else
                                            <i class="ti tabler-eye"></i>
                                        @endif
                                    </button>
                                    <button class="btn btn-sm btn-outline-info"
                                            wire:click="editPanel({{ $panel['id'] }})"
                                            title="Edit Panel">
                                        <i class="ti tabler-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger"
                                            wire:click="deletePanel({{ $panel['id'] }})"
                                            wire:confirm="Are you sure you want to delete this panel?"
                                            title="Delete Panel">
                                        <i class="ti tabler-trash"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Panel Items Section --}}
                            @if($panel['can_have_items'])
                                <div class="mt-3 ps-4 border-start">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 text-muted">
                                            <i class="ti tabler-list"></i> Items ({{ count($panel['items']) }})
                                        </h6>
                                    </div>

                                    {{-- Add New Item Form --}}
                                    <div class="card bg-light mb-3">
                                        <div class="card-body py-2">
                                            <div class="row g-2 align-items-end">
                                                <div class="col-md-3">
                                                    <label class="form-label small mb-1">Item Type</label>
                                                    <select class="form-select form-select-sm"
                                                            wire:model="newItemType.{{ $panel['id'] }}">
                                                        <option value="">Select type...</option>
                                                        @foreach($itemTypes as $type)
                                                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @foreach(LanguageEnum::values() as $lang)
                                                    <div class="col-md-2">
                                                        <label class="form-label small mb-1">Title ({{ strtoupper($lang) }})</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                               placeholder="Title"
                                                               wire:model.defer="newItemTitle.{{ $panel['id'] }}.{{ $lang }}">
                                                    </div>
                                                @endforeach
                                                <div class="col-md-2">
                                                    <label class="form-label small mb-1">Image</label>
                                                    <input type="file" class="form-control form-control-sm"
                                                           wire:model="newItemImage.{{ $panel['id'] }}"
                                                           accept="image/*">
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-sm btn-primary w-100"
                                                            wire:click="createItem({{ $panel['id'] }})"
                                                            wire:loading.attr="disabled">
                                                        <i class="ti tabler-plus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Type-specific fields --}}
                                            @php $itemType = $newItemType[$panel['id']] ?? null; @endphp
                                            @if($itemType)
                                                <div class="row g-2 mt-2">
                                                    @if($itemType === 'feature_card')
                                                        <div class="col-md-3">
                                                            <label class="form-label small mb-1">Icon Class</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="e.g., ti tabler-star"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.icon">
                                                        </div>
                                                    @elseif($itemType === 'team_member')
                                                        <div class="col-md-3">
                                                            <label class="form-label small mb-1">Name</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="Name"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.name">
                                                        </div>
                                                        @foreach(LanguageEnum::values() as $lang)
                                                            <div class="col-md-2">
                                                                <label class="form-label small mb-1">Role ({{ strtoupper($lang) }})</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                       placeholder="Role"
                                                                       wire:model.defer="newItemData.{{ $panel['id'] }}.role.{{ $lang }}">
                                                            </div>
                                                        @endforeach
                                                    @elseif($itemType === 'review')
                                                        <div class="col-md-3">
                                                            <label class="form-label small mb-1">Reviewer Name</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="Name"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.name">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label small mb-1">Rating (1-5)</label>
                                                            <input type="number" min="1" max="5"
                                                                   class="form-control form-control-sm"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.rating">
                                                        </div>
                                                    @elseif($itemType === 'stat')
                                                        <div class="col-md-2">
                                                            <label class="form-label small mb-1">Value</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="100+"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.value">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label small mb-1">Icon</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="ti tabler-users"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.icon">
                                                        </div>
                                                    @endif

                                                    {{-- Description fields for all types --}}
                                                    @foreach(LanguageEnum::values() as $lang)
                                                        <div class="col-md-3">
                                                            <label class="form-label small mb-1">Description ({{ strtoupper($lang) }})</label>
                                                            <textarea class="form-control form-control-sm" rows="1"
                                                                      wire:model.defer="newItemContent.{{ $panel['id'] }}.{{ $lang }}"
                                                                      placeholder="Description..."></textarea>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Existing Items List --}}
                                    @if(empty($panel['items']))
                                        <div class="text-muted small py-2">
                                            <i class="ti tabler-info-circle"></i> No items yet. Add items above.
                                        </div>
                                    @else
                                        <ul class="list-group list-group-flush" data-items-sortable="{{ $panel['id'] }}">
                                            @foreach($panel['items'] as $itemIndex => $item)
                                                <li class="list-group-item d-flex justify-content-between align-items-center px-2"
                                                    data-item-id="{{ $item['id'] }}">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="text-muted draggable" title="Drag to reorder"
                                                              style="cursor: move;">
                                                            <i class="ti tabler-grip-vertical"></i>
                                                        </span>
                                                        @if($item['media_url'])
                                                            <img src="{{ $item['media_url'] }}"
                                                                 width="40" height="40" class="rounded"
                                                                 style="object-fit: cover;" alt="">
                                                        @else
                                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                                 style="width: 40px; height: 40px;">
                                                                <i class="ti tabler-photo text-muted"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-medium">
                                                                {{ $item['title'][app()->getLocale()] ?? '(No title)' }}
                                                            </div>
                                                            <div class="text-muted small">
                                                                {{ Str::limit($item['content'][app()->getLocale()] ?? '', 50) }}
                                                            </div>
                                                        </div>
                                                        <span class="badge bg-{{ $item['is_active'] ? 'success' : 'secondary' }} ms-2">
                                                            {{ $item['is_active'] ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex gap-1">
                                                        <button class="btn btn-sm btn-outline-secondary"
                                                                wire:click="toggleItemStatus({{ $item['id'] }})"
                                                                title="{{ $item['is_active'] ? 'Deactivate' : 'Activate' }}">
                                                            <i class="ti tabler-{{ $item['is_active'] ? 'eye-off' : 'eye' }}"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-primary"
                                                                wire:click="editItem({{ $item['id'] }})"
                                                                title="Edit">
                                                            <i class="ti tabler-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger"
                                                                wire:click="deleteItem({{ $item['id'] }})"
                                                                wire:confirm="Are you sure you want to delete this item?"
                                                                title="Delete">
                                                            <i class="ti tabler-trash"></i>
                                                        </button>
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
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ti tabler-edit me-2"></i>
                            Edit Panel: {{ \Modules\CMS\Enums\PanelTypeEnum::tryFrom($editingPanel['type'])?->label() ?? 'Panel' }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showEditPanelModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Panel Titles --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Panel Title</label>
                            <div class="row g-2">
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                            <input type="text" class="form-control"
                                                   wire:model.defer="editingPanel.title.{{ $lang }}"
                                                   placeholder="Title in {{ strtoupper($lang) }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Badge (for sections that use it) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Section Badge</label>
                            <div class="row g-2">
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                            <input type="text" class="form-control"
                                                   wire:model.defer="editingPanel.settings.badge.{{ $lang }}"
                                                   placeholder="Badge text">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Small badge displayed above the section title</small>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Section Description</label>
                            <div class="row g-2">
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                            <textarea class="form-control" rows="2"
                                                      wire:model.defer="editingPanel.settings.description.{{ $lang }}"
                                                      placeholder="Description in {{ strtoupper($lang) }}"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Active Status --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   wire:model.defer="editingPanel.is_active"
                                   id="editPanelActive">
                            <label class="form-check-label" for="editPanelActive">
                                Active (visible on website)
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showEditPanelModal', false)">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="saveEditedPanel">
                            <i class="ti tabler-check me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Edit Item Modal --}}
    @if($showEditItemModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ti tabler-edit me-2"></i> Edit Item
                        </h5>
                        <button type="button" class="btn-close" wire:click="$set('showEditItemModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Item Titles --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Item Title</label>
                            <div class="row g-2">
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                            <input type="text" class="form-control"
                                                   wire:model.defer="editPanelItem.title.{{ $lang }}"
                                                   placeholder="Title">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Item Content/Description --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Content / Description</label>
                            @foreach(LanguageEnum::values() as $lang)
                                <div class="mb-2">
                                    <div class="input-group">
                                        <span class="input-group-text">{{ strtoupper($lang) }}</span>
                                        <textarea class="form-control" rows="2"
                                                  wire:model.defer="editPanelItem.content.{{ $lang }}"
                                                  placeholder="Content in {{ strtoupper($lang) }}"></textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Data Fields --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Additional Data</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label small">Icon Class</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="editPanelItem.data.icon"
                                           placeholder="ti tabler-star">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Name</label>
                                    <input type="text" class="form-control"
                                           wire:model.defer="editPanelItem.data.name"
                                           placeholder="Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Rating (1-5)</label>
                                    <input type="number" min="1" max="5" class="form-control"
                                           wire:model.defer="editPanelItem.data.rating">
                                </div>
                            </div>
                            <div class="row g-2 mt-2">
                                @foreach(LanguageEnum::values() as $lang)
                                    <div class="col-md-4">
                                        <label class="form-label small">Role ({{ strtoupper($lang) }})</label>
                                        <input type="text" class="form-control"
                                               wire:model.defer="editPanelItem.data.role.{{ $lang }}"
                                               placeholder="Role">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Active Status --}}
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   wire:model.defer="editPanelItem.is_active"
                                   id="editItemActive">
                            <label class="form-check-label" for="editItemActive">
                                Active (visible on website)
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showEditItemModal', false)">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="saveEditedItem">
                            <i class="ti tabler-check me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('page-script')
        <script>
            document.addEventListener('livewire:initialized', () => {
                const makePanelsSortable = () => {
                    const root = document.getElementById('panels-sortable');
                    if (!root || !window.Sortable) return;
                    if (root._sortable) return;
                    root._sortable = new Sortable(root, {
                        handle: '.draggable',
                        animation: 150,
                        onEnd: function () {
                            const ids = Array.from(root.querySelectorAll('[data-panel-id]')).map(el => parseInt(el.getAttribute('data-panel-id')));
                            @this.call('reorderPanels', ids);
                        }
                    });
                }

                const makeItemsSortable = () => {
                    document.querySelectorAll('[data-items-sortable]')?.forEach(el => {
                        if (el._sortable || !window.Sortable) return;
                        const panelId = parseInt(el.getAttribute('data-items-sortable'));
                        el._sortable = new Sortable(el, {
                            handle: '.draggable',
                            animation: 150,
                            onEnd: function () {
                                const ids = Array.from(el.querySelectorAll('[data-item-id]')).map(li => parseInt(li.getAttribute('data-item-id')));
                                @this.call('reorderItems', panelId, ids);
                            }
                        });
                    });
                }

                setTimeout(() => {
                    makePanelsSortable();
                    makeItemsSortable();
                }, 100);

                Livewire.hook('message.processed', () => {
                    setTimeout(() => {
                        makePanelsSortable();
                        makeItemsSortable();
                    }, 50);
                });

                // Close modal on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        @this.call('closeAllModals');
                    }
                });
            });
        </script>
    @endpush
</div>
