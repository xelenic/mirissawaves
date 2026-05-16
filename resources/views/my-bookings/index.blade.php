@extends('layouts.app')

@section('title', 'My Bookings - Mirissawaves')
@section('description', 'View and manage your tour bookings with Mirissawaves.')

@section('content')
<!-- Hero Section -->
<section class="relative page-hero flex items-center justify-center overflow-hidden min-h-[38vh] sm:min-h-[45vh]">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-green-900/70"></div>
    </div>
    
    <div class="relative z-10 text-center text-white px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold playfair mb-4 animate-fade-in">
                My
                <span class="gradient-text">Bookings</span>
            </h1>
            <p class="text-lg md:text-xl mb-6 opacity-90 animate-fade-in-delay">
                Manage your tour bookings and track your Sri Lankan adventures
            </p>
        </div>
    </div>
</section>

<!-- Bookings Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 customer-container">
        <div class="max-w-6xl mx-auto">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl shadow-md p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-calendar-check text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                            <p class="text-xl font-semibold text-gray-900">{{ $bookings->total() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-xl font-semibold text-gray-900">{{ $bookings->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Confirmed</p>
                            <p class="text-xl font-semibold text-gray-900">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-star text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Completed</p>
                            <p class="text-xl font-semibold text-gray-900">{{ $bookings->where('status', 'completed')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($bookings->count() > 0)
                @include('my-bookings._booking-cards-mobile', ['bookings' => $bookings])

                <!-- Bookings Table (desktop) -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden bookings-table-wrap">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Your Bookings</h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travel Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Travelers</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($bookings as $booking)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">#{{ $booking->id }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->created_at->format('M d, Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @if($booking->package)
                                                    <img class="h-12 w-12 rounded-lg object-cover" src="{{ $booking->package->image_url ?? 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=400' }}" alt="{{ $booking->package->title ?? 'Package' }}">
                                                @elseif($booking->vehicle)
                                                    <img class="h-12 w-12 rounded-lg object-cover" src="{{ $booking->vehicle->image_url ?? 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400' }}" alt="{{ $booking->vehicle->name ?? 'Vehicle' }}">
                                                @else
                                                    <img class="h-12 w-12 rounded-lg object-cover" src="https://images.unsplash.com/photo-1551632811-561732d7e918?w=400" alt="Booking">
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                @if($booking->package)
                                                    <div class="text-sm font-medium text-gray-900">{{ $booking->package->title ?? 'Package' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $booking->package->category->name ?? 'Category' }}</div>
                                                @elseif($booking->vehicle)
                                                    <div class="text-sm font-medium text-gray-900">{{ $booking->vehicle->name ?? 'Vehicle' }}</div>
                                                    <div class="text-sm text-gray-500">Vehicle Booking</div>
                                                @else
                                                    <div class="text-sm font-medium text-gray-900">Booking #{{ $booking->id }}</div>
                                                    <div class="text-sm text-gray-500">{{ $booking->booking_type ?? 'Booking' }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->travel_date->format('M d, Y') }}</div>
                                        @if($booking->package)
                                            <div class="text-sm text-gray-500">{{ $booking->package->duration ?? 'N/A' }}</div>
                                        @elseif($booking->vehicle && $booking->distance)
                                            <div class="text-sm text-gray-500">{{ number_format($booking->distance, 2) }} km</div>
                                        @else
                                            <div class="text-sm text-gray-500">Vehicle Booking</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $booking->travelers }} {{ Str::plural('person', $booking->travelers) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->formatted_amount }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $booking->status_badge }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $booking->payment_status_badge }}">
                                            {{ ucfirst($booking->payment_status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('my-bookings.show', $booking) }}" 
                                               class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 hover:text-blue-800 transition-colors duration-200"
                                               title="View Details">
                                                <i class="fas fa-eye mr-1"></i>
                                                View
                                            </a>
                                            @if($booking->status === 'pending')
                                            <a href="{{ route('my-bookings.edit', $booking) }}" 
                                               class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 hover:text-green-800 transition-colors duration-200"
                                               title="Edit Booking">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('my-bookings.cancel', $booking) }}" class="inline" onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-md hover:bg-red-200 hover:text-red-800 transition-colors duration-200"
                                                        title="Cancel Booking">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Cancel
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">No Bookings Yet</h3>
                    <p class="text-gray-600 mb-6">You haven't made any bookings yet. Start exploring our amazing tour packages!</p>
                    <a href="{{ route('packages') }}" class="inline-block bg-gradient-to-r from-blue-600 to-green-600 hover:from-blue-700 hover:to-green-700 text-white px-6 py-3 rounded-full text-sm font-semibold transition-all duration-300 transform hover:scale-105">
                        Browse Packages
                    </a>
                </div>
            @endif
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
