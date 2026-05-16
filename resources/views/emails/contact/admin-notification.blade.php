<x-mail::message>
# New contact form message

**From:** {{ $inquiry['name'] }}  
**Email:** {{ $inquiry['email'] }}  
@if(!empty($inquiry['phone']))
**Phone:** {{ $inquiry['phone'] }}  
@endif
@if(!empty($inquiry['tour_interest']))
**Interest:** {{ $inquiry['tour_interest'] }}  
@endif
@if(!empty($inquiry['travel_dates']))
**Preferred dates:** {{ $inquiry['travel_dates'] }}  
@endif
@if(!empty($inquiry['group_size']))
**Group size:** {{ $inquiry['group_size'] }}  
@endif

**Message:**

{{ $inquiry['message'] }}

Reply directly to this email to respond to the customer.

</x-mail::message>
