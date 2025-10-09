/**
 * Form Editors
 */

'use strict';

(function () {
    /*
        // Snow Theme
        // --------------------------------------------------------------------
        const snowEditor = new Quill('#snow-editor', {
            bounds: '#snow-editor',
            modules: {
                syntax: true,
                toolbar: '#snow-toolbar'
            },
            theme: 'snow'
        });

        // Bubble Theme
        // --------------------------------------------------------------------
        const bubbleEditor = new Quill('#bubble-editor', {
            modules: {
                toolbar: '#bubble-toolbar'
            },
            theme: 'bubble'
        });
    */


    // toolbar shared by all instances
    const fullToolbar = [
        [{font: []}, {size: []}],
        ['bold', 'italic', 'underline', 'strike'],
        [{color: []}, {background: []}],
        [{script: 'super'}, {script: 'sub'}],
        [{header: '1'}, {header: '2'}, 'blockquote', 'code-block'],
        [{list: 'ordered'}, {indent: '-1'}, {indent: '+1'}],
        [{direction: 'rtl'}, {align: []}],
        ['link', 'image', 'video', 'formula'],
        ['clean']
    ];

    const Delta = Quill.import('delta');

    // ----- shared helpers -----
    function uploadToServer(file, uploadUrl) {
        const form = new FormData();
        form.append('image', file);
        return fetch(uploadUrl, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content},
            body: form
        }).then(async (res) => {
            if (!res.ok) throw new Error(await res.text());
            return res.json(); // { url: 'https://...' }
        });
    }

    function selectLocalImage(quill, uploadUrl) {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = async () => {
            const file = input.files?.[0];
            if (!file) return;
            const range = quill.getSelection(true) || {index: quill.getLength(), length: 0};
            quill.insertEmbed(range.index, 'image', '/img/spinner.svg', 'user');
            try {
                const {url} = await uploadToServer(file, uploadUrl);
                quill.deleteText(range.index, 1);
                quill.insertEmbed(range.index, 'image', url, 'user');
                quill.setSelection(range.index + 1, 0, 'user');
            } catch (e) {
                console.error(e);
                quill.deleteText(range.index, 1);
                alert('Image upload failed');
            }
        };
        input.click();
    }

    // ----- universal initializer (works for any element) -----
    function initQuillFor(el) {
        const lang = el.dataset.lang || 'en';
        const uploadUrl = el.dataset.upload || '/quill/upload-image';
        const hidden = document.getElementById(el.dataset.input);
        const isRTL = ['ar', 'fa', 'he', 'ur'].includes(lang);

        const quill = new Quill(el, {
            bounds: el,
            placeholder: 'Type Something...',
            theme: 'snow',
            modules: {
                syntax: true,
                toolbar: {
                    container: fullToolbar,
                    handlers: {
                        image: function () {
                            selectLocalImage(this.quill, uploadUrl);
                        }
                    }
                },
                clipboard: {matchVisual: false}
            }
        });

        // default direction for RTL languages
        if (isRTL) {
            quill.format('direction', 'rtl');
            quill.format('align', 'right');
        }

        // keep hidden input in sync
        quill.on('text-change', () => {
            hidden.value = quill.root.innerHTML;
        });

        // block base64 pastes (force server uploads)
        quill.clipboard.addMatcher('IMG', (node, delta) => {
            const src = node.getAttribute('src') || '';
            if (src.startsWith('data:')) return new Delta();
            return delta;
        });

        // drag & drop upload
        quill.root.addEventListener('drop', async (e) => {
            if (!e.dataTransfer?.files?.length) return;
            const file = e.dataTransfer.files[0];
            if (!file.type?.startsWith('image/')) return;
            e.preventDefault();
            const range = quill.getSelection(true) || {index: quill.getLength(), length: 0};
            quill.insertEmbed(range.index, 'image', '/img/spinner.svg', 'user');
            try {
                const {url} = await uploadToServer(file, uploadUrl);
                quill.deleteText(range.index, 1);
                quill.insertEmbed(range.index, 'image', url, 'user');
                quill.setSelection(range.index + 1, 0, 'user');
            } catch (e2) {
                quill.deleteText(range.index, 1);
                alert('Image upload failed');
            }
        });

        return quill;
    }

    // initialize all editors on the page
    const editors = {};
    document.querySelectorAll('.quill-editor').forEach((el) => {
        const lang = el.dataset.lang || crypto.randomUUID();
        editors[lang] = initQuillFor(el);
    });

    // optional: expose for later access
    window.quillEditors = editors;

    // If editors live inside hidden tabs/modals, re-measure after show:
    document.addEventListener('shown.bs.tab', () => {
        Object.values(window.quillEditors || {}).forEach(q => q?.resize?.());
    });


})();
