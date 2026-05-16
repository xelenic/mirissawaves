<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt #{{ $booking->id }} - {{ config('app.name', 'Mirissawaves') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #111827;
            line-height: 1.5;
            margin: 0;
            padding: 24px;
            background: #f3f4f6;
        }
        .receipt {
            max-width: 720px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #059669;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .header h1 {
            margin: 0 0 4px;
            font-size: 1.75rem;
            color: #047857;
        }
        .header p { margin: 0; color: #6b7280; font-size: 0.95rem; }
        .badge {
            display: inline-block;
            background: #d1fae5;
            color: #065f46;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            text-align: left;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        th {
            width: 38%;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.875rem;
        }
        td { font-size: 0.95rem; }
        .total-row td {
            border-bottom: none;
            font-size: 1.25rem;
            font-weight: 700;
            color: #047857;
            padding-top: 16px;
        }
        .footer {
            text-align: center;
            font-size: 0.8rem;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 16px;
        }
        .actions {
            max-width: 720px;
            margin: 16px auto 0;
            text-align: center;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .btn-primary { background: #059669; color: #fff; }
        .btn-secondary { background: #fff; color: #374151; border: 1px solid #d1d5db; }
        @media print {
            body { background: #fff; padding: 0; }
            .receipt { box-shadow: none; border-radius: 0; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="receipt" id="booking-receipt">
        <div class="header">
            <h1>{{ config('app.name', 'Mirissawaves') }}</h1>
            <p>Booking Confirmation Receipt</p>
            <span class="badge">PAID</span>
        </div>

        <table>
            <tr>
                <th>Booking ID</th>
                <td>#{{ $booking->id }}</td>
            </tr>
            <tr>
                <th>Date issued</th>
                <td>{{ now()->format('M d, Y g:i A') }}</td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>{{ $booking->full_name }}<br>{{ $booking->email }}@if($booking->phone)<br>{{ $booking->phone }}@endif</td>
            </tr>
            @if($booking->package)
            <tr>
                <th>Package</th>
                <td>{{ $booking->package->title }}</td>
            </tr>
            @elseif($booking->vehicle)
            <tr>
                <th>Vehicle</th>
                <td>{{ $booking->vehicle->name }}</td>
            </tr>
            @if($booking->pickupLocation && $booking->destinationLocation)
            <tr>
                <th>Route</th>
                <td>{{ $booking->pickupLocation->name }} → {{ $booking->destinationLocation->name }}</td>
            </tr>
            @endif
            @if($booking->distance)
            <tr>
                <th>Distance</th>
                <td>{{ number_format($booking->distance, 2) }} km</td>
            </tr>
            @endif
            @endif
            <tr>
                <th>{{ $booking->vehicle ? 'Pickup date' : 'Travel date' }}</th>
                <td>{{ $booking->travel_date?->format('M d, Y') ?? 'N/A' }}</td>
            </tr>
            @if($booking->pickup_time)
            <tr>
                <th>Pickup time</th>
                <td>{{ \Carbon\Carbon::parse($booking->pickup_time)->format('g:i A') }}</td>
            </tr>
            @endif
            @php $guestCount = $booking->passengers ?? $booking->travelers ?? 1; @endphp
            <tr>
                <th>{{ $booking->vehicle ? 'Passengers' : 'Travelers' }}</th>
                <td>{{ $guestCount }}</td>
            </tr>
            @if($booking->payhere_order_id)
            <tr>
                <th>Order reference</th>
                <td style="font-family: monospace; font-size: 0.85rem;">{{ $booking->payhere_order_id }}</td>
            </tr>
            @endif
            @if($booking->payhere_payment_id)
            <tr>
                <th>Payment reference</th>
                <td style="font-family: monospace; font-size: 0.85rem;">{{ $booking->payhere_payment_id }}</td>
            </tr>
            @endif
            <tr>
                <th>Payment method</th>
                <td>PayHere ({{ config('payhere.currency', 'USD') }})</td>
            </tr>
            <tr class="total-row">
                <th>Total paid</th>
                <td>{{ $booking->formatted_amount }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Thank you for booking with {{ config('app.name', 'Mirissawaves') }}.</p>
            <p>info@mirissawaves.com · +94 77 552 3939</p>
        </div>
    </div>

    <div class="actions no-print">
        <button type="button" class="btn btn-primary" onclick="window.print()">
            Print / Save as PDF
        </button>
        <a href="{{ route('booking.success', $booking->id) }}" class="btn btn-secondary">Back to confirmation</a>
    </div>

    <script>
        window.addEventListener('load', function () {
            if (new URLSearchParams(window.location.search).get('print') === '1') {
                setTimeout(function () { window.print(); }, 300);
            }
        });
    </script>
</body>
</html>
