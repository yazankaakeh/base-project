/**
 * Form Editors - Quill Implementation
 * Original working implementation
 */

'use strict';

// --- Quill Import ---
import Quill from 'quill/dist/quill';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';

// Import Quill Blot Formatter for image resizing
import QuillBlotFormatter from 'quill-blot-formatter';

// Import Quill Table UI
import QuillTableUI from 'quill-table-ui';

// Make Quill globally available
window.Quill = window.Quill || Quill;

// --- Quill Configuration ---

/**
 * Default Quill configuration
 */
const defaultConfig = {
    theme: 'snow',
    modules: {
        toolbar: [
            [{'header': [1, 2, 3, 4, 5, 6, false]}],
            ['bold', 'italic', 'underline', 'strike'],
            [{'color': []}, {'background': []}],
            [{'list': 'ordered'}, {'list': 'bullet'}],
            [{'indent': '-1'}, {'indent': '+1'}],
            [{'align': []}],
            ['link', 'image', 'video'],
            ['blockquote', 'code-block'],
            ['clean']
        ],
        keyboard: {
            bindings: {
                tab: {
                    key: 9,
                    handler: function (range, context) {
                        return true;
                    }
                }
            }
        }
    },
    placeholder: 'Start writing...'
};

/**
 * Add custom table button to Quill toolbar
 */
function addCustomTableButton(quill) {
    const toolbar = quill.getModule('toolbar');
    const toolbarContainer = toolbar.container;
    
    // Check if table button already exists
    if (toolbarContainer.querySelector('.ql-table')) {
        return; // Button already exists, don't add another one
    }
    
    // Create table button
    const tableButton = document.createElement('button');
    tableButton.type = 'button';
    tableButton.className = 'ql-table';
    tableButton.innerHTML = `
        <svg viewBox="0 0 18 18">
            <rect class="ql-stroke" height="12" width="12" x="3" y="3"></rect>
            <rect class="ql-stroke" height="12" width="12" x="3" y="3"></rect>
            <line class="ql-stroke" x1="9" x2="9" y1="3" y2="15"></line>
            <line class="ql-stroke" x1="3" x2="15" y1="9" y2="9"></line>
        </svg>
    `;
    tableButton.title = 'Insert Table';
    
    // Add click handler
    tableButton.addEventListener('click', function() {
        const range = quill.getSelection();
        if (range) {
            const tableHTML = `
                <table border="1" style="border-collapse: collapse; width: 100%; margin: 10px 0;">
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ccc;">Cell 1</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">Cell 2</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ccc;">Cell 3</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">Cell 4</td>
                    </tr>
                </table>
            `;
            quill.clipboard.dangerouslyPasteHTML(range.index, tableHTML);
        }
    });
    
    // Add button to toolbar (before the clean button)
    const cleanButton = toolbarContainer.querySelector('.ql-clean');
    if (cleanButton) {
        toolbarContainer.insertBefore(tableButton, cleanButton);
    } else {
        toolbarContainer.appendChild(tableButton);
    }
}

/**
 * Initialize Quill for a single element
 */
function initSingleEditor(element, options = {}) {
    try {
        // Check if already initialized
        if (element._quill) {
            console.log('Quill already initialized for element:', element.id || element.className);
            return element._quill;
        }

        console.log('Initializing Quill for element:', element.id || element.className);

        const config = {...defaultConfig, ...options};
        const quill = new Quill(element, config);

        // Add custom table button to toolbar
        addCustomTableButton(quill);

        // Register blot formatter for image resizing
        const blotFormatter = new QuillBlotFormatter(quill);

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
            quill.on('text-change', function () {
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
            quill.on('text-change', function () {
                if (window.Livewire) {
                    Livewire.find(element.closest('[wire:id]').getAttribute('wire:id'))
                        .set(wireModel, quill.root.innerHTML);
                }
            });
        }

        // Store editor instance
        element._quill = quill;

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
    const editors = document.querySelectorAll('.quill-editor:not([data-quill-initialized])');
    editors.forEach((element) => {
        const rtl = element.dataset.rtl === 'true';
        initSingleEditor(element, {rtl});
        // Mark as initialized to prevent double initialization
        element.setAttribute('data-quill-initialized', 'true');
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
