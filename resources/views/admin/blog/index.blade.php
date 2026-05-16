@extends('layouts.admin')

@section('title', 'Blog Management - Admin Panel')
@section('page-title', 'Blog Management')
@section('page-description', 
    request('status') === 'published' ? 'Showing published posts only' : 
    (request('status') === 'draft' ? 'Showing draft posts only' : 
    (request('featured') == '1' ? 'Showing featured posts only' : 
    'Manage your blog posts and categories'))
)

@section('header-actions')
<a href="{{ route('admin.blog.create') }}" class="bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 text-sm mr-2">
    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
    </svg>
    New Post
</a>
<a href="{{ route('admin.categories') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 text-sm">
    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
    </svg>
    Categories
</a>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Posts</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $blogs->total() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Published</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $blogs->where('is_published', true)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Drafts</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $blogs->where('is_published', false)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Views</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $blogs->sum('views_count') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog Posts Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Blog Posts</h2>
                </div>
                
                @if($blogs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Post</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Category</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Views</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Published</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($blogs as $blog)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-16 h-16 rounded-lg overflow-hidden mr-4 flex-shrink-0">
                                            <x-placeholder-image :src="$blog->featured_image_url" :alt="$blog->title" placeholder="blog" class="w-full h-full object-cover" />
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ Str::limit($blog->title, 50) }}</h3>
                                            <p class="text-xs text-gray-500">{{ Str::limit($blog->excerpt, 60) }}</p>
                                            @if($blog->is_featured)
                                            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full mt-1">Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-white" style="background-color: {{ $blog->category->color }}">
                                        {{ $blog->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($blog->is_published)
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">
                                        Published
                                    </span>
                                    @else
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full font-medium">
                                        Draft
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ number_format($blog->views_count) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-700 transition-colors duration-200" title="View Post">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $blog) }}" class="text-green-600 hover:text-green-700 transition-colors duration-200" title="Edit Post">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 transition-colors duration-200" title="Delete Post">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-8 py-6 border-t border-gray-200">
                    {{ $blogs->links() }}
                </div>
                @else
                <div class="px-8 py-12 text-center">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">No Blog Posts Yet</h3>
                    <p class="text-gray-600 mb-8">Start creating amazing content for your blog!</p>
                    <a href="{{ route('admin.blog.create') }}" class="inline-block bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Create Your First Post
                    </a>
                </div>
                @endif
            </div>
@endsection

