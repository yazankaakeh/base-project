@php use Modules\Core\App\Enums\LanguageEnum; use Illuminate\Support\Str; @endphp
<div data-livewire="{{$componentName}}">
    <div class="card my-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Panels</h5>
            <div class="d-flex gap-2">
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
                    <p class="text-muted mt-3">No panels yet</p>
                </div>
            @else
                <div class="list-group" id="panels-sortable">
                    @foreach($panels as $panelIndex => $panel)
                        <div class="list-group-item" data-panel-id="{{ $panel['id'] }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted draggable" title="Drag to reorder" style="cursor: move;">
                                        <i class="ti tabler-grip-vertical"></i>
                                    </span>
                                    <i class="{{ $panel['icon'] ?? '' }} text-primary"></i>
                                    <strong>{{ $panel['type_label'] }}</strong>
                                    <span class="badge bg-{{ $panel['is_active'] ? 'success' : 'secondary' }}">{{ $panel['is_active'] ? 'Active' : 'Inactive' }}</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary"
                                            wire:click="togglePanel({{ $panel['id'] }})">
                                        @if($panel['is_active'])
                                            <i class="ti icon-base tabler-eye-off"></i>
                                        @else
                                            <i class="ti icon-base tabler-eye"></i>
                                        @endif
                                    </button>
                                    <button
                                            class="btn btn-sm btn-outline-info"
                                            data-bs-backdrop="static"
                                            data-bs-keyboard="false"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editItemModal"
                                            wire:click="editPanel({{ $panel['id'] }})">
                                        Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger"
                                            wire:click="deletePanel({{ $panel['id'] }})">Delete
                                    </button>
                                </div>
                            </div>
                            @if($panel['can_have_items'])
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Items</h6>
                                        <div class="d-flex gap-2">
                                            <div class="d-flex flex-column gap-2 w-100">
                                                {{--<div class="d-flex align-items-center gap-2">
                                                    <select class="form-select form-select-sm"
                                                            wire:model="newItemType.{{ $panel['id'] }}"
                                                            style="min-width: 180px;">
                                                        <option value="">Item type...</option>
                                                        @foreach($itemTypes as $type)
                                                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="file" class="form-control form-control-sm"
                                                           wire:model="newItemImage.{{ $panel['id'] }}"
                                                           accept="image/*" style="max-width: 260px;"/>
                                                </div>

                                                <div class="input-group input-group-sm">
                                                    @foreach(LanguageEnum::values() as $lang)
                                                        <input type="text" class="form-control"
                                                               style="max-width: 200px;"
                                                               placeholder="Title ({{ strtoupper($lang) }})"
                                                               wire:model.defer="newItemTitle.{{ $panel['id'] }}.{{ $lang }}">
                                                    @endforeach
                                                </div>

                                                <div class="input-group input-group-sm">
                                                    @foreach(LanguageEnum::values() as $lang)
                                                        <input type="text" class="form-control"
                                                               style="max-width: 260px;"
                                                               placeholder="Description ({{ strtoupper($lang) }})"
                                                               wire:model.defer="newItemContent.{{ $panel['id'] }}.{{ $lang }}">
                                                    @endforeach
                                                </div>

                                                --}}{{-- Per-type fields: icon/name/role etc. --}}{{--
                                                @php $type = $newItemType[$panel['id']] ?? null; @endphp
                                                <div class="row g-2">
                                                    @if($type === 'feature_card')
                                                        <div class="col-auto">
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="Icon class e.g. ti ti-star"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.icon"/>
                                                        </div>
                                                    @elseif($type === 'team_member')
                                                        <div class="col-auto">
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="Name"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.name"/>
                                                        </div>
                                                        @foreach(LanguageEnum::values() as $lang)
                                                            <div class="col-auto">
                                                                <input type="text" class="form-control form-control-sm"
                                                                       placeholder="Role ({{ strtoupper($lang) }})"
                                                                       wire:model.defer="newItemData.{{ $panel['id'] }}.role.{{ $lang }}"/>
                                                            </div>
                                                        @endforeach
                                                    @elseif($type === 'review')
                                                        <div class="col-auto">
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="Name"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.name"/>
                                                        </div>
                                                        <div class="col-auto">
                                                            <input type="number" min="1" max="5"
                                                                   class="form-control form-control-sm"
                                                                   placeholder="Rating"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.rating"/>
                                                        </div>
                                                    @elseif($type === 'gallery_image')
                                                        <div class="col-auto">
                                                            <input type="text" class="form-control form-control-sm"
                                                                   placeholder="Caption"
                                                                   wire:model.defer="newItemData.{{ $panel['id'] }}.caption"/>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="text-end">
                                                    <button class="btn btn-sm btn-primary"
                                                            wire:click="createItem({{ $panel['id'] }})"
                                                            wire:loading.attr="disabled">
                                                        <i class="ti tabler-plus"></i> Add item
                                                    </button>
                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                    @if(empty($panel['items']))
                                        <div class="text-muted small">No items</div>
                                    @else
                                        <ul class="list-group" data-items-sortable="{{ $panel['id'] }}">
                                            @foreach($panel['items'] as $itemIndex => $item)
                                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                                    data-item-id="{{ $item['id'] }}">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="text-muted draggable" title="Drag to reorder"
                                                              style="cursor: move;">
                                                            <i class="ti tabler-grip-vertical"></i>
                                                        </span>
                                                        @if(in_array($item['type'], ['feature_card','team_member','review','gallery_image']))
                                                            <img src="{{ $item['media_url'] ?: asset('assets/img/avatars/1.png') }}"
                                                                 width="40" height="40" class="rounded"
                                                                 style="object-fit: cover;" alt=""/>
                                                        @endif
                                                        <div>
                                                            <div class="fw-medium">{{ $item['title'][app()->getLocale()] ?? '—' }}</div>
                                                            @if(in_array($item['type'], ['feature_card','review','faq_item']))
                                                                <div class="text-muted small">{{ Str::limit($item['content'][app()->getLocale()] ?? '', 80) }}</div>
                                                            @endif
                                                            <span class="badge bg-{{ $item['is_active'] ? 'success' : 'secondary' }}">{{ $item['is_active'] ? 'Active' : 'Inactive' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editItemModal-{{ $item['id'] }}">Edit
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger"
                                                                wire:click="deleteItem({{ $item['id'] }})">Delete
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
    <!-- Edit Item Modal -->
    <div wire:ignore.self class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true"
         aria-labelledby="editItemModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="editItemModalLabel" class="modal-title">Edit Panel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form fields go here -->
                </div>
            </div>
        </div>
    </div>
    @push('page-script')

        <script>
            document.addEventListener('livewire:initialized', () => {
                const makePanelsSortable = () => {
                    const root = document.getElementById('panels-sortable');
                    if (!root || !window.Sortable) return;
                    if (root._sortable) return; // prevent double-init
                    root._sortable = new Sortable(root, {
                        handle: '.draggable',
                        animation: 150,
                        onEnd: function () {
                            const ids = Array.from(root.querySelectorAll('[data-panel-id]')).map(el => parseInt(el.getAttribute('data-panel-id')));
                            $wire.call('reorderPanels', ids);
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
                                $wire.call('reorderItems', panelId, ids);
                            }
                        });
                    });
                }

                // init after DOM paints
                setTimeout(() => {
                    makePanelsSortable();
                    makeItemsSortable();
                }, 100);
                // re-init after Livewire DOM updates
                Livewire.hook('message.processed', () => {
                    setTimeout(() => {
                        makePanelsSortable();
                        makeItemsSortable();
                    }, 50);
                });
            });
        </script>
    @endpush
</div>


