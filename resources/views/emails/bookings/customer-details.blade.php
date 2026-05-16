<x-mail::message>
@if($event === 'payment_confirmed')
# Your booking is confirmed

Hi {{ $booking->full_name }},

Thank you for your payment. Your **{{ $booking->order_type_label }}** with {{ config('app.name') }} is now confirmed.
@else
# We received your booking

Hi {{ $booking->full_name }},

Thank you for booking with **{{ config('app.name') }}**. Here are your booking details. Please complete payment to confirm your reservation.
@endif

## Booking summary

**Reference:** {{ $booking->reference_number }}  
**Type:** {{ $booking->order_type_label }}  
**Status:** {{ ucfirst($booking->status) }}  
**Payment:** {{ $booking->payment_status_text }}  
**Total:** {{ $booking->formatted_amount }}

@if($booking->package)
## Package

**{{ $booking->package->title }}**  
@if($booking->package->category)
{{ $booking->package->category->name }}  
@endif
@if($booking->package->duration)
Duration: {{ $booking->package->duration }}  
@endif
@endif

@if($booking->vehicle)
## Vehicle transfer

**Vehicle:** {{ $booking->vehicle->name }}  
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

## Travel details

@if($booking->travel_date)
**Date:** {{ $booking->travel_date->format('l, F j, Y') }}  
@endif
**Travelers:** {{ $booking->travelers }}

@if($booking->special_requirements)
**Special requests:**  
{{ $booking->special_requirements }}
@endif

@if($event === 'payment_confirmed')
<x-mail::button :url="$receiptUrl">
View receipt
</x-mail::button>

<x-mail::button :url="$bookingsUrl" color="success">
My bookings
</x-mail::button>
@elseif($booking->payment_status === 'pending')
<x-mail::button :url="$paymentUrl">
Complete payment
</x-mail::button>
@endif

If you have questions, reply to this email or contact us at {{ config('mail.from.address') }}.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
