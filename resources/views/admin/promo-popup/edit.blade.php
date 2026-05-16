@extends('layouts.admin')

@section('title', 'Edit Promo Slide - Admin Panel')
@section('page-title', 'Edit Promo Slide')
@section('page-description', 'Update startup popup banner')

@section('content')
<form action="{{ route('admin.promo-popup.update', $slide) }}" method="POST" class="max-w-3xl">
    @csrf
    @method('PUT')
    @include('admin.promo-popup._form', ['slide' => $slide, 'geminiConfigured' => $geminiConfigured ?? false])

    <div class="flex items-center gap-3 mt-6">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
            <i class="fas fa-save mr-2"></i>Update slide
        </button>
        <a href="{{ route('admin.promo-popup.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
    </div>
</form>
@endsection
