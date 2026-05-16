<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingCustomerDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $event = 'order_received',
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->event === 'payment_confirmed'
            ? 'Booking confirmed — '.$this->booking->reference_number
            : 'Booking received — '.$this->booking->reference_number;

        return new Envelope(
            subject: $subject.' | '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.customer-details',
            with: [
                'booking' => $this->booking,
                'event' => $this->event,
                'paymentUrl' => route('payhere.initialize', ['booking_id' => $this->booking->id]),
                'receiptUrl' => route('booking.receipt', $this->booking->id),
                'bookingsUrl' => route('my-bookings.index'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
