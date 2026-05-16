@php
    $geminiConfigured = $geminiConfigured ?? false;
@endphp

<div class="bg-gradient-to-br from-violet-50 via-white to-blue-50 rounded-2xl shadow-lg border-2 border-dashed border-violet-200 p-8 mb-8 space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-wand-magic-sparkles text-violet-600"></i>
                Generate article with Gemini AI
            </h2>
            <p class="text-sm text-gray-600 mt-1">Describe a topic — AI fills title, excerpt, content, SEO fields, and tags.</p>
        </div>
        @unless($geminiConfigured)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 shrink-0">
                <i class="fas fa-key mr-1"></i> API key required
            </span>
        @endunless
    </div>

    @unless($geminiConfigured)
        <div class="text-sm text-amber-800 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
            Add <code class="font-mono text-xs bg-amber-100 px-1 rounded">GEMINI_API_KEY</code> to <code class="font-mono text-xs bg-amber-100 px-1 rounded">.env</code>.
            Get a key from <a href="https://aistudio.google.com/apikey" target="_blank" rel="noopener" class="underline font-medium">Google AI Studio</a>.
        </div>
    @endunless

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2">
            <label for="ai-article-topic" class="block text-sm font-semibold text-gray-700 mb-2">Topic / prompt</label>
            <textarea id="ai-article-topic" rows="3" maxlength="500"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent resize-y"
                placeholder="e.g. Best time for whale watching in Mirissa and what to expect on a half-day tour"
                @disabled(!$geminiConfigured)></textarea>
            <p class="text-xs text-gray-500 mt-1"><span id="ai-topic-count">0</span>/500</p>
        </div>
        <div>
            <label for="ai-article-tone" class="block text-sm font-semibold text-gray-700 mb-2">Writing tone</label>
            <select id="ai-article-tone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-violet-500" @disabled(!$geminiConfigured)>
                <option value="informative">Informative</option>
                <option value="friendly">Friendly</option>
                <option value="professional">Professional</option>
                <option value="adventurous">Adventurous</option>
            </select>
            <p class="text-xs text-gray-500 mt-2">Uses the category selected below when generating.</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        <span class="text-xs font-medium text-gray-500 w-full">Quick topics:</span>
        @foreach([
            'Whale watching season and tips in Mirissa',
            'Complete guide to visiting Sigiriya Rock Fortress',
            'Top beaches on the south coast of Sri Lanka',
            'Yala National Park safari: what to pack and expect',
        ] as $suggestion)
        <button type="button"
            class="ai-article-suggestion text-xs px-3 py-1.5 rounded-full bg-white border border-violet-200 text-violet-700 hover:bg-violet-100 transition-colors"
            data-topic="{{ $suggestion }}"
            @disabled(!$geminiConfigured)>
            {{ Str::limit($suggestion, 40) }}
        </button>
        @endforeach
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <button type="button" id="ai-generate-article-btn"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white transition-all duration-300 {{ $geminiConfigured ? 'bg-gradient-to-r from-violet-600 to-blue-600 hover:from-violet-700 hover:to-blue-700 hover:shadow-lg' : 'bg-gray-300 cursor-not-allowed' }}"
            @disabled(!$geminiConfigured)>
            <i class="fas fa-sparkles"></i>
            <span class="btn-label">Generate & fill article</span>
        </button>
        <p class="text-xs text-gray-500">Replaces empty fields or overwrites existing content after confirmation.</p>
    </div>

    <div id="ai-article-status" class="hidden text-sm rounded-xl px-4 py-3"></div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const topicEl = document.getElementById('ai-article-topic');
    const countEl = document.getElementById('ai-topic-count');
    const generateBtn = document.getElementById('ai-generate-article-btn');
    const statusEl = document.getElementById('ai-article-status');
    const toneEl = document.getElementById('ai-article-tone');
    const categoryEl = document.getElementById('blog_category_id');

    if (!topicEl || !generateBtn) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const fields = {
        title: document.getElementById('title'),
        excerpt: document.getElementById('excerpt'),
        content: document.getElementById('content'),
        meta_title: document.getElementById('meta_title'),
        meta_description: document.getElementById('meta_description'),
        tags: document.getElementById('tags'),
    };

    function updateCount() {
        if (countEl) countEl.textContent = topicEl.value.length;
    }

    topicEl.addEventListener('input', updateCount);
    updateCount();

    document.querySelectorAll('.ai-article-suggestion').forEach(function(btn) {
        btn.addEventListener('click', function() {
            topicEl.value = btn.getAttribute('data-topic') || '';
            updateCount();
            topicEl.focus();
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

    function hasExistingContent() {
        return (fields.title?.value.trim() || fields.content?.value.trim());
    }

    generateBtn.addEventListener('click', async function() {
        const topic = topicEl.value.trim();
        if (topic.length < 5) {
            setStatus('error', 'Enter at least 5 characters for the topic.');
            return;
        }

        if (hasExistingContent() && !confirm('This will replace your current title, excerpt, content, and SEO fields. Continue?')) {
            return;
        }

        const label = generateBtn.querySelector('.btn-label');
        const icon = generateBtn.querySelector('i');
        generateBtn.disabled = true;
        label.textContent = 'Writing article…';
        if (icon) icon.className = 'fas fa-spinner fa-spin';
        setStatus('info', 'Gemini is writing your article — this may take 30–60 seconds…');

        try {
            const response = await fetch('{{ route('admin.blog.generate-article') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({
                    topic: topic,
                    blog_category_id: categoryEl?.value || null,
                    tone: toneEl?.value || 'informative',
                }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Generation failed.');
            }

            const article = data.article;
            if (fields.title) fields.title.value = article.title || '';
            if (fields.excerpt) fields.excerpt.value = article.excerpt || '';
            if (fields.content) fields.content.value = article.content || '';
            if (fields.meta_title) fields.meta_title.value = article.meta_title || '';
            if (fields.meta_description) fields.meta_description.value = article.meta_description || '';
            if (fields.tags) fields.tags.value = article.tags || '';

            setStatus('success', 'Article generated! Review the fields below, add an image, then save.');
            document.getElementById('title')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } catch (err) {
            setStatus('error', err.message || 'Something went wrong. Check your API key and try again.');
        } finally {
            generateBtn.disabled = false;
            label.textContent = 'Generate & fill article';
            if (icon) icon.className = 'fas fa-sparkles';
        }
    });
});
</script>
@endpush
