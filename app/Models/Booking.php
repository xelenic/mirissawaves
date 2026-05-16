<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'package_id',
        'user_id',
        'vehicle_id',
        'pickup_location_id',
        'destination_location_id',
        'full_name',
        'email',
        'phone',
        'travel_date',
        'pickup_time',
        'travelers',
        'distance',
        'special_requirements',
        'total_amount',
        'status',
        'admin_notes',
        'payment_status',
        'payment_method',
        'payment_reference',
        'payhere_order_id',
        'payhere_payment_id',
        'confirmation_emailed_at',
        'admin_order_notified_at',
        'customer_order_notified_at',
        'booking_type',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'pickup_time' => 'datetime:H:i',
        'distance' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'confirmation_emailed_at' => 'datetime',
        'admin_order_notified_at' => 'datetime',
        'customer_order_notified_at' => 'datetime',
    ];

    public function loadMailRelations(): self
    {
        return $this->loadMissing([
            'package.category',
            'vehicle',
            'pickupLocation',
            'destinationLocation',
            'user',
        ]);
    }

    public function getOrderTypeLabelAttribute(): string
    {
        if ($this->booking_type === 'vehicle' || $this->vehicle_id) {
            return 'Vehicle transfer';
        }

        return 'Package tour';
    }

    public function isPackageBooking(): bool
    {
        return $this->package_id !== null && $this->booking_type !== 'vehicle';
    }

    public function isVehicleBooking(): bool
    {
        return $this->booking_type === 'vehicle' || $this->vehicle_id !== null;
    }

    public function getReferenceNumberAttribute(): string
    {
        return 'BK-'.str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getSummaryTitleAttribute(): string
    {
        if ($this->booking_type === 'vehicle' && $this->vehicle) {
            return $this->vehicle->name;
        }

        if ($this->package) {
            return $this->package->title;
        }

        return 'Tour booking';
    }

    /**
     * Older views/controllers still read `special_requests`; DB column is `special_requirements`.
     */
    public function getSpecialRequestsAttribute(): ?string
    {
        $v = $this->attributes['special_requirements'] ?? null;

        return $v !== null && $v !== '' ? (string) $v : null;
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function pickupLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'pickup_location_id');
    }

    public function destinationLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'destination_location_id');
    }

    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->total_amount, 2);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'paid' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Check if the booking can be edited by the user
     */
    public function canBeEdited(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the booking can be cancelled by the user
     */
    public function canBeCancelled(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Get the booking status text for display
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Awaiting Confirmation',
            'confirmed' => 'Confirmed & Ready',
            'completed' => 'Tour Completed',
            'cancelled' => 'Booking Cancelled',
            default => 'Unknown Status',
        };
    }

    /**
     * Get the payment status text for display
     */
    public function getPaymentStatusTextAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'Payment Pending',
            'paid' => 'Payment Completed',
            'failed' => 'Payment Failed',
            'cancelled' => 'Payment Cancelled',
            default => 'Unknown Payment Status',
        };
    }

    /**
     * Scope to get bookings for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get bookings by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get bookings by payment status
     */
    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }
}
