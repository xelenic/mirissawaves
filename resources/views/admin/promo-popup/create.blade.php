@extends('layouts.admin')

@section('title', 'Add Promo Slide - Admin Panel')
@section('page-title', 'Add Promo Slide')
@section('page-description', 'Upload a new startup popup banner')

@section('content')
<form action="{{ route('admin.promo-popup.store') }}" method="POST" class="max-w-3xl">
    @csrf
    @include('admin.promo-popup._form', ['geminiConfigured' => $geminiConfigured ?? false])

    <div class="flex items-center gap-3 mt-6">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
            <i class="fas fa-save mr-2"></i>Save slide
        </button>
        <a href="{{ route('admin.promo-popup.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
    </div>
</form>
@endsection
