<?php

namespace App\Services;

use App\Mail\BookingAdminDetailsMail;
use App\Mail\BookingCustomerDetailsMail;
use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingNotificationService
{
    /**
     * Call after any package or vehicle booking is created.
     */
    public function afterBookingCreated(Booking $booking): void
    {
        $this->notifyCustomerOrderReceived($booking);
        $this->notifyAdminNewOrder($booking);
    }

    public function notifyCustomerOrderReceived(Booking $booking): bool
    {
        $booking->refresh();

        if ($booking->customer_order_notified_at || ! filter_var($booking->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $booking->loadMailRelations();

        try {
            Mail::to($booking->email)->send(new BookingCustomerDetailsMail($booking, 'order_received'));

            $booking->forceFill(['customer_order_notified_at' => now()])->save();

            Log::info('Customer order-received email sent', ['booking_id' => $booking->id]);

            return true;
        } catch (\Throwable $e) {
            Log::error('Failed to send customer order email', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function notifyAdminNewOrder(Booking $booking): bool
    {
        $booking->refresh();

        if ($booking->admin_order_notified_at) {
            return false;
        }

        $adminEmail = $this->adminNotificationAddress();
        if (! $adminEmail) {
            Log::warning('Admin new-order email skipped: no admin address configured', [
                'booking_id' => $booking->id,
            ]);

            return false;
        }

        $booking->loadMailRelations();

        try {
            Mail::to($adminEmail)->send(new BookingAdminDetailsMail($booking, 'new_order'));

            $booking->forceFill(['admin_order_notified_at' => now()])->save();

            Log::info('Admin new-order email sent', ['booking_id' => $booking->id]);

            return true;
        } catch (\Throwable $e) {
            Log::error('Failed to send admin new-order email', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function sendPaymentConfirmationIfNeeded(Booking $booking): bool
    {
        $booking->refresh();

        if ($booking->payment_status !== 'paid' || $booking->confirmation_emailed_at) {
            return false;
        }

        if (! filter_var($booking->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $booking->loadMailRelations();

        try {
            Mail::to($booking->email)->send(new BookingCustomerDetailsMail($booking, 'payment_confirmed'));

            $this->notifyAdminPaymentReceived($booking);

            $booking->forceFill(['confirmation_emailed_at' => now()])->save();

            Log::info('Booking confirmation emails sent', ['booking_id' => $booking->id]);

            return true;
        } catch (\Throwable $e) {
            Log::error('Failed to send booking confirmation emails', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function notifyAdminPaymentReceived(Booking $booking): bool
    {
        $adminEmail = $this->adminNotificationAddress();
        if (! $adminEmail) {
            return false;
        }

        $booking->loadMailRelations();

        try {
            Mail::to($adminEmail)->send(new BookingAdminDetailsMail($booking, 'payment_received'));

            Log::info('Admin payment-received email sent', ['booking_id' => $booking->id]);

            return true;
        } catch (\Throwable $e) {
            Log::error('Failed to send admin payment email', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function adminNotificationAddress(): ?string
    {
        $address = trim((string) config('mail.admin_address', ''));
        if ($address === '') {
            $address = trim((string) Setting::get('contact_email', ''));
        }

        return filter_var($address, FILTER_VALIDATE_EMAIL) ? $address : null;
    }
}
