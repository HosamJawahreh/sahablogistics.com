# Laravel Development & Deployment Notes

## Local prerequisites
- PHP 8.3 or newer for Laravel 13.
- Composer 2.
- Node.js LTS and npm.
- MySQL/MariaDB for production; SQLite is acceptable for local development.

## Intended build directory
The actual Laravel app is generated in `laravel-app/`. The handoff materials remain at the package root.

## Local setup after Cursor has scaffolded the app
```bash
cd laravel-app
cp .env.example .env
php artisan key:generate
# Configure DB_* and MAIL_* values in .env
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

If the app seeds an admin from env, add `ADMIN_NAME`, `ADMIN_EMAIL`, and `ADMIN_PASSWORD` to `.env` before running the seeder. Otherwise create a user with `php artisan make:filament-user` and grant the `is_admin` flag via the secure admin setup command.

## Production checklist
- Configure production MySQL/MariaDB.
- Set `APP_ENV=production`, `APP_DEBUG=false`, a strong `APP_KEY`.
- Configure HTTPS and the `APP_URL=https://sahablogistics.com`.
- Configure `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`.
- Verify actual email delivery with a test enquiry.
- Run `php artisan migrate --force`, `php artisan storage:link`, `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.
- Build frontend: `npm ci && npm run build`.
- Configure the web server document root to `laravel-app/public`, never the Laravel project root.
- Ensure `storage/` and `bootstrap/cache/` are writable.
- Configure queue worker only if mail/notifications are queued.
- Back up database and `storage/app/public`.
- Keep `.env` outside source control.
