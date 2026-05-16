<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayHereController extends Controller
{
    private $merchantId;
    private $merchantSecret;
    private $sandboxMode;

    public function __construct()
    {
        $this->merchantId = config('payhere.merchant_id');
        $this->merchantSecret = config('payhere.merchant_secret');
        $this->sandboxMode = config('payhere.sandbox_mode', true);
    }

    /**
     * Initialize payment with PayHere
     */
    public function initializePayment(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::with(['package', 'package.media', 'vehicle', 'pickupLocation', 'destinationLocation', 'user'])->findOrFail($request->booking_id);

        // Generate unique order ID
        $orderId = 'BK' . $booking->id . '_' . time();

        // Update booking with PayHere order ID
        $booking->update([
            'payhere_order_id' => $orderId,
            'payment_status' => 'pending',
            'payment_method' => 'payhere'
        ]);

        $currency = strtoupper(config('payhere.currency', 'USD'));
        $amount = number_format((float) $booking->total_amount, 2, '.', '');

        // Prepare payment data
        $paymentData = [
            'merchant_id' => $this->merchantId,
            'return_url' => route('payhere.return'),
            'cancel_url' => route('payhere.cancel'),
            'notify_url' => route('payhere.notify'),
            'first_name' => explode(' ', $booking->full_name)[0] ?? $booking->full_name,
            'last_name' => explode(' ', $booking->full_name)[1] ?? '',
            'email' => $booking->email,
            'phone' => $booking->phone ?? '',
            'address' => 'Sri Lanka',
            'city' => 'Colombo',
            'country' => 'Sri Lanka',
            'order_id' => $orderId,
            'items' => $booking->booking_type === 'vehicle' 
                ? ($booking->vehicle ? $booking->vehicle->name : 'Vehicle Booking')
                : ($booking->package ? $booking->package->title : 'Booking'),
            'currency' => $currency,
            'amount' => $amount,
            'hash' => $this->generateHash($orderId, $amount, $currency)
        ];

        return view('payhere.payment-form', compact('paymentData', 'booking'));
    }

    /**
     * Handle successful payment return
     */
    public function handleReturn(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $paymentId = $request->input('payment_id');
            $status = $request->input('status');

            // Log the request for debugging
            Log::info('PayHere return request:', [
                'order_id' => $orderId,
                'payment_id' => $paymentId,
                'status' => $status,
                'all_params' => $request->all()
            ]);

            $booking = Booking::where('payhere_order_id', $orderId)->first();

            if (!$booking) {
                Log::error('PayHere return: Booking not found for order ID: ' . $orderId);
                return redirect()->route('packages')->with('error', 'Booking not found.');
            }

            // If only order_id is provided, assume payment was successful
            // since PayHere only redirects to return URL on successful payment
            if (!$status && !$paymentId) {
                Log::info('PayHere return: Only order_id provided, assuming payment successful');

                $this->markBookingPaid($booking, null);

                return redirect()->route('booking.success', $booking->id)
                    ->with('success', 'Payment successful! Your booking has been confirmed.');
            }

            // Handle explicit status from PayHere
            if ($status === '2') { // Payment successful
                $this->markBookingPaid($booking, $paymentId);

                return redirect()->route('booking.success', $booking->id)
                    ->with('success', 'Payment successful! Your booking has been confirmed.');
            } else {
                $booking->update([
                    'payment_status' => 'failed'
                ]);

                Log::info('PayHere return: Payment failed for booking ID: ' . $booking->id);

                return redirect()->route('booking.failed', $booking->id)
                    ->with('error', 'Payment failed. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('PayHere return error: ' . $e->getMessage());
            return redirect()->route('packages')->with('error', 'An error occurred while processing your payment.');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function handleCancel(Request $request)
    {
        $orderId = $request->input('order_id');
        $booking = Booking::where('payhere_order_id', $orderId)->first();

        if ($booking) {
            $booking->update([
                'payment_status' => 'cancelled'
            ]);
        }

        if ($booking?->package) {
            return redirect()->route('package.details', $booking->package->slug)
                ->with('error', 'Payment was cancelled. You can try again anytime.');
        }

        return redirect()->to(url('/#booking'))
            ->with('error', 'Payment was cancelled. You can try again anytime.');
    }

    /**
     * Handle payment notifications from PayHere
     */
    public function handleNotify(Request $request)
    {
        try {
            // Log all notification requests for debugging
            Log::info('PayHere notification received:', [
                'all_params' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            $orderId = $request->input('order_id');
            $paymentId = $request->input('payment_id');
            $status = $request->input('status');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
            $hash = $request->input('hash');

            $booking = Booking::where('payhere_order_id', $orderId)->first();

            if (!$booking) {
                Log::error('PayHere notify: Booking not found for order ID: ' . $orderId);
                return response('Booking not found', 404);
            }

            // Verify hash
            $expectedHash = $this->generateHash($orderId, $amount, $currency);
            if ($hash !== $expectedHash) {
                Log::error('PayHere notify: Hash verification failed for order ID: ' . $orderId);
                return response('Hash verification failed', 400);
            }

            // Update booking based on status
            switch ($status) {
                case '2': // Payment successful
                    $this->markBookingPaid($booking, $paymentId);
                    break;
                case '0': // Payment failed
                    $booking->update([
                        'payment_status' => 'failed'
                    ]);
                    break;
                case '-1': // Payment cancelled
                    $booking->update([
                        'payment_status' => 'cancelled'
                    ]);
                    break;
                case '-2': // Payment charged back
                    $booking->update([
                        'payment_status' => 'failed'
                    ]);
                    break;
            }

            Log::info('PayHere notify: Payment status updated for booking ID: ' . $booking->id . ' Status: ' . $status);

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('PayHere notify error: ' . $e->getMessage());
            return response('Error', 500);
        }
    }

    protected function markBookingPaid(Booking $booking, ?string $paymentId): void
    {
        $wasPaid = $booking->payment_status === 'paid';

        $booking->update([
            'payment_status' => 'paid',
            'payhere_payment_id' => $paymentId ?? $booking->payhere_payment_id,
            'status' => 'confirmed',
        ]);

        if (!$wasPaid) {
            app(BookingNotificationService::class)->sendPaymentConfirmationIfNeeded($booking);
        }
    }

    /**
     * Generate hash for PayHere
     */
    private function generateHash($orderId, $amount, $currency)
    {
        $hashString = $this->merchantId . $orderId . number_format($amount, 2, '.', '') . $currency;

        return strtoupper(
            md5(
                $this->merchantId .
                $orderId .
                number_format($amount, 2, '.', '') .
                $currency .
                strtoupper(md5($this->merchantSecret))
            )
        );
    }

    /**
     * Show payment success page
     */
    public function showSuccess($bookingId)
    {
        $booking = Booking::with([
            'package',
            'package.media',
            'vehicle',
            'pickupLocation',
            'destinationLocation',
            'user',
        ])->findOrFail($bookingId);

        return view('payhere.success', compact('booking'));
    }

    /**
     * Show payment failed page
     */
    public function showFailed($bookingId)
    {
        $booking = Booking::with([
            'package',
            'package.media',
            'vehicle',
            'pickupLocation',
            'destinationLocation',
            'user',
        ])->findOrFail($bookingId);

        return view('payhere.failed', compact('booking'));
    }

    /**
     * Printable booking receipt (browser Print → Save as PDF)
     */
    public function printReceipt($bookingId)
    {
        $booking = Booking::with([
            'package',
            'vehicle',
            'pickupLocation',
            'destinationLocation',
            'user',
        ])->findOrFail($bookingId);

        return view('payhere.receipt', compact('booking'));
    }
}
