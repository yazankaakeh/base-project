<div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Panel Items Order</h5>
        </div>
        <div class="card-body">
            <ul id="panel-items-sortable" class="list-group" data-panel-id="{{ $panelId }}">
                @foreach($items as $item)
                    <li data-id="{{ $item['id'] }}" class="list-group-item d-flex align-items-center gap-3 p-3 border rounded mb-2">
                        <span class="handle cursor-grab text-muted" style="cursor: move;">
                            <i class="ti tabler-grip-vertical"></i>
                        </span>
                        <div class="flex-grow-1">
                            <span class="fw-medium">{{ $item['title'] }}</span>
                            <span class="badge bg-{{ $item['is_active'] ? 'success' : 'secondary' }} ms-2">
                                {{ $item['is_active'] ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="badge bg-info ms-1">{{ $item['type']->label() }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" defer></script>
<script>
document.addEventListener('livewire:initialized', function() {
    const el = document.getElementById('panel-items-sortable');
    if (!el) return;

    new Sortable(el, {
        handle: '.handle',
        animation: 150,
        onEnd: function() {
            const ids = Array.from(el.querySelectorAll('[data-id]')).map(function(li) {
                return li.getAttribute('data-id');
            });
            const panelId = el.getAttribute('data-panel-id');
            window.Livewire.dispatch('panelItemsReordered', { panelId: panelId, ids: ids });
        }
    });
});
</script>
