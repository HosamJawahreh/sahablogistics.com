# Data Model & Localization Contract

## Initial seeded language set
- English (`en`), LTR, enabled, default.
- Arabic (`ar`), RTL, enabled.

The languages are database-managed and can be expanded later from Filament.

## Page sections
Seed these section keys and their display order:
1. `hero`
2. `benefits`
3. `about`
4. `vision`
5. `mission`
6. `service`
7. `how_we_work`
8. `global_reach`
9. `contact`

Use a separate row for `vision` and `mission` if that makes dashboard editing easier, but render them together in one shared front-end panel matching the design screenshot.

## Translation structure
Translations are locale-keyed JSON. Example:
```json
{
  "en": {"title":"Connecting Jordan with Aqaba Port and Beyond"},
  "ar": {"title":"نربط الأردن بميناء العقبة وما بعده"}
}
```
Create a localization service that reads current locale, then field-level fallback to default locale. The current default locale is always loaded from the languages table / cache, never hard-coded to `en`.

## Repeatable blocks
- Benefits: title + short text + icon key.
- Company pillars: title + short text + icon key.
- Service benefits: short text + icon key.
- How-we-work steps: title + explanatory text + icon key.
Repeaters must be translatable and reorderable in Filament.

## Settings groups
- `company`: identity, domain, HQ, contact address.
- `contact`: public email, manager details, phone, WhatsApp.
- `location`: exact Google Maps URL, map embed query/location.
- `brand`: light/dark logo paths, favicon, palette tokens.
- `seo`: localized title/description, OG image, canonical.
- `localization`: default language selection and fallback behavior.
