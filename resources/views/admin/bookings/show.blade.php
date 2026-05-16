@extends('layouts.admin')

@section('title', 'Booking Details - Admin Panel')
@section('page-title', 'Booking Details')
@section('page-description', 'View and manage booking information')

@section('header-actions')
<div class="flex items-center space-x-2">
    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $booking->status_badge }}">
        {{ ucfirst($booking->status) }}
    </span>
    <a href="{{ route('admin.bookings') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 text-sm">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Bookings
    </a>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Booking Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <p class="text-sm text-gray-900">{{ $booking->full_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <p class="text-sm text-gray-900">{{ $booking->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <p class="text-sm text-gray-900">{{ $booking->phone ?: 'Not provided' }}</p>
                    </div>
                    @if($booking->user)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Registered User</label>
                        <p class="text-sm text-gray-900">{{ $booking->user->name }} ({{ $booking->user->email }})</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($booking->package)
        <!-- Package Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Package Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Package</label>
                        <p class="text-sm text-gray-900">{{ $booking->package->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <p class="text-sm text-gray-900">{{ $booking->package->category?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                        <p class="text-sm text-gray-900">{{ $booking->package->duration }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price per Person</label>
                        <p class="text-sm text-gray-900">{{ $booking->package->formatted_price }}</p>
                    </div>
                </div>
            </div>
        </div>
        @elseif($booking->vehicle)
        <!-- Vehicle & Route Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Vehicle & Route</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle</label>
                        <p class="text-sm text-gray-900">{{ $booking->vehicle->name }}</p>
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
                        <p class="text-sm text-gray-900">{{ number_format($booking->distance, 1) }} km</p>
                    </div>
                    @endif
                    @if($booking->pickup_time)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Time</label>
                        <p class="text-sm text-gray-900">{{ $booking->pickup_time->format('g:i A') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Travel Details -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Travel Details</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Travel Date</label>
                        <p class="text-sm text-gray-900">{{ $booking->travel_date->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Number of Travelers</label>
                        @php $guestCount = $booking->passengers ?? $booking->travelers ?? 1; @endphp
                        <p class="text-sm text-gray-900">{{ $guestCount }} {{ $guestCount == 1 ? 'Person' : 'People' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->formatted_amount }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Booking Date</label>
                        <p class="text-sm text-gray-900">{{ $booking->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $booking->formatted_amount }}</p>
                    </div>
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

        <!-- Special Requirements -->
        @if($booking->special_requests)
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Special Requirements</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-900">{{ $booking->special_requests }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Payment Status -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Payment Status</h3>
            </div>
            <div class="p-6">
                <div class="text-center">
                    <span class="inline-flex px-4 py-2 text-lg font-semibold rounded-full {{ $booking->payment_status_badge }}">
                        {{ ucfirst($booking->payment_status ?? 'pending') }}
                    </span>
                    @if($booking->payment_status === 'paid')
                        <p class="text-sm text-green-600 mt-2">
                            <i class="fas fa-check-circle mr-1"></i>
                            Payment Completed
                        </p>
                    @elseif($booking->payment_status === 'failed')
                        <p class="text-sm text-red-600 mt-2">
                            <i class="fas fa-times-circle mr-1"></i>
                            Payment Failed
                        </p>
                    @else
                        <p class="text-sm text-yellow-600 mt-2">
                            <i class="fas fa-clock mr-1"></i>
                            Awaiting Payment
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Management -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Status Management</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition-colors duration-300">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Admin Notes</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <textarea name="admin_notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Add admin notes...">{{ $booking->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-semibold transition-colors duration-300">
                        Save Notes
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="mailto:{{ $booking->email }}" class="block w-full bg-blue-50 hover:bg-blue-100 text-blue-700 py-2 px-4 rounded-lg font-semibold transition-colors duration-300 text-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Email
                </a>
                @if($booking->phone)
                <a href="tel:{{ $booking->phone }}" class="block w-full bg-green-50 hover:bg-green-100 text-green-700 py-2 px-4 rounded-lg font-semibold transition-colors duration-300 text-center">
                    <i class="fas fa-phone mr-2"></i>
                    Call Customer
                </a>
                @endif
                @if($booking->package)
                <a href="{{ route('package.details', $booking->package->slug) }}" target="_blank" class="block w-full bg-purple-50 hover:bg-purple-100 text-purple-700 py-2 px-4 rounded-lg font-semibold transition-colors duration-300 text-center">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    View Package
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
