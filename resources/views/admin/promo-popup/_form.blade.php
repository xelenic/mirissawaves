@php
    $slide = $slide ?? null;
    $mediaId = old('media_id', $slide?->media_id);
    $previewUrl = null;
    if ($mediaId && $slide?->media && (int) $mediaId === (int) $slide->media_id) {
        $previewUrl = $slide->media->url;
    }
@endphp

<div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
    <div>
        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Label (admin only)</label>
        <input type="text" id="title" name="title" value="{{ old('title', $slide?->title) }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="e.g. Summer whale watching offer">
    </div>

    @include('admin.promo-popup._ai-generator', ['geminiConfigured' => $geminiConfigured ?? false])

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Promo image *</label>
        <p class="text-xs text-gray-500 mb-3">Use a tall or wide banner graphic — it fills the entire popup. Generate with AI above or pick from Media.</p>

        <div id="promo-image-preview" class="mb-4">
            @if($previewUrl)
                <img src="{{ $previewUrl }}" alt="Preview" class="w-full max-w-md h-64 object-cover rounded-xl border border-gray-200">
            @else
                <div class="w-full max-w-md h-64 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center">
                    <span class="text-gray-500">No image selected</span>
                </div>
            @endif
        </div>

        <button type="button"
            data-media-manager="true"
            data-input-id="promo-image-input"
            data-preview-id="promo-image-preview"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
            <i class="fas fa-image mr-2"></i>Choose image from Media
        </button>

        <input type="hidden" id="promo-image-input" name="media_id" value="{{ $mediaId }}" required>
        @error('media_id')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="link" class="block text-sm font-semibold text-gray-700 mb-2">Click link (optional)</label>
        <input type="text" id="link" name="link" value="{{ old('link', $slide?->link) }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="/packages or /#booking">
        <p class="text-xs text-gray-500 mt-1">Relative path or full URL. Leave empty for image-only.</p>
        @error('link')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $slide?->sort_order ?? 0) }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div class="flex items-end">
            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    {{ old('is_active', $slide?->is_active ?? true) ? 'checked' : '' }}>
                <span class="text-sm font-medium text-gray-700">Active (show on site)</span>
            </label>
        </div>
    </div>
</div>
