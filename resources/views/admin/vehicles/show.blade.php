@extends('layouts.admin')

@section('title', 'Vehicle Details - Admin Panel')
@section('page-title', 'Vehicle Details')
@section('page-description', 'View vehicle information')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.vehicles.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Vehicles
        </a>
    </div>

    <!-- Vehicle Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-20 h-20 rounded-lg overflow-hidden mr-6">
                    <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $vehicle->name }}</h1>
                    <p class="text-gray-600">{{ $vehicle->registration_number }}</p>
                    <div class="flex items-center mt-2 space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($vehicle->type) }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vehicle->status_badge }}">
                            {{ ucfirst(str_replace('_', ' ', $vehicle->status)) }}
                        </span>
                        @if(!$vehicle->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form method="POST" action="{{ route('admin.vehicles.toggle-status', $vehicle) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 {{ $vehicle->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <i class="fas fa-{{ $vehicle->is_active ? 'pause' : 'play' }} mr-2"></i>{{ $vehicle->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.vehicles.destroy', $vehicle) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Brand</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->brand ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Model</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->model ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Color</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->color ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Manufacturing Year</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->manufacturing_year ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Capacity & Pricing -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Capacity & Pricing</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Maximum PAX</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->pax_count }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Passengers</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->passenger_count }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price for First 1km</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->formatted_price_first_km }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price per 100m After</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->formatted_price_per_100m_after }}</p>
                    </div>
                </div>
            </div>

            <!-- Driver Information -->
            @if($vehicle->driver_name)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Driver Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Driver Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->driver_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->driver_phone }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">License Number</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->driver_license_number ?: '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Vehicle Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fuel Type</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->fuel_type ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fuel Capacity</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->fuel_capacity ? $vehicle->fuel_capacity . ' L' : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mileage</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $vehicle->mileage ? $vehicle->mileage . ' km/L' : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vehicle->status_badge }}">
                            {{ ucfirst(str_replace('_', ' ', $vehicle->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Available Locations -->
            @if($vehicle->available_locations && count($vehicle->available_locations) > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Available Locations</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($vehicle->available_locations as $location)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $location }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Features & Amenities -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Features & Amenities</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($vehicle->features && count($vehicle->features) > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                        <div class="space-y-1">
                            @foreach($vehicle->features as $feature)
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span class="text-sm text-gray-900">{{ $feature }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($vehicle->amenities && count($vehicle->amenities) > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amenities</label>
                        <div class="space-y-1">
                            @foreach($vehicle->amenities as $amenity)
                            <div class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span class="text-sm text-gray-900">{{ $amenity }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($vehicle->description)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $vehicle->description }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Created</span>
                        <span class="text-sm font-medium text-gray-900">{{ $vehicle->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Last Updated</span>
                        <span class="text-sm font-medium text-gray-900">{{ $vehicle->updated_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Availability</span>
                        <span class="text-sm font-medium {{ $vehicle->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $vehicle->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Additional Images -->
            @if($vehicle->images && count($vehicle->images) > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Images</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($vehicle->images as $image)
                    <div class="aspect-square rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($image) }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Insurance Information -->
            @if($vehicle->insurance_amount || $vehicle->insurance_expiry_date)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Insurance Information</h3>
                <div class="space-y-3">
                    @if($vehicle->insurance_amount)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Insurance Amount</label>
                        <p class="text-sm text-gray-900">${{ number_format($vehicle->insurance_amount, 2) }}</p>
                    </div>
                    @endif
                    @if($vehicle->insurance_expiry_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->insurance_expiry_date->format('M d, Y') }}</p>
                        @if($vehicle->insurance_expiry_date->isPast())
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                Expired
                            </span>
                        @elseif($vehicle->insurance_expiry_date->diffInDays() <= 30)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                Expires Soon
                            </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Maintenance Information -->
            @if($vehicle->last_maintenance_date || $vehicle->next_maintenance_date)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Maintenance Information</h3>
                <div class="space-y-3">
                    @if($vehicle->last_maintenance_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Maintenance</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->last_maintenance_date->format('M d, Y') }}</p>
                        @if($vehicle->last_maintenance_cost)
                            <p class="text-xs text-gray-500">Cost: ${{ number_format($vehicle->last_maintenance_cost, 2) }}</p>
                        @endif
                    </div>
                    @endif
                    @if($vehicle->next_maintenance_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Next Maintenance</label>
                        <p class="text-sm text-gray-900">{{ $vehicle->next_maintenance_date->format('M d, Y') }}</p>
                        @if($vehicle->next_maintenance_date->isPast())
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                Overdue
                            </span>
                        @elseif($vehicle->next_maintenance_date->diffInDays() <= 7)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                Due Soon
                            </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection