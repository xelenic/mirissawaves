<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<string, mixed>  $inquiry
     */
    public function __construct(
        public array $inquiry,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact form: '.$this->inquiry['name'].' | '.config('app.name'),
            replyTo: [$this->inquiry['email']],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact.admin-notification',
            with: ['inquiry' => $this->inquiry],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
