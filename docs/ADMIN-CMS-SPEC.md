# Laravel CMS & Admin Dashboard Requirements

## Required architecture
Build a real Laravel website with a server-rendered Blade public frontend and a Filament admin panel at `/admin`. Do not build this as a Vite-only static page or a front-end-only mockup.

Recommended stack:
- Laravel 13 (PHP 8.3+)
- Filament 5 Panel Builder for `/admin`
- Blade templates for the public site
- Vite for frontend assets
- MySQL/MariaDB for production; SQLite may be used for local development/tests
- Laravel Mail for enquiry notifications

Use Composer's compatible dependency resolution; do not pin random package versions or use abandoned plugins.

## CMS features the owner must manage without editing code
1. All public page text and labels, including hero, About, Vision, Mission, service, process, Global Reach, Contact, navigation, footer, buttons, form labels and validation/success copy.
2. Every supported website language, with code, English name, native name, LTR/RTL direction, enabled/disabled, sort order and exactly one default language.
3. Per-language translations for every content field, including repeaters (benefits, pillars, process steps).
4. Change the default language from the dashboard. The root `/` must show the selected default language.
5. Enable/disable languages, add a language and manage its translations. Do not permit disabling/deleting the only active or current default language without first selecting a replacement.
6. Reorder sections, hide/show sections, publish/unpublish sections.
7. Upload/replace hero, About, Aqaba port, road transport, global illustration, logos, favicon and Open Graph image. Use Laravel's public storage disk and image alt text translated per language.
8. Company settings: English/Arabic company names, domain, public email, manager name/email, phone, WhatsApp, headquarters, contact address and exact Maps URL.
9. SEO settings per locale: title, meta description, OG image/alt, canonical, robots; generate sitemap and hreflang references.
10. Manage enquiries received through the Contact form: searchable list, view, mark read/in progress/resolved, internal notes, export CSV.
11. A dashboard overview with counts of new enquiries, enabled languages, published sections and last submissions.
12. Admin user access. Only authorized admin users can access `/admin`.

## Recommended database design
- `users`: Laravel users table plus `is_admin` boolean.
- `languages`: `code` unique, `name`, `native_name`, `direction`, `is_active`, `is_default`, `sort_order`, timestamps.
- `pages`: `key` unique, `is_published`, `sort_order`, timestamps (home page initially).
- `page_sections`: page FK, `key`, `type`, `is_enabled`, `is_published`, `sort_order`, `translations` JSON, `media` JSON, optional approval note, timestamps. Unique `(page_id, key)`.
- `site_settings`: `key` unique, `value` JSON, group/index, timestamps. Store contact, maps, branding, SEO, locale settings here.
- `contact_inquiries`: name, company nullable, email, phone, direction, message, locale, status, mail status/error metadata, timestamps.
- Optional media table only if required; otherwise use Laravel's public filesystem and Filament FileUpload.
Use JSON translations shaped as `{ "en": { "title": "...", "body": "..." }, "ar": { "title": "...", "body": "..." } }`. Provide model/service helpers for locale fallback.

## Filament resources/pages
- Languages: CRUD, status, sort, default selection (transaction ensures exactly one default).
- Pages & Sections: edit all page sections, per-enabled-language tabs, repeaters, visibility, publish status, drag-sort order, image fields and alt translations.
- Site Settings: grouped form sections for company identity, contact, map, branding, social, SEO, default language.
- Contact Inquiries: searchable/filterable table, statuses, details, CSV export, read status.
- Admin Users: create/update users, is_admin access flag, no public registration.
- Dashboard widgets: latest inquiries, quick links to edit home sections/settings, enabled language summary.

The Filament editor must be understandable to a non-developer. Avoid raw JSON text editors as the primary editing UI. Use localized tabs and meaningful fields/repeaters for all content.

## Multilingual routing behavior
- Languages seeded initially: English (`en`, LTR, default) and Arabic (`ar`, RTL, enabled).
- `/` loads the active default language chosen in the dashboard.
- `/{locale}` loads an enabled non-default language; invalid/disabled locales return 404.
- If a visitor visits `/{defaultLocale}`, redirect to canonical `/`.
- Language switcher should change between available language versions; for this one-page website, link to `/` for current default and `/{otherLocale}` for non-default.
- `html lang` and `dir` attributes must come from selected locale.
- Use logical CSS properties (`margin-inline`, `padding-inline`, `inset-inline`, etc.) to support RTL naturally.
- Missing translation fields fall back field-by-field to the current default language; never show raw translation keys.
- All public page strings come from DB / seeded CMS content, not hard-coded in Blade except safe fallback text.
- When default language is changed in admin, flush relevant config/cache and update canonical/hreflang URLs.

## Contact form
- Validate name, email, phone, message, direction; company optional.
- Persist the inquiry to `contact_inquiries` first.
- Attempt to email `info@sahablogistics.com` using Laravel Mail and `.env` SMTP configuration; if email delivery fails or SMTP is not configured, preserve the saved enquiry, log the failure and show a safe success message with admin visibility.
- Show enquiry submission status in Filament.
- Add CSRF, server-side validation, rate limiting and a honeypot field.
- Never expose email credentials or API keys in code.
- Document SMTP variables and test email delivery before production.
- Do not claim the form is fully sending email until SMTP is configured and verified.

## Security
- No public registration.
- Admin access through Filament auth and `is_admin`.
- Rate limit admin login and contact POST.
- CSRF, output escaping, validation, secure file upload MIME/size restrictions.
- Seed admin using environment variables or `php artisan make:filament-user` then explicitly grant admin access; never commit default passwords.
- Include `.env.example`, secure `APP_KEY`, production `APP_DEBUG=false`.
