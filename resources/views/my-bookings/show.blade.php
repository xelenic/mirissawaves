@extends('layouts.app')

@section('title', 'Booking Details - Mirissawaves')
@section('description', 'View detailed information about your tour booking.')

@section('content')
<!-- Hero Section -->
<section class="relative page-hero flex items-center justify-center overflow-hidden min-h-[32vh] sm:min-h-[38vh]">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $booking->package?->image_url ?? ($booking->vehicle?->image_url ?? 'https://images.unsplash.com/photo-1551632811-561732d7e918?w=1920') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-green-900/70"></div>
    </div>
    
    <div class="relative z-10 text-center text-white px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold playfair mb-4 animate-fade-in">
                Booking
                <span class="gradient-text">Details</span>
            </h1>
            <p class="text-lg md:text-xl mb-6 opacity-90 animate-fade-in-delay">
                Booking #{{ $booking->id }} - {{ $booking->package?->title ?? ($booking->vehicle?->name ?? 'Booking') }}
            </p>
        </div>
    </div>
</section>

<!-- Booking Details Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    @if($booking->package)
                    <!-- Package Information -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Package Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <img src="{{ $booking->package->image_url ?? 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=400' }}" alt="{{ $booking->package->title ?? 'Package' }}" class="w-24 h-24 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $booking->package->title ?? 'Package' }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $booking->package->category?->name ?? 'Category' }}</p>
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($booking->package->description ?? '', 150) }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span><i class="fas fa-clock mr-1"></i>{{ $booking->package->duration ?? 'N/A' }}</span>
                                        <span><i class="fas fa-users mr-1"></i>{{ $booking->package->group_size ?? 'N/A' }}</span>
                                        <span><i class="fas fa-signal mr-1"></i>{{ $booking->package->difficulty ?? 'N/A' }}</span>
                                        @if($booking->package?->rating)
                                        <span><i class="fas fa-star mr-1 text-yellow-500"></i>{{ $booking->package->rating }}/5</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Package Highlights -->
                            @if($booking->package->highlights && count($booking->package->highlights) > 0)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Package Highlights</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($booking->package->highlights as $highlight)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        {{ $highlight }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @elseif($booking->vehicle)
                    <!-- Vehicle Information -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Vehicle Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <img src="{{ $booking->vehicle->image_url ?? 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400' }}" alt="{{ $booking->vehicle->name ?? 'Vehicle' }}" class="w-24 h-24 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $booking->vehicle->name ?? 'Vehicle' }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ ucfirst(str_replace('_', ' ', $booking->vehicle->type ?? 'vehicle')) }}</p>
                                    <p class="text-sm text-gray-600 mb-3">{{ $booking->vehicle->description ?? 'Vehicle booking details' }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span><i class="fas fa-users mr-1"></i>{{ $booking->vehicle->pax_count ?? 'N/A' }} passengers</span>
                                        @if($booking->pickupLocation && $booking->destinationLocation)
                                        <span><i class="fas fa-route mr-1"></i>{{ $booking->pickupLocation->name }} → {{ $booking->destinationLocation->name }}</span>
                                        @endif
                                        @if($booking->distance)
                                        <span><i class="fas fa-map-marker-alt mr-1"></i>{{ number_format($booking->distance, 2) }} km</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Booking Details -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Booking Details</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $booking->pickup_date ? 'Pickup Date' : 'Travel Date' }}</label>
                                    <p class="text-sm text-gray-900">{{ ($booking->pickup_date ?? $booking->travel_date)->format('F d, Y') }}</p>
                                </div>
                                @if($booking->pickup_time)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Time</label>
                                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->pickup_time)->format('g:i A') }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of {{ $booking->vehicle ? 'Passengers' : 'Travelers' }}</label>
                                    <p class="text-sm text-gray-900">{{ $booking->passengers ?? $booking->travelers ?? 1 }} {{ Str::plural('person', $booking->passengers ?? $booking->travelers ?? 1) }}</p>
                                </div>
                                @if($booking->package)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Package Price</label>
                                    <p class="text-sm text-gray-900">{{ $booking->package->formatted_price ?? 'N/A' }} per person</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                                    <p class="text-lg font-semibold text-gray-900">{{ $booking->formatted_amount }}</p>
                                </div>
                                @if($booking->pickupLocation && $booking->destinationLocation)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Route</label>
                                    <p class="text-sm text-gray-900">{{ $booking->pickupLocation->name }} → {{ $booking->destinationLocation->name }}</p>
                                </div>
                                @endif
                                @if($booking->distance)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Distance</label>
                                    <p class="text-sm text-gray-900">{{ number_format($booking->distance, 2) }} km</p>
                                </div>
                                @endif
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests</label>
                                    <p class="text-sm text-gray-900">{{ $booking->special_requirements ?? $booking->special_requests ?: 'No special requests' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Itinerary Information -->
                    @if($booking->package && $booking->package->itinerary)
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Tour Itinerary</h2>
                        </div>
                        <div class="p-6">
                            <div class="prose prose-sm max-w-none">
                                {!! nl2br(e($booking->package->itinerary)) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- What's Included -->
                    @if($booking->package && ($booking->package->included || $booking->package->not_included))
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">What's Included</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($booking->package->included)
                                <div>
                                    <h4 class="text-sm font-semibold text-green-700 mb-3 flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i>Included
                                    </h4>
                                    <div class="prose prose-sm max-w-none text-gray-600">
                                        {!! nl2br(e($booking->package->included)) !!}
                                    </div>
                                </div>
                                @endif
                                
                                @if($booking->package->not_included)
                                <div>
                                    <h4 class="text-sm font-semibold text-red-700 mb-3 flex items-center">
                                        <i class="fas fa-times-circle mr-2"></i>Not Included
                                    </h4>
                                    <div class="prose prose-sm max-w-none text-gray-600">
                                        {!! nl2br(e($booking->package->not_included)) !!}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Payment Information -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Payment Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $booking->payment_status_badge }}">
                                        {{ ucfirst($booking->payment_status ?? 'pending') }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                    <p class="text-sm text-gray-900">{{ ucfirst($booking->payment_method ?? 'PayHere') }}</p>
                                </div>
                                @if($booking->payhere_order_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">PayHere Order ID</label>
                                    <p class="text-sm text-gray-900 font-mono">{{ $booking->payhere_order_id }}</p>
                                </div>
                                @endif
                                @if($booking->payhere_payment_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">PayHere Payment ID</label>
                                    <p class="text-sm text-gray-900 font-mono">{{ $booking->payhere_payment_id }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Date</label>
                                    <p class="text-sm text-gray-900">
                                        @if($booking->payment_status === 'paid')
                                            {{ $booking->updated_at->format('F d, Y \a\t g:i A') }}
                                        @else
                                            Not paid yet
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Booking Status -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Booking Status</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center">
                                <span class="inline-flex px-4 py-2 text-lg font-semibold rounded-full {{ $booking->status_badge }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                @if($booking->status === 'pending')
                                    <p class="text-sm text-yellow-600 mt-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        Awaiting Confirmation
                                    </p>
                                @elseif($booking->status === 'confirmed')
                                    <p class="text-sm text-green-600 mt-2">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Confirmed & Ready
                                    </p>
                                @elseif($booking->status === 'completed')
                                    <p class="text-sm text-purple-600 mt-2">
                                        <i class="fas fa-star mr-1"></i>
                                        Tour Completed
                                    </p>
                                @elseif($booking->status === 'cancelled')
                                    <p class="text-sm text-red-600 mt-2">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Booking Cancelled
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Actions</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            @if($booking->status === 'pending')
                                <a href="{{ route('my-bookings.edit', $booking) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors duration-300 flex items-center justify-center">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Booking
                                </a>
                                <form method="POST" action="{{ route('my-bookings.cancel', $booking) }}" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors duration-300 flex items-center justify-center">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('my-bookings.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Bookings
                            </a>
                            
                            <a href="{{ route('packages') }}" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors duration-300 flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i>
                                Book Another Tour
                            </a>
                        </div>
                    </div>

                    <!-- Important Information -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Important Information</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 mb-2">Booking Reference</h4>
                                <p class="text-sm text-gray-600 font-mono">#{{ $booking->id }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 mb-2">Booking Date</h4>
                                <p class="text-sm text-gray-600">{{ $booking->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            
                            @if($booking->package && $booking->package->requirements)
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900 mb-2">Requirements</h4>
                                <div class="text-sm text-gray-600">
                                    {!! nl2br(e($booking->package->requirements)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Cancellation Policy -->
                    @if($booking->package && $booking->package->cancellation_policy)
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Cancellation Policy</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-sm text-gray-600">
                                {!! nl2br(e($booking->package->cancellation_policy)) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Contact Support -->
                    <div class="bg-gradient-to-br from-blue-50 to-green-50 rounded-xl shadow-md">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Need Help?</h3>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-600 mb-4">Have questions about your booking? Our support team is here to help!</p>
                            <div class="space-y-2">
                                <a href="tel:+94775523939" class="flex items-center text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-phone mr-2"></i>
                                    +94 77 552 3939
                                </a>
                                <a href="mailto:info@mirissawaves.com" class="flex items-center text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-envelope mr-2"></i>
                                    info@mirissawaves.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

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

