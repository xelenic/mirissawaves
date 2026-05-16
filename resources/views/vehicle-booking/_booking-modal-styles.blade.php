@push('styles')
<style>
    .booking-modal {
        position: fixed;
        inset: 0;
        z-index: 10050;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 0.75rem;
    }
    .booking-modal.is-open {
        display: flex;
    }
    body.booking-modal-open .navbar,
    body.booking-modal-open #chatButton,
    body.booking-modal-open .mobile-menu,
    body.booking-modal-open #startup-offers-popup {
        visibility: hidden;
        pointer-events: none;
    }
    .booking-modal__backdrop {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        animation: bookingModalFadeIn 0.25s ease;
    }
    .booking-modal__dialog {
        position: relative;
        width: 100%;
        max-width: 72rem;
        max-height: min(86vh, 680px);
        height: min(86vh, 680px);
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 0.875rem;
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.22);
        overflow: hidden;
        animation: bookingModalSlideUp 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    }
    @media (max-height: 700px) {
        .booking-modal__dialog {
            max-height: 94vh;
            height: 94vh;
        }
    }
    @keyframes bookingModalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes bookingModalSlideUp {
        from {
            opacity: 0;
            transform: translateY(0.75rem) scale(0.99);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .booking-modal__header {
        position: relative;
        padding: 0.75rem 1rem 0.625rem;
        background: linear-gradient(135deg, #1e3a8a 0%, #0f766e 55%, #059669 100%);
        color: #fff;
        overflow: hidden;
    }
    .booking-modal__header::before,
    .booking-modal__header::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.07);
        pointer-events: none;
    }
    .booking-modal__header::before {
        top: -50%;
        right: -8%;
        width: 9rem;
        height: 9rem;
    }
    .booking-modal__header::after {
        bottom: -70%;
        left: 4%;
        width: 7rem;
        height: 7rem;
    }
    .booking-modal__header-inner {
        position: relative;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.5rem;
    }
    .booking-modal__badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.625rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.22);
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        margin-bottom: 0.375rem;
    }
    .booking-modal__badge i {
        font-size: 0.5625rem;
    }
    .booking-modal__title {
        font-size: 1.125rem;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }
    .booking-modal__subtitle {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.85);
        margin-top: 0.2rem;
        line-height: 1.35;
    }
    .booking-modal__close {
        flex-shrink: 0;
        width: 1.75rem;
        height: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        color: #fff;
        transition: background 0.2s;
        cursor: pointer;
    }
    .booking-modal__close svg {
        width: 1rem;
        height: 1rem;
    }
    .booking-modal__close:hover {
        background: rgba(255, 255, 255, 0.22);
    }
    .booking-modal__scroll {
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
    }
    .booking-modal--trip-step .booking-modal__scroll {
        overflow: hidden;
    }
    .booking-modal__body {
        display: grid;
        grid-template-columns: 1fr;
    }
    @media (min-width: 768px) {
        .booking-modal__body {
            grid-template-columns: minmax(0, 18rem) 1fr;
        }
    }
    .booking-modal__summary {
        padding: 0.75rem 0.875rem;
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
    }
    @media (min-width: 768px) {
        .booking-modal__summary {
            border-bottom: none;
            border-right: 1px solid #e2e8f0;
            padding: 0.875rem 0.75rem;
        }
    }
    .booking-modal__summary-title {
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    .booking-summary-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .booking-summary-item {
        display: flex;
        gap: 0.5rem;
        align-items: flex-start;
    }
    .booking-summary-item__icon {
        flex-shrink: 0;
        width: 1.75rem;
        height: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.4375rem;
        font-size: 0.6875rem;
    }
    .booking-summary-item__icon--route {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .booking-summary-item__icon--time {
        background: #fef3c7;
        color: #b45309;
    }
    .booking-summary-item__icon--vehicle {
        background: #d1fae5;
        color: #047857;
    }
    .booking-summary-item__label {
        font-size: 0.625rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: #94a3b8;
        line-height: 1.2;
    }
    .booking-summary-item__value {
        font-size: 0.75rem;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.35;
        margin-top: 0.0625rem;
    }
    .booking-summary-fare {
        margin-top: 0.625rem;
        padding: 0.625rem 0.75rem;
        border-radius: 0.625rem;
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 1px solid #a7f3d0;
    }
    .booking-summary-fare__label {
        font-size: 0.625rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #047857;
    }
    .booking-summary-fare__amount {
        font-size: 1.125rem;
        font-weight: 800;
        color: #065f46;
        line-height: 1.15;
        margin-top: 0.125rem;
        letter-spacing: -0.02em;
    }
    .booking-summary-fare__note {
        font-size: 0.625rem;
        color: #059669;
        margin-top: 0.125rem;
        line-height: 1.3;
    }
    .booking-modal__form-area {
        padding: 0.75rem 0.875rem 0.875rem;
    }
    @media (min-width: 768px) {
        .booking-modal__form-area {
            padding: 0.875rem 1rem;
        }
    }
    .booking-form-section {
        margin-bottom: 0.75rem;
    }
    .booking-form-section:last-of-type {
        margin-bottom: 0.625rem;
    }
    .booking-form-section__title {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.5rem;
        padding-bottom: 0.3125rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .booking-form-section__title i {
        color: #2563eb;
        font-size: 0.75rem;
    }
    .booking-field {
        margin-bottom: 0.5rem;
    }
    .booking-field:last-child {
        margin-bottom: 0;
    }
    .booking-field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.25rem;
    }
    .booking-field label .required {
        color: #ef4444;
    }
    .booking-field label .optional {
        font-weight: 400;
        color: #94a3b8;
    }
    .booking-input-wrap {
        position: relative;
    }
    .booking-input-wrap > i {
        position: absolute;
        left: 0.625rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.75rem;
        pointer-events: none;
    }
    .booking-input-wrap .booking-input {
        padding-left: 2rem;
    }
    .booking-input,
    .booking-textarea {
        width: 100%;
        padding: 0.4375rem 0.625rem;
        font-size: 0.8125rem;
        color: #1e293b;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .booking-input:focus,
    .booking-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.12);
    }
    .booking-input:read-only {
        background: #f8fafc;
        color: #64748b;
        cursor: not-allowed;
    }
    .booking-textarea {
        resize: vertical;
        min-height: 2.75rem;
        line-height: 1.4;
    }
    .booking-pax-card {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.5rem 0.625rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
    }
    .booking-pax-card__icon {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3b82f6, #10b981);
        color: #fff;
        border-radius: 0.5rem;
        font-size: 0.8125rem;
        flex-shrink: 0;
    }
    .booking-pax-card__control {
        flex: 1;
        min-width: 0;
    }
    .booking-pax-card__control label {
        margin-bottom: 0.1875rem;
    }
    .booking-pax-card__control input {
        max-width: 5rem;
    }
    .booking-pax-hint {
        font-size: 0.6875rem;
        color: #64748b;
        margin-top: 0.25rem;
        line-height: 1.35;
    }
    .booking-auth-banner {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4375rem 0.625rem;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        color: #1e40af;
        margin-bottom: 0.5rem;
    }
    .booking-auth-banner i {
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    .booking-terms {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.5rem 0.625rem;
        background: #fafafa;
        border: 1px solid #f1f5f9;
        border-radius: 0.5rem;
    }
    .booking-terms input {
        width: 0.9375rem;
        height: 0.9375rem;
        margin-top: 0.0625rem;
        flex-shrink: 0;
        accent-color: #2563eb;
        cursor: pointer;
    }
    .booking-terms label {
        font-size: 0.75rem;
        color: #64748b;
        line-height: 1.4;
        cursor: pointer;
    }
    .booking-terms a {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
    }
    .booking-terms a:hover {
        text-decoration: underline;
    }
    .booking-modal__footer {
        flex-shrink: 0;
        padding: 0.625rem 0.875rem 0.75rem;
        background: #fff;
        border-top: 1px solid #e2e8f0;
    }
    .booking-modal__footer-trust {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        font-size: 0.625rem;
        color: #94a3b8;
        margin-bottom: 0.5rem;
    }
    .booking-modal__footer-trust i {
        color: #10b981;
        font-size: 0.625rem;
    }
    .booking-modal__footer-actions {
        display: flex;
        flex-direction: column-reverse;
        gap: 0.5rem;
    }
    @media (min-width: 480px) {
        .booking-modal__footer-actions {
            flex-direction: row;
            align-items: center;
            justify-content: flex-end;
        }
    }
    .booking-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        padding: 0.5rem 1rem;
        font-size: 0.8125rem;
        font-weight: 600;
        border-radius: 0.5rem;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
    }
    .booking-btn--ghost {
        background: #fff;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .booking-btn--ghost:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    .booking-btn--primary {
        flex: 1;
        background: linear-gradient(135deg, #2563eb 0%, #059669 100%);
        color: #fff;
        box-shadow: 0 2px 10px rgba(37, 99, 235, 0.28);
    }
    @media (min-width: 480px) {
        .booking-btn--primary {
            flex: none;
            min-width: 9.5rem;
        }
    }
    .booking-btn--primary:hover:not(:disabled) {
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.38);
        transform: translateY(-1px);
    }
    .booking-btn--primary:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }
    .booking-btn--primary i {
        font-size: 0.75rem;
    }
    .booking-field-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    @media (min-width: 480px) {
        .booking-field-grid--2 {
            grid-template-columns: 1fr 1fr;
        }
    }
    #userStatus {
        margin-top: 0.375rem;
        padding: 0.375rem 0.5rem;
        border-radius: 0.375rem;
        background: #f0f9ff;
    }
    #userStatusText {
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Wizard layout */
    .booking-modal__dialog--wizard .booking-modal__header {
        padding-bottom: 0.5rem;
        flex-shrink: 0;
    }
    .booking-modal--trip-step.booking-modal__dialog--wizard .booking-modal__header {
        padding: 0.625rem 1rem 0.5rem;
    }
    .booking-modal--trip-step .booking-wizard-nav {
        margin-top: 0.5rem;
        padding-top: 0.5rem;
    }
    .booking-modal__header-text {
        flex: 1;
        min-width: 0;
    }
    .booking-wizard-nav {
        position: relative;
        margin-top: 0.75rem;
        padding-top: 0.625rem;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
    }
    .booking-wizard-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0;
    }
    .booking-wizard-steps__item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        flex: 0 0 auto;
        min-width: 4.5rem;
    }
    .booking-wizard-steps__connector {
        flex: 1;
        max-width: 4rem;
        height: 2px;
        background: rgba(255, 255, 255, 0.2);
        margin: 0 0.25rem;
        margin-bottom: 1.125rem;
        border-radius: 1px;
        transition: background 0.25s;
    }
    .booking-wizard-steps__connector.is-done {
        background: rgba(255, 255, 255, 0.55);
    }
    .booking-wizard-steps__dot {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.12);
        border: 2px solid rgba(255, 255, 255, 0.25);
        font-size: 0.6875rem;
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.25s;
    }
    .booking-wizard-steps__label {
        font-size: 0.625rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: rgba(255, 255, 255, 0.55);
        transition: color 0.25s;
    }
    .booking-wizard-steps__item.is-active .booking-wizard-steps__dot {
        background: #fff;
        border-color: #fff;
        color: #0f766e;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }
    .booking-wizard-steps__item.is-active .booking-wizard-steps__label {
        color: #fff;
    }
    .booking-wizard-steps__item.is-done .booking-wizard-steps__dot {
        background: rgba(255, 255, 255, 0.9);
        border-color: rgba(255, 255, 255, 0.9);
        color: #059669;
    }
    .booking-wizard-steps__item.is-done .booking-wizard-steps__label {
        color: rgba(255, 255, 255, 0.85);
    }
    .booking-wizard {
        padding: 1rem 1.25rem 1.25rem;
    }
    @media (min-width: 768px) {
        .booking-wizard {
            padding: 1.25rem 2rem 1.5rem;
        }
    }
    .booking-modal--trip-step .booking-wizard {
        padding: 0.625rem 1rem 0.75rem;
        height: 100%;
        min-height: 0;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }
    @media (min-width: 768px) {
        .booking-modal--trip-step .booking-wizard {
            padding: 0.75rem 1.25rem;
        }
    }
    .booking-wizard-step {
        display: none;
        animation: bookingWizardFade 0.28s ease;
    }
    .booking-wizard-step.is-active {
        display: block;
    }
    .booking-wizard-step[hidden] {
        display: none !important;
    }
    @keyframes bookingWizardFade {
        from {
            opacity: 0;
            transform: translateX(0.5rem);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    .booking-wizard-step__lead {
        font-size: 0.8125rem;
        color: #64748b;
        margin-bottom: 1rem;
        line-height: 1.45;
    }
    .booking-wizard-step1-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.75rem;
        align-items: stretch;
    }
    .booking-modal--trip-step .booking-wizard-step.is-active[data-wizard-step="1"] {
        flex: 1;
        min-height: 0;
        display: flex !important;
        flex-direction: column;
    }
    .booking-modal--trip-step .booking-wizard-step1-layout {
        flex: 1;
        min-height: 0;
        height: 100%;
    }
    @media (min-width: 768px) {
        .booking-wizard-step1-layout {
            grid-template-columns: minmax(0, 15.5rem) minmax(0, 1fr);
            gap: 0.875rem;
        }
    }
    @media (min-width: 1024px) {
        .booking-wizard-step1-layout {
            grid-template-columns: minmax(0, 16.5rem) minmax(0, 1fr);
        }
    }
    .booking-trip-panel {
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.625rem;
        display: flex;
        flex-direction: column;
        min-height: 0;
        height: 100%;
        overflow: hidden;
        box-sizing: border-box;
    }
    .booking-trip-panel__step {
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #64748b;
        margin-bottom: 0.375rem;
        flex-shrink: 0;
    }
    .booking-trip-panel__media {
        position: relative;
        width: 100%;
        height: 5.25rem;
        flex-shrink: 0;
        margin-bottom: 0.5rem;
        border-radius: 0.5rem;
        overflow: hidden;
        background: #e2e8f0;
    }
    .booking-trip-panel__img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .booking-trip-panel__img.hidden {
        display: none;
    }
    .booking-trip-panel__img-placeholder {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #dbeafe 0%, #d1fae5 100%);
        color: #2563eb;
        font-size: 2rem;
    }
    .booking-trip-panel__img-placeholder.hidden {
        display: none;
    }
    .booking-trip-panel__stats {
        margin: 0 0 0.375rem;
        flex: 1 1 auto;
        min-height: 0;
        overflow: hidden;
    }
    .booking-trip-panel__row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.375rem;
        padding: 0.25rem 0;
        font-size: 0.6875rem;
        border-bottom: 1px solid #e8edf2;
    }
    .booking-trip-panel__row:last-child {
        border-bottom: none;
    }
    .booking-trip-panel__row dt {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        color: #64748b;
        font-weight: 500;
        flex-shrink: 0;
    }
    .booking-trip-panel__row dt i {
        width: 0.875rem;
        text-align: center;
        color: #94a3b8;
        font-size: 0.6875rem;
    }
    .booking-trip-panel__row dd {
        margin: 0;
        font-weight: 600;
        color: #1e293b;
        text-align: right;
        line-height: 1.3;
        max-width: 58%;
        word-break: break-word;
    }
    .booking-trip-panel__total {
        padding: 0.4375rem 0.5rem;
        margin: 0;
        flex-shrink: 0;
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border: 1px solid #a7f3d0;
        border-radius: 0.5rem;
        text-align: center;
    }
    .booking-trip-panel__total-label {
        font-size: 0.625rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #047857;
    }
    .booking-trip-panel__total-amount {
        font-size: 1.125rem;
        font-weight: 800;
        color: #065f46;
        line-height: 1.15;
        margin-top: 0.0625rem;
    }
    .booking-trip-panel__total-note {
        font-size: 0.625rem;
        color: #059669;
        margin-top: 0.125rem;
    }
    /* Right panel: vehicle details, features */
    .booking-trip-vehicle-panel {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
        min-height: 0;
        height: 100%;
        overflow: hidden;
        box-sizing: border-box;
    }
    .booking-modal--trip-step .booking-trip-vehicle-panel {
        overflow-y: auto;
        overscroll-behavior: contain;
    }
    .booking-trip-vehicle-panel__name {
        font-size: 1rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.25;
        margin: 0;
    }
    .booking-trip-vehicle-panel__meta {
        font-size: 0.8125rem;
        color: #64748b;
        margin: 0.25rem 0 0;
        line-height: 1.4;
    }
    .booking-trip-vehicle-panel__specs {
        list-style: none;
        margin: 0.625rem 0 0;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
    }
    .booking-trip-vehicle-panel__specs li {
        font-size: 0.6875rem;
        font-weight: 600;
        color: #1d4ed8;
        background: #eff6ff;
        padding: 0.2rem 0.5rem;
        border-radius: 9999px;
    }
    .booking-trip-vehicle-panel__specs li i {
        margin-right: 0.25rem;
        opacity: 0.85;
    }
    .booking-trip-vehicle-panel__desc {
        font-size: 0.75rem;
        color: #64748b;
        line-height: 1.4;
        margin: 0.375rem 0 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .booking-trip-vehicle-panel__desc.hidden {
        display: none;
    }
    .booking-trip-vehicle-panel__features {
        padding-top: 0.5rem;
        border-top: 1px solid #e2e8f0;
        flex-shrink: 0;
    }
    .booking-trip-vehicle-panel__features-title {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #334155;
        margin: 0 0 0.5rem;
    }
    .booking-trip-vehicle-panel__features-title i {
        color: #f59e0b;
    }
    .booking-trip-vehicle-panel__features-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
    }
    .booking-trip-vehicle-panel__features-grid.hidden {
        display: none;
    }
    .booking-trip-feature-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.6875rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        line-height: 1.3;
    }
    .booking-trip-feature-tag--feature {
        background: #f1f5f9;
        color: #334155;
    }
    .booking-trip-feature-tag--feature i {
        color: #64748b;
        font-size: 0.5625rem;
    }
    .booking-trip-feature-tag--amenity {
        background: #ecfdf5;
        color: #047857;
    }
    .booking-trip-feature-tag--amenity i {
        color: #10b981;
        font-size: 0.5625rem;
    }
    .booking-trip-vehicle-panel__features-empty {
        font-size: 0.75rem;
        color: #94a3b8;
        font-style: italic;
        margin: 0;
        line-height: 1.4;
    }
    .booking-trip-vehicle-panel__hint {
        font-size: 0.6875rem;
        color: #94a3b8;
        margin: 0;
        line-height: 1.35;
        padding-top: 0.125rem;
        flex-shrink: 0;
    }
    .booking-modal--trip-step .booking-modal__footer {
        padding: 0.5rem 0.875rem 0.625rem;
    }
    .booking-modal--trip-step .booking-modal__footer-trust {
        margin-bottom: 0.375rem;
    }
    .booking-wizard-review {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.875rem;
        margin-bottom: 1rem;
    }
    @media (min-width: 640px) {
        .booking-wizard-review {
            grid-template-columns: 1fr 1fr;
        }
    }
    .booking-wizard-review__block {
        padding: 0.875rem 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.625rem;
    }
    .booking-wizard-review__heading {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.625rem;
        padding-bottom: 0.375rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .booking-wizard-review__heading i {
        color: #2563eb;
        font-size: 0.75rem;
    }
    .booking-wizard-review__list {
        margin: 0;
    }
    .booking-wizard-review__list > div {
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.3125rem 0;
        font-size: 0.8125rem;
    }
    .booking-wizard-review__list dt {
        color: #94a3b8;
        font-weight: 500;
        flex-shrink: 0;
    }
    .booking-wizard-review__list dd {
        margin: 0;
        font-weight: 600;
        color: #1e293b;
        text-align: right;
    }
    .booking-wizard-review__fare {
        color: #059669 !important;
        font-size: 0.9375rem !important;
    }
    .booking-modal__footer-actions .hidden {
        display: none !important;
    }

    @media (max-width: 639px) {
        .booking-modal {
            padding: 0;
            align-items: flex-end;
        }
        .booking-modal__dialog {
            max-width: 100%;
            width: 100%;
            max-height: 96dvh;
            height: 96dvh;
            border-radius: 1rem 1rem 0 0;
        }
        .booking-modal__header {
            padding: 0.625rem 0.875rem 0.5rem;
        }
        .booking-modal__title {
            font-size: 1rem;
        }
        .booking-modal__scroll {
            -webkit-overflow-scrolling: touch;
        }
        .booking-modal__footer {
            padding: 0.625rem 0.875rem;
            padding-bottom: max(0.625rem, env(safe-area-inset-bottom));
        }
        .booking-modal__footer-actions {
            width: 100%;
        }
        .booking-modal__footer-actions .booking-btn {
            width: 100%;
            min-height: 2.75rem;
        }
        .booking-wizard-steps__label {
            font-size: 0.5625rem;
        }
        .booking-wizard-steps__item {
            min-width: 3rem;
        }
        .booking-wizard-steps__connector {
            max-width: 2rem;
        }
        .booking-field-grid--2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
