@extends('layouts.app')

@section('title', 'Payment Failed - Mirissawaves')

@section('content')
<div class="payhere-page min-h-screen bg-gradient-to-br from-red-50 to-pink-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Error Message -->
        <div class="text-center mb-8">
            <div class="mx-auto w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 playfair mb-4">Payment Failed</h1>
            <p class="text-lg text-gray-600">We're sorry, but your payment could not be processed at this time.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Booking Details -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 playfair mb-6">Booking Details</h2>
                
                <div class="space-y-4">
                    <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-red-900">Payment Failed</p>
                                <p class="text-sm text-red-700">Status: {{ ucfirst($booking->payment_status) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Booking ID</label>
                            <p class="text-gray-900 font-mono">#{{ $booking->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ $booking->package ? 'Package' : ($booking->vehicle ? 'Vehicle & Route' : 'Booking') }}</label>
                            <p class="text-gray-900">
                                @if($booking->package)
                                    {{ $booking->package->title }}
                                @elseif($booking->vehicle)
                                    {{ $booking->vehicle->name }}
                                    @if($booking->pickupLocation && $booking->destinationLocation)
                                        <span class="block text-sm text-gray-600 mt-1">{{ $booking->pickupLocation->name }} → {{ $booking->destinationLocation->name }}</span>
                                    @endif
                                @else
                                    Booking #{{ $booking->id }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Travel Date</label>
                            <p class="text-gray-900">{{ $booking->travel_date?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Travelers</label>
                            @php $guestCount = $booking->passengers ?? $booking->travelers ?? 1; @endphp
                            <p class="text-gray-900">{{ $guestCount }} {{ $guestCount == 1 ? 'Person' : 'People' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                            <p class="text-gray-900 font-semibold text-lg">{{ $booking->formatted_amount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help & Support -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 playfair mb-6">What Can You Do?</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Try Again</h3>
                            <p class="text-sm text-gray-600">You can attempt the payment again. Sometimes temporary issues can cause payment failures.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Different Payment Method</h3>
                            <p class="text-sm text-gray-600">Try using a different card or payment method if available.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Contact Support</h3>
                            <p class="text-sm text-gray-600">Our support team is here to help you complete your booking.</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mt-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Get Help</h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p>📧 Email: info@mirissawaves.com</p>
                        <p>📞 Phone: +94 77 552 3939</p>
                        <p>💬 WhatsApp: +94 77 552 3939</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-8 space-x-4">
            <a href="{{ route('payhere.initialize', ['booking_id' => $booking->id]) }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Try Payment Again
            </a>
            
            @if($booking->package)
            <a href="{{ route('package.details', $booking->package->slug) }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Package
            </a>
            @else
            <a href="{{ url('/#booking') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Booking
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
