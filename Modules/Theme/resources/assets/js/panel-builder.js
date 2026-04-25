/**
 * Panel Builder for CMS Pages
 * Handles panel creation, editing, reordering via drag-and-drop
 */

class PanelBuilder {
    constructor(pageId = null) {
        this.pageId = pageId;
        this.panels = [];
        this.currentPanelIndex = null;
        this.init();
    }

    init() {
        this.loadPanels();
        this.initSortable();
        this.bindEvents();
    }

    loadPanels() {
        if (!this.pageId) {
            this.renderPanels();
            return;
        }

        fetch(`/cms/panels/panel/${this.pageId}`)
            .then(response => response.json())
            .then(data => {
                this.panels = data.panels || [];
                this.renderPanels();
            })
            .catch(error => {
                console.error('Error loading panels:', error);
                this.renderPanels();
            });
    }

    initSortable() {
        const panelsContainer = document.getElementById('panels-container');
        if (!panelsContainer || typeof Sortable === 'undefined') return;

        Sortable.create(panelsContainer, {
            animation: 150,
            handle: '.panel-drag-handle',
            ghostClass: 'panel-ghost',
            onEnd: (evt) => {
                this.reorderPanels(evt.oldIndex, evt.newIndex);
            }
        });
    }

    bindEvents() {
        // Add panel button
        const addPanelBtn = document.getElementById('add-panel-btn');
        if (addPanelBtn) {
            addPanelBtn.addEventListener('click', () => this.showAddPanelModal());
        }

        // Panel type selection
        document.addEventListener('click', (e) => {
            if (e.target.closest('.panel-type-option')) {
                const panelTypeCard = e.target.closest('.panel-type-option');
                console.log('Panel type clicked:', panelTypeCard.dataset.panelType);
                console.log('Page ID:', this.pageId);
                this.createPanel(panelTypeCard.dataset.panelType);
            }
        });

        // Edit panel
        document.addEventListener('click', (e) => {
            if (e.target.closest('.edit-panel-btn')) {
                const panelId = e.target.closest('.edit-panel-btn').dataset.panelId;
                this.editPanel(panelId);
            }
        });

        // Delete panel
        document.addEventListener('click', (e) => {
            if (e.target.closest('.delete-panel-btn')) {
                const panelId = e.target.closest('.delete-panel-btn').dataset.panelId;
                this.deletePanel(panelId);
            }
        });

        // Toggle panel
        document.addEventListener('click', (e) => {
            if (e.target.closest('.toggle-panel-btn')) {
                const panelId = e.target.closest('.toggle-panel-btn').dataset.panelId;
                this.togglePanel(panelId);
            }
        });

        // Duplicate panel
        document.addEventListener('click', (e) => {
            if (e.target.closest('.duplicate-panel-btn')) {
                const panelId = e.target.closest('.duplicate-panel-btn').dataset.panelId;
                this.duplicatePanel(panelId);
            }
        });

        // Add panel item
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-panel-item-btn')) {
                const panelId = e.target.closest('.add-panel-item-btn').dataset.panelId;
                this.addPanelItem(panelId);
            }
        });

        // Edit panel item
        document.addEventListener('click', (e) => {
            if (e.target.closest('.edit-item-btn')) {
                const btn = e.target.closest('.edit-item-btn');
                const panelId = btn.dataset.panelId;
                const itemId = btn.dataset.itemId;
                this.editPanelItem(panelId, itemId);
            }
        });

        // Delete panel item
        document.addEventListener('click', (e) => {
            if (e.target.closest('.delete-item-btn')) {
                const btn = e.target.closest('.delete-item-btn');
                const panelId = btn.dataset.panelId;
                const itemId = btn.dataset.itemId;
                this.deletePanelItem(panelId, itemId);
            }
        });
    }

    renderPanels() {
        const container = document.getElementById('panels-container');
        if (!container) return;

        if (this.panels.length === 0) {
            const message = !this.pageId
                ? 'Please save the page first before adding panels.'
                : 'No panels yet. Click "Add Panel" to get started.';

            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="ti tabler-layout-grid-add" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">${message}</p>
                </div>
            `;
            return;
        }

        container.innerHTML = this.panels.map(panel => this.renderPanel(panel)).join('');
    }

    renderPanel(panel) {
        const activeClass = panel.is_active ? 'border-primary' : 'border-secondary opacity-50';
        const activeIcon = panel.is_active ? 'tabler-eye' : 'tabler-eye-off';

        return `
            <div class="card mb-3 panel-item ${activeClass}" data-panel-id="${panel.id}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="panel-drag-handle cursor-move me-2">
                            <i class="ti tabler-grip-vertical"></i>
                        </span>
                        <i class="${panel.icon || 'ti tabler-layout'} me-2"></i>
                        <strong>${panel.title?.en || panel.title?.[Object.keys(panel.title || {})[0]] || 'Untitled Panel'}</strong>
                        <span class="badge bg-label-primary ms-2">${panel.type_label}</span>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary toggle-panel-btn"
                                data-panel-id="${panel.id}" title="${panel.is_active ? 'Hide' : 'Show'}">
                            <i class="ti ${activeIcon}"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary edit-panel-btn"
                                data-panel-id="${panel.id}" title="Edit">
                            <i class="ti tabler-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-info duplicate-panel-btn"
                                data-panel-id="${panel.id}" title="Duplicate">
                            <i class="ti tabler-copy"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-danger delete-panel-btn"
                                data-panel-id="${panel.id}" title="Delete">
                            <i class="ti tabler-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    ${panel.items && panel.items.length > 0 ? `
                        <div class="panel-items-list">
                            ${panel.items.map(item => this.renderPanelItem(panel.id, item)).join('')}
                        </div>
                    ` : `
                        <p class="text-muted mb-0">No items in this panel.</p>
                    `}
                    ${panel.can_have_items ? `
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-panel-item-btn"
                                data-panel-id="${panel.id}">
                            <i class="ti tabler-plus"></i> Add Item
                        </button>
                    ` : ''}
                </div>
            </div>
        `;
    }

    renderPanelItem(panelId, item) {
        return `
            <div class="panel-item-card card mb-2" data-item-id="${item.id}">
                <div class="card-body p-2 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fw-bold">${item.title?.en || item.title?.[Object.keys(item.title || {})[0]] || 'Untitled Item'}</span>
                        <span class="badge bg-label-secondary ms-2">${item.type_label}</span>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary edit-item-btn"
                                data-panel-id="${panelId}" data-item-id="${item.id}">
                            <i class="ti tabler-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-danger delete-item-btn"
                                data-panel-id="${panelId}" data-item-id="${item.id}">
                            <i class="ti tabler-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    showAddPanelModal() {
        const modal = document.getElementById('addPanelModal');
        if (modal) {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    }

    createPanel(panelType) {
        console.log('createPanel called with:', panelType);
        console.log('pageId:', this.pageId);

        if (!this.pageId) {
            alert('Please save the page first before adding panels.');
            // Close the modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addPanelModal'));
            if (modal) modal.hide();
            return;
        }

        // Multi-language panel title input
        const titleEn = prompt(`Enter panel title (English):`, `New ${panelType} Panel`);
        if (!titleEn) return;

        const titleAr = prompt('Enter panel title (Arabic) [Optional]:', `لوحة ${panelType} جديدة`) || titleEn;
        const titleTr = prompt('Enter panel title (Turkish) [Optional]:', `Yeni ${panelType} Paneli`) || titleEn;

        const data = {
            page_id: this.pageId,
            type: panelType,
            title: {
                en: titleEn,
                ar: titleAr,
                tr: titleTr
            },
            is_active: true
        };

        console.log('Creating panel with data:', data);
        this.savePanel(data);
    }

    savePanel(data, panelId = null) {
        const url = panelId ? `/cms/panels/panel/${panelId}` : '/cms/panels';
        const method = panelId ? 'PUT' : 'POST';

        console.log('Saving panel to:', url);
        console.log('Request data:', data);

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    this.loadPanels();
                    // Close modal if open
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addPanelModal'));
                    if (modal) modal.hide();
                } else {
                    alert('Error saving panel: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error saving panel:', error);
                alert('Error saving panel. Please try again.');
            });
    }

    editPanel(panelId) {
        // Load panel data and show edit modal
        fetch(`/cms/panels/panel/${panelId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // For now, just reload the page to the edit URL
                    window.location.href = `/cms/panels/${panelId}/edit`;
                } else {
                    alert('Error loading panel data');
                }
            })
            .catch(error => {
                console.error('Error loading panel:', error);
                alert('Error loading panel. Please try again.');
            });
    }

    deletePanel(panelId) {
        if (!confirm('Are you sure you want to delete this panel?')) {
            return;
        }

        fetch(`/cms/panels/${panelId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.loadPanels();
                } else {
                    alert('Error deleting panel: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error deleting panel:', error);
            });
    }

    togglePanel(panelId) {
        fetch(`/cms/panels/${panelId}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.loadPanels();
                }
            })
            .catch(error => {
                console.error('Error toggling panel:', error);
            });
    }

    duplicatePanel(panelId) {
        fetch(`/cms/panels/${panelId}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.loadPanels();
                }
            })
            .catch(error => {
                console.error('Error duplicating panel:', error);
            });
    }

    reorderPanels(oldIndex, newIndex) {
        if (oldIndex === newIndex) return;

        const reorderedPanels = [...this.panels];
        const [movedPanel] = reorderedPanels.splice(oldIndex, 1);
        reorderedPanels.splice(newIndex, 0, movedPanel);

        const panelIds = reorderedPanels.map(panel => panel.id);

        fetch('/cms/panels/reorder', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({panel_ids: panelIds})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.panels = reorderedPanels;
                } else {
                    this.loadPanels(); // Reload on error
                }
            })
            .catch(error => {
                console.error('Error reordering panels:', error);
                this.loadPanels();
            });
    }

    addPanelItem(panelId) {
        // Show add item modal
        console.log('Add item to panel:', panelId);

        // Find the panel to determine its type
        const panel = this.panels.find(p => p.id === parseInt(panelId));
        if (!panel) {
            alert('Panel not found');
            return;
        }

        // Multi-language input
        const titleEn = prompt('Enter item title (English):');
        if (!titleEn) return;

        const titleAr = prompt('Enter item title (Arabic) [Optional]:') || titleEn;
        const titleTr = prompt('Enter item title (Turkish) [Optional]:') || titleEn;

        const contentEn = prompt('Enter item content (English) [Optional]:') || '';
        const contentAr = prompt('Enter item content (Arabic) [Optional]:') || contentEn;
        const contentTr = prompt('Enter item content (Turkish) [Optional]:') || contentEn;

        const itemData = {
            panel_id: panelId,
            type: 'custom', // Default type for panel items
            title: {
                en: titleEn,
                ar: titleAr,
                tr: titleTr
            },
            content: {
                en: contentEn,
                ar: contentAr,
                tr: contentTr
            },
            order: 0,
            is_active: true
        };

        // Save the item
        fetch('/cms/panel-items', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(itemData)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.loadPanels();
                } else {
                    alert('Error adding item: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error adding item:', error);
                alert('Error adding item. Please try again.');
            });
    }

    editPanelItem(panelId, itemId) {
        console.log('Edit item:', itemId, 'in panel:', panelId);

        // Find the panel and item
        const panel = this.panels.find(p => p.id === parseInt(panelId));
        if (!panel || !panel.items) {
            alert('Panel not found');
            return;
        }

        const item = panel.items.find(i => i.id === parseInt(itemId));
        if (!item) {
            alert('Item not found');
            return;
        }

        // Multi-language editing
        const currentTitleEn = item.title?.en || item.title?.[Object.keys(item.title || {})[0]] || '';
        const currentTitleAr = item.title?.ar || '';
        const currentTitleTr = item.title?.tr || '';
        const currentContentEn = item.content?.en || item.content || '';
        const currentContentAr = item.content?.ar || '';
        const currentContentTr = item.content?.tr || '';

        const titleEn = prompt('Edit item title (English):', currentTitleEn);
        if (titleEn === null) return; // User clicked cancel

        const titleAr = prompt('Edit item title (Arabic):', currentTitleAr) || titleEn;
        const titleTr = prompt('Edit item title (Turkish):', currentTitleTr) || titleEn;

        const contentEn = prompt('Edit item content (English):', currentContentEn) || '';
        const contentAr = prompt('Edit item content (Arabic):', currentContentAr) || contentEn;
        const contentTr = prompt('Edit item content (Turkish):', currentContentTr) || contentEn;

        const itemData = {
            title: {
                en: titleEn,
                ar: titleAr,
                tr: titleTr
            },
            content: {
                en: contentEn,
                ar: contentAr,
                tr: contentTr
            }
        };

        fetch(`/cms/panel-items/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(itemData)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.loadPanels();
                } else {
                    alert('Error updating item: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error updating item:', error);
                alert('Error updating item. Please try again.');
            });
    }

    deletePanelItem(panelId, itemId) {
        if (!confirm('Are you sure you want to delete this item?')) {
            return;
        }

        fetch(`/cms/panel-items/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.loadPanels();
                } else {
                    alert('Error deleting item: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error deleting item:', error);
                alert('Error deleting item. Please try again.');
            });
    }
}

// Initialize panel builder when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
    const pageIdElement = document.querySelector('[data-page-id]');
    const pageId = pageIdElement ? pageIdElement.dataset.pageId : null;

    if (document.getElementById('panels-container')) {
        window.panelBuilder = new PanelBuilder(pageId);
    }
});

// Export for use in other scripts
window.PanelBuilder = PanelBuilder;
