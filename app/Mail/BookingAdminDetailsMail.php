<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingAdminDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $event = 'new_order',
    ) {}

    public function envelope(): Envelope
    {
        $prefix = $this->event === 'payment_received'
            ? 'Payment received'
            : 'New booking';

        return new Envelope(
            subject: $prefix.' — '.$this->booking->reference_number.' | '.config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.admin-details',
            with: [
                'booking' => $this->booking,
                'event' => $this->event,
                'adminUrl' => route('admin.bookings.show', $this->booking),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
