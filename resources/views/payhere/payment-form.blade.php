@extends('layouts.app')

@section('title', 'Payment - Mirissawaves')

@section('content')
<div class="payhere-page min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 playfair mb-4">Complete Your Payment</h1>
            <p class="text-lg text-gray-600">Secure payment powered by PayHere ({{ config('payhere.currency', 'USD') }})</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Booking Summary -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 playfair mb-6">Booking Summary</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        @if($booking->package)
                            <img src="{{ $booking->package->image_url ?? asset('images/default-package.jpg') }}" alt="{{ $booking->package->title ?? 'Package' }}" 
                                 class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $booking->package->title ?? 'Package' }}</h3>
                                <p class="text-sm text-gray-600">{{ $booking->package->duration ?? 'N/A' }}</p>
                            </div>
                        @elseif($booking->vehicle)
                            <img src="{{ asset('images/default-vehicle.jpg') }}" alt="{{ $booking->vehicle->name ?? 'Vehicle' }}" 
                                 class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $booking->vehicle->name ?? 'Vehicle' }}</h3>
                                <p class="text-sm text-gray-600">Vehicle Booking</p>
                            </div>
                        @else
                            <img src="{{ asset('images/default-booking.jpg') }}" alt="Booking" 
                                 class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <h3 class="font-semibold text-gray-900">Booking #{{ $booking->id }}</h3>
                                <p class="text-sm text-gray-600">{{ ucfirst($booking->booking_type ?? 'booking') }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Travel Date:</span>
                            <span class="font-semibold">{{ $booking->travel_date->format('M d, Y') }}</span>
                        </div>
                        @if($booking->package)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Travelers:</span>
                                <span class="font-semibold">{{ $booking->travelers ?? 1 }} {{ ($booking->travelers ?? 1) == 1 ? 'Person' : 'People' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Package Price:</span>
                                <span class="font-semibold">{{ $booking->package->formatted_price ?? 'N/A' }}</span>
                            </div>
                        @elseif($booking->vehicle)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Passengers:</span>
                                <span class="font-semibold">{{ $booking->passengers ?? 1 }} {{ ($booking->passengers ?? 1) == 1 ? 'Person' : 'People' }}</span>
                            </div>
                            @if($booking->distance)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Distance:</span>
                                <span class="font-semibold">{{ number_format($booking->distance, 2) }} km</span>
                            </div>
                            @endif
                        @endif
                        <div class="flex justify-between text-lg font-bold border-t pt-2">
                            <span>Total Amount:</span>
                            <span class="text-blue-600">{{ $booking->formatted_amount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 playfair mb-6">Payment Details</h2>
                
                <div class="space-y-6">
                    <!-- Customer Info -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Customer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                <p class="text-gray-900">{{ $booking->full_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="text-gray-900">{{ $booking->email }}</p>
                            </div>
                            @if($booking->phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="text-gray-900">{{ $booking->phone }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Payment Method</h3>
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-blue-900">PayHere Payment Gateway</p>
                                    <p class="text-sm text-blue-700">You will be charged in {{ config('payhere.currency', 'USD') }} (US dollars)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pay Button -->
                    <form id="payhere-form" method="POST" action="{{ config('payhere.sandbox_mode') ? config('payhere.urls.sandbox') : config('payhere.urls.live') }}">
                        @foreach($paymentData as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 px-6 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Pay {{ $booking->formatted_amount }} Securely
                            </div>
                        </button>
                    </form>

                    <!-- Security Notice -->
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-green-800">Secure Payment</p>
                                <p class="text-xs text-green-700 mt-1">Your payment information is encrypted and secure. We never store your payment details.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8">
            @if($booking->package)
                <a href="{{ route('package.details', $booking->package->slug) }}" 
                   class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Package Details
                </a>
            @elseif($booking->vehicle)
                <a href="{{ route('home') }}#booking" 
                   class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            @else
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            @endif
        </div>
    </div>
</div>

<script>
// Auto-submit form after a short delay to show the payment page
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.getElementById('payhere-form').submit();
    }, 2000);
});
</script>
@endsection
