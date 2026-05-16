<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmailCommand extends Command
{
    protected $signature = 'mail:test {email? : Recipient address (defaults to MAIL_FROM_ADDRESS)}';

    protected $description = 'Send a test email via the configured mailer (Resend)';

    public function handle(): int
    {
        $to = $this->argument('email') ?: config('mail.from.address');

        if (! $to || ! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $this->error('Provide a valid email or set MAIL_FROM_ADDRESS in .env');

            return self::FAILURE;
        }

        if (config('mail.default') === 'resend' && ! config('services.resend.key')) {
            $this->error('RESEND_KEY is not set in .env');

            return self::FAILURE;
        }

        $this->info('Mailer: '.config('mail.default'));
        $this->info('From: '.config('mail.from.address'));
        $this->info('Sending test to: '.$to);

        try {
            Mail::raw(
                'This is a test email from '.config('app.name').' sent at '.now()->toDateTimeString(),
                function ($message) use ($to) {
                    $message->to($to)->subject('Test email — '.config('app.name'));
                }
            );

            $this->info('Test email sent successfully.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
