@extends('layouts.admin')

@section('title', 'Edit Location-Vehicle Price - Admin Panel')
@section('page-title', 'Edit Location-Vehicle Price')
@section('page-description', 'Update the price for a route and vehicle combination')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.location-vehicle-prices.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Location-Vehicle Price</h2>
                <p class="text-gray-600">Update the price for {{ $locationVehiclePrice->pickupLocation->name }} → {{ $locationVehiclePrice->destinationLocation->name }}</p>
            </div>
        </div>

        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.location-vehicle-prices.update', $locationVehiclePrice) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pickup Location -->
                <div>
                    <label for="pickup_location_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pickup Location <span class="text-red-500">*</span>
                    </label>
                    <select id="pickup_location_id" name="pickup_location_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pickup_location_id') border-red-500 @enderror">
                        <option value="">Select pickup location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('pickup_location_id', $locationVehiclePrice->pickup_location_id) == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('pickup_location_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination Location -->
                <div>
                    <label for="destination_location_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Destination Location <span class="text-red-500">*</span>
                    </label>
                    <select id="destination_location_id" name="destination_location_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('destination_location_id') border-red-500 @enderror">
                        <option value="">Select destination location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('destination_location_id', $locationVehiclePrice->destination_location_id) == $location->id ? 'selected' : '' }}>
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_location_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Vehicle -->
            <div>
                <label for="vehicle_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Vehicle <span class="text-red-500">*</span>
                </label>
                <select id="vehicle_id" name="vehicle_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('vehicle_id') border-red-500 @enderror">
                    <option value="">Select vehicle</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $locationVehiclePrice->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->name }} - {{ ucfirst(str_replace('_', ' ', $vehicle->type)) }} ({{ $vehicle->pax_count }} passengers)
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                    Price (USD) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" id="price" name="price" step="0.01" min="0" required
                           value="{{ old('price', $locationVehiclePrice->price) }}"
                           placeholder="0.00"
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror">
                </div>
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" name="description" rows="4"
                          placeholder="Optional description for this price..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $locationVehiclePrice->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $locationVehiclePrice->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Active (uncheck to deactivate)</span>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.location-vehicle-prices.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Update Price
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pickupSelect = document.getElementById('pickup_location_id');
    const destinationSelect = document.getElementById('destination_location_id');
    
    // Update destination options when pickup changes
    pickupSelect.addEventListener('change', function() {
        const selectedPickup = this.value;
        const destinationOptions = destinationSelect.querySelectorAll('option');
        
        destinationOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else if (option.value === selectedPickup) {
                option.style.display = 'none';
            } else {
                option.style.display = 'block';
            }
        });
        
        // Reset destination if it matches pickup
        if (destinationSelect.value === selectedPickup) {
            destinationSelect.value = '';
        }
    });
    
    // Initial call to set up the options
    pickupSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection

