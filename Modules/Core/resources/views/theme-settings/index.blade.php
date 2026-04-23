@php
    $page = 'theme-settings';
@endphp

@extends('theme::user.layouts.horizontalLayout')

@section('title', trans('core::core.theme_settings.title'))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'], 'build/modules/theme')
    <style>
        .color-preview {
            width: 50px;
            height: 38px;
            border-radius: 0.375rem;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .theme-preview-box {
            border: 2px solid #e0e0e0;
            border-radius: 0.5rem;
            padding: 1rem;
            min-height: 150px;
            background: var(--preview-bg, #f8f7fa);
        }

        /* ─── Scope picker tiles ─────────────────────────────────────── */
        .theme-scope-picker .theme-scope-tile {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 14px;
            transition: all .2s ease;
            background: var(--bs-card-bg, #fff);
            box-shadow: 0 1px 3px rgba(var(--bs-primary-rgb, 0, 86, 248), 0.05);
        }
        .theme-scope-picker .theme-scope-tile:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(var(--bs-primary-rgb, 0, 86, 248), 0.12);
        }
        .theme-scope-picker .nav-link.active .theme-scope-tile {
            border-color: var(--bs-primary);
            background: rgba(var(--bs-primary-rgb, 0, 86, 248), 0.04);
            box-shadow: 0 6px 18px rgba(var(--bs-primary-rgb, 0, 86, 248), 0.18);
        }
        .theme-scope-picker .nav-link { padding: 0; border: 0 !important; background: transparent !important; }
        .theme-scope-picker .nav-link:focus { box-shadow: none; }

        .theme-scope-tile__icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        /* ─── Quick jump navbar ─────────────────────────────────────── */
        .theme-quick-nav {
            position: sticky;
            top: 72px;
            z-index: 5;
            background: var(--bs-body-bg, #fff);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }
        .theme-quick-nav a {
            color: var(--bs-body-color);
            text-decoration: none;
            padding: 0.5rem 0.85rem;
            border-radius: 8px;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: background .15s ease;
        }
        .theme-quick-nav a:hover {
            background: rgba(var(--bs-primary-rgb, 0, 86, 248), 0.08);
            color: var(--bs-primary);
        }

        /* ─── Card headers with accent ──────────────────────────────── */
        .theme-section-card > .card-header {
            background: transparent;
            border-bottom: 1px solid var(--bs-border-color, #e0e0e0);
        }
        .theme-section-card > .card-header h5 {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .theme-section-card > .card-header h5 .theme-section-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(var(--bs-primary-rgb, 0, 86, 248), 0.1);
            color: var(--bs-primary);
            flex-shrink: 0;
        }
        .theme-section-card > .card-header h5 .theme-section-icon i {
            font-size: 18px;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">

            {{-- ══════════════════════════════════════════════════════════ --}}
            {{-- Hero header                                                 --}}
            {{-- ══════════════════════════════════════════════════════════ --}}
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-body py-4"
                     style="background: linear-gradient(135deg,
                        rgba(var(--bs-primary-rgb, 0, 86, 248), 0.08) 0%,
                        rgba(var(--bs-primary-rgb, 0, 86, 248), 0.02) 100%);">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-lg">
                                <span class="avatar-initial rounded-3 bg-primary">
                                    <i class="ti tabler-palette ti-lg"></i>
                                </span>
                            </div>
                            <div>
                                <h4 class="mb-1">{{ trans('core::core.theme_settings.title') }}</h4>
                                <p class="text-muted mb-0 small">
                                    {{ trans('core::core.theme_settings.subtitle') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-label-primary d-inline-flex align-items-center gap-1">
                                <i class="ti tabler-info-circle"></i>
                                {{ __('Live changes apply after save') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════════════ --}}
            {{-- Scope picker — big clickable tiles instead of small tabs   --}}
            {{-- ══════════════════════════════════════════════════════════ --}}
            <ul class="nav theme-scope-picker row g-3 mb-4 list-unstyled" role="tablist">
                <li class="nav-item col-md-6 p-0" role="presentation">
                    <button type="button" class="nav-link active w-100 p-0"
                            data-bs-toggle="tab" data-bs-target="#admin-settings"
                            role="tab" aria-controls="admin-settings" aria-selected="true">
                        <div class="theme-scope-tile d-flex align-items-center gap-3 p-3 p-md-4 text-start">
                            <span class="theme-scope-tile__icon bg-label-info">
                                <i class="ti tabler-layout-dashboard"></i>
                            </span>
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="mb-0 fw-semibold">{{ trans('core::core.theme_settings.admin_theme') }}</h6>
                                <small class="text-muted">{{ __('Dashboard colors, fonts, and layout') }}</small>
                            </div>
                            <i class="ti tabler-chevron-right text-muted"></i>
                        </div>
                    </button>
                </li>
                <li class="nav-item col-md-6 p-0" role="presentation">
                    <button type="button" class="nav-link w-100 p-0"
                            data-bs-toggle="tab" data-bs-target="#website-settings"
                            role="tab" aria-controls="website-settings" aria-selected="false">
                        <div class="theme-scope-tile d-flex align-items-center gap-3 p-3 p-md-4 text-start">
                            <span class="theme-scope-tile__icon bg-label-success">
                                <i class="ti tabler-world"></i>
                            </span>
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="mb-0 fw-semibold">{{ trans('core::core.theme_settings.website_theme') }}</h6>
                                <small class="text-muted">{{ __('Public site branding, landing palette') }}</small>
                            </div>
                            <i class="ti tabler-chevron-right text-muted"></i>
                        </div>
                    </button>
                </li>
            </ul>

            {{-- ══════════════════════════════════════════════════════════ --}}
            {{-- Quick jump bar — anchors within the currently active form  --}}
            {{-- ══════════════════════════════════════════════════════════ --}}
            <div class="theme-quick-nav d-flex flex-wrap align-items-center gap-1 mb-4 px-3 py-2 d-none d-lg-flex">
                <small class="text-muted me-2 ms-2">
                    <i class="ti tabler-list-search"></i>
                    {{ __('Jump to') }}:
                </small>
                <a href="#section-light-colors">
                    <i class="ti tabler-sun"></i>{{ __('Light colors') }}
                </a>
                <a href="#section-dark-colors">
                    <i class="ti tabler-moon"></i>{{ __('Dark colors') }}
                </a>
                <a href="#section-typography">
                    <i class="ti tabler-typography"></i>{{ trans('core::core.theme_settings.typography') }}
                </a>
                <a href="#section-layout">
                    <i class="ti tabler-layout-2"></i>{{ trans('core::core.theme_settings.layout') }}
                </a>
                <a href="#section-branding">
                    <i class="ti tabler-badge"></i>{{ trans('core::core.theme_settings.branding') }}
                </a>
                <a href="#section-advanced">
                    <i class="ti tabler-code"></i>{{ trans('core::core.theme_settings.advanced') }}
                </a>
            </div>

            {{-- ══════════════════════════════════════════════════════════ --}}
            {{-- Tab content — the two form scopes                          --}}
            {{-- ══════════════════════════════════════════════════════════ --}}
            <div class="tab-content">
                <div class="tab-pane fade show active" id="admin-settings" role="tabpanel">
                    @include('core::theme-settings.partials.theme-form', ['settings' => $adminSettings, 'scope' => 'admin'])
                </div>
                <div class="tab-pane fade" id="website-settings" role="tabpanel">
                    @include('core::theme-settings.partials.theme-form', ['settings' => $websiteSettings, 'scope' => 'website'])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Color picker sync (hex text <-> color picker)
            document.querySelectorAll('input[type="color"]').forEach(input => {
                const textInput = document.getElementById(input.id + '_text');
                if (textInput) {
                    input.addEventListener('input', () => textInput.value = input.value);
                    textInput.addEventListener('input', () => {
                        if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(textInput.value)) {
                            input.value = textInput.value;
                        }
                    });
                }
            });

            // Live preview update
            function updatePreview(scope) {
                const form = document.getElementById(`theme-form-${scope}`);
                const preview = document.getElementById(`preview-${scope}`);
                if (!form || !preview) return;

                const primaryColor = form.querySelector('[name="primary_color"]')?.value;
                const bodyBg       = form.querySelector('[name="body_bg"]')?.value;
                const cardBg       = form.querySelector('[name="card_bg"]')?.value;

                if (bodyBg)       preview.style.setProperty('--preview-bg', bodyBg);
                if (cardBg)       { const pc = preview.querySelector('.preview-card'); if (pc) pc.style.background = cardBg; }
                if (primaryColor) { const pb = preview.querySelector('.preview-button'); if (pb) pb.style.background = primaryColor; }
            }

            ['admin', 'website'].forEach(scope => {
                const form = document.getElementById(`theme-form-${scope}`);
                if (!form) return;
                form.querySelectorAll('input[type="color"], input[type="text"]').forEach(input => {
                    input.addEventListener('input', () => updatePreview(scope));
                });
            });
        });
    </script>
@endsection
