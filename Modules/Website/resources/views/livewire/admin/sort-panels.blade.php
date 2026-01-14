<div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Panels Order</h5>
        </div>
        <div class="card-body">
            <ul id="panels-sortable" class="list-group">
                @foreach($panels as $panel)
                    <li data-id="{{ $panel['id'] }}" class="list-group-item d-flex align-items-center gap-3 p-3 border rounded mb-2">
                        <span class="handle cursor-grab text-muted" style="cursor: move;">
                            <i class="ti tabler-grip-vertical"></i>
                        </span>
                        <div class="flex-grow-1">
                            <span class="fw-medium">{{ $panel['title'] }}</span>
                            <span class="badge bg-{{ $panel['is_active'] ? 'success' : 'secondary' }} ms-2">
                                {{ $panel['is_active'] ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="badge bg-info ms-1">{{ $panel['type']->label() }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" defer></script>
<script>
document.addEventListener('livewire:initialized', () => {
    const el = document.getElementById('panels-sortable');
    if (!el) return;

    new Sortable(el, {
        handle: '.handle',
        animation: 150,
        onEnd: () => {
            const ids = Array.from(el.querySelectorAll('[data-id]')).map(li => li.getAttribute('data-id'));
            window.Livewire.dispatch('panelsReordered', { ids });
        }
    });
});
</script>


