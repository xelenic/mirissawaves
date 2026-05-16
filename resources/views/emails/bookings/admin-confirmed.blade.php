<x-mail::message>
# New paid booking

A customer completed payment for booking **{{ $booking->reference_number }}**.

**Customer:** {{ $booking->full_name }}  
**Email:** {{ $booking->email }}  
**Phone:** {{ $booking->phone ?: '—' }}  
**Trip:** {{ $summary }}  
@if($booking->travel_date)
**Date:** {{ $booking->travel_date->format('Y-m-d') }}  
@endif
**Amount:** {{ $booking->formatted_amount }}  
**PayHere order:** {{ $booking->payhere_order_id ?: '—' }}

<x-mail::button :url="$adminUrl">
View in admin
</x-mail::button>

</x-mail::message>
