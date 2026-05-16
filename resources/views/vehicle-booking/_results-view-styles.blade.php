@push('styles')
<style>
    .vehicle-results {
        display: grid;
        gap: 1.25rem;
    }
    .vehicle-results.view-grid {
        grid-template-columns: 1fr;
    }
    @media (min-width: 640px) {
        .vehicle-results.view-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (min-width: 1280px) {
        .vehicle-results.view-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    .vehicle-results.view-list {
        grid-template-columns: 1fr;
        gap: 0.875rem;
    }
    .vehicle-card {
        display: flex;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .vehicle-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }
    .vehicle-card__media {
        position: relative;
        flex-shrink: 0;
        background: #f3f4f6;
    }
    .vehicle-card__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .vehicle-card__type-badge {
        position: absolute;
        top: 0.625rem;
        left: 0.625rem;
        font-size: 0.6875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        background: rgba(255, 255, 255, 0.95);
        color: #1e40af;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
    }
    .vehicle-card__body {
        flex: 1;
        min-width: 0;
        padding: 1rem 1.25rem;
    }
    .vehicle-card__main {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        height: 100%;
    }
    .vehicle-card__title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
    }
    .vehicle-card__meta {
        font-size: 0.875rem;
        color: #4b5563;
        margin-top: 0.25rem;
    }
    .vehicle-card__stats {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem 0.75rem;
        margin-top: 0.625rem;
    }
    .vehicle-card__stat {
        font-size: 0.75rem;
        font-weight: 500;
        color: #1d4ed8;
        background: #eff6ff;
        padding: 0.2rem 0.55rem;
        border-radius: 9999px;
    }
    .vehicle-card__stat i {
        margin-right: 0.25rem;
        opacity: 0.85;
    }
    .vehicle-card__tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
        margin-top: 0.625rem;
    }
    .vehicle-card__tag {
        font-size: 0.6875rem;
        padding: 0.15rem 0.5rem;
        border-radius: 9999px;
    }
    .vehicle-card__tag--feature {
        background: #f1f5f9;
        color: #334155;
    }
    .vehicle-card__tag--amenity {
        background: #ecfdf5;
        color: #047857;
    }
    .vehicle-card__desc {
        font-size: 0.8125rem;
        color: #6b7280;
        margin-top: 0.5rem;
        line-height: 1.45;
    }
    .vehicle-card__breakdown {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
        margin-top: 0.5rem;
        font-size: 0.6875rem;
        color: #9ca3af;
    }
    .vehicle-card__aside {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    .vehicle-card__price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #16a34a;
        line-height: 1;
    }
    .vehicle-card__price-note {
        font-size: 0.6875rem;
        color: #9ca3af;
    }
    .vehicle-card__cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(to right, #2563eb, #16a34a);
        transition: opacity 0.2s, transform 0.15s;
        white-space: nowrap;
        border: none;
        cursor: pointer;
    }
    .vehicle-card__cta:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }
    .view-grid .vehicle-card {
        flex-direction: column;
    }
    .view-grid .vehicle-card__media {
        width: 100%;
        height: 11rem;
    }
    .view-grid .vehicle-card__aside {
        width: 100%;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid #f3f4f6;
    }
    .view-grid .vehicle-card__desc {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .view-grid .vehicle-card__breakdown {
        display: none;
    }
    .view-list .vehicle-card {
        flex-direction: row;
        align-items: stretch;
    }
    .view-list .vehicle-card__media {
        width: 7.5rem;
        min-height: 8.5rem;
    }
    @media (min-width: 640px) {
        .view-list .vehicle-card__media {
            width: 10rem;
            min-height: 9.5rem;
        }
    }
    .view-list .vehicle-card__body {
        padding: 0.875rem 1rem;
    }
    .view-list .vehicle-card__main {
        flex-direction: row;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
    }
    .view-list .vehicle-card__info {
        flex: 1;
        min-width: 0;
    }
    .view-list .vehicle-card__aside {
        align-items: flex-end;
        text-align: right;
        flex-shrink: 0;
    }
    .view-list .vehicle-card__desc {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .view-list .vehicle-card__tags {
        max-height: 3.5rem;
        overflow: hidden;
    }
    .vehicle-view-btn[aria-pressed="true"] {
        background: #fff;
        color: #2563eb;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .vehicle-view-btn[aria-pressed="false"] {
        color: #6b7280;
    }
    .vehicle-view-btn[aria-pressed="false"]:hover {
        color: #374151;
    }

    /* ---- Vehicle booking page: mobile layout ---- */
    .vehicle-booking-page {
        overflow-x: hidden;
    }

    .vehicle-booking-layout {
        min-width: 0;
    }

    .vehicle-booking-results {
        min-width: 0;
        width: 100%;
    }

    .vehicle-filters-toggle.is-open .vehicle-filters-toggle__icon {
        transform: rotate(180deg);
    }

    .vehicle-filters-panel {
        display: none;
    }

    .vehicle-filters-panel.is-open {
        display: block;
    }

    @media (min-width: 1024px) {
        .vehicle-filters-panel {
            display: block;
        }
        .vehicle-filters-toggle {
            display: none;
        }
    }

    @media (min-width: 640px) {
        .vehicle-results-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .vehicle-results-toolbar > p {
            margin-bottom: 0;
        }
        .vehicle-results-toolbar__controls {
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
            width: auto;
        }
        .vehicle-sort-row {
            flex: 1;
            min-width: 12rem;
            max-width: 16rem;
        }
    }

    @media (max-width: 639px) {
        /* Force grid layout on phones (list view is cramped) */
        .vehicle-results.view-list {
            grid-template-columns: 1fr;
        }
        .vehicle-results.view-list .vehicle-card {
            flex-direction: column;
        }
        .vehicle-results.view-list .vehicle-card__media {
            width: 100%;
            min-height: 10rem;
            height: 10rem;
        }
        .vehicle-results.view-list .vehicle-card__body {
            padding: 0.875rem 1rem;
        }
        .vehicle-results.view-list .vehicle-card__main {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }
        .vehicle-results.view-list .vehicle-card__aside {
            width: 100%;
            align-items: stretch;
            text-align: left;
            border-top: 1px solid #f3f4f6;
            padding-top: 0.75rem;
        }

        .view-grid .vehicle-card__aside,
        .view-list .vehicle-card__aside {
            flex-direction: column;
            align-items: stretch;
            gap: 0.625rem;
        }

        .view-grid .vehicle-card__aside {
            flex-direction: column;
        }

        .vehicle-card__price {
            font-size: 1.25rem;
        }

        .vehicle-card__cta {
            width: 100%;
            white-space: normal;
            min-height: 2.75rem;
            padding: 0.75rem 1rem;
        }

        .vehicle-card__title {
            font-size: 1rem;
        }

        .vehicle-card__body {
            padding: 0.875rem 1rem;
        }

        .view-grid .vehicle-card__media {
            height: 10rem;
        }

        .vehicle-view-btn--list {
            display: none;
        }

        .vehicle-view-toggle .vehicle-view-btn:only-of-type,
        .vehicle-view-toggle .vehicle-view-btn:first-child:last-child {
            flex: 1;
        }

        #vehicleResultsEmpty {
            padding: 2rem 1rem;
        }
    }

    @media (min-width: 640px) and (max-width: 1023px) {
        .view-list .vehicle-card__main {
            flex-direction: column;
            align-items: stretch;
        }
        .view-list .vehicle-card__aside {
            width: 100%;
            flex-direction: row;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #f3f4f6;
            padding-top: 0.75rem;
            margin-top: 0.25rem;
        }
        .view-list .vehicle-card__cta {
            flex: 1 1 auto;
            min-width: 10rem;
        }
    }
</style>
@endpush
