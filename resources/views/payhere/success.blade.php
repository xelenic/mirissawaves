@extends('layouts.app')

@section('title', 'Payment Successful - Mirissawaves')

@push('styles')
<style>
    @media print {
        header, footer, nav, .no-print { display: none !important; }
        body { background: #fff !important; }
        #booking-success-print { box-shadow: none !important; }
    }
</style>
@endpush

@section('content')
<div class="payhere-page min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="text-center mb-8">
            <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-900 playfair mb-4">Payment Successful!</h1>
            <p class="text-lg text-gray-600">Your booking has been confirmed and payment processed successfully.</p>
        </div>

        <div id="booking-success-print" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Booking Details -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 playfair mb-6">Booking Confirmation</h2>
                
                <div class="space-y-4">
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-green-900">Booking Confirmed</p>
                                <p class="text-sm text-green-700">Payment Status: Paid</p>
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
                        @if($booking->payhere_payment_id)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Payment Reference</label>
                            <p class="text-gray-900 font-mono text-sm">{{ $booking->payhere_payment_id }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 playfair mb-6">What's Next?</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">1</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Confirmation Email</h3>
                            <p class="text-sm text-gray-600">You'll receive a confirmation email with all booking details within the next few minutes.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">2</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Pre-Trip Information</h3>
                            <p class="text-sm text-gray-600">We'll send you detailed information about your trip, including meeting points and what to bring.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">3</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Contact Support</h3>
                            <p class="text-sm text-gray-600">If you have any questions, feel free to contact our support team anytime.</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mt-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Need Help?</h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <p>📧 Email: info@mirissawaves.com</p>
                        <p>📞 Phone: +94 77 552 3939</p>
                        <p>💬 WhatsApp: +94 77 552 3939</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-8 payhere-actions flex flex-wrap gap-3 justify-center no-print">
            <a href="{{ route('booking.receipt', $booking->id) }}?print=1"
               target="_blank"
               rel="noopener"
               class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print PDF
            </a>
            <a href="{{ route('packages') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Browse More Packages
            </a>
            
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Go Home
            </a>
        </div>
    </div>
</div>
@endsection
