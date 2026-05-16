@php
    $geminiConfigured = $geminiConfigured ?? false;
@endphp

<div class="rounded-2xl border-2 border-dashed border-violet-200 bg-gradient-to-br from-violet-50 via-white to-blue-50 p-6 space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-wand-magic-sparkles text-violet-600"></i>
                Generate with Gemini AI
            </h3>
            <p class="text-sm text-gray-600 mt-1">Describe your promotion — AI creates a banner and attaches it below.</p>
        </div>
        @unless($geminiConfigured)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 shrink-0">
                <i class="fas fa-key mr-1"></i> API key required
            </span>
        @endunless
    </div>

    @unless($geminiConfigured)
        <div class="text-sm text-amber-800 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
            Add <code class="font-mono text-xs bg-amber-100 px-1 rounded">GEMINI_API_KEY</code> to your <code class="font-mono text-xs bg-amber-100 px-1 rounded">.env</code> file.
            Get a key from <a href="https://aistudio.google.com/apikey" target="_blank" rel="noopener" class="underline font-medium">Google AI Studio</a>.
        </div>
    @endunless

    <div>
        <label for="ai-banner-prompt" class="block text-sm font-semibold text-gray-700 mb-2">Prompt</label>
        <textarea id="ai-banner-prompt" rows="3" maxlength="480"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent resize-y"
            placeholder="e.g. Whale watching tour at sunrise in Mirissa, 20% off, tropical ocean, golden light, happy travelers on a boat"
            @disabled(!$geminiConfigured)></textarea>
        <p class="text-xs text-gray-500 mt-1"><span id="ai-prompt-count">0</span>/480 characters</p>
    </div>

    <div class="flex flex-wrap gap-2">
        <span class="text-xs font-medium text-gray-500 w-full">Quick prompts:</span>
        @foreach([
            'Sigiriya Lion Rock at golden hour, ancient fortress, dramatic clouds, Sri Lanka heritage tour promotion',
            'Blue whale watching in Mirissa, turquoise ocean, professional travel poster style',
            'Luxury airport transfer SUV on coastal road, palm trees, sunset, book now vibe',
            'Yala safari jeep with elephants, wildlife adventure, vibrant jungle greens',
        ] as $suggestion)
        <button type="button"
            class="ai-prompt-suggestion text-xs px-3 py-1.5 rounded-full bg-white border border-violet-200 text-violet-700 hover:bg-violet-100 transition-colors"
            data-prompt="{{ $suggestion }}"
            @disabled(!$geminiConfigured)>
            {{ Str::limit($suggestion, 42) }}
        </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="ai-aspect-ratio" class="block text-sm font-semibold text-gray-700 mb-2">Aspect ratio</label>
            <select id="ai-aspect-ratio" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-violet-500" @disabled(!$geminiConfigured)>
                <option value="9:16" selected>9:16 — Mobile popup (recommended)</option>
                <option value="3:4">3:4 — Portrait</option>
                <option value="4:3">4:3 — Landscape</option>
                <option value="16:9">16:9 — Widescreen</option>
                <option value="1:1">1:1 — Square</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="button" id="ai-generate-banner-btn"
                class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-xl font-semibold text-white transition-all duration-300 {{ $geminiConfigured ? 'bg-gradient-to-r from-violet-600 to-blue-600 hover:from-violet-700 hover:to-blue-700 hover:shadow-lg' : 'bg-gray-300 cursor-not-allowed' }}"
                @disabled(!$geminiConfigured)>
                <i class="fas fa-sparkles"></i>
                <span class="btn-label">Generate banner</span>
            </button>
        </div>
    </div>

    <div id="ai-generate-status" class="hidden text-sm rounded-xl px-4 py-3"></div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const promptEl = document.getElementById('ai-banner-prompt');
    const countEl = document.getElementById('ai-prompt-count');
    const generateBtn = document.getElementById('ai-generate-banner-btn');
    const statusEl = document.getElementById('ai-generate-status');
    const aspectEl = document.getElementById('ai-aspect-ratio');
    const mediaInput = document.getElementById('promo-image-input');
    const previewEl = document.getElementById('promo-image-preview');

    if (!promptEl || !generateBtn) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function updateCount() {
        if (countEl) countEl.textContent = promptEl.value.length;
    }

    promptEl.addEventListener('input', updateCount);
    updateCount();

    document.querySelectorAll('.ai-prompt-suggestion').forEach(function(btn) {
        btn.addEventListener('click', function() {
            promptEl.value = btn.getAttribute('data-prompt') || '';
            updateCount();
            promptEl.focus();
        });
    });

    function setStatus(type, message) {
        statusEl.classList.remove('hidden', 'bg-red-50', 'text-red-800', 'border-red-200', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-200', 'bg-blue-50', 'text-blue-800', 'border-blue-200', 'border');
        if (type === 'error') {
            statusEl.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
        } else if (type === 'success') {
            statusEl.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200');
        } else {
            statusEl.classList.add('bg-blue-50', 'text-blue-800', 'border', 'border-blue-200');
        }
        statusEl.textContent = message;
    }

    function setPreview(url) {
        previewEl.innerHTML = '<img src="' + url + '" alt="Generated banner" class="w-full max-w-md h-64 object-cover rounded-xl border border-violet-200 shadow-md">';
    }

    generateBtn.addEventListener('click', async function() {
        const prompt = promptEl.value.trim();
        if (prompt.length < 10) {
            setStatus('error', 'Please enter at least 10 characters in your prompt.');
            return;
        }

        const label = generateBtn.querySelector('.btn-label');
        const icon = generateBtn.querySelector('i');
        generateBtn.disabled = true;
        label.textContent = 'Generating…';
        if (icon) icon.className = 'fas fa-spinner fa-spin';
        setStatus('info', 'Creating your banner with Gemini Imagen — this may take up to a minute…');

        try {
            const response = await fetch('{{ route('admin.promo-popup.generate-banner') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({
                    prompt: prompt,
                    aspect_ratio: aspectEl ? aspectEl.value : '9:16',
                }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Generation failed.');
            }

            mediaInput.value = data.media.media_id;
            setPreview(data.media.url);
            setStatus('success', 'Banner generated and selected. Save the slide to publish it.');
        } catch (err) {
            setStatus('error', err.message || 'Something went wrong. Check your API key and try again.');
        } finally {
            generateBtn.disabled = false;
            label.textContent = 'Generate banner';
            if (icon) icon.className = 'fas fa-sparkles';
        }
    });
});
</script>
@endpush
