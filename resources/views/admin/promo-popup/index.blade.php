@extends('layouts.admin')

@section('title', 'Promo Popup - Admin Panel')
@section('page-title', 'Startup Promo Popup')
@section('page-description', 'Manage full-screen promotional images shown on site load')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Promo Popup Slides</h2>
        <p class="text-gray-600">Upload banner images via Media Manager. Only active slides appear on the homepage.</p>
    </div>
    <a href="{{ route('admin.promo-popup.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 whitespace-nowrap">
        <i class="fas fa-plus mr-2"></i>Add Slide
    </a>
</div>

<div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
    <form method="POST" action="{{ route('admin.promo-popup.settings') }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        @csrf
        @method('PUT')
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Popup visibility</h3>
            <p class="text-sm text-gray-500">Turn off to hide the startup popup site-wide.</p>
        </div>
        <label class="inline-flex items-center gap-3 cursor-pointer">
            <input type="hidden" name="promo_popup_enabled" value="0">
            <input type="checkbox" name="promo_popup_enabled" value="1" class="sr-only peer" {{ $popupEnabled ? 'checked' : '' }} onchange="this.form.submit()">
            <span class="relative w-12 h-7 bg-gray-300 rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:w-6 after:h-6 after:bg-white after:rounded-full after:transition-transform peer-checked:after:translate-x-5"></span>
            <span class="text-sm font-medium text-gray-700">{{ $popupEnabled ? 'Enabled' : 'Disabled' }}</span>
        </label>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <p class="text-sm text-gray-600">Total slides</p>
        <p class="text-2xl font-bold text-gray-900">{{ $slides->count() }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <p class="text-sm text-gray-600">Active</p>
        <p class="text-2xl font-bold text-emerald-600">{{ $slides->where('is_active', true)->count() }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <p class="text-sm text-gray-600">Status</p>
        <p class="text-2xl font-bold {{ $popupEnabled ? 'text-blue-600' : 'text-gray-400' }}">{{ $popupEnabled ? 'Live' : 'Hidden' }}</p>
    </div>
</div>

@if($slides->isEmpty())
<div class="bg-white rounded-2xl shadow-lg p-12 text-center">
    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fas fa-images text-blue-600 text-2xl"></i>
    </div>
    <h3 class="text-lg font-semibold text-gray-900 mb-2">No promo slides yet</h3>
    <p class="text-gray-600 mb-6">Add your first full-screen offer image to show visitors on startup.</p>
    <a href="{{ route('admin.promo-popup.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
        <i class="fas fa-plus mr-2"></i>Create first slide
    </a>
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($slides as $slide)
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border {{ $slide->is_active ? 'border-emerald-200' : 'border-gray-100' }}">
        <div class="relative aspect-[4/5] bg-gray-100">
            @if($slide->image_url)
                <img src="{{ $slide->image_url }}" alt="{{ $slide->title ?? 'Promo slide' }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i class="fas fa-image text-4xl"></i>
                </div>
            @endif
            <span class="absolute top-3 left-3 px-2 py-1 rounded-full text-xs font-semibold {{ $slide->is_active ? 'bg-emerald-500 text-white' : 'bg-gray-500 text-white' }}">
                {{ $slide->is_active ? 'Active' : 'Inactive' }}
            </span>
            <span class="absolute top-3 right-3 px-2 py-1 rounded-full text-xs font-semibold bg-black/50 text-white">
                #{{ $slide->sort_order }}
            </span>
        </div>
        <div class="p-4">
            <h3 class="font-semibold text-gray-900 truncate">{{ $slide->title ?: 'Untitled slide' }}</h3>
            @if($slide->link)
                <p class="text-xs text-gray-500 truncate mt-1"><i class="fas fa-link mr-1"></i>{{ $slide->link }}</p>
            @else
                <p class="text-xs text-gray-400 mt-1">No link (image only)</p>
            @endif
            <div class="flex items-center gap-2 mt-4">
                <a href="{{ route('admin.promo-popup.edit', $slide) }}" class="flex-1 text-center py-2 rounded-lg bg-blue-50 text-blue-700 text-sm font-medium hover:bg-blue-100">
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
                <form action="{{ route('admin.promo-popup.toggle-status', $slide) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-3 py-2 rounded-lg bg-gray-50 text-gray-700 hover:bg-gray-100" title="Toggle status">
                        <i class="fas fa-power-off"></i>
                    </button>
                </form>
                <form action="{{ route('admin.promo-popup.destroy', $slide) }}" method="POST" onsubmit="return confirm('Delete this slide?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
