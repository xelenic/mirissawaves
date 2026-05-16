@extends('layouts.app')

@section('title', 'Travel Blog - Mirissawaves')
@section('description', 'Discover Sri Lanka through our travel blog. Get insider tips, cultural insights, and adventure guides for your perfect Sri Lankan journey.')

@section('content')
<!-- Hero Section -->
<section class="relative page-hero py-10 sm:py-14 bg-gradient-to-r from-blue-600 via-purple-600 to-green-600 overflow-hidden">
    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="relative z-10 h-full flex items-center justify-center text-center text-white">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold playfair mb-4 animate-fade-in">
                    Travel
                    <span class="gradient-text">Blog</span>
                </h1>
                <p class="text-lg md:text-xl mb-6 opacity-90 animate-fade-in-delay">
                    Discover Sri Lanka through stories, tips, and adventures
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center animate-fade-in-delay-2">
                    <a href="#blog-posts" class="bg-white text-blue-600 hover:bg-gray-100 font-semibold py-2 px-6 rounded-full transition-all duration-300 transform hover:scale-105 text-sm">
                        Read Latest Posts
                    </a>
                    <a href="{{ route('packages') }}" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-semibold py-2 px-6 rounded-full transition-all duration-300 text-sm">
                        Plan Your Trip
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute top-16 left-10 w-16 h-16 bg-white bg-opacity-10 rounded-full animate-float"></div>
    <div class="absolute bottom-16 right-10 w-12 h-12 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-1/4 w-10 h-10 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 2s;"></div>
</section>

<!-- Featured Posts Section -->
@if($featuredBlogs->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 playfair mb-4">Featured Stories</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Handpicked stories that will inspire your Sri Lankan adventure</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredBlogs as $blog)
                <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48">
                        <x-placeholder-image :src="$blog->featured_image_url" :alt="$blog->title" placeholder="blog" class="w-full h-full object-cover" />
                        <div class="absolute top-4 left-4">
                            <span class="text-white px-3 py-1 rounded-full text-sm font-semibold" style="background-color: {{ $blog->category->color }}">
                                {{ $blog->category->name }}
                            </span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-full p-2">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-700">{{ $blog->views_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $blog->formatted_published_date }}
                            <span class="mx-2">•</span>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $blog->reading_time }} min read
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 playfair mb-3 hover:text-blue-600 transition-colors duration-300">
                            <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $blog->excerpt }}</p>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-300">
                                Read More
                            </a>
                            <div class="flex items-center">
                                @if($blog->tags)
                                    @foreach(array_slice($blog->tags, 0, 2) as $tag)
                                    <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded-full text-xs font-medium mr-1">
                                        {{ $tag }}
                                    </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Filter and Search Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 playfair mb-4">Explore Our Stories</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Filter by category or search for specific topics</p>
            </div>
            
            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-8">
                <form action="{{ route('blog.search') }}" method="GET" class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search blog posts..." 
                           class="w-full px-6 py-4 pr-12 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- Category Filters -->
            <div class="flex flex-wrap justify-center gap-4 mb-8">
                <a href="{{ route('blog.index') }}" class="filter-btn {{ !request('category') || request('category') === 'all' ? 'active bg-gradient-to-r from-blue-600 to-green-600 text-white' : 'bg-white text-gray-700 hover:bg-blue-50 hover:text-blue-600 border border-gray-300' }} px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                    All Posts
                </a>
                @foreach($categories as $category)
                <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="filter-btn {{ request('category') === $category->slug ? 'active bg-gradient-to-r from-blue-600 to-green-600 text-white' : 'bg-white text-gray-700 hover:bg-blue-50 hover:text-blue-600 border border-gray-300' }} px-6 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts Grid -->
<section id="blog-posts" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            @if($blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($blogs as $blog)
                <article class="blog-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <!-- Blog Image -->
                    <div class="relative h-48 overflow-hidden">
                        <x-placeholder-image :src="$blog->featured_image_url" :alt="$blog->title" placeholder="blog" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                        <div class="absolute top-4 left-4">
                            <span class="text-white px-3 py-1 rounded-full text-sm font-semibold" style="background-color: {{ $blog->category->color }}">
                                {{ $blog->category->name }}
                            </span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-full p-2">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-700">{{ $blog->views_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Blog Content -->
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $blog->formatted_published_date }}
                            <span class="mx-2">•</span>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $blog->reading_time }} min read
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 playfair mb-3 group-hover:text-blue-600 transition-colors duration-300">
                            <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $blog->excerpt }}</p>
                        
                        <!-- Tags -->
                        @if($blog->tags)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach(array_slice($blog->tags, 0, 3) as $tag)
                                <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $tag }}
                                </span>
                                @endforeach
                                @if(count($blog->tags) > 3)
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-medium">
                                    +{{ count($blog->tags) - 3 }} more
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Action Button -->
                        <a href="{{ route('blog.show', $blog->slug) }}" class="w-full bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 text-center block">
                            Read Full Story
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $blogs->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No Blog Posts Found</h3>
                <p class="text-gray-600 mb-8">We're working on creating amazing content for you. Check back soon!</p>
                <a href="{{ route('packages') }}" class="inline-block bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Explore Our Packages
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-green-600">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-3xl font-bold playfair mb-4">Stay Updated</h2>
            <p class="text-xl mb-8 opacity-90">Get the latest travel tips and stories delivered to your inbox</p>
            <form class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Enter your email" class="flex-1 px-6 py-3 rounded-full text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                <button type="submit" class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors duration-300">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</section>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.filter-btn.active {
    background: linear-gradient(135deg, #3b82f6, #10b981);
    color: white;
    border: none;
}

.blog-card {
    transition: all 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>
@endsection
