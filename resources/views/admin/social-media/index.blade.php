@extends('layouts.admin')

@section('title', 'Social Media - Admin Panel')
@section('page-title', 'Social Media Links')
@section('page-description', 'Manage Facebook, Instagram, and TripAdvisor links on the homepage')

@section('content')
@if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <ul class="mt-1 list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <p class="text-sm text-gray-600">Configured links</p>
        <p class="text-2xl font-bold text-gray-900">
            {{ collect($links)->filter(fn ($l) => filled($l['value']))->count() }} / {{ count($links) }}
        </p>
    </div>
    <div class="bg-white rounded-2xl shadow-lg p-6 lg:col-span-2">
        <p class="text-sm text-gray-600 mb-1">Homepage display</p>
        <p class="text-gray-800 text-sm">
            Active links appear as fixed buttons on the left side of the homepage. Visitors open them in a new tab.
        </p>
        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center mt-3 text-sm font-medium text-blue-600 hover:text-blue-800">
            <i class="fas fa-external-link-alt mr-2"></i>Preview homepage
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.social-media.update') }}" class="space-y-6">
    @csrf
    @method('PUT')

    @foreach($links as $key => $link)
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl {{ $link['color'] }} flex items-center justify-center text-white text-2xl shadow-md">
                    <i class="{{ $link['icon'] }}" aria-hidden="true"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <label for="{{ $key }}" class="block text-lg font-semibold text-gray-900 mb-1">
                        {{ $link['label'] }}
                    </label>
                    <p class="text-sm text-gray-500 mb-3">{{ $link['description'] }}</p>
                    <input type="url"
                           name="{{ $key }}"
                           id="{{ $key }}"
                           value="{{ old($key, $link['value']) }}"
                           placeholder="{{ $link['placeholder'] }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error($key) border-red-500 @enderror"
                           autocomplete="url">
                    @error($key)
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if(filled(old($key, $link['value'])))
                        <a href="{{ old($key, $link['value']) }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center mt-3 text-sm text-blue-600 hover:text-blue-800">
                            <i class="fas fa-link mr-2"></i>Test link
                        </a>
                    @else
                        <p class="mt-3 text-sm text-amber-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Leave empty to hide this button on the homepage.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <p class="text-sm text-gray-500">
            URLs must start with <code class="text-xs bg-gray-100 px-1 rounded">https://</code>
        </p>
        <button type="submit"
                class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
            <i class="fas fa-save mr-2"></i>
            Save links
        </button>
    </div>
</form>
@endsection
