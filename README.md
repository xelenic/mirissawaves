# Mirissawaves

Tour and travel booking platform for Sri Lanka — tour packages, vehicle transfers, online payments, and a full admin dashboard.

**Repository:** [github.com/xelenic/mirissawaves](https://github.com/xelenic/mirissawaves)

## Features

### Public site
- Homepage with hero slider, package highlights, and route-based **vehicle booking** (pickup → destination pricing)
- Tour **packages** with detail pages, image galleries, and booking flow
- **Blog** with categories and search
- **Contact** form with email notifications (customer acknowledgement + admin alert)
- Site search across packages and blog posts
- **My Bookings** for registered customers
- Mobile-responsive layout (customer pages + vehicle results)
- WhatsApp floating button and configurable social links (Facebook, Instagram, TripAdvisor)
- Optional startup **promo popup** slides

### Payments
- [PayHere](https://www.payhere.lk/) checkout for package and vehicle bookings
- Success / failure pages and printable booking receipt

### Email (Resend)
- Booking confirmation emails (customer + admin) on new orders and after payment
- Contact form emails
- Test command: `php artisan mail:test`

### Admin panel (`/admin`)
- Dashboard, packages, categories, blog (with optional **Gemini** AI article/banner helpers)
- Bookings, users, vehicles, locations, location–vehicle pricing
- Reviews, media library, site settings, about page
- Promo popup slides and social media URLs

## Tech stack

| Layer | Technology |
|--------|------------|
| Backend | PHP 8.2+, Laravel 12 |
| Database | MySQL |
| Auth & roles | Laravel + [spatie/laravel-permission](https://github.com/spatie/laravel-permission) |
| Email | [Resend](https://resend.com) (`resend/resend-php`) |
| Payments | PayHere |
| Frontend | Blade, Tailwind CSS (CDN), Alpine/vanilla JS where needed |
| Optional AI | Google Gemini (blog/promo image generation in admin) |

## Requirements

- PHP 8.2+ with extensions: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`
- Composer 2.x
- MySQL 8.0+ (or MariaDB equivalent)
- Node.js is **not** required unless you change the asset build setup

## Installation

```bash
git clone git@github.com:xelenic/mirissawaves.git
cd mirissawaves

composer install

cp .env.example .env
php artisan key:generate
```

Create a MySQL database (default name in `.env.example`: `mirissawaves`), then set `DB_*` in `.env`.

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### Default admin (after seeding)

Check `database/seeders/AdminSeeder.php` for seeded credentials, or create an admin manually:

```bash
php artisan admin:create --email=you@example.com --password=your-secure-password
```

### Run locally

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000`. Admin: `http://127.0.0.1:8000/admin`.

For queued mail or other jobs (if you enable queues):

```bash
php artisan queue:work
```

## Environment variables

Copy from `.env.example` and configure:

| Variable | Purpose |
|----------|---------|
| `APP_URL` | Public site URL (required for PayHere return URLs) |
| `DB_*` | Database connection |
| `MAIL_MAILER`, `RESEND_KEY`, `MAIL_FROM_*`, `MAIL_ADMIN_ADDRESS` | Resend email |
| `PAYHERE_MERCHANT_ID`, `PAYHERE_MERCHANT_SECRET`, `PAYHERE_SANDBOX_MODE`, `PAYHERE_CURRENCY` | PayHere gateway |
| `GEMINI_API_KEY` | Optional — AI blog/promo assets in admin |
| `WHATSAPP_NUMBER`, `WHATSAPP_MESSAGE` | WhatsApp button (overridden by admin contact phone if set) |
| `FACEBOOK_URL`, `INSTAGRAM_URL`, `TRIPADVISOR_URL` | Social links (also editable in admin) |

**PayHere** (add to `.env` if not present):

```env
PAYHERE_MERCHANT_ID=
PAYHERE_MERCHANT_SECRET=
PAYHERE_SANDBOX_MODE=true
PAYHERE_CURRENCY=USD
```

Use sandbox credentials for development. Set `PAYHERE_SANDBOX_MODE=false` and live keys in production.

**Resend:** Verify your sending domain at [resend.com](https://resend.com) and set `MAIL_FROM_ADDRESS` to an address on that domain.

Never commit `.env` or API keys to Git.

## Useful commands

```bash
# Create admin user
php artisan admin:create

# Send test email
php artisan mail:test you@example.com

# Clear caches after config changes
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Project structure (high level)

```
app/
  Http/Controllers/     # Public, admin, PayHere, vehicle booking
  Mail/                 # Booking & contact mailables
  Services/             # Booking notifications, Gemini, contact mail
config/                 # payhere, gemini, mail, services, promo-popup
database/migrations/
database/seeders/
resources/views/        # Blade templates (layouts, admin, emails)
public/                 # logo, customer-mobile.css, uploads via storage
routes/web.php
```

## Deployment notes

1. Point the web root to `public/`.
2. Set `APP_ENV=production`, `APP_DEBUG=false`, and a strong `APP_KEY`.
3. Run `php artisan migrate --force` and ensure `storage/` and `bootstrap/cache/` are writable.
4. Configure PayHere **notify URL** to: `https://yourdomain.com/payhere/notify`
5. Use HTTPS for `APP_URL` and PayHere return URLs.
6. Run a queue worker if using `QUEUE_CONNECTION=database` for mail.

See `PAYHERE_INTEGRATION.md` and `ADMIN_STYLING_GUIDE.md` in the repo for more detail.

## License

MIT (Laravel framework components retain their respective licenses.)
