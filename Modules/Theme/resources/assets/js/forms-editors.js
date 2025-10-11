/**
 * Form Editors
 */

'use strict';

// --- Imports ---
// You must have these packages installed:
// npm install quill quill-blot-formatter highlight.js
// or
// yarn add quill quill-blot-formatter highlight.js

import Quill from 'quill';
import BlotFormatter from 'quill-blot-formatter';
import hljs from 'highlight.js'; // Import highlight.js
import 'highlight.js/styles/monokai.css'; // Or any other theme you prefer

// Ensure Quill is globally available for any external scripts or legacy code
// if your Vite configuration doesn't do this by default.
window.Quill = window.Quill || Quill;

// --- Quill Module Registrations ---

// 1. BlotFormatter: For image resizing and drag-and-drop functionality
//    This replaces `quill-image-resize-module` and `quill-image-drop-module` for Quill 2.x compatibility.
//    Register it directly after imports to ensure it's available.
Quill.register('modules/blotFormatter', BlotFormatter);

// 2. Syntax: For code block highlighting using highlight.js
//    Quill 2.x has a built-in 'syntax' module that integrates with highlight.js.
//    No explicit Quill.register call needed, just enable in modules config.

// 3. Table: For rich table editing functionality
//    Quill 2.x has a built-in 'table' module.
//    No explicit Quill.register call needed, just enable in modules config.

// --- Modules without direct Quill 2.x plug-and-play alternatives (as of writing) ---
// For 'quill-mention', 'quill-emoji', 'quill-markdown-shortcuts':
// Quill 2.x introduced significant architectural changes. Many Quill 1.x plugins
// are not directly compatible. Robust implementations for these often involve:
// - Custom Quill Blots for UI elements (e.g., mentions, emojis)
// - Integrating external UI libraries (e.g., a React/Vue mention component) that
//   interact with Quill's API to insert content.
// - Custom `text-change` event listeners and Delta operations for markdown shortcuts.
// It's a more involved process than simply registering a plugin.
// For simplicity in this comprehensive setup, we will omit these and provide guidance.
// You would typically add their registration here if compatible Quill 2.x modules exist.


// --- Quill Toolbar Configuration ---
const fullToolbar = [
    [{ font: [] }, { size: [] }],
    ['bold', 'italic', 'underline', 'strike'],
    [{ color: [] }, { background: [] }],
    [{ script: 'super' }, { script: 'sub' }],
    [{ header: '1' }, { header: '2' }, 'blockquote', 'code-block'],
    [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
    [{ direction: 'rtl' }, { align: [] }],
    ['link', 'image', 'video'],
    ['clean'], // Remove formatting button
    ['formula'], // Optional if you need math formulas
    [{ 'table': 'insert' }, { 'table': 'remove' }], // Table options
    [{ 'table-row': 'insert' }, { 'table-row': 'remove' }], // Table row options
    [{ 'table-col': 'insert' }, { 'table-col': 'remove' }] // Table column options
];

// Ensure Delta is imported after Quill is available
const Delta = window.Quill ? Quill.import('delta') : null;

// --- Helper Functions ---

/**
 * Uploads an image file to the server.
 * @param {File} file - The image file to upload.
 * @param {string} uploadUrl - The URL for the image upload endpoint.
 * @returns {Promise<{url: string}>} A promise that resolves with the URL of the uploaded image.
 */
async function uploadToServer(file, uploadUrl) {
    const form = new FormData();
    form.append('image', file);

    // Get CSRF token for Laravel
    const csrfToken = document.querySelector('meta[name="csrf-token"]') ?
                      document.querySelector('meta[name="csrf-token"]').content :
                      '';

    try {
        const response = await fetch(uploadUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                // Do NOT set 'Content-Type': 'multipart/form-data' here,
                // fetch will set it automatically with the correct boundary for FormData.
            },
            body: form
        });

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Image upload failed: ${response.status} - ${errorText}`);
        }

        return response.json(); // Expected: { url: 'https://...' }
    } catch (e) {
        console.error('Error uploading image:', e);
        throw e; // Re-throw to be caught by the caller
    }
}

/**
 * Handles local image selection and upload for Quill.
 * @param {Quill} quill - The Quill instance.
 * @param {string} uploadUrl - The URL for the image upload endpoint.
 */
function selectLocalImage(quill, uploadUrl) {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.classList.add('ql-image'); // Add this class to ensure Quill handles it

    input.onchange = async () => {
        const file = input.files?.[0];
        if (!file) return;

        const range = quill.getSelection(true) || { index: quill.getLength(), length: 0 };
        // Insert a placeholder/spinner while uploading
        quill.insertEmbed(range.index, 'image', '/img/spinner.svg', 'user');

        try {
            const { url } = await uploadToServer(file, uploadUrl);
            // Remove the spinner and insert the actual image
            quill.deleteText(range.index, 1);
            quill.insertEmbed(range.index, 'image', url, 'user');
            quill.setSelection(range.index + 1, 0, 'user'); // Move cursor after the image
        } catch (e) {
            console.error('Image upload failed:', e);
            quill.deleteText(range.index, 1); // Remove spinner on failure
            alert('Image upload failed: ' + e.message);
        }
    };
    input.click();
}


// --- Main Initialization Function ---

/**
 * Initializes Quill editor(s) for the given selector.
 * @param {string} selector - CSS selector for the Quill editor container(s).
 * @param {object} [options={}] - Optional configuration for Quill.
 * @returns {Quill[]} An array of initialized Quill instances.
 */
function initQuill(selector, options = {}) {
    console.log("forms-editors.js: initQuill called for selector:", selector); // Debugging line
    const editorElements = document.querySelectorAll(selector);
    console.log("forms-editors.js: Found editor elements:", editorElements.length, editorElements); // Debugging line
    const quillInstances = [];

    if (!window.Quill) {
        console.error("forms-editors.js: Quill is not globally available when initQuill is called.");
        return [];
    }

    editorElements.forEach((el) => {
        console.log("forms-editors.js: Initializing Quill for element:", el.id || el.className); // Debugging line
        const lang = el.dataset.lang || 'en';
        const uploadUrl = el.dataset.upload || '/quill/upload-image'; // Default upload URL
        const hiddenInputId = el.dataset.input;
        const hiddenInput = hiddenInputId ? document.getElementById(hiddenInputId) : null;
        const isRTL = ['ar', 'fa', 'he', 'ur'].includes(lang);

        // Merge default modules with provided options
        const modules = {
            syntax: {
                highlight: hljs // Use highlight.js for syntax highlighting
            },
            toolbar: {
                container: fullToolbar,
                handlers: {
                    // Custom image handler to trigger our upload logic
                    image: function () {
                        selectLocalImage(this.quill, uploadUrl);
                    }
                }
            },
            clipboard: {
                matchVisual: false // Prevent issues with pasting rich content
            },
            // BlotFormatter for Quill 2.x image resizing and drag/drop
            // Must be enabled here after registration.
            blotFormatter: {},
            // Built-in Quill 2.x table module
            table: true, // Enable Quill's built-in table module
            // For other modules like 'mention', 'emoji', 'markdown-shortcuts':
            // You would enable them here if compatible Quill 2.x modules were registered.
            // Example: mention: { ... config ... },
        };

        const quill = new Quill(el, {
            bounds: el, // Constrain tooltip/toolbar to editor bounds
            placeholder: options.placeholder || 'Type Something...',
            theme: options.theme || 'snow', // 'snow' or 'bubble'
            modules: { ...modules, ...options.modules }, // Merge with custom modules
            readOnly: options.readOnly || false,
        });
        console.log("forms-editors.js: Quill instance created for:", el.id || el.className, quill); // Debugging line

        // Set default text direction for RTL languages
        if (isRTL) {
            quill.format('direction', 'rtl');
            quill.format('align', 'right');
        }

        // Preload existing content from hidden input (for edit forms)
        if (hiddenInput && hiddenInput.value) {
            quill.root.innerHTML = hiddenInput.value;
        }

        // Keep hidden input in sync with Quill's content
        quill.on('text-change', () => {
            if (hiddenInput) {
                hiddenInput.value = quill.root.innerHTML;
            }
        });

        // Block base64 image pastes (force server uploads via our handler)
        if (Delta) { // Check if Delta is available before using
            quill.clipboard.addMatcher('IMG', (node, delta) => {
                const src = node.getAttribute('src') || '';
                if (src.startsWith('data:')) {
                    // console.warn('Blocked base64 image paste. Please upload images via the toolbar.');
                    return new Delta(); // Return an empty delta to remove the image
                }
                return delta;
            });
        }


        // Handle drag & drop file uploads (complementary to BlotFormatter's drag-and-drop for images already in content)
        // This handles dropping a file from outside the editor into the editor.
        quill.root.addEventListener('drop', async (e) => {
            e.preventDefault(); // Prevent default browser handling of dropped files
            e.stopPropagation();

            const files = e.dataTransfer?.files;
            if (!files || files.length === 0) return;

            const imageFile = Array.from(files).find(file => file.type.startsWith('image/'));
            if (!imageFile) return;

            const range = quill.getSelection(true) || { index: quill.getLength(), length: 0 };
            quill.insertEmbed(range.index, 'image', '/img/spinner.svg', 'user'); // Placeholder

            try {
                const { url } = await uploadToServer(imageFile, uploadUrl);
                quill.deleteText(range.index, 1); // Remove placeholder
                quill.insertEmbed(range.index, 'image', url, 'user');
                quill.setSelection(range.index + 1, 0, 'user');
            } catch (e2) {
                console.error('Drag-and-drop image upload failed:', e2);
                quill.deleteText(range.index, 1); // Remove placeholder on error
                alert('Drag-and-drop image upload failed');
            }
        });

        quillInstances.push(quill);
    });

    // Handle tab switching for editor resizing (important for editors in hidden tabs)
    document.addEventListener('shown.bs.tab', () => {
        quillInstances.forEach(q => q?.resize?.());
    });

    return quillInstances;
}

// Auto-initialize Quill editors on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    initQuill('.quill-editor');
});


// --- Example Usage in a Blade File (add this to a <script> section in your Blade view) ---
//
// <div class="card-body">
//     <!-- Editor container -->
//     <div id="editor-en" class="quill-editor"
//          data-lang="en"
//          data-input="postContent-en"
//          data-upload="{{ route('doctor.quillUpload.store') }}"
//          style="min-height: 200px;">
//         <h6>Quill Rich Text Editor</h6>
//         <p>English content...</p>
//     </div>
//     <!-- Hidden input to store Quill's HTML content -->
//     <input type="hidden" name="description[en]" id="postContent-en">
// </div>
//
// <script type="module">
//     // This section is now deprecated as forms-editors.js is self-initializing.
//     // import { initQuill } from '~/Modules/Theme/resources/assets/js/forms-editors.js';
//     // initQuill('.quill-editor');
//
//     // If you need to initialize a specific editor or pass custom options dynamically,
//     // you would export initQuill and call it. For this setup, we assume auto-init.
//     // const mySpecificQuillEditor = initQuill('#my-custom-editor', {
//     //   placeholder: 'Start typing...',
//     //   theme: 'bubble'
//     // });
// </script>
//
//
