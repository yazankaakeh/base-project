{{-- Shared Panel Styles - Modern, RTL/LTR, Responsive, Uses Theme Settings --}}
<style>
    :root {
        /* Use Bootstrap theme variables from theme_settings */
        --panel-primary: var(--bs-primary, #1EAAE7);
        --panel-primary-rgb: var(--bs-primary-rgb, 30, 170, 231);
        --panel-secondary: var(--bs-secondary, #092C4C);
        --panel-secondary-rgb: var(--bs-secondary-rgb, 9, 44, 76);
        --panel-success: var(--bs-success, #28C76F);
        --panel-success-rgb: var(--bs-success-rgb, 40, 199, 111);
        --panel-warning: var(--bs-warning, #FF9900);
        --panel-warning-rgb: var(--bs-warning-rgb, 255, 153, 0);
        --panel-danger: var(--bs-danger, #FF0000);
        --panel-danger-rgb: var(--bs-danger-rgb, 255, 0, 0);
        --panel-info: var(--bs-info, #17a2b8);
        --panel-info-rgb: var(--bs-info-rgb, 23, 162, 184);
        --panel-light: var(--bs-light, #f8f9fa);
        --panel-dark: var(--bs-dark, #29344a);
        --panel-body-bg: var(--bs-body-bg, #ffffff);
        --panel-card-bg: var(--bs-card-bg, #ffffff);

        /* Panel-specific design tokens */
        --panel-gray: #67748E;
        --panel-gray-light: #f8fafc;
        --panel-radius: var(--bs-border-radius, 12px);
        --panel-radius-lg: 20px;
        --panel-shadow: 0 10px 40px rgba(var(--panel-secondary-rgb), 0.12);
        --panel-shadow-hover: 0 20px 60px rgba(var(--panel-secondary-rgb), 0.18);
        --panel-transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Dark Mode Support */
    [data-bs-theme="dark"] {
        --panel-gray: #9aa4b8;
        --panel-gray-light: #1a1a2e;
    }

    /* Section Base */
    .panel-section {
        position: relative;
        padding: 80px 0;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .panel-section {
            padding: 50px 0;
        }
    }

    /* Section Header */
    .panel-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .panel-badge {
        display: inline-block;
        padding: 8px 20px;
        font-size: 0.875rem;
        font-weight: 600;
        border-radius: 50px;
        background: rgba(var(--panel-primary-rgb), 0.1);
        color: var(--panel-primary);
        margin-bottom: 16px;
        animation: fadeInDown 0.6s ease;
    }

    .panel-title {
        font-size: clamp(1.75rem, 4vw, 2.75rem);
        font-weight: 700;
        color: var(--panel-secondary);
        margin-bottom: 16px;
        line-height: 1.2;
    }

    [data-bs-theme="dark"] .panel-title {
        color: #fff;
    }

    .panel-title.text-white {
        color: #fff !important;
    }

    .panel-description {
        font-size: 1.1rem;
        color: var(--panel-gray);
        max-width: 650px;
        margin-inline: auto;
        line-height: 1.7;
    }

    /* Cards */
    .panel-card {
        background: var(--panel-card-bg);
        border-radius: var(--panel-radius);
        box-shadow: var(--panel-shadow);
        transition: var(--panel-transition);
        height: 100%;
        border: none;
        overflow: hidden;
    }

    .panel-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--panel-shadow-hover);
    }

    .panel-card-body {
        padding: 30px;
    }

    /* Icon Box */
    .panel-icon-box {
        width: 70px;
        height: 70px;
        border-radius: var(--panel-radius);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(var(--panel-primary-rgb), 0.15), rgba(var(--panel-primary-rgb), 0.05));
        color: var(--panel-primary);
        font-size: 1.75rem;
        margin-bottom: 20px;
        transition: var(--panel-transition);
    }

    .panel-card:hover .panel-icon-box {
        background: var(--panel-primary);
        color: #fff;
        transform: scale(1.1) rotate(5deg);
    }

    /* Gradient Backgrounds - Using theme colors */
    .panel-gradient-primary {
        background: linear-gradient(135deg, var(--panel-secondary) 0%, color-mix(in srgb, var(--panel-secondary) 70%, var(--panel-primary)) 40%, var(--panel-primary) 100%);
    }

    .panel-gradient-secondary {
        background: linear-gradient(180deg, var(--panel-secondary) 0%, color-mix(in srgb, var(--panel-secondary) 80%, var(--panel-primary)) 100%);
    }

    /* Fallback for browsers without color-mix */
    @supports not (background: color-mix(in srgb, red, blue)) {
        .panel-gradient-primary {
            background: linear-gradient(135deg, var(--panel-secondary) 0%, #0d3a5c 40%, var(--panel-primary) 100%);
        }
        .panel-gradient-secondary {
            background: linear-gradient(180deg, var(--panel-secondary) 0%, #14466a 100%);
        }
    }

    /* Pattern Overlay */
    .panel-pattern {
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    /* Floating Shapes */
    .panel-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(var(--panel-primary-rgb), 0.1);
        animation: float 6s ease-in-out infinite;
        pointer-events: none;
    }

    .panel-shape-1 {
        width: 200px;
        height: 200px;
        top: -50px;
        inset-inline-end: -50px;
        animation-delay: 0s;
    }

    .panel-shape-2 {
        width: 150px;
        height: 150px;
        bottom: -30px;
        inset-inline-start: 10%;
        animation-delay: 2s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Animate on scroll */
    .panel-animate {
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .panel-animate:nth-child(1) { animation-delay: 0.1s; }
    .panel-animate:nth-child(2) { animation-delay: 0.2s; }
    .panel-animate:nth-child(3) { animation-delay: 0.3s; }
    .panel-animate:nth-child(4) { animation-delay: 0.4s; }
    .panel-animate:nth-child(5) { animation-delay: 0.5s; }
    .panel-animate:nth-child(6) { animation-delay: 0.6s; }
    .panel-animate:nth-child(7) { animation-delay: 0.7s; }
    .panel-animate:nth-child(8) { animation-delay: 0.8s; }

    /* Buttons */
    .panel-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: var(--panel-transition);
        text-decoration: none;
        border: 2px solid transparent;
        cursor: pointer;
    }

    .panel-btn-primary {
        background: var(--panel-primary);
        color: #fff;
    }

    .panel-btn-primary:hover {
        background: color-mix(in srgb, var(--panel-primary) 85%, black);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(var(--panel-primary-rgb), 0.4);
    }

    @supports not (background: color-mix(in srgb, red, blue)) {
        .panel-btn-primary:hover {
            filter: brightness(0.9);
        }
    }

    .panel-btn-secondary {
        background: var(--panel-secondary);
        color: #fff;
    }

    .panel-btn-secondary:hover {
        background: color-mix(in srgb, var(--panel-secondary) 85%, black);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(var(--panel-secondary-rgb), 0.4);
    }

    .panel-btn-outline {
        background: transparent;
        border-color: rgba(255,255,255,0.3);
        color: #fff;
    }

    .panel-btn-outline:hover {
        background: #fff;
        color: var(--panel-secondary);
        border-color: #fff;
    }

    .panel-btn-outline-primary {
        background: transparent;
        border-color: var(--panel-primary);
        color: var(--panel-primary);
    }

    .panel-btn-outline-primary:hover {
        background: var(--panel-primary);
        color: #fff;
        border-color: var(--panel-primary);
    }

    /* Avatar */
    .panel-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .panel-avatar-lg {
        width: 120px;
        height: 120px;
        border-width: 4px;
    }

    .panel-avatar-placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--panel-primary), color-mix(in srgb, var(--panel-primary) 80%, var(--panel-secondary)));
        color: #fff;
        font-weight: 700;
        font-size: 1.5rem;
    }

    @supports not (background: color-mix(in srgb, red, blue)) {
        .panel-avatar-placeholder {
            background: linear-gradient(135deg, var(--panel-primary), #1899d0);
        }
    }

    /* Stars Rating */
    .panel-stars {
        display: flex;
        gap: 4px;
        color: var(--panel-warning);
    }

    .panel-stars i {
        font-size: 1.1rem;
    }

    /* Accordion Custom */
    .panel-accordion .accordion-item {
        border: none;
        background: var(--panel-card-bg);
        border-radius: var(--panel-radius) !important;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(var(--panel-secondary-rgb), 0.06);
        overflow: hidden;
        transition: var(--panel-transition);
    }

    .panel-accordion .accordion-item:hover {
        box-shadow: 0 8px 30px rgba(var(--panel-secondary-rgb), 0.1);
    }

    .panel-accordion .accordion-button {
        padding: 20px 24px;
        font-weight: 600;
        font-size: 1.05rem;
        color: var(--panel-secondary);
        background: var(--panel-card-bg);
        border: none;
        box-shadow: none !important;
    }

    [data-bs-theme="dark"] .panel-accordion .accordion-button {
        color: #fff;
    }

    .panel-accordion .accordion-button:not(.collapsed) {
        color: var(--panel-primary);
        background: rgba(var(--panel-primary-rgb), 0.05);
    }

    .panel-accordion .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='currentColor'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        width: 1.25rem;
        height: 1.25rem;
        transition: var(--panel-transition);
        filter: none;
    }

    .panel-accordion .accordion-button:not(.collapsed)::after {
        filter: invert(58%) sepia(98%) saturate(2056%) hue-rotate(165deg) brightness(95%) contrast(88%);
    }

    .panel-accordion .accordion-body {
        padding: 0 24px 24px;
        color: var(--panel-gray);
        line-height: 1.7;
    }

    /* Gallery */
    .panel-gallery-item {
        position: relative;
        border-radius: var(--panel-radius);
        overflow: hidden;
        cursor: pointer;
        aspect-ratio: 1;
    }

    .panel-gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--panel-transition);
    }

    .panel-gallery-item:hover img {
        transform: scale(1.1);
    }

    .panel-gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(var(--panel-secondary-rgb), 0.9) 0%, transparent 70%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 20px;
        opacity: 0;
        transition: var(--panel-transition);
    }

    .panel-gallery-item:hover .panel-gallery-overlay {
        opacity: 1;
    }

    .panel-gallery-overlay h6,
    .panel-gallery-overlay p {
        color: #fff;
        transform: translateY(10px);
        transition: var(--panel-transition);
    }

    .panel-gallery-item:hover .panel-gallery-overlay h6,
    .panel-gallery-item:hover .panel-gallery-overlay p {
        transform: translateY(0);
    }

    .panel-gallery-zoom {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 50px;
        height: 50px;
        background: var(--panel-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.25rem;
        transition: var(--panel-transition);
        opacity: 0;
    }

    .panel-gallery-item:hover .panel-gallery-zoom {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }

    /* Stats Counter */
    .panel-stat {
        text-align: center;
        color: #fff;
        padding: 30px 20px;
    }

    .panel-stat-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        transition: var(--panel-transition);
        border: 2px solid rgba(255,255,255,0.1);
    }

    .panel-stat:hover .panel-stat-icon {
        background: rgba(255,255,255,0.2);
        transform: scale(1.1);
        border-color: rgba(255,255,255,0.3);
    }

    .panel-stat-number {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 700;
        line-height: 1;
        margin-bottom: 10px;
    }

    .panel-stat-label {
        font-size: 1rem;
        opacity: 0.8;
    }

    /* Contact Form */
    .panel-form .form-control {
        padding: 14px 18px;
        border-radius: 10px;
        border: 2px solid rgba(var(--panel-secondary-rgb), 0.1);
        font-size: 1rem;
        transition: var(--panel-transition);
        background: var(--panel-card-bg);
    }

    .panel-form .form-control:focus {
        border-color: var(--panel-primary);
        box-shadow: 0 0 0 4px rgba(var(--panel-primary-rgb), 0.1);
    }

    .panel-form .form-label {
        font-weight: 600;
        color: var(--panel-secondary);
        margin-bottom: 8px;
    }

    [data-bs-theme="dark"] .panel-form .form-label {
        color: #fff;
    }

    /* Contact Info Card */
    .panel-contact-info {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }

    .panel-contact-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--panel-radius);
        background: rgba(var(--panel-primary-rgb), 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--panel-primary);
        font-size: 1.25rem;
        flex-shrink: 0;
        transition: var(--panel-transition);
    }

    .panel-contact-info:hover .panel-contact-icon {
        background: var(--panel-primary);
        color: #fff;
    }

    /* Team Card */
    .panel-team-card {
        text-align: center;
        background: var(--panel-card-bg);
        border-radius: var(--panel-radius-lg);
        padding: 40px 30px;
        box-shadow: var(--panel-shadow);
        transition: var(--panel-transition);
        position: relative;
        overflow: hidden;
    }

    .panel-team-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(135deg, var(--panel-primary), color-mix(in srgb, var(--panel-primary) 80%, var(--panel-secondary)));
        opacity: 0.1;
        transition: var(--panel-transition);
    }

    @supports not (background: color-mix(in srgb, red, blue)) {
        .panel-team-card::before {
            background: linear-gradient(135deg, var(--panel-primary), #1899d0);
        }
    }

    .panel-team-card:hover::before {
        height: 100%;
        opacity: 0.05;
    }

    .panel-team-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--panel-shadow-hover);
    }

    .panel-team-avatar {
        position: relative;
        z-index: 1;
        margin-bottom: 20px;
    }

    .panel-team-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--panel-secondary);
        margin-bottom: 5px;
    }

    [data-bs-theme="dark"] .panel-team-name {
        color: #fff;
    }

    .panel-team-role {
        color: var(--panel-primary);
        font-weight: 500;
        margin-bottom: 15px;
    }

    .panel-team-bio {
        color: var(--panel-gray);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .panel-social-links {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .panel-social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(var(--panel-primary-rgb), 0.1);
        color: var(--panel-primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: var(--panel-transition);
        text-decoration: none;
    }

    .panel-social-link:hover {
        background: var(--panel-primary);
        color: #fff;
        transform: translateY(-3px);
    }

    /* Review Card */
    .panel-review-card {
        background: var(--panel-card-bg);
        border-radius: var(--panel-radius-lg);
        padding: 35px;
        box-shadow: var(--panel-shadow);
        height: 100%;
        position: relative;
        transition: var(--panel-transition);
        display: flex;
        flex-direction: column;
    }

    .panel-review-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--panel-shadow-hover);
    }

    .panel-review-quote {
        position: absolute;
        top: 25px;
        inset-inline-start: 30px;
        font-size: 4rem;
        font-family: Georgia, serif;
        color: var(--panel-primary);
        opacity: 0.15;
        line-height: 1;
    }

    .panel-review-content {
        color: var(--panel-gray);
        font-size: 1.05rem;
        line-height: 1.8;
        margin: 20px 0 25px;
        position: relative;
        z-index: 1;
        flex-grow: 1;
    }

    .panel-review-author {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: auto;
    }

    /* CTA Section */
    .panel-cta-content {
        position: relative;
        z-index: 1;
    }

    /* RTL Support */
    [dir="rtl"] .panel-btn i.tabler-arrow-right,
    [dir="rtl"] .panel-btn i.tabler-arrow-left {
        transform: scaleX(-1);
    }

    [dir="rtl"] .panel-accordion .accordion-button::after {
        margin-left: 0;
        margin-right: auto;
    }

    [dir="rtl"] .panel-contact-info {
        flex-direction: row;
    }

    [dir="rtl"] .panel-review-author {
        flex-direction: row;
    }

    /* Custom Panel Background Classes */
    .panel-bg-light {
        background: var(--panel-gray-light);
    }

    .panel-bg-gradient-light {
        background: linear-gradient(180deg, var(--panel-gray-light) 0%, var(--panel-card-bg) 100%);
    }

    .panel-bg-white {
        background: var(--panel-card-bg);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .panel-card-body {
            padding: 25px;
        }

        .panel-team-card {
            padding: 30px 20px;
        }
    }

    @media (max-width: 576px) {
        .panel-header {
            margin-bottom: 35px;
        }

        .panel-card-body {
            padding: 20px;
        }

        .panel-icon-box {
            width: 56px;
            height: 56px;
            font-size: 1.5rem;
        }

        .panel-review-card {
            padding: 25px;
        }

        .panel-stat-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .panel-btn {
            padding: 12px 24px;
            font-size: 0.95rem;
        }

        .panel-team-card {
            padding: 25px 20px;
        }

        .panel-avatar-lg {
            width: 100px;
            height: 100px;
        }
    }

    /* Print styles */
    @media print {
        .panel-section {
            padding: 30px 0;
        }

        .panel-shape,
        .panel-pattern {
            display: none;
        }

        .panel-card,
        .panel-team-card,
        .panel-review-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>
