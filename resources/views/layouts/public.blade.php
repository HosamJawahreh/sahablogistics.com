<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale->code ?? app()->getLocale()) }}" dir="{{ $locale->direction ?? 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $seo = setting('seo', []);
        $title = trans_field($seo, 'title', localized_setting('company.name', 'Sahab Logistics'));
        $description = trans_field($seo, 'description', '');
        $ogImage = media_url(setting('brand.og_image'), asset('assets/images/og-sahab.jpg'));
        $canonical = localized_url(app()->getLocale());
        $logoLight = media_url(setting('brand.logo_light'), asset('assets/brand/sahab-logo-light.png'));
        $favicon = media_url(setting('brand.favicon'), asset('assets/brand/favicon.ico'));
        $domain = setting('company.domain', 'sahablogistics.com');
        $phone = setting('contact.phone_e164', '+962799248711');
        $email = setting('contact.public_email', 'info@sahablogistics.com');
        $address = localized_setting('company.contact_address', 'Jama\'at Intersection, 60th Street, Amman, Jordan');
    @endphp
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">
    @foreach ($languages as $language)
        <link rel="alternate" hreflang="{{ $language->code }}" href="{{ localized_url($language->code) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ localized_url(default_locale()) }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_JO' : 'en_US' }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
    <link rel="icon" href="{{ $favicon }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/brand/favicon-256.png') }}">
    @if ($hero ?? null)
        <link rel="preload" as="image" href="{{ $hero->mediaPath('desktop', asset('assets/images/hero-aqaba-desktop.webp')) }}" imagesrcset="{{ $hero->mediaPath('mobile', asset('assets/images/hero-aqaba-mobile.webp')) }} 768w, {{ $hero->mediaPath('desktop', asset('assets/images/hero-aqaba-desktop.webp')) }} 1440w">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => localized_setting('company.name', 'Sahab Logistics'),
            'url' => 'https://'.$domain,
            'email' => $email,
            'telephone' => $phone,
            'image' => $logoLight,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressCountry' => 'JO',
            ],
            'areaServed' => ['Jordan', 'Aqaba Port'],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    @yield('content')
</body>
</html>
