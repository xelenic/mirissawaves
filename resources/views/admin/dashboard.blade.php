@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview of your tour packages and categories')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-box text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Packages</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_packages'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Active Packages</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_packages'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-star text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Featured Packages</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['featured_packages'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-tags text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Categories</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_categories'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Blog Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                <i class="fas fa-blog text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Blog Posts</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_blogs'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                <i class="fas fa-eye text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Published Posts</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['published_blogs'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                <i class="fas fa-edit text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Draft Posts</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['draft_blogs'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Views</p>
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_views']) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Packages -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Packages</h3>
                <a href="{{ route('admin.packages') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
            </div>
        </div>
        <div class="p-6">
            @if($stats['recent_packages']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['recent_packages'] as $package)
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if($package->media)
                                <img src="{{ $package->media->url }}" alt="{{ $package->title }}" class="w-12 h-12 rounded-lg object-cover">
                            @elseif($package->image)
                                <img src="{{ asset($package->image) }}" alt="{{ $package->title }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $package->title }}</p>
                            <p class="text-sm text-gray-500">{{ $package->category->name }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $package->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No packages found</p>
            @endif
        </div>
    </div>

    <!-- Recent Blog Posts -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Blog Posts</h3>
                <a href="{{ route('admin.blog.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
            </div>
        </div>
        <div class="p-6">
            @if($stats['recent_blogs']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['recent_blogs'] as $blog)
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <x-placeholder-image :src="$blog->featured_image_url" :alt="$blog->title" placeholder="blog" class="w-12 h-12 rounded-lg object-cover" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $blog->title }}</p>
                            <p class="text-sm text-gray-500">{{ $blog->category->name }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $blog->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $blog->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No blog posts found</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <a href="{{ route('admin.packages.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <i class="fas fa-plus-circle text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-blue-900">Create New Package</p>
                        <p class="text-sm text-blue-700">Add a new tour package</p>
                    </div>
                </a>

                <a href="{{ route('admin.categories.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <i class="fas fa-tag text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-900">Create New Category</p>
                        <p class="text-sm text-green-700">Add a new package category</p>
                    </div>
                </a>

                <a href="{{ route('admin.packages') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <i class="fas fa-edit text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-purple-900">Manage Packages</p>
                        <p class="text-sm text-purple-700">Edit existing packages</p>
                    </div>
                </a>

                <a href="{{ route('admin.categories') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <i class="fas fa-cog text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-yellow-900">Manage Categories</p>
                        <p class="text-sm text-yellow-700">Edit package categories</p>
                    </div>
                </a>

                <a href="{{ route('admin.blog.create') }}" class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <i class="fas fa-plus-circle text-indigo-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-indigo-900">Create Blog Post</p>
                        <p class="text-sm text-indigo-700">Write a new blog article</p>
                    </div>
                </a>

                <a href="{{ route('admin.blog.index') }}" class="flex items-center p-4 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <i class="fas fa-blog text-emerald-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-emerald-900">Manage Blog Posts</p>
                        <p class="text-sm text-emerald-700">Edit existing blog posts</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Package Status Overview -->
<div class="mt-8 bg-white rounded-lg shadow-md">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Package Status Overview</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600">{{ $stats['active_packages'] }}</div>
                <div class="text-sm text-gray-600">Active Packages</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $stats['total_packages'] > 0 ? ($stats['active_packages'] / $stats['total_packages']) * 100 : 0 }}%"></div>
                </div>
            </div>
            
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600">{{ $stats['featured_packages'] }}</div>
                <div class="text-sm text-gray-600">Featured Packages</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-yellow-600 h-2 rounded-full" style="width: {{ $stats['total_packages'] > 0 ? ($stats['featured_packages'] / $stats['total_packages']) * 100 : 0 }}%"></div>
                </div>
            </div>
            
            <div class="text-center">
                <div class="text-3xl font-bold text-red-600">{{ $stats['total_packages'] - $stats['active_packages'] }}</div>
                <div class="text-sm text-gray-600">Inactive Packages</div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ $stats['total_packages'] > 0 ? (($stats['total_packages'] - $stats['active_packages']) / $stats['total_packages']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
