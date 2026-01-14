/**
 * TinyMCE Configuration for CMS Pages
 * Similar to blog configuration but optimized for CMS content
 */

// CMS-specific TinyMCE configuration
window.cmsTinyMCEConfig = {
    // Basic configuration
    height: 500,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons',
        'template', 'codesample', 'hr', 'pagebreak', 'nonbreaking', 'toc',
        'imagetools', 'textpattern', 'noneditable', 'quickbars', 'accordion',
        'autosave', 'directionality'
    ],

    // Toolbar configuration
    toolbar: [
        'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview | insertfile image media template link anchor codesample | ltr rtl',
    ],

    // Context menu
    contextmenu: 'link image imagetools table spellchecker',

    // Quickbars
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    quickbars_insert_toolbar: 'quickimage quicktable',

    // Table toolbar
    table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',

    // Content styling
    content_style: function() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark' ||
                      document.body.classList.contains('dark') ||
                      window.matchMedia('(prefers-color-scheme: dark)').matches;

        const baseStyles = `
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                font-size: 14px;
                line-height: 1.6;
                margin: 1rem;
            }
            h1, h2, h3, h4, h5, h6 {
                margin-top: 1.5rem;
                margin-bottom: 0.5rem;
                font-weight: 600;
            }
            p {
                margin-bottom: 1rem;
            }
            img {
                max-width: 100%;
                height: auto;
                border-radius: 0.375rem;
            }
            blockquote {
                border-left: 4px solid #e9ecef;
                padding-left: 1rem;
                margin: 1rem 0;
                font-style: italic;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 1rem 0;
            }
            table th, table td {
                border: 1px solid #dee2e6;
                padding: 0.5rem;
                text-align: left;
            }
            table th {
                background-color: #f8f9fa;
                font-weight: 600;
            }
            .img-responsive {
                max-width: 100%;
                height: auto;
            }
        `;

        if (isDark) {
            return baseStyles + `
                body {
                    background-color: #1a1a1a;
                    color: #e9ecef;
                }
                blockquote {
                    border-left-color: #495057;
                }
                table th, table td {
                    border-color: #495057;
                }
                table th {
                    background-color: #343a40;
                }
            `;
        }

        return baseStyles + `
            body {
                background-color: #ffffff;
                color: #212529;
            }
        `;
    },

    // Image handling
    automatic_uploads: true,
    images_upload_url: '/uploads/tinymce',
    images_upload_base_path: '/storage/uploads/tinymce/',
    images_upload_credentials: true,
    file_picker_types: 'image',

    // File picker callback
    file_picker_callback: function(callback, value, meta) {
        if (meta.filetype === 'image') {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                const file = this.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append('file', file);

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                    document.querySelector('input[name="_token"]')?.value ||
                                    window.Laravel?.csrfToken;

                    if (csrfToken) {
                        formData.append('_token', csrfToken);
                    }

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
                        if (data.success && data.url) {
                            callback(data.url, {
                                title: file.name,
                                alt: file.name
                            });
                        } else {
                            console.error('Upload failed:', data.message);
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

    // Drag and drop image upload
    paste_data_images: true,

    // Image resizing
    object_resizing: true,
    resize_img_proportional: true,

    // Auto-save
    autosave_interval: '30s',
    autosave_retention: '2m',
    autosave_restore_when_empty: true,

    // Spell checker
    browser_spellcheck: true,

    // Word count
    wordcount: {
        show_wordcount: true,
        show_charcount: true,
        show_paragraphs: true,
        show_reading_time: true
    },

    // Setup function
    setup: function(editor) {
        // Theme support
        const applyTheme = () => {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark' ||
                          document.body.classList.contains('dark') ||
                          window.matchMedia('(prefers-color-scheme: dark)').matches;

            const themeClass = isDark ? 'tinymce-dark' : 'tinymce-light';
            editor.getContainer().classList.remove('tinymce-dark', 'tinymce-light');
            editor.getContainer().classList.add(themeClass);

            // Apply theme to editor body
            const body = editor.getBody();
            if (body) {
                body.style.backgroundColor = isDark ? '#1a1a1a' : '#ffffff';
                body.style.color = isDark ? '#e9ecef' : '#212529';
            }
        };

        // Apply theme on init
        editor.on('init', function() {
            applyTheme();
        });

        // Watch for theme changes
        const themeObserver = new MutationObserver(applyTheme);
        themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['data-bs-theme'] });
        themeObserver.observe(document.body, { attributes: true, attributeFilter: ['class'] });

        // Content sync
        editor.on('change keyup undo redo', function() {
            const textarea = editor.getElement();
            const lang = textarea.dataset.lang;
            const inputId = textarea.dataset.input;

            // Find the hidden input
            let hiddenInput = document.getElementById(inputId);
            if (!hiddenInput) {
                const alternativeIds = [
                    `content-${lang}`,
                    `pageContent-${lang}`
                ];

                for (const id of alternativeIds) {
                    hiddenInput = document.getElementById(id);
                    if (hiddenInput) break;
                }
            }

            if (hiddenInput) {
                hiddenInput.value = editor.getContent();
            }

            // Also update the textarea value
            textarea.value = editor.getContent();
        });
    },

    // Init callback
    init_instance_callback: function(editor) {
        console.log('CMS TinyMCE editor initialized:', editor.id);

        // Load existing content
        const textarea = editor.getElement();
        const content = textarea.dataset.content || textarea.value;
        if (content) {
            editor.setContent(content);
        }

        // Form submission sync
        const form = textarea.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                editor.save();
            });
        }
    }
};

// Initialize CMS editors
window.initCMSEditors = function() {
    console.log('initCMSEditors called');
    
    const editors = document.querySelectorAll('.tinymce-editor');
    console.log(`Found ${editors.length} CMS editors to initialize`);

    editors.forEach(element => {
        if (!element.hasAttribute('data-tinymce-initialized')) {
            console.log(`Initializing CMS editor: ${element.id}`);
            
            const config = { ...window.cmsTinyMCEConfig };

            // Set element-specific options
            config.selector = `#${element.id}`;
            config.target = element;

            // Initialize TinyMCE
            tinymce.init(config).then(() => {
                element.setAttribute('data-tinymce-initialized', 'true');
                console.log('CMS editor initialized for:', element.id);
            }).catch(error => {
                console.error('Failed to initialize CMS editor:', element.id, error);
            });
        } else {
            console.log(`CMS editor ${element.id} already initialized`);
        }
    });
};

// Auto-initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded - CMS TinyMCE');
    setTimeout(() => {
        window.initCMSEditors();
    }, 300);
});

// Window load event as fallback
window.addEventListener('load', function() {
    console.log('Window load - CMS TinyMCE');
    setTimeout(() => {
        window.initCMSEditors();
    }, 100);
});

// Livewire integration
document.addEventListener('livewire:navigated', function() {
    console.log('Livewire navigated - CMS TinyMCE');
    setTimeout(() => {
        window.initCMSEditors();
    }, 300);
});

document.addEventListener('livewire:initialized', function() {
    console.log('Livewire initialized - CMS TinyMCE');
    setTimeout(() => {
        window.initCMSEditors();
    }, 300);
});

