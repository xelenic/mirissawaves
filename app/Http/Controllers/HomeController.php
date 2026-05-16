<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageCategory;
use App\Models\Review;
use App\Models\Location;
use App\Models\Vehicle;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured packages for the home page
        $tourPackages = Package::with(['category', 'media'])
            ->active()
            ->featured()
            ->ordered()
            ->limit(6)
            ->get()
            ->map(function ($package) {
                return [
                    'id' => $package->id,
                    'title' => $package->title,
                    'slug' => $package->slug,
                    'description' => $package->description,
                    'duration' => $package->duration,
                    'price' => $package->formatted_price,
                    'original_price' => $package->formatted_original_price,
                    'image' => $package->image_url,
                    'highlights' => $package->highlights ?? [],
                    'category' => $package->category->name,
                    'rating' => $package->rating,
                    'reviews_count' => $package->reviews_count,
                    'difficulty' => $package->difficulty,
                    'group_size' => $package->group_size
                ];
            });

        // Get featured reviews for the home page
        $featuredReviews = Review::with('package')
            ->featured()
            ->approved()
            ->latest()
            ->limit(6)
            ->get();

        // Get active locations for the booking form
        $locations = Location::active()
            ->orderBy('name')
            ->get();

        // Prepare locations data for JavaScript map
        $locationsForMap = $locations->map(function ($location) {
            return [
                'id' => $location->id,
                'name' => $location->name,
                'latitude' => (float) $location->latitude,
                'longitude' => (float) $location->longitude,
                'description' => $location->description
            ];
        });

        // Get active vehicles for the booking form
        $vehicles = Vehicle::active()
            ->orderBy('name')
            ->get()
            ->map(function ($vehicle) {
                return [
                    'id' => $vehicle->id,
                    'name' => $vehicle->name,
                    'type' => $vehicle->type,
                    'type_display' => ucfirst(str_replace('_', ' ', $vehicle->type)),
                    'pax_count' => $vehicle->pax_count,
                    'registration_number' => $vehicle->registration_number,
                    'driver_name' => $vehicle->driver_name,
                    'description' => $this->getVehicleDescription($vehicle),
                    'pricing_type' => $vehicle->pricing_type,
                    'per_km_price' => $vehicle->per_km_price,
                    'first_km_price' => $vehicle->first_km_price,
                    'per_100m_price' => $vehicle->per_100m_price,
                    'price_first_km' => $vehicle->price_first_km,
                    'price_per_100m_after' => $vehicle->price_per_100m_after,
                    'formatted_per_km_price' => $vehicle->formatted_per_km_price,
                    'formatted_first_km_price' => $vehicle->formatted_first_km_price,
                    'formatted_per_100m_price' => $vehicle->formatted_per_100m_price,
                    'pricing_type_label' => $vehicle->pricing_type_label,
                    'effective_pricing_type' => $this->getEffectivePricingType($vehicle)
                ];
            });

        return view('home', compact('tourPackages', 'featuredReviews', 'locations', 'locationsForMap', 'vehicles'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function packages(Request $request)
    {
        $query = Package::with(['category', 'media'])->active()->ordered();
        
        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $packages = $query->get();
        $categories = PackageCategory::active()->ordered()->get();
        
        return view('packages', compact('packages', 'categories'));
    }

    public function packageDetails($slug)
    {
        $package = Package::with(['category', 'media'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related packages from the same category
        $relatedPackages = Package::with(['category', 'media'])
            ->where('package_category_id', $package->package_category_id)
            ->where('id', '!=', $package->id)
            ->where('is_active', true)
            ->limit(3)
            ->get();

        return view('package-details', compact('package', 'relatedPackages'));
    }

    /**
     * Calculate price based on distance and vehicle
     */
    public function calculatePrice(Request $request)
    {
        $request->validate([
            'pickup_location_id' => 'required|exists:locations,id',
            'destination_location_id' => 'required|exists:locations,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'distance' => 'required|numeric|min:0.1'
        ]);

        $pickupLocation = Location::findOrFail($request->pickup_location_id);
        $destinationLocation = Location::findOrFail($request->destination_location_id);
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $distance = $request->distance; // Distance in kilometers

        // Calculate price based on vehicle pricing type
        $price = 0;
        $priceBreakdown = [];

        if ($vehicle->pricing_type === 'first_km_meter') {
            // First KM + Per 100m pricing
            $firstKmPrice = $vehicle->price_first_km ?? 0;
            $per100mPrice = $vehicle->price_per_100m_after ?? 0;
            
            if ($distance <= 1) {
                $price = $firstKmPrice;
                $priceBreakdown[] = "First 1km: $" . number_format($firstKmPrice, 2);
            } else {
                $remainingDistance = $distance - 1;
                $remainingMeters = $remainingDistance * 1000; // Convert to meters
                $additionalPrice = ceil($remainingMeters / 100) * $per100mPrice; // Round up to nearest 100m
                
                $price = $firstKmPrice + $additionalPrice;
                $priceBreakdown[] = "First 1km: $" . number_format($firstKmPrice, 2);
                $priceBreakdown[] = "Additional " . number_format($remainingDistance, 2) . "km: $" . number_format($additionalPrice, 2);
            }
        } else {
            // Standard per KM pricing
            $perKmPrice = $vehicle->per_km_price ?? 0;
            $price = $distance * $perKmPrice;
            $priceBreakdown[] = "Per km rate: $" . number_format($perKmPrice, 2);
            $priceBreakdown[] = "Distance: " . number_format($distance, 2) . "km";
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total_price' => round($price, 2),
                'formatted_price' => '$' . number_format($price, 2),
                'distance' => round($distance, 2),
                'vehicle_name' => $vehicle->name,
                'vehicle_type' => ucfirst(str_replace('_', ' ', $vehicle->type)),
                'pricing_type' => $vehicle->pricing_type,
                'price_breakdown' => $priceBreakdown,
                'pickup_location' => $pickupLocation->name,
                'destination_location' => $destinationLocation->name,
                'route_description' => $pickupLocation->name . ' → ' . $destinationLocation->name
            ]
        ]);
    }

    /**
     * Get effective pricing type based on available pricing data
     */
    private function getEffectivePricingType($vehicle)
    {
        // If per_km_price is available, use standard pricing
        if ($vehicle->per_km_price && $vehicle->per_km_price > 0) {
            return 'standard';
        }
        
        // If first_km_price and per_100m_price are available, use first_km_meter pricing
        if ($vehicle->price_first_km && $vehicle->price_per_100m_after && 
            $vehicle->price_first_km > 0 && $vehicle->price_per_100m_after > 0) {
            return 'first_km_meter';
        }
        
        // Default to standard
        return 'standard';
    }

    /**
     * Get vehicle description
     */
    private function getVehicleDescription($vehicle)
    {
        $description = "{$vehicle->type_display} - {$vehicle['pax_count']} passengers";
        
        if ($vehicle->driver_name) {
            $description .= " (Driver: {$vehicle->driver_name})";
        }
        
        if ($vehicle->registration_number) {
            $description .= " [{$vehicle->registration_number}]";
        }
        
        return $description;
    }

    /**
     * Check if user exists
     */
    public function checkUser(Request $request)
    {
        $email = $request->query('email');
        
        if (!$email) {
            return response()->json([
                'exists' => false
            ]);
        }
        
        $user = \App\Models\User::where('email', $email)->first();
        
        return response()->json([
            'exists' => $user !== null
        ]);
    }
}
