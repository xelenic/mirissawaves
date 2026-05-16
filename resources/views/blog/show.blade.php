@extends('layouts.app')

@section('title', $blog->meta_title ?: $blog->title . ' - Mirissawaves')
@section('description', $blog->meta_description ?: Str::limit($blog->excerpt, 160))

@section('content')
<!-- Hero Section with Featured Image -->
<section class="relative detail-hero overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $blog->featured_image_url }}')"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/40"></div>
    
    <!-- Blog Info Overlay -->
    <div class="detail-hero-card absolute bottom-0 left-0 right-0 z-10 p-4 sm:p-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white/95 backdrop-blur-lg rounded-2xl p-4 sm:p-8 shadow-2xl">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-white px-4 py-2 rounded-full text-sm font-semibold" style="background-color: {{ $blog->category->color }}">
                                {{ $blog->category->name }}
                            </span>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-5 h-5 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span class="font-semibold">{{ $blog->views_count }} views</span>
                            </div>
                        </div>
                        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-gray-900 playfair mb-4">
                            {{ $blog->title }}
                        </h1>
                        <p class="text-lg text-gray-600 mb-4">
                            {{ $blog->excerpt }}
                        </p>
                        <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-gray-600 detail-meta">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $blog->formatted_published_date }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $blog->reading_time }} min read
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content Section -->
<section class="py-16 lg:py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start blog-show-layout">
                <!-- Main Content -->
                <div class="lg:col-span-8 order-2 lg:order-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 lg:p-10">
                    <article class="prose prose-lg max-w-none mb-10">
                        {!! $blog->content !!}
                    </article>

                    @if($blog->tags && count($blog->tags) > 0)
                    <div class="mb-10">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($blog->tags as $tag)
                            <span class="bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-sm font-medium hover:bg-blue-100 transition-colors duration-300">
                                {{ $tag }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Share This Story</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors duration-300">
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}" target="_blank" rel="noopener" class="bg-sky-500 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-sky-600 transition-colors duration-300">
                                Twitter
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-800 transition-colors duration-300">
                                LinkedIn
                            </a>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4 order-1 lg:order-2 w-full min-w-0 flex flex-col">
                    <div class="lg:sticky lg:top-24 lg:self-start space-y-6 blog-sidebar-sticky w-full">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 playfair">About Mirissawaves</h3>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">We're passionate about showcasing the beauty and culture of Sri Lanka through authentic travel experiences and stories.</p>
                        <a href="{{ route('about') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                            Learn more about us →
                        </a>
                    </div>

                    <div class="bg-gradient-to-br from-blue-600 to-emerald-600 rounded-2xl p-6 text-white">
                        <h3 class="text-lg font-bold mb-2 playfair">Plan your trip</h3>
                        <p class="text-sm text-white/90 mb-4">Explore tours, transfers, and book your Sri Lanka adventure.</p>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('packages') }}" class="block text-center bg-white text-blue-700 text-sm font-semibold py-2.5 px-4 rounded-xl hover:bg-blue-50 transition-colors">View packages</a>
                            <a href="{{ route('home') }}#booking" class="block text-center border border-white/60 text-white text-sm font-semibold py-2.5 px-4 rounded-xl hover:bg-white/10 transition-colors">Book a transfer</a>
                        </div>
                    </div>

                    @if($recentBlogs->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 playfair">Recent Stories</h3>
                        <ul class="space-y-4">
                            @foreach($recentBlogs as $recentBlog)
                            <li class="flex gap-3 items-start">
                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                                    <x-placeholder-image :src="$recentBlog->featured_image_url" :alt="$recentBlog->title" placeholder="blog" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1 leading-snug">
                                        <a href="{{ route('blog.show', $recentBlog->slug) }}" class="hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $recentBlog->title }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500">{{ $recentBlog->formatted_published_date }}</p>
                                    @if($recentBlog->category)
                                    <span class="inline-block mt-1.5 text-[10px] font-semibold text-white px-2 py-0.5 rounded-full" style="background-color: {{ $recentBlog->category->color ?? '#3b82f6' }}">
                                        {{ $recentBlog->category->name }}
                                    </span>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($relatedBlogs->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 playfair">Related Stories</h3>
                        <ul class="space-y-4">
                            @foreach($relatedBlogs as $relatedBlog)
                            <li class="flex gap-3 items-start">
                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                                    <x-placeholder-image :src="$relatedBlog->featured_image_url" :alt="$relatedBlog->title" placeholder="blog" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1 leading-snug">
                                        <a href="{{ route('blog.show', $relatedBlog->slug) }}" class="hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $relatedBlog->title }}
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500">{{ $relatedBlog->formatted_published_date }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-green-600">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-3xl font-bold playfair mb-4">Ready for Your Own Adventure?</h2>
            <p class="text-xl mb-8 opacity-90">Let us help you create unforgettable memories in Sri Lanka</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('packages') }}" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105">
                    Explore Packages
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-semibold py-3 px-8 rounded-full transition-all duration-300">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    color: #374151;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: #111827;
    font-weight: 700;
}

.prose h2 {
    font-size: 1.875rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.prose h3 {
    font-size: 1.5rem;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.prose p {
    margin-bottom: 1.5rem;
    line-height: 1.75;
}

.prose strong {
    font-weight: 600;
    color: #111827;
}

.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 0.75rem;
}

@media (min-width: 1024px) {
    .blog-show-layout {
        align-items: flex-start;
    }
    .blog-sidebar-sticky {
        max-height: none;
        overflow: visible;
        height: auto;
    }
}
</style>
@endsection
