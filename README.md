# Sahab Logistics — Laravel website + Filament CMS

Public Blade website and Filament 5 admin dashboard for `sahablogistics.com`.

## Requirements
- PHP 8.3+
- Composer 2
- Node.js LTS
- SQLite for local/testing, MySQL/MariaDB for production

## Setup
```bash
cp .env.example .env
php artisan key:generate
# Add ADMIN_EMAIL and a 12+ character ADMIN_PASSWORD
php artisan migrate --seed
php artisan storage:link
php artisan sahab:create-admin
npm install
npm run build
php artisan serve
```

- Public site: `http://localhost:8000/`
- Arabic: `http://localhost:8000/ar`
- Admin: `http://localhost:8000/admin`

The homepage at `/` always uses the **default language** chosen in Admin → Languages. Other active languages use `/{code}`.

## Email
Contact submissions are always stored in `contact_inquiries` first. Notifications use Laravel Mail. With `MAIL_MAILER=log` the enquiry is kept and marked `logged`. Configure SMTP in `.env` before expecting inbox delivery. Do not commit mail passwords.

## Production notes
- Document root: `public`
- `APP_ENV=production`, `APP_DEBUG=false`, HTTPS `APP_URL`
- `php artisan migrate --force && php artisan storage:link && npm ci && npm run build`
- `php artisan config:cache && php artisan route:cache && php artisan view:cache`
