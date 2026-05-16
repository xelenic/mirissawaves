@extends('layouts.app')

@section('title', 'Search Results - ' . $query)
@section('description', 'Search results for: ' . $query)

@section('content')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
<!-- Hero Section -->
<section class="page-hero bg-gradient-to-r from-blue-600 to-green-600 text-white py-10 sm:py-16">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="text-center">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-bold mb-4 playfair">Search Results</h1>
            <p class="text-xl mb-6">Results for: <span class="font-semibold">"{{ $query }}"</span></p>
            <p class="text-lg opacity-90">{{ $totalResults }} results found</p>
        </div>
    </div>
</section>

<!-- Search Results -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        
        <!-- Categories Section -->
        @if($packageCategories->count() > 0 || $blogCategories->count() > 0)
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 playfair">Categories</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($packageCategories as $category)
                <div class="bg-gradient-to-br from-white to-gray-50 rounded-lg shadow-sm p-4 hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-blue-200">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 rounded-md flex items-center justify-center mr-3" style="background-color: {{ $category->color }}20">
                            <i class="{{ $category->icon }} text-sm" style="color: {{ $category->color }}"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">{{ $category->name }}</h3>
                            <p class="text-xs text-gray-600">Package Category</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">{{ $category->description ?: 'Explore our ' . strtolower($category->name) . ' packages' }}</p>
                    <a href="{{ route('packages') }}?category={{ $category->id }}" class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 font-medium">
                        View Packages
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                @endforeach

                @foreach($blogCategories as $category)
                <div class="bg-gradient-to-br from-white to-gray-50 rounded-lg shadow-sm p-4 hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-green-200">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 rounded-md flex items-center justify-center mr-3" style="background-color: {{ $category->color }}20">
                            <i class="{{ $category->icon }} text-sm" style="color: {{ $category->color }}"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">{{ $category->name }}</h3>
                            <p class="text-xs text-gray-600">Blog Category</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">{{ $category->description ?: 'Read our ' . strtolower($category->name) . ' blog posts' }}</p>
                    <a href="{{ route('blog.category', $category->slug) }}" class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 font-medium">
                        View Posts
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Packages Section -->
        @if($packages->count() > 0)
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 playfair">Tour Packages ({{ $packages->total() }})</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($packages as $package)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-blue-200 group">
                    <div class="aspect-video bg-gray-200 overflow-hidden relative">
                        <img src="{{ $package->image_url }}" alt="{{ $package->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full text-white" style="background-color: {{ $package->category->color }}">
                                {{ $package->category->name }}
                            </span>
                            <span class="text-lg font-bold text-gray-900">{{ $package->formatted_price }}</span>
                        </div>
                        
                        <h3 class="text-sm font-semibold text-gray-900 mb-2 line-clamp-2">{{ $package->title }}</h3>
                        <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ $package->short_description ?: substr($package->description, 0, 80) . '...' }}</p>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <span><i class="fas fa-clock mr-1"></i>{{ $package->duration }}</span>
                            <span><i class="fas fa-users mr-1"></i>{{ $package->group_size }}</span>
                            <span><i class="fas fa-signal mr-1"></i>{{ $package->difficulty }}</span>
                        </div>
                        
                        <a href="{{ route('package.details', $package->slug) }}" class="block w-full bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white text-center py-2 px-3 rounded-md text-sm font-semibold transition-all duration-300">
                            View Details
                        </a>
                    </div>
                </div>
                @endforeach
                </div>
                
                @if($packages->hasPages())
                <div class="mt-8">
                    {{ $packages->appends(['q' => $query])->links() }}
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Blogs Section -->
        @if($blogs->count() > 0)
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 playfair">Blog Posts ({{ $blogs->total() }})</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($blogs as $blog)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-green-200 group">
                    <div class="aspect-video bg-gray-200 overflow-hidden relative">
                        <x-placeholder-image :src="$blog->featured_image_url" :alt="$blog->title" placeholder="blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full text-white" style="background-color: {{ $blog->category->color }}">
                                {{ $blog->category->name }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $blog->published_at->format('M d, Y') }}</span>
                        </div>
                        
                        <h3 class="text-sm font-semibold text-gray-900 mb-2 line-clamp-2">{{ $blog->title }}</h3>
                        <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ $blog->excerpt ?: substr(strip_tags($blog->content), 0, 80) . '...' }}</p>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <span><i class="fas fa-eye mr-1"></i>{{ $blog->views_count }} views</span>
                            <span><i class="fas fa-clock mr-1"></i>{{ $blog->reading_time }} min read</span>
                        </div>
                        
                        <a href="{{ route('blog.show', $blog->slug) }}" class="block w-full bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white text-center py-2 px-3 rounded-md text-sm font-semibold transition-all duration-300">
                            Read More
                        </a>
                    </div>
                </div>
                @endforeach
                </div>
                
                @if($blogs->hasPages())
                <div class="mt-8">
                    {{ $blogs->appends(['q' => $query])->links() }}
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- No Results -->
        @if($totalResults === 0)
        <div class="bg-white rounded-xl shadow-md p-8">
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">No results found</h3>
                <p class="text-gray-600 mb-8">We couldn't find anything matching "{{ $query }}". Try different keywords or browse our content.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('packages') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300">
                        Browse Packages
                    </a>
                    <a href="{{ route('blog.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300">
                        Browse Blog
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>
@endsection
