<?php

namespace App\Services;

use App\Mail\ContactFormAcknowledgementMail;
use App\Mail\ContactFormSubmittedMail;
use App\Services\BookingNotificationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactMailService
{
    public function __construct(
        protected BookingNotificationService $bookingNotifications,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function send(array $data): void
    {
        $adminEmail = $this->bookingNotifications->adminNotificationAddress();
        if (!$adminEmail) {
            throw new \RuntimeException('Admin notification email is not configured.');
        }

        Mail::to($adminEmail)->send(new ContactFormSubmittedMail($data));
        Mail::to($data['email'])->send(new ContactFormAcknowledgementMail($data));

        Log::info('Contact form emails sent', ['email' => $data['email']]);
    }
}
