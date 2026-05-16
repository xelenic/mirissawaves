<x-mail::message>
@if($event === 'payment_received')
# Payment received — booking details

Payment was completed for **{{ $booking->reference_number }}**.
@else
# New {{ $booking->order_type_label }} — booking details

A customer placed a new order **{{ $booking->reference_number }}** (awaiting payment).
@endif

## Order summary

**Reference:** {{ $booking->reference_number }}  
**Type:** {{ $booking->order_type_label }}  
**Booking status:** {{ ucfirst($booking->status) }}  
**Payment:** {{ $booking->payment_status_text }}  
**Total:** {{ $booking->formatted_amount }}

## Customer

**Name:** {{ $booking->full_name }}  
**Email:** {{ $booking->email }}  
**Phone:** {{ $booking->phone ?: '—' }}

@if($booking->package)
## Package

**Package:** {{ $booking->package->title }}  
@if($booking->package->category)
**Category:** {{ $booking->package->category->name }}  
@endif
@if($booking->package->duration)
**Duration:** {{ $booking->package->duration }}  
@endif
**Price per person:** {{ $booking->package->formatted_price ?? '$'.number_format($booking->package->price, 2) }}
@endif

@if($booking->vehicle)
## Vehicle transfer

**Vehicle:** {{ $booking->vehicle->name }}  
@if($booking->vehicle->vehicle_type)
**Type:** {{ $booking->vehicle->vehicle_type }}  
@endif
@if($booking->pickupLocation && $booking->destinationLocation)
**Route:** {{ $booking->pickupLocation->name }} → {{ $booking->destinationLocation->name }}  
@endif
@if($booking->distance)
**Distance:** {{ number_format((float) $booking->distance, 1) }} km  
@endif
@if($booking->pickup_time)
**Pickup time:** {{ $booking->pickup_time->format('g:i A') }}  
@endif
@endif

## Travel

@if($booking->travel_date)
**Date:** {{ $booking->travel_date->format('l, F j, Y') }}  
@endif
**Travelers:** {{ $booking->travelers }}

@if($booking->special_requirements)
**Special requirements:**  
{{ $booking->special_requirements }}
@endif

@if($booking->payhere_order_id)
**PayHere order ID:** {{ $booking->payhere_order_id }}  
@endif

<x-mail::button :url="$adminUrl">
View booking in admin
</x-mail::button>

</x-mail::message>
