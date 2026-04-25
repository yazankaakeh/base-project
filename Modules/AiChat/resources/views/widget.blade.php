@php
    /** @var array $aiChatConfig */
    $aiChatConfig = $aiChatConfig ?? ['enabled' => false];
@endphp

@if(!empty($aiChatConfig['enabled']))
    <div id="codliy-aichat-root" aria-live="polite">
        <button type="button" id="codliy-aichat-launcher" aria-label="{{ $aiChatConfig['title'] ?? 'Chat with us' }}">
            <span class="codliy-aichat-launcher__icon" aria-hidden="true">
                <i class="ti tabler-messages"></i>
            </span>
            <span class="codliy-aichat-launcher__label">{{ $aiChatConfig['title'] ?? 'Chat' }}</span>
        </button>

        <section id="codliy-aichat-panel" role="dialog" aria-modal="false" aria-labelledby="codliy-aichat-title" hidden>
            <header class="codliy-aichat-panel__header">
                <div>
                    <div
                        class="codliy-aichat-panel__eyebrow">{{ strtoupper($aiChatConfig['provider'] ?? 'assistant') }}</div>
                    <h3 id="codliy-aichat-title"
                        class="codliy-aichat-panel__title">{{ $aiChatConfig['title'] ?? 'Chat with us' }}</h3>
                </div>
                <div class="codliy-aichat-panel__actions">
                    <button type="button" id="codliy-aichat-reset" title="Start a new chat"
                            aria-label="Start a new chat">
                        <i class="ti tabler-refresh"></i>
                    </button>
                    <button type="button" id="codliy-aichat-close" title="Close" aria-label="Close chat">
                        <i class="ti tabler-x"></i>
                    </button>
                </div>
            </header>

            <div id="codliy-aichat-messages" class="codliy-aichat-panel__body" tabindex="0">
                <div class="codliy-aichat-msg codliy-aichat-msg--assistant">
                    <div
                        class="codliy-aichat-msg__bubble">{{ $aiChatConfig['greeting'] ?? 'Hi! How can we help?' }}</div>
                </div>
            </div>

            <form id="codliy-aichat-form" class="codliy-aichat-panel__form" autocomplete="off">
                <label for="codliy-aichat-input" class="visually-hidden">Message</label>
                <textarea
                    id="codliy-aichat-input"
                    name="message"
                    rows="1"
                    maxlength="4000"
                    placeholder="{{ $aiChatConfig['placeholder'] ?? 'Type your message...' }}"
                    required></textarea>
                <button type="submit" id="codliy-aichat-send" aria-label="Send">
                    <i class="ti tabler-send"></i>
                </button>
            </form>
            <div class="codliy-aichat-panel__meta">Powered by {{ $aiChatConfig['provider'] ?? 'AI' }}</div>
        </section>
    </div>

    <style>
        /*
         * Codliy AI Chat widget.
         * Every color routes through --codliy-* tokens so it automatically
         * inherits admin ThemeSetting changes.
         */
        #codliy-aichat-root {
            position: fixed;
            bottom: 80px;
            inset-inline-end: 24px;
            z-index: 9000;
            font-family: var(--codliy-font-family, var(--bs-body-font-family, system-ui, sans-serif));
        }

        #codliy-aichat-launcher {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--codliy-primary-gradient, var(--codliy-primary));
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.7rem 1.1rem;
            border-radius: 999px;
            box-shadow: 0 14px 30px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.35);
            cursor: pointer;
            font-weight: 600;
            letter-spacing: 0.1px;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        #codliy-aichat-launcher:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 36px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.42);
        }

        #codliy-aichat-launcher[data-open="1"] .codliy-aichat-launcher__label {
            display: none;
        }

        .codliy-aichat-launcher__icon {
            font-size: 1.2rem;
            line-height: 1;
            display: inline-flex;
        }

        @media (max-width: 575.98px) {
            .codliy-aichat-launcher__label {
                display: none;
            }

            #codliy-aichat-launcher {
                padding: 0.85rem;
                border-radius: 999px;
            }
        }

        #codliy-aichat-panel {
            position: absolute;
            bottom: 70px;
            inset-inline-end: 0;
            width: min(380px, calc(100vw - 40px));
            height: min(560px, calc(100vh - 140px));
            display: flex;
            flex-direction: column;
            background: rgba(10, 18, 40, 0.96);
            color: var(--codliy-text-soft, #D9D9D9);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: var(--codliy-radius-lg, 18px);
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .codliy-aichat-panel__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            padding: 0.9rem 1rem;
            background: var(--codliy-primary-gradient, var(--codliy-primary));
            color: #fff;
        }

        .codliy-aichat-panel__eyebrow {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.75);
        }

        .codliy-aichat-panel__title {
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
            letter-spacing: -0.2px;
        }

        .codliy-aichat-panel__actions button {
            background: rgba(255, 255, 255, 0.12);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: var(--codliy-radius-sm, 8px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.18s ease;
        }

        .codliy-aichat-panel__actions button:hover {
            background: rgba(255, 255, 255, 0.22);
        }

        .codliy-aichat-panel__body {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .codliy-aichat-msg {
            display: flex;
        }

        .codliy-aichat-msg--user {
            justify-content: flex-end;
        }

        .codliy-aichat-msg__bubble {
            max-width: 85%;
            padding: 0.65rem 0.9rem;
            border-radius: var(--codliy-radius, 14px);
            line-height: 1.5;
            font-size: 0.92rem;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .codliy-aichat-msg--user .codliy-aichat-msg__bubble {
            background: var(--codliy-primary, #0056F8);
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        [dir="rtl"] .codliy-aichat-msg--user .codliy-aichat-msg__bubble {
            border-bottom-right-radius: var(--codliy-radius, 14px);
            border-bottom-left-radius: 4px;
        }

        .codliy-aichat-msg--assistant .codliy-aichat-msg__bubble {
            background: rgba(255, 255, 255, 0.06);
            color: var(--codliy-text-soft, #D9D9D9);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-bottom-left-radius: 4px;
        }

        [dir="rtl"] .codliy-aichat-msg--assistant .codliy-aichat-msg__bubble {
            border-bottom-left-radius: var(--codliy-radius, 14px);
            border-bottom-right-radius: 4px;
        }

        .codliy-aichat-msg--typing .codliy-aichat-msg__bubble {
            display: inline-flex;
            gap: 4px;
            align-items: center;
        }

        .codliy-aichat-msg--typing span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.65);
            animation: codliyAichatDot 1.2s infinite ease-in-out;
        }

        .codliy-aichat-msg--typing span:nth-child(2) {
            animation-delay: 0.15s;
        }

        .codliy-aichat-msg--typing span:nth-child(3) {
            animation-delay: 0.3s;
        }

        @keyframes codliyAichatDot {
            0%, 60%, 100% {
                opacity: 0.3;
                transform: translateY(0);
            }
            30% {
                opacity: 1;
                transform: translateY(-3px);
            }
        }

        .codliy-aichat-panel__form {
            display: flex;
            align-items: flex-end;
            gap: 0.5rem;
            padding: 0.8rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(0, 0, 0, 0.25);
        }

        .codliy-aichat-panel__form textarea {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            color: var(--codliy-text-soft, #D9D9D9);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--codliy-radius, 12px);
            padding: 0.65rem 0.8rem;
            font-size: 0.92rem;
            line-height: 1.45;
            max-height: 140px;
            resize: none;
            outline: none;
            font-family: inherit;
        }

        .codliy-aichat-panel__form textarea:focus {
            border-color: var(--codliy-primary);
            box-shadow: 0 0 0 3px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.18);
        }

        .codliy-aichat-panel__form button {
            background: var(--codliy-primary, #0056F8);
            color: #fff;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: var(--codliy-radius, 12px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
        }

        .codliy-aichat-panel__form button:hover {
            background: var(--codliy-accent, var(--codliy-primary));
        }

        .codliy-aichat-panel__form button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .codliy-aichat-panel__meta {
            text-align: center;
            font-size: 11px;
            color: var(--codliy-text-mute, #8A94B0);
            padding: 0.35rem 0 0.6rem;
            background: rgba(0, 0, 0, 0.25);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* ---------- Light-mode refinement ----------
         * Front-end toggles light/dark via <html data-bs-theme="light|dark">.
         * We keep the dark palette as the default and flip every surface here
         * when the document is light so the widget reads as a crisp card on
         * white instead of a dark glass panel.
         */
        [data-bs-theme="light"] #codliy-aichat-panel,
        [data-layout-mode="light_mode"] #codliy-aichat-panel {
            background: #ffffff;
            color: #0a1220;
            border-color: rgba(10, 31, 77, 0.08);
            box-shadow: 0 24px 60px rgba(10, 31, 77, 0.14),
            0 2px 6px rgba(10, 31, 77, 0.06);
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
        }

        [data-bs-theme="light"] #codliy-aichat-panel a {
            color: var(--codliy-primary, #0056F8);
        }

        [data-bs-theme="light"] .codliy-aichat-msg--assistant .codliy-aichat-msg__bubble,
        [data-layout-mode="light_mode"] .codliy-aichat-msg--assistant .codliy-aichat-msg__bubble {
            background: #F4F6FB;
            color: #0a1220;
            border-color: rgba(10, 31, 77, 0.08);
        }

        [data-bs-theme="light"] .codliy-aichat-panel__form,
        [data-layout-mode="light_mode"] .codliy-aichat-panel__form {
            background: #FAFBFE;
            border-top-color: rgba(10, 31, 77, 0.08);
        }

        [data-bs-theme="light"] .codliy-aichat-panel__form textarea,
        [data-layout-mode="light_mode"] .codliy-aichat-panel__form textarea {
            background: #ffffff;
            color: #0a1220;
            border-color: rgba(10, 31, 77, 0.12);
        }

        [data-bs-theme="light"] .codliy-aichat-panel__form textarea::placeholder,
        [data-layout-mode="light_mode"] .codliy-aichat-panel__form textarea::placeholder {
            color: rgba(10, 31, 77, 0.45);
        }

        /* Bottom "Powered by …" strip — was dark rgba black in the default. */
        [data-bs-theme="light"] .codliy-aichat-panel__meta,
        [data-layout-mode="light_mode"] .codliy-aichat-panel__meta {
            background: #FAFBFE;
            color: rgba(10, 31, 77, 0.55);
            border-top: 1px solid rgba(10, 31, 77, 0.06);
        }

        /* Scrollbar inside the message list — the default webkit shade is too dark on white. */
        [data-bs-theme="light"] .codliy-aichat-panel__body,
        [data-layout-mode="light_mode"] .codliy-aichat-panel__body {
            scrollbar-color: rgba(10, 31, 77, 0.2) transparent;
        }

        [data-bs-theme="light"] .codliy-aichat-panel__body::-webkit-scrollbar,
        [data-layout-mode="light_mode"] .codliy-aichat-panel__body::-webkit-scrollbar {
            width: 8px;
        }

        [data-bs-theme="light"] .codliy-aichat-panel__body::-webkit-scrollbar-thumb,
        [data-layout-mode="light_mode"] .codliy-aichat-panel__body::-webkit-scrollbar-thumb {
            background: rgba(10, 31, 77, 0.18);
            border-radius: 999px;
        }

        [data-bs-theme="light"] .codliy-aichat-panel__body::-webkit-scrollbar-thumb:hover,
        [data-layout-mode="light_mode"] .codliy-aichat-panel__body::-webkit-scrollbar-thumb:hover {
            background: rgba(10, 31, 77, 0.3);
        }

        /* Typing dots read better with a slightly stronger alpha on white. */
        [data-bs-theme="light"] .codliy-aichat-msg--typing span,
        [data-layout-mode="light_mode"] .codliy-aichat-msg--typing span {
            background: rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.55);
        }

        /* Softer launcher shadow in light so it doesn't stamp a blue blob onto a white hero. */
        [data-bs-theme="light"] #codliy-aichat-launcher,
        [data-layout-mode="light_mode"] #codliy-aichat-launcher {
            box-shadow: 0 12px 24px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.28),
            0 2px 4px rgba(10, 31, 77, 0.08);
        }

        [data-bs-theme="light"] #codliy-aichat-launcher:hover,
        [data-layout-mode="light_mode"] #codliy-aichat-launcher:hover {
            box-shadow: 0 16px 30px rgba(var(--codliy-primary-rgb, 0, 86, 248), 0.35),
            0 3px 6px rgba(10, 31, 77, 0.1);
        }

        /* ─── RTL layout ──────────────────────────────────────────────
           The previous override forced the root to `inset-inline-start: 24px`
           (= right:24px in RTL), which kept the launcher on the right. But the
           panel kept `inset-inline-end: 0` which in RTL becomes `left:0` of
           the root — making the 380px panel extend RIGHT off-screen.

           We now let logical properties flip naturally:
             LTR: root right, panel opens leftward  ✓
             RTL: root left,  panel opens rightward ✓
           Both directions render fully inside the viewport and the panel
           always opens INTO the content area, not away from it. --}
        @media (min-width: 576px) {
            [dir="rtl"] #codliy-aichat-root,
            [data-direction="rtl"] #codliy-aichat-root {
                /* Let inset-inline-end flip naturally — remove any legacy override. */
                inset-inline-end: 24px;
                inset-inline-start: auto;
            }
        }

        /* On very narrow screens, clamp the panel's width so it never
           exceeds the viewport regardless of direction. The 16px inner
           padding keeps the panel from touching the edge of the screen. */
        @media (max-width: 575.98px) {
            #codliy-aichat-root {
                bottom: 16px;
                inset-inline-end: 16px;
            }
            #codliy-aichat-panel {
                width: calc(100vw - 32px);
                /* Pin to viewport edge rather than relative-to-root so it
                   can't overflow if the launcher is close to the corner. */
                position: fixed;
                bottom: 84px;
                inset-inline-end: 16px;
                inset-inline-start: auto;
                left: auto;
                right: auto;
            }
            /* Restore the direction-appropriate side for the pinned panel. */
            [dir="ltr"] #codliy-aichat-panel { right: 16px; }
            [dir="rtl"] #codliy-aichat-panel { left: 16px; }
        }

        /* Flip the send-icon in RTL so it points toward the outgoing side. */
        [dir="rtl"] #codliy-aichat-send .ti,
        [data-direction="rtl"] #codliy-aichat-send .ti {
            transform: scaleX(-1);
        }
    </style>

    <script>
        (function () {
            var cfg = @json($aiChatConfig);
            if (!cfg.enabled) return;

            var root = document.getElementById('codliy-aichat-root');
            if (!root) return;
            var launcher = document.getElementById('codliy-aichat-launcher');
            var panel = document.getElementById('codliy-aichat-panel');
            var closeBtn = document.getElementById('codliy-aichat-close');
            var resetBtn = document.getElementById('codliy-aichat-reset');
            var form = document.getElementById('codliy-aichat-form');
            var input = document.getElementById('codliy-aichat-input');
            var sendBtn = document.getElementById('codliy-aichat-send');
            var messages = document.getElementById('codliy-aichat-messages');

            var csrfMeta = document.querySelector('meta[name="csrf-token"]');
            var csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            function escapeHtml(text) {
                return (text || '').replace(/[&<>"']/g, function (c) {
                    return ({'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'})[c];
                });
            }

            function appendMessage(role, content) {
                var wrap = document.createElement('div');
                wrap.className = 'codliy-aichat-msg codliy-aichat-msg--' + role;
                var bubble = document.createElement('div');
                bubble.className = 'codliy-aichat-msg__bubble';
                bubble.innerHTML = escapeHtml(content).replace(/\n/g, '<br>');
                wrap.appendChild(bubble);
                messages.appendChild(wrap);
                messages.scrollTop = messages.scrollHeight;
                return wrap;
            }

            function appendTyping() {
                var wrap = document.createElement('div');
                wrap.className = 'codliy-aichat-msg codliy-aichat-msg--assistant codliy-aichat-msg--typing';
                wrap.innerHTML = '<div class="codliy-aichat-msg__bubble"><span></span><span></span><span></span></div>';
                messages.appendChild(wrap);
                messages.scrollTop = messages.scrollHeight;
                return wrap;
            }

            function togglePanel(open) {
                if (open) {
                    panel.hidden = false;
                    launcher.setAttribute('data-open', '1');
                    setTimeout(function () {
                        input.focus();
                    }, 100);
                    loadHistory();
                } else {
                    panel.hidden = true;
                    launcher.removeAttribute('data-open');
                }
            }

            var historyLoaded = false;

            function loadHistory() {
                if (historyLoaded) return;
                historyLoaded = true;
                fetch(cfg.history_url, {credentials: 'same-origin'})
                    .then(function (r) {
                        return r.ok ? r.json() : {messages: []};
                    })
                    .then(function (data) {
                        if (!data.messages || !data.messages.length) return;
                        // Clear the greeting bubble if we have stored history.
                        messages.innerHTML = '';
                        data.messages.forEach(function (m) {
                            appendMessage(m.role, m.content);
                        });
                    })
                    .catch(function () {
                    });
            }

            launcher.addEventListener('click', function () {
                togglePanel(panel.hidden);
            });
            closeBtn.addEventListener('click', function () {
                togglePanel(false);
            });
            resetBtn.addEventListener('click', function () {
                fetch(cfg.reset_url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json'}
                }).then(function () {
                    messages.innerHTML = '';
                    appendMessage('assistant', cfg.greeting || 'Hi! How can we help?');
                    historyLoaded = true;
                });
            });

            input.addEventListener('input', function () {
                input.style.height = 'auto';
                input.style.height = Math.min(input.scrollHeight, 140) + 'px';
            });
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    form.requestSubmit();
                }
            });

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                var text = (input.value || '').trim();
                if (!text) return;
                sendBtn.disabled = true;
                appendMessage('user', text);
                input.value = '';
                input.style.height = 'auto';
                var typing = appendTyping();

                fetch(cfg.endpoint, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({message: text})
                })
                    .then(function (r) {
                        return r.json().then(function (data) {
                            return {ok: r.ok, data: data};
                        });
                    })
                    .then(function (result) {
                        typing.remove();
                        if (!result.ok) {
                            appendMessage('assistant', result.data && result.data.error
                                ? result.data.error
                                : 'Something went wrong. Please try again.');
                            return;
                        }
                        appendMessage('assistant', result.data.reply || '…');
                    })
                    .catch(function () {
                        typing.remove();
                        appendMessage('assistant', 'Network error — please try again.');
                    })
                    .finally(function () {
                        sendBtn.disabled = false;
                        input.focus();
                    });
            });
        })();
    </script>
@endif
