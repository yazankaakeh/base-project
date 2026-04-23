/**
 * TinyMCE – All OSS plugins (ESM, Vite-ready)
 * - No network fetching (icons/theme/model/plugins are bundled)
 * - Multi-editor, RTL, Livewire sync, re-init safe
 */

'use strict';

/* =========================
   Core + Model + Theme + Icons
   ========================= */
import tinymce from 'tinymce/tinymce';
import 'tinymce/models/dom/model';          // prevents model lazy-loading
import 'tinymce/themes/silver';             // UI theme
import 'tinymce/icons/default';             // default icon pack

/* =========================
   Editor CSS
   ========================= */
import 'tinymce/skins/ui/oxide/skin.min.css';              // UI skin
import 'tinymce/skins/content/default/content.min.css';    // content styles

/* =========================
   OSS Plugins (TinyMCE 8.x)
   =========================
   NOTE: This list covers the official open-source plugins published in the tinymce NPM package.
   Premium plugins (PowerPaste, Spell Checker Pro, Export, etc.) are NOT included.
*/
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/autoresize';
import 'tinymce/plugins/autosave';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/code';
import 'tinymce/plugins/codesample';
import 'tinymce/plugins/directionality';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/help';
import 'tinymce/plugins/image';
import 'tinymce/plugins/insertdatetime';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/media';
import 'tinymce/plugins/nonbreaking';
import 'tinymce/plugins/pagebreak';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/quickbars';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/table';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/visualchars';
import 'tinymce/plugins/wordcount';

/* =========================
   Make available globally (optional)
   ========================= */
window.tinymce = tinymce;

// Disable TinyMCE's automatic resource loading to prevent 404 errors
if (window.tinymce) {
  // Override TinyMCE's resource loading to prevent 404 errors
  window.tinymce.Resource = window.tinymce.Resource || {};
  window.tinymce.Resource.load = function() { return Promise.resolve(); };

  // Disable external model loading
  window.tinymce.ModelManager = window.tinymce.ModelManager || {};
  window.tinymce.ModelManager.load = function() { return Promise.resolve(); };

  // Disable external icon loading
  window.tinymce.IconManager = window.tinymce.IconManager || {};
  window.tinymce.IconManager.load = function() { return Promise.resolve(); };

  // Disable license key manager
  window.tinymce.LicenseManager = window.tinymce.LicenseManager || {};
  window.tinymce.LicenseManager.load = function() { return Promise.resolve(); };

  // Override script loading to prevent 404s
  const originalLoadScript = window.tinymce.util.Tools.loadScript;
  window.tinymce.util.Tools.loadScript = function(url, callback) {
    console.log('Blocked script load:', url);
    if (callback) callback();
    return Promise.resolve();
  };
}

/* =========================
   Default Config
   ========================= */
const ALL_PLUGINS = [
  'advlist','anchor','autolink','autoresize','autosave','charmap','code','codesample',
  'directionality','fullscreen','help','image','insertdatetime',
  'link','lists','media','nonbreaking','pagebreak','preview','quickbars','searchreplace',
  'table','visualblocks','visualchars','wordcount'
];

const TOOLBAR_MAIN =
  'undo redo | blocks fontfamily fontsize | ' +
  'bold italic underline strikethrough forecolor backcolor | ' +
  'alignleft aligncenter alignright alignjustify | ' +
  'outdent indent | bullist numlist checklist | ' + // checklist works via lists in v6 UI
  'link image media table | codesample charmap pagebreak | ' +
  'ltr rtl | removeformat | fullscreen preview code help';

const CONTEXT_MENU = 'link image table';

const defaultConfig = {
  selector: '.tinymce-editor',
  height: 400,
  menubar: 'file edit view insert format tools table help',
  plugins: ALL_PLUGINS,
  toolbar: TOOLBAR_MAIN + ' | image',
  // Quickbars (on selection / inline context)
  quickbars_selection_toolbar:
    'bold italic underline | forecolor backcolor | ' +
    'h2 h3 blockquote | bullist numlist | link',
  quickbars_insert_toolbar: 'image media table | pagebreak',
  // Tables
  table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
  // Style inside the editable area with dark/light mode support
  content_style: function() {
    const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark' ||
                   document.body.classList.contains('dark') ||
                   window.matchMedia('(prefers-color-scheme: dark)').matches;

    const baseStyles = 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size:14px; } ' +
      'img { max-width: 100%; height: auto; cursor: pointer; } ' +
      'img:hover { opacity: 0.8; } ' +
      '.img-responsive { max-width: 100%; height: auto; } ' +
      '.img-thumbnail { padding: 4px; line-height: 1.42857143; border-radius: 4px; } ' +
      '.img-rounded { border-radius: 6px; } ' +
      '.img-circle { border-radius: 50%; }';

    if (isDark) {
      return baseStyles +
        'body { background-color: #1a1a1a; color: #e9ecef; } ' +
        '.img-thumbnail { background-color: #2d3748; border: 1px solid #4a5568; } ' +
        'table { border-color: #4a5568; } ' +
        'td, th { border-color: #4a5568; } ' +
        'blockquote { border-left-color: #4a5568; color: #cbd5e0; }';
    } else {
      return baseStyles +
        'body { background-color: #ffffff; color: #212529; } ' +
        '.img-thumbnail { background-color: #fff; border: 1px solid #ddd; } ' +
        'table { border-color: #dee2e6; } ' +
        'td, th { border-color: #dee2e6; } ' +
        'blockquote { border-left-color: #dee2e6; color: #6c757d; }';
    }
  }(),
  // Enhanced theme support for all UI elements
  skin: false,
  content_css: false,
  // Inject comprehensive theme CSS
  setup: function(editor) {
    // Inject theme CSS
    const injectThemeCSS = function() {
      const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark' ||
                     document.body.classList.contains('dark') ||
                     window.matchMedia('(prefers-color-scheme: dark)').matches;

      const existingStyle = document.getElementById('tinymce-theme-css');
      if (existingStyle) {
        existingStyle.remove();
      }

      const style = document.createElement('style');
      style.id = 'tinymce-theme-css';

      if (isDark) {
        style.textContent = `
          /* TinyMCE Dark Theme */
          .tox-tinymce.tinymce-dark,
          .tox-tinymce.tinymce-dark .tox-editor-header,
          .tox-tinymce.tinymce-dark .tox-toolbar,
          .tox-tinymce.tinymce-dark .tox-toolbar__primary,
          .tox-tinymce.tinymce-dark .tox-tbtn,
          .tox-tinymce.tinymce-dark .tox-tbtn--enabled,
          .tox-tinymce.tinymce-dark .tox-tbtn:hover {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e9ecef !important;
          }

          .tox-tinymce.tinymce-dark .tox-tbtn svg {
            fill: #e9ecef !important;
          }

          .tox-tinymce.tinymce-dark .tox-tbtn--enabled,
          .tox-tinymce.tinymce-dark .tox-tbtn--enabled:hover {
            background-color: #4a5568 !important;
          }

          .tox-tinymce.tinymce-dark .tox-edit-area {
            border-color: #4a5568 !important;
          }

          .tox-tinymce.tinymce-dark .tox-statusbar {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e9ecef !important;
          }

          /* Dialog and Popup Dark Theme */
          .tox-dialog.tinymce-dark,
          .tox-pop.tinymce-dark,
          .tox-collection.tinymce-dark,
          .tox-menu.tinymce-dark {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e9ecef !important;
          }

          .tox-dialog.tinymce-dark .tox-dialog__header,
          .tox-dialog.tinymce-dark .tox-dialog__body,
          .tox-dialog.tinymce-dark .tox-dialog__footer {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
            color: #e9ecef !important;
          }

          .tox-dialog.tinymce-dark .tox-textfield,
          .tox-dialog.tinymce-dark .tox-textarea,
          .tox-dialog.tinymce-dark .tox-selectfield select {
            background-color: #1a1a1a !important;
            border-color: #4a5568 !important;
            color: #e9ecef !important;
          }

          .tox-dialog.tinymce-dark .tox-button {
            background-color: #4a5568 !important;
            border-color: #4a5568 !important;
            color: #e9ecef !important;
          }

          .tox-dialog.tinymce-dark .tox-button:hover {
            background-color: #5a6578 !important;
          }

          .tox-dialog.tinymce-dark .tox-button--primary {
            background-color: #3182ce !important;
            border-color: #3182ce !important;
          }

          .tox-dialog.tinymce-dark .tox-button--primary:hover {
            background-color: #2c5aa0 !important;
          }

          /* Table Dialog Dark Theme */
          .tox-dialog.tinymce-dark .tox-table-dialog,
          .tox-dialog.tinymce-dark .tox-table-dialog .tox-table-dialog__grid {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
          }

          .tox-dialog.tinymce-dark .tox-table-dialog .tox-table-dialog__cell {
            border-color: #4a5568 !important;
          }

          .tox-dialog.tinymce-dark .tox-table-dialog .tox-table-dialog__cell:hover {
            background-color: #4a5568 !important;
          }

          /* Image Dialog Dark Theme */
          .tox-dialog.tinymce-dark .tox-image-dialog,
          .tox-dialog.tinymce-dark .tox-image-dialog .tox-image-dialog__preview {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
          }

          /* Link Dialog Dark Theme */
          .tox-dialog.tinymce-dark .tox-link-dialog {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
          }

          /* Color Picker Dark Theme */
          .tox-dialog.tinymce-dark .tox-swatches,
          .tox-dialog.tinymce-dark .tox-swatch {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
          }

          .tox-dialog.tinymce-dark .tox-swatch:hover {
            background-color: #4a5568 !important;
          }

          /* Image Resizing Dark Theme */
          .tox-tinymce.tinymce-dark img[data-mce-resize] {
            outline: 2px dashed #4a5568 !important;
            outline-offset: 2px !important;
          }

          .tox-tinymce.tinymce-dark .tox-image-tools {
            background-color: #2d3748 !important;
            border-color: #4a5568 !important;
          }
        `;
                        } else {
        style.textContent = `
          /* TinyMCE Light Theme */
          .tox-tinymce.tinymce-light,
          .tox-tinymce.tinymce-light .tox-editor-header,
          .tox-tinymce.tinymce-light .tox-toolbar,
          .tox-tinymce.tinymce-light .tox-toolbar__primary,
          .tox-tinymce.tinymce-light .tox-tbtn,
          .tox-tinymce.tinymce-light .tox-tbtn--enabled,
          .tox-tinymce.tinymce-light .tox-tbtn:hover {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
            color: #212529 !important;
          }

          .tox-tinymce.tinymce-light .tox-tbtn svg {
            fill: #212529 !important;
          }

          .tox-tinymce.tinymce-light .tox-tbtn--enabled,
          .tox-tinymce.tinymce-light .tox-tbtn--enabled:hover {
            background-color: #f8f9fa !important;
          }

          .tox-tinymce.tinymce-light .tox-edit-area {
            border-color: #dee2e6 !important;
          }

          .tox-tinymce.tinymce-light .tox-statusbar {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
            color: #212529 !important;
          }

          /* Dialog and Popup Light Theme */
          .tox-dialog.tinymce-light,
          .tox-pop.tinymce-light,
          .tox-collection.tinymce-light,
          .tox-menu.tinymce-light {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
            color: #212529 !important;
          }

          .tox-dialog.tinymce-light .tox-dialog__header,
          .tox-dialog.tinymce-light .tox-dialog__body,
          .tox-dialog.tinymce-light .tox-dialog__footer {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
            color: #212529 !important;
          }

          .tox-dialog.tinymce-light .tox-textfield,
          .tox-dialog.tinymce-light .tox-textarea,
          .tox-dialog.tinymce-light .tox-selectfield select {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
            color: #212529 !important;
          }

          .tox-dialog.tinymce-light .tox-button {
            background-color: #f8f9fa !important;
            border-color: #dee2e6 !important;
            color: #212529 !important;
          }

          .tox-dialog.tinymce-light .tox-button:hover {
            background-color: #e9ecef !important;
          }

          .tox-dialog.tinymce-light .tox-button--primary {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: #ffffff !important;
          }

          .tox-dialog.tinymce-light .tox-button--primary:hover {
            background-color: #0b5ed7 !important;
          }

          /* Table Dialog Light Theme */
          .tox-dialog.tinymce-light .tox-table-dialog,
          .tox-dialog.tinymce-light .tox-table-dialog .tox-table-dialog__grid {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
          }

          .tox-dialog.tinymce-light .tox-table-dialog .tox-table-dialog__cell {
            border-color: #dee2e6 !important;
          }

          .tox-dialog.tinymce-light .tox-table-dialog .tox-table-dialog__cell:hover {
            background-color: #f8f9fa !important;
          }

          /* Image Dialog Light Theme */
          .tox-dialog.tinymce-light .tox-image-dialog,
          .tox-dialog.tinymce-light .tox-image-dialog .tox-image-dialog__preview {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
          }

          /* Link Dialog Light Theme */
          .tox-dialog.tinymce-light .tox-link-dialog {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
          }

          /* Color Picker Light Theme */
          .tox-dialog.tinymce-light .tox-swatches,
          .tox-dialog.tinymce-light .tox-swatch {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
          }

          .tox-dialog.tinymce-light .tox-swatch:hover {
            background-color: #f8f9fa !important;
          }

          /* Image Resizing Light Theme */
          .tox-tinymce.tinymce-light img[data-mce-resize] {
            outline: 2px dashed #007cba !important;
            outline-offset: 2px !important;
          }

          .tox-tinymce.tinymce-light .tox-image-tools {
            background-color: #ffffff !important;
            border-color: #dee2e6 !important;
          }
        `;
      }

      document.head.appendChild(style);
    };

    // Inject initial theme CSS
    injectThemeCSS();

    // Re-inject CSS when theme changes
    const themeObserver = new MutationObserver(function(mutations) {
      mutations.forEach(function(mutation) {
        if (mutation.type === 'attributes' &&
            (mutation.attributeName === 'data-bs-theme' || mutation.attributeName === 'class')) {
          injectThemeCSS();
                        }
                    });
                });

    themeObserver.observe(document.documentElement, { attributes: true });
    themeObserver.observe(document.body, { attributes: true });

    // Editor initialization and content sync
    editor.on('init', function() {
      // Try multiple possible hidden input ID patterns
      const lang = editor.id.replace('editor-', '');
      const possibleIds = [
        `content-${lang}`,
        `postContent-${lang}`,
        `description-${lang}`
      ];

      let hiddenInput = null;
      for (const id of possibleIds) {
        hiddenInput = document.getElementById(id);
        if (hiddenInput) break;
      }

      if (hiddenInput) {
        const content = hiddenInput.value || editor.getContent();
        if (content && content.trim()) {
          editor.setContent(content);
        }
      }
    });

    editor.on('change keyup undo redo', function() {
      // Try multiple possible hidden input ID patterns
      const lang = editor.id.replace('editor-', '');
      const possibleIds = [
        `content-${lang}`,
        `postContent-${lang}`,
        `description-${lang}`
      ];

      let hiddenInput = null;
      for (const id of possibleIds) {
        hiddenInput = document.getElementById(id);
        if (hiddenInput) break;
      }

      if (hiddenInput) {
        hiddenInput.value = editor.getContent();
        console.log(`Updated hidden input ${hiddenInput.id} with content`);

        // Also update the textarea value for wire:model compatibility
        const textarea = editor.getElement();
        if (textarea) {
          textarea.value = editor.getContent();
        }

        // Sync with Livewire if available
        const wireId = editor.getElement().closest('[wire:id]')?.getAttribute('wire:id');
        if (wireId && window.Livewire) {
          const fieldName = editor.id.replace('editor-', '');
          // Try multiple possible Livewire field patterns
          const possibleFields = [
            `content.${fieldName}`,
            `description.${fieldName}`,
            `postContent.${fieldName}`
          ];

          for (const field of possibleFields) {
            try {
              window.Livewire.find(wireId).set(field, editor.getContent());
              console.log(`Successfully synced with Livewire field: ${field}`);
              break; // If successful, stop trying other fields
        } catch (e) {
              console.log(`Failed to sync with Livewire field: ${field}`, e);
              // Continue to next field pattern
            }
          }
        } else {
          console.log('No Livewire component found or Livewire not available');
        }
      } else {
        console.log(`No hidden input found for editor ${editor.id}`);
      }
    });
  },
  branding: false,
  promotion: false,
  resize: true,
  elementpath: true,
  statusbar: true,
  contextmenu: CONTEXT_MENU,
  // Bundle-provided assets (no network fetching)
  icons: 'default',
  // License key for open source usage
  license_key: 'gpl',
  // Disable external resource loading
  base_url: '',
  suffix: '.min',
  // Disable external plugin loading
  external_plugins: {},
  // If you want autoresize behavior (height auto)
  // autoresize_bottom_margin: 20,
  // autosave
  autosave_interval: '30s',
  autosave_retention: '30m',
  // Media defaults
  media_alt_source: false,
  media_poster: false,
  // Image upload configuration
  image_title: true,
  automatic_uploads: true,
  images_upload_url: '/uploads/tinymce',
  images_upload_base_path: '/storage/uploads/tinymce/',
  images_upload_credentials: true,
  file_picker_types: 'image',
  // Image resizing configuration
  image_resize: true,
  image_dimensions: true,
  image_advtab: true,
  image_caption: true,
  image_description: true,
  // Enable native image resizing
  object_resizing: true,
  resize_img_proportional: true,
  image_class_list: [
    {title: 'Responsive', value: 'img-responsive'},
    {title: 'Thumbnail', value: 'img-thumbnail'},
    {title: 'Rounded', value: 'img-rounded'},
    {title: 'Circle', value: 'img-circle'},
    {title: 'No Style', value: ''}
  ],
  file_picker_callback: function (callback, value, meta) {
    if (meta.filetype === 'image') {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');

      input.onchange = function () {
        const file = this.files[0];
        if (file) {
          const formData = new FormData();
          formData.append('file', file);

          // Get CSRF token
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                           document.querySelector('input[name="_token"]')?.value ||
                           window.Laravel?.csrfToken;

          console.log('CSRF Token found:', csrfToken);

          if (!csrfToken) {
            console.error('CSRF token not found');
            return;
          }

          formData.append('_token', csrfToken);

          fetch('/uploads/tinymce', {
            method: 'POST',
            body: formData,
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.location) {
              callback(data.location, { title: file.name, class: 'img-responsive' });
                                    } else {
              console.error('Upload failed:', data.error);
            }
          })
          .catch(error => {
            console.error('Upload error:', error);
          });
        }
      };

    input.click();
}
  },
  // Accessibility & UX
  toolbar_sticky: true,
  // Correct option name (not auto_focus)
  autofocus: false,
  setup(editor) {
    editor.on('init', () => {
      console.log('TinyMCE initialized for:', editor.id);
    });

    // Keep hidden input and Livewire in sync
    editor.on('change keyup undo redo', () => {
      const el = editor.getElement();
      const hiddenInput = document.getElementById(editor.id + '_input');
      if (hiddenInput) hiddenInput.value = editor.getContent();

      // Livewire sync
      if (window.Livewire) {
        const root = el.closest('[wire\\:id]');
        const wireId = root?.getAttribute('wire:id');
        const wireModel =
          el.getAttribute('wire:model') || el.getAttribute('wire:model.live');
        if (wireId && wireModel) {
          Livewire.find(wireId).set(wireModel, editor.getContent());
        }
      }
    });

    // Handle drag and drop for images
    editor.on('drop', function(e) {
      const files = e.dataTransfer.files;
      if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
          e.preventDefault();

          const formData = new FormData();
          formData.append('file', file);

          // Get CSRF token
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                           document.querySelector('input[name="_token"]')?.value ||
                           window.Laravel?.csrfToken;

          console.log('CSRF Token found:', csrfToken);

          if (!csrfToken) {
            console.error('CSRF token not found');
            return;
          }

          formData.append('_token', csrfToken);

          fetch('/uploads/tinymce', {
            method: 'POST',
            body: formData,
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.location) {
              editor.insertContent(`<img src="${data.location}" alt="${file.name}" class="img-responsive" />`);
                                    } else {
              console.error('Upload failed:', data.error);
            }
          })
          .catch(error => {
            console.error('Upload error:', error);
          });
        }
      }
    });

    // Handle paste for images
    editor.on('paste', function(e) {
      const items = e.clipboardData.items;
      for (let i = 0; i < items.length; i++) {
        const item = items[i];
        if (item.type.startsWith('image/')) {
          e.preventDefault();

          const file = item.getAsFile();
          const formData = new FormData();
          formData.append('file', file);

          // Get CSRF token
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                           document.querySelector('input[name="_token"]')?.value ||
                           window.Laravel?.csrfToken;

          console.log('CSRF Token found:', csrfToken);

          if (!csrfToken) {
            console.error('CSRF token not found');
            return;
          }

          formData.append('_token', csrfToken);

          fetch('/uploads/tinymce', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.location) {
              editor.insertContent(`<img src="${data.location}" alt="Pasted image" class="img-responsive" />`);
                                    } else {
              console.error('Upload failed:', data.error);
            }
          })
          .catch(error => {
            console.error('Upload error:', error);
          });
        }
      }
    });

    // Add dynamic image resizing functionality and comprehensive theme support
    editor.on('init', function() {
      // Comprehensive theme detection and application
      const applyThemeToTinyMCE = function() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark' ||
                       document.body.classList.contains('dark') ||
                       window.matchMedia('(prefers-color-scheme: dark)').matches;

        const editorContainer = editor.getContainer();
        const editorBody = editor.getBody();

        // Apply theme to editor container
        if (editorContainer) {
          if (isDark) {
            editorContainer.classList.add('tinymce-dark');
            editorContainer.classList.remove('tinymce-light');
          } else {
            editorContainer.classList.add('tinymce-light');
            editorContainer.classList.remove('tinymce-dark');
          }
        }

        // Apply theme to editor body
        if (editorBody) {
          if (isDark) {
            editorBody.style.backgroundColor = '#1a1a1a';
            editorBody.style.color = '#e9ecef';
          } else {
            editorBody.style.backgroundColor = '#ffffff';
            editorBody.style.color = '#212529';
          }
        }

        // Apply theme to all dialogs and popups
        setTimeout(() => {
          const dialogs = document.querySelectorAll('.tox-dialog, .tox-pop, .tox-collection, .tox-menu');
          dialogs.forEach(dialog => {
            if (isDark) {
              dialog.classList.add('tinymce-dark');
              dialog.classList.remove('tinymce-light');
            } else {
              dialog.classList.add('tinymce-light');
              dialog.classList.remove('tinymce-dark');
            }
          });
        }, 100);
      };

      // Listen for theme changes
      const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.type === 'attributes' &&
              (mutation.attributeName === 'data-bs-theme' || mutation.attributeName === 'class')) {
            applyThemeToTinyMCE();
          }
        });
      });

      observer.observe(document.documentElement, { attributes: true });
      observer.observe(document.body, { attributes: true });

      // Listen for dialog/popup creation
      editor.on('OpenDialog', function() {
        setTimeout(applyThemeToTinyMCE, 50);
      });

      editor.on('CloseDialog', function() {
        setTimeout(applyThemeToTinyMCE, 50);
      });

      // Initial theme setup
      applyThemeToTinyMCE();

      // Enhanced image resizing functionality
      const enhanceImageResizing = function() {
        // Enable native TinyMCE image resizing
        const images = editor.getBody().querySelectorAll('img');
        images.forEach(function(img) {
          // Make images resizable by adding the necessary attributes
          if (!img.hasAttribute('data-mce-resize')) {
            img.setAttribute('data-mce-resize', 'true');
            img.style.cursor = 'move';

            // Add resize indicator
            img.addEventListener('mousedown', function(e) {
              if (e.target === img) {
                img.style.outline = '2px dashed #007cba';
                img.style.outlineOffset = '2px';
              }
            });

            img.addEventListener('mouseup', function(e) {
              if (e.target === img) {
                img.style.outline = 'none';
              }
            });

            // Add context menu for image options
            img.addEventListener('contextmenu', function(e) {
              e.preventDefault();
              editor.execCommand('mceImage');
            });
          }
        });
      };

      // Apply image resizing enhancements
      editor.on('NodeChange', enhanceImageResizing);
      editor.on('SetContent', enhanceImageResizing);
      editor.on('ExecCommand', function(e) {
        if (e.command === 'mceInsertContent' && e.value.includes('<img')) {
          setTimeout(enhanceImageResizing, 100);
        }
      });

    // Initial call
    setTimeout(enhanceImageResizing, 100);

    // Ensure content is synced before form submission
    const form = editor.getElement().closest('form');
    if (form) {
      form.addEventListener('submit', function() {
        // Force sync all TinyMCE editors before form submission
        const allEditors = document.querySelectorAll('.tinymce-editor');
        allEditors.forEach(function(textarea) {
          if (textarea._tinymce) {
            const lang = textarea.id.replace('editor-', '');
            const possibleIds = [
              `content-${lang}`,
              `postContent-${lang}`,
              `description-${lang}`
            ];

            let hiddenInput = null;
            for (const id of possibleIds) {
              hiddenInput = document.getElementById(id);
              if (hiddenInput) break;
            }

            if (hiddenInput) {
              hiddenInput.value = textarea._tinymce.getContent();
              console.log(`Form submission: Synced ${hiddenInput.id} with content`);
            }
          }
        });
      });
    }
  });
  }
};

/* =========================
   Single Editor Init
   ========================= */
async function initSingleEditor(element, options = {}) {
  if (element._tinymce) return element._tinymce;

  // Check if TinyMCE is available
  if (typeof tinymce === 'undefined') {
    console.log('TinyMCE not available, waiting...');
    return new Promise((resolve) => {
      setTimeout(() => {
        initSingleEditor(element, options).then(resolve);
      }, 200);
    });
  }

  // Check if document is ready before initializing
  if (!isDocumentReady()) {
    console.log('Document not ready, waiting...');
    return new Promise((resolve) => {
      waitForDocumentReady(() => {
        initSingleEditor(element, options).then(resolve);
      });
    });
  }

  if (!element.id) {
    element.id = 'tinymce_' + Math.random().toString(36).slice(2, 11);
  }

  const cfg = { ...defaultConfig, target: element, ...options };

  // RTL support
  if (options.rtl || element.dataset.rtl === 'true' || element.getAttribute('dir') === 'rtl') {
    cfg.directionality = 'rtl';
  }

  // Load existing content (from hidden input or data-content)
  const hiddenInputId = element.dataset.input;
        const hiddenInput = hiddenInputId ? document.getElementById(hiddenInputId) : null;
  const existingContent = element.dataset.content;

  if (hiddenInput?.value?.trim()) {
    cfg.init_instance_callback = (ed) => ed.setContent(hiddenInput.value);
  } else if (existingContent?.trim()) {
    cfg.init_instance_callback = (ed) => ed.setContent(existingContent);
  }

  const [editor] = await tinymce.init(cfg);
  element._tinymce = editor;
  element.setAttribute('data-tinymce-initialized', 'true');
  return editor;
}

/* =========================
   Batch Init / Reset (Livewire-safe)
   ========================= */
let editorsInitialized = false;

function initEditors() {
  if (editorsInitialized) return;
  const nodes = document.querySelectorAll('.tinymce-editor:not([data-tinymce-initialized])');
  if (!nodes.length) return;

  nodes.forEach((el) => {
    const rtl = el.dataset.rtl === 'true' || el.getAttribute('dir') === 'rtl';
    initSingleEditor(el, { rtl }).catch((e) => {
      console.error('Failed to init TinyMCE for:', el.id || el.className, e);
    });
  });

  editorsInitialized = true;
}

function resetEditorsInitialization() {
  document.querySelectorAll('.tinymce-editor[data-tinymce-initialized]').forEach((el) => {
    el.removeAttribute('data-tinymce-initialized');
    if (el._tinymce) {
      tinymce.remove(el._tinymce);
      delete el._tinymce;
    }
  });
  editorsInitialized = false;
}

/* =========================
   Lifecycle Hooks
   ========================= */

// Check if document is in standards mode
function isDocumentReady() {
  try {
    return document.readyState === 'complete' &&
           document.documentElement &&
           document.documentElement.nodeType === 1 &&
           document.body &&
           (document.compatMode === 'CSS1Compat' || document.compatMode === 'BackCompat') &&
           typeof tinymce !== 'undefined';
  } catch (e) {
    return false;
  }
}

// Wait for document to be fully ready with timeout
function waitForDocumentReady(callback, maxAttempts = 100) {
  let attempts = 0;

  function checkReady() {
    attempts++;

    if (isDocumentReady()) {
      console.log('Document is ready, initializing TinyMCE');
      callback();
    } else if (attempts < maxAttempts) {
      console.log(`Document not ready, attempt ${attempts}/${maxAttempts}, waiting...`);
      setTimeout(checkReady, 100);
    } else {
      console.warn('Document ready timeout reached, forcing initialization');
      callback();
    }
  }

  checkReady();
}

document.addEventListener('DOMContentLoaded', () => {
  console.log('DOMContentLoaded - Waiting for document ready');
  waitForDocumentReady(() => {
    console.log('Document ready - Initializing editors');
    setTimeout(initEditors, 500); // Increased delay
  });
});

document.addEventListener('livewire:navigated', () => {
  console.log('Livewire navigated - Reinitializing editors');
  resetEditorsInitialization();
  waitForDocumentReady(() => {
    setTimeout(initEditors, 500); // Increased delay
  });
});

document.addEventListener('livewire:initialized', () => {
  // You can emit this from components after DOM updates:
  // $this->dispatch('dom-updated');
  Livewire.on('dom-updated', () => {
    console.log('Livewire dom-updated - Reinitializing editors');
    resetEditorsInitialization();
    waitForDocumentReady(() => {
      setTimeout(initEditors, 500); // Increased delay
    });
  });
});

// Fallback: Initialize on window load if DOMContentLoaded didn't work
window.addEventListener('load', () => {
  console.log('Window load event - Checking if editors need initialization');
  const uninitializedEditors = document.querySelectorAll('.tinymce-editor:not([data-tinymce-initialized])');
  if (uninitializedEditors.length > 0) {
    console.log(`Found ${uninitializedEditors.length} uninitialized editors, initializing...`);
    setTimeout(initEditors, 1000); // Long delay for window load
  }
});

/* =========================
   OPTIONAL: Export helpers
   ========================= */

// Manual initialization function for cases where automatic initialization fails
function manualInitEditors() {
  console.log('Manual initialization triggered');
  resetEditorsInitialization();
  waitForDocumentReady(() => {
    setTimeout(initEditors, 200);
  });
}

// Make manual initialization available globally
window.manualInitTinyMCE = manualInitEditors;

export { initEditors, resetEditorsInitialization, initSingleEditor, manualInitEditors };
