@extends('layouts.app')

@section('title', 'Edit Booking - Mirissawaves')
@section('description', 'Update your tour booking details.')

@section('content')
<!-- Hero Section -->
<section class="relative page-hero flex items-center justify-center overflow-hidden min-h-[32vh] sm:min-h-[38vh]">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $booking->package->image_url }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-green-900/70"></div>
    </div>
    
    <div class="relative z-10 text-center text-white px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold playfair mb-4 animate-fade-in">
                Edit
                <span class="gradient-text">Booking</span>
            </h1>
            <p class="text-lg md:text-xl mb-6 opacity-90 animate-fade-in-delay">
                Update your booking details for {{ $booking->package->title }}
            </p>
        </div>
    </div>
</section>

<!-- Edit Booking Form Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Update Booking Details</h2>
                    <p class="text-sm text-gray-600 mt-1">Booking #{{ $booking->id }}</p>
                </div>
                
                <form method="POST" action="{{ route('my-bookings.update', $booking) }}" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Package Selection -->
                        <div class="md:col-span-2">
                            <label for="package_id" class="block text-sm font-medium text-gray-700 mb-2">Select Package</label>
                            <select id="package_id" name="package_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm">
                                <option value="">Choose a package</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}" 
                                        {{ old('package_id', $booking->package_id) == $package->id ? 'selected' : '' }}
                                        data-price="{{ $package->price }}">
                                        {{ $package->title }} - {{ $package->formatted_price }}
                                    </option>
                                @endforeach
                            </select>
                            @error('package_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Travel Date -->
                        <div>
                            <label for="travel_date" class="block text-sm font-medium text-gray-700 mb-2">Travel Date</label>
                            <input type="date" id="travel_date" name="travel_date" 
                                value="{{ old('travel_date', $booking->travel_date->format('Y-m-d')) }}" 
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm">
                            @error('travel_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Number of Travelers -->
                        <div>
                            <label for="travelers" class="block text-sm font-medium text-gray-700 mb-2">Number of Travelers</label>
                            <select id="travelers" name="travelers" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm">
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}" {{ old('travelers', $booking->travelers) == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ Str::plural('person', $i) }}
                                    </option>
                                @endfor
                            </select>
                            @error('travelers')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Special Requests -->
                        <div class="md:col-span-2">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-2">Special Requests</label>
                            <textarea id="special_requests" name="special_requests" rows="4" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm resize-none"
                                placeholder="Any special dietary requirements, accessibility needs, or other requests...">{{ old('special_requests', $booking->special_requests) }}</textarea>
                            @error('special_requests')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Price Summary</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Package Price:</span>
                            <span class="text-sm font-medium text-gray-900" id="package-price">$0</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-sm text-gray-600">Travelers:</span>
                            <span class="text-sm font-medium text-gray-900" id="travelers-count">0</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-semibold text-gray-900">Total Amount:</span>
                            <span class="text-lg font-bold text-green-600" id="total-amount">$0</span>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white py-3 px-6 rounded-lg text-sm font-semibold transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            Update Booking
                        </button>
                        <a href="{{ route('my-bookings.show', $booking) }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-3 px-6 rounded-lg text-sm font-semibold transition-all duration-300 text-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Current Booking Info -->
            <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Current Booking Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Package</label>
                            <p class="text-sm text-gray-900">{{ $booking->package->title }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Travel Date</label>
                            <p class="text-sm text-gray-900">{{ $booking->travel_date->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Travelers</label>
                            <p class="text-sm text-gray-900">{{ $booking->travelers }} {{ Str::plural('person', $booking->travelers) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageSelect = document.getElementById('package_id');
    const travelersSelect = document.getElementById('travelers');
    const packagePriceSpan = document.getElementById('package-price');
    const travelersCountSpan = document.getElementById('travelers-count');
    const totalAmountSpan = document.getElementById('total-amount');

    function updatePrice() {
        const selectedOption = packageSelect.options[packageSelect.selectedIndex];
        const packagePrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const travelers = parseInt(travelersSelect.value) || 0;
        const totalAmount = packagePrice * travelers;

        packagePriceSpan.textContent = '$' + packagePrice.toFixed(2);
        travelersCountSpan.textContent = travelers;
        totalAmountSpan.textContent = '$' + totalAmount.toFixed(2);
    }

    packageSelect.addEventListener('change', updatePrice);
    travelersSelect.addEventListener('change', updatePrice);

    // Initialize price on page load
    updatePrice();
});
</script>
@endpush

@push('styles')
<style>
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }
    
    .animate-fade-in-delay {
        animation: fadeIn 0.8s ease-out 0.2s both;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush
