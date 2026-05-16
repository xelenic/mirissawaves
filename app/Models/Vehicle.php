<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'type',
        'pax_count',
        'passenger_count',
        'pricing_type',
        'per_km_price',
        'first_km_price',
        'per_100m_price',
        'price_first_km',
        'price_per_100m_after',
        'available_locations',
        'driver_name',
        'driver_phone',
        'driver_license_number',
        'manufacturing_year',
        'brand',
        'model',
        'color',
        'fuel_type',
        'fuel_capacity',
        'mileage',
        'features',
        'amenities',
        'description',
        'image',
        'images',
        'gallery_images',
        'status',
        'is_active',
        'insurance_amount',
        'insurance_expiry_date',
        'last_maintenance_cost',
        'last_maintenance_date',
        'next_maintenance_date',
        'admin_notes',
        'media_id',
    ];

    protected $casts = [
        'available_locations' => 'array',
        'features' => 'array',
        'amenities' => 'array',
        'images' => 'array',
        'gallery_images' => 'array',
        'per_km_price' => 'decimal:2',
        'first_km_price' => 'decimal:2',
        'per_100m_price' => 'decimal:2',
        'price_first_km' => 'decimal:2',
        'price_per_100m_after' => 'decimal:2',
        'fuel_capacity' => 'decimal:2',
        'mileage' => 'decimal:2',
        'insurance_amount' => 'decimal:2',
        'last_maintenance_cost' => 'decimal:2',
        'is_active' => 'boolean',
        'insurance_expiry_date' => 'date',
        'last_maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
    ];

    /**
     * Get the vehicle type badge color
     */
    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            'car' => 'bg-blue-100 text-blue-800',
            'lorry' => 'bg-gray-100 text-gray-800',
            'van' => 'bg-green-100 text-green-800',
            'bus' => 'bg-purple-100 text-purple-800',
            'jeep' => 'bg-yellow-100 text-yellow-800',
            'tuk_tuk' => 'bg-pink-100 text-pink-800',
            'motorcycle' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'available' => 'bg-green-100 text-green-800',
            'busy' => 'bg-yellow-100 text-yellow-800',
            'maintenance' => 'bg-orange-100 text-orange-800',
            'out_of_service' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the media relationship
     */
    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    /**
     * Get the vehicle image URL
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->media) {
            return $this->media->url;
        }
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-vehicle.jpg');
    }

    /**
     * Get formatted first 1km price
     */
    public function getFormattedPriceFirstKmAttribute(): string
    {
        return '$' . number_format($this->price_first_km, 2);
    }

    /**
     * Get formatted after 100m price
     */
    public function getFormattedPricePer100mAfterAttribute(): string
    {
        return '$' . number_format($this->price_per_100m_after, 2);
    }

    /**
     * Get formatted per km price
     */
    public function getFormattedPerKmPriceAttribute(): string
    {
        return $this->per_km_price ? '$' . number_format($this->per_km_price, 2) : 'N/A';
    }

    /**
     * Get formatted first km price
     */
    public function getFormattedFirstKmPriceAttribute(): string
    {
        return $this->first_km_price ? '$' . number_format($this->first_km_price, 2) : 'N/A';
    }

    /**
     * Get formatted per 100m price
     */
    public function getFormattedPer100mPriceAttribute(): string
    {
        return $this->per_100m_price ? '$' . number_format($this->per_100m_price, 2) : 'N/A';
    }

    /**
     * Get pricing type label
     */
    public function getPricingTypeLabelAttribute(): string
    {
        return match($this->pricing_type) {
            'standard' => 'Standard Pricing (Per 1km)',
            'first_km_meter' => 'First KM + Per 100m',
            default => 'Standard Pricing',
        };
    }

    /**
     * Get formatted insurance amount
     */
    public function getFormattedInsuranceAmountAttribute(): string
    {
        return $this->insurance_amount ? '$' . number_format($this->insurance_amount, 2) : 'N/A';
    }

    /**
     * Get formatted maintenance cost
     */
    public function getFormattedMaintenanceCostAttribute(): string
    {
        return $this->last_maintenance_cost ? '$' . number_format($this->last_maintenance_cost, 2) : 'N/A';
    }

    /**
     * Check if vehicle is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->is_active;
    }

    /**
     * Check if insurance is expired
     */
    public function isInsuranceExpired(): bool
    {
        return $this->insurance_expiry_date && $this->insurance_expiry_date < now();
    }

    /**
     * Check if maintenance is due
     */
    public function isMaintenanceDue(): bool
    {
        return $this->next_maintenance_date && $this->next_maintenance_date <= now();
    }

    /**
     * Scope for active vehicles
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for available vehicles
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope by vehicle type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope by location
     */
    public function scopeByLocation($query, $location)
    {
        return $query->whereJsonContains('available_locations', $location);
    }
}