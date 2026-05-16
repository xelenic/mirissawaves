<div id="vehicleImageHoverPreview" class="vehicle-image-hover-preview" hidden aria-hidden="true">
    <img id="vehicleImageHoverPreviewImg" src="" alt="">
</div>

@push('styles')
<style>
    .js-vehicle-image-preview {
        cursor: zoom-in;
    }
    .vehicle-image-hover-preview {
        position: fixed;
        z-index: 10100;
        pointer-events: none;
        padding: 0.375rem;
        background: #fff;
        border-radius: 0.75rem;
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.35),
            0 0 0 1px rgba(0, 0, 0, 0.06);
        opacity: 0;
        visibility: hidden;
        transform: scale(0.96);
        transition: opacity 0.15s ease, transform 0.15s ease, visibility 0.15s;
        max-width: min(92vw, 42rem);
        max-height: min(88vh, 36rem);
    }
    .vehicle-image-hover-preview.is-visible {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }
    .vehicle-image-hover-preview[hidden] {
        display: block !important;
    }
    .vehicle-image-hover-preview:not(.is-visible) {
        pointer-events: none;
    }
    .vehicle-image-hover-preview img {
        display: block;
        max-width: min(90vw, 40rem);
        max-height: min(85vh, 34rem);
        width: auto;
        height: auto;
        object-fit: contain;
        border-radius: 0.5rem;
    }
</style>
@endpush
