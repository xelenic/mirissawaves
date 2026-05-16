<?php

namespace App\Providers;

use App\Models\PromoPopupSlide;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureMailFromSettings();

        View::composer('components.startup-offers-popup', function ($view) {
            $enabled = Setting::get('promo_popup_enabled', '1') === '1';

            $promoSlides = $enabled
                ? PromoPopupSlide::with('media')->active()->ordered()->get()->filter(fn ($slide) => $slide->image_url)
                : collect();

            $view->with('promoSlides', $promoSlides->values());
        });

        View::composer('layouts.app', function ($view) {
            $raw = trim((string) Setting::get('contact_phone', ''));
            if ($raw === '') {
                $raw = (string) config('services.whatsapp.number', '');
            }
            $digits = preg_replace('/\D+/', '', $raw);
            $message = (string) config('services.whatsapp.default_message', '');
            $whatsappUrl = $digits !== ''
                ? 'https://wa.me/' . $digits . ($message !== '' ? '?text=' . rawurlencode($message) : '')
                : null;

            $view->with('whatsappUrl', $whatsappUrl);
        });
    }

    protected function configureMailFromSettings(): void
    {
        try {
            $fromEmail = trim((string) Setting::get('contact_email', ''));
            if ($fromEmail !== '' && filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
                config([
                    'mail.from.address' => $fromEmail,
                    'mail.from.name' => config('app.name'),
                ]);
            }

            if (! config('mail.admin_address')) {
                $admin = $fromEmail ?: config('mail.from.address');
                if ($admin && filter_var($admin, FILTER_VALIDATE_EMAIL)) {
                    config(['mail.admin_address' => $admin]);
                }
            }
        } catch (\Throwable) {
            // Settings table may be unavailable during install/migrate
        }
    }
}
