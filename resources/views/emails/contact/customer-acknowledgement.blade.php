<x-mail::message>
# Thanks for contacting us

Hi {{ $inquiry['name'] }},

We received your message and will get back to you shortly — usually within a few hours during business days.

@if(!empty($inquiry['message']))
**Your message:**  
{{ $inquiry['message'] }}
@endif

For urgent questions, you can also reach us at {{ config('mail.from.address') }}.

Warm regards,<br>
{{ config('app.name') }}
</x-mail::message>
