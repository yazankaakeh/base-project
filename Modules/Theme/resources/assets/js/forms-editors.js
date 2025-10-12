/**
 * Form Editors - Quill Implementation
 * Enhanced implementation with table support and theme awareness
 */

'use strict';

// --- Quill Import ---
import Quill from 'quill/dist/quill';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';

// Import Quill Blot Formatter for image resizing
import QuillBlotFormatter from 'quill-blot-formatter';

// Make Quill globally available
window.Quill = window.Quill || Quill;

// --- Quill Configuration ---

/**
 * Default Quill configuration
 */
const defaultConfig = {
    theme: 'snow',
    modules: {
        toolbar: {
            container: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['blockquote', 'code-block'],
                ['clean']
            ],
            handlers: {
                'image': imageHandler,
                'table': tableHandler
            }
        },
        table: true,
        keyboard: {
            bindings: {
                tab: {
                    key: 9,
                    handler: function(range, context) {
                        return true;
                    }
                }
            }
        }
    },
    placeholder: 'Start writing...'
};

/**
 * Image handler for Quill
 */
function imageHandler() {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.click();

    input.onchange = function() {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const range = this.quill.getSelection();
                this.quill.insertEmbed(range.index, 'image', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    };
}

/**
 * Table handler for Quill
 */
function tableHandler() {
    showTableDialog();
}

/**
 * Show table insertion dialog
 */
function showTableDialog() {
    // Create modal backdrop
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    backdrop.style.zIndex = '1055';
    document.body.appendChild(backdrop);

    // Create modal
    const modal = document.createElement('div');
    modal.className = 'modal fade show';
    modal.style.display = 'block';
    modal.style.zIndex = '1056';
    modal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Insert Table</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Select table size:</p>
                    <div class="table-grid-selector" style="display: grid; grid-template-columns: repeat(10, 1fr); gap: 2px; max-width: 300px;">
                        ${Array.from({length: 100}, (_, i) => {
                            const row = Math.floor(i / 10) + 1;
                            const col = (i % 10) + 1;
                            return `<div class="table-cell" data-row="${row}" data-col="${col}" style="width: 20px; height: 20px; border: 1px solid #ddd; cursor: pointer; background: #f8f9fa;"></div>`;
                        }).join('')}
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">Selected: <span id="table-size">1x1</span></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="insert-table-btn">Insert Table</button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    // Add event listeners
    let selectedRows = 1, selectedCols = 1;
    const cells = modal.querySelectorAll('.table-cell');
    const sizeDisplay = modal.querySelector('#table-size');
    const insertBtn = modal.querySelector('#insert-table-btn');

    cells.forEach(cell => {
        cell.addEventListener('mouseenter', function() {
            const row = parseInt(this.dataset.row);
            const col = parseInt(this.dataset.col);
            
            // Clear previous selection
            cells.forEach(c => c.style.background = '#f8f9fa');
            
            // Highlight selected area
            cells.forEach(c => {
                const cRow = parseInt(c.dataset.row);
                const cCol = parseInt(c.dataset.col);
                if (cRow <= row && cCol <= col) {
                            c.style.background = '#007bff';
                }
            });
            
            selectedRows = row;
            selectedCols = col;
            sizeDisplay.textContent = `${row}x${col}`;
        });

        cell.addEventListener('click', function() {
            insertTableHTML(selectedRows, selectedCols);
            closeModal();
        });
    });

    insertBtn.addEventListener('click', function() {
        insertTableHTML(selectedRows, selectedCols);
        closeModal();
    });

    // Close modal handlers
    function closeModal() {
        document.body.removeChild(backdrop);
        document.body.removeChild(modal);
    }

    modal.querySelector('.btn-close').addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);
}

/**
 * Insert table HTML into Quill editor
 */
function insertTableHTML(rows, cols) {
    const tableHTML = `
        <table class="table table-bordered" style="width: 100%;">
            <tbody>
                ${Array.from({length: rows}, () => 
                    `<tr>${Array.from({length: cols}, () => '<td>&nbsp;</td>').join('')}</tr>`
                ).join('')}
            </tbody>
        </table>
    `;
    
    const range = this.quill.getSelection();
    if (range) {
        this.quill.clipboard.dangerouslyPasteHTML(range.index, tableHTML);
    }
}

/**
 * Apply theme-aware styling to Quill editor
 */
function applyThemeStyling(quill) {
    const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark' ||
                      document.body.classList.contains('dark') ||
                      document.body.classList.contains('theme-dark') ||
                      document.body.classList.contains('dark-mode');

    const editorElement = quill.container;
    
    if (isDarkMode) {
        editorElement.classList.add('quill-dark');
    } else {
        editorElement.classList.add('quill-light');
    }

    // Inject theme-specific CSS
    injectThemeCSS();
}

/**
 * Inject theme-specific CSS for Quill
 */
function injectThemeCSS() {
    if (document.getElementById('quill-theme-css')) {
        return;
    }

    const style = document.createElement('style');
    style.id = 'quill-theme-css';
    style.textContent = `
        /* Light theme styles */
        .quill-light .ql-editor {
            background: var(--bs-body-bg, #ffffff) !important;
            color: var(--bs-body-color, #212529) !important;
        }

        .quill-light .ql-toolbar {
            background: var(--bs-body-bg, #ffffff) !important;
            border-color: var(--bs-border-color, #dee2e6) !important;
        }

        .quill-light .ql-container {
            border-color: var(--bs-border-color, #dee2e6) !important;
        }

        /* Dark theme styles */
        .quill-dark .ql-editor {
            background: var(--bs-dark, #212529) !important;
            color: var(--bs-light, #f8f9fa) !important;
        }

        .quill-dark .ql-toolbar {
            background: var(--bs-dark, #212529) !important;
            border-color: var(--bs-border-color, #495057) !important;
        }

        .quill-dark .ql-container {
            border-color: var(--bs-border-color, #495057) !important;
        }

        .quill-dark .ql-toolbar .ql-stroke {
            stroke: var(--bs-light, #f8f9fa) !important;
        }

        .quill-dark .ql-toolbar .ql-fill {
            fill: var(--bs-light, #f8f9fa) !important;
        }

        .quill-dark .ql-toolbar button:hover {
            background: var(--bs-secondary, #6c757d) !important;
        }

        .quill-dark .ql-toolbar button.ql-active {
            background: var(--bs-primary, #0d6efd) !important;
        }

        /* Table styles */
        .ql-editor table {
            border-collapse: collapse;
            width: 100%;
        }

        .ql-editor table td,
        .ql-editor table th {
            border: 1px solid var(--bs-border-color, #dee2e6);
            padding: 8px;
        }

        .quill-dark .ql-editor table td,
        .quill-dark .ql-editor table th {
            border-color: var(--bs-border-color, #495057);
        }
    `;

    document.head.appendChild(style);
}

/**
 * Add theme change listener
 */
function addThemeChangeListener(quill) {
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' &&
                (mutation.attributeName === 'data-bs-theme' ||
                 mutation.attributeName === 'class')) {
                updateEditorTheme(quill);
            }
        });
    });

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['data-bs-theme', 'class']
    });

    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });

    quill._themeObserver = observer;
}

/**
 * Update editor theme
 */
function updateEditorTheme(quill) {
    const editorElement = quill.container;
    const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark' ||
                      document.body.classList.contains('dark') ||
                      document.body.classList.contains('theme-dark') ||
                      document.body.classList.contains('dark-mode');

    editorElement.classList.remove('quill-dark', 'quill-light');

    if (isDarkMode) {
        editorElement.classList.add('quill-dark');
    } else {
        editorElement.classList.add('quill-light');
    }
}

/**
 * Initialize Quill for a single element
 */
function initSingleEditor(element, options = {}) {
    try {
        console.log('Initializing Quill for element:', element.id || element.className);

        const config = { ...defaultConfig, ...options };
        const quill = new Quill(element, config);

        // Apply theme-aware styling
        applyThemeStyling(quill);

        // Set RTL direction if specified
        if (options.rtl || element.dataset.rtl === 'true') {
            quill.root.setAttribute('dir', 'rtl');
        }

        // Sync with hidden input if specified
        const hiddenInputId = element.dataset.input;
        const hiddenInput = hiddenInputId ? document.getElementById(hiddenInputId) : null;

        if (hiddenInput) {
            // Load existing content
            if (hiddenInput.value) {
            quill.root.innerHTML = hiddenInput.value;
        }

            // Sync changes to hidden input
            quill.on('text-change', function() {
                hiddenInput.value = quill.root.innerHTML;
            });
        }

        // Load existing content from data-content attribute
        const existingContent = element.dataset.content;
        if (existingContent) {
            quill.root.innerHTML = existingContent;
        }

        // Livewire integration if wire:model is present
        if (element.hasAttribute('wire:model') || element.hasAttribute('wire:model.live')) {
            const wireModel = element.getAttribute('wire:model') || element.getAttribute('wire:model.live');
            
            // Set initial data for Livewire
            if (element.dataset.initialValue) {
                quill.root.innerHTML = element.dataset.initialValue;
            }

            // Update Livewire model on editor change
            quill.on('text-change', function() {
                if (window.Livewire) {
                    Livewire.find(element.closest('[wire:id]').getAttribute('wire:id'))
                        .set(wireModel, quill.root.innerHTML);
                }
            });
        }

        // Add theme change listener
        addThemeChangeListener(quill);

        // Store editor instance
        element._quill = quill;

        // Add cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (quill._themeObserver) {
                quill._themeObserver.disconnect();
            }
        });

        console.log('Quill initialized successfully for:', element.id || element.className);
        return quill;

    } catch (error) {
        console.error('Error initializing Quill:', error);
        throw error;
    }
}

/**
 * Initialize Quill for multiple elements
 */
function initEditors() {
    const editors = document.querySelectorAll('.quill-editor');
    editors.forEach((element) => {
        const rtl = element.dataset.rtl === 'true';
        initSingleEditor(element, { rtl });
    });
}

// Initialize editors on DOMContentLoaded
document.addEventListener('DOMContentLoaded', initEditors);

// Re-initialize editors after Livewire updates
document.addEventListener('livewire:navigated', initEditors);
document.addEventListener('livewire:initialized', () => {
    Livewire.on('dom-updated', () => {
        initEditors();
    });
});