@php
    $nav = $nav ?? null;
    $logoLight = media_url(setting('brand.logo_light'), asset('assets/brand/sahab-logo-light.png'));
    $logoDark = media_url(setting('brand.logo_dark'), asset('assets/brand/sahab-logo-dark.png'));
    $phoneDisplay = setting('contact.phone_display', '+962 79 924 8711');
    $phoneE164 = setting('contact.phone_e164', '+962799248711');
    $publicEmail = setting('contact.public_email', 'info@sahablogistics.com');
    $managerEmail = setting('contact.manager_email', 'a.salem@sahablogistics.com');
    $managerName = setting('contact.manager_name', 'Abdelkareem ALmsaeed');
    $whatsapp = setting('contact.whatsapp_number', '962799248711');
    $whatsappText = localized_setting('contact.whatsapp_prefill', 'Hello Sahab Logistics, I would like to enquire about Jordan – Aqaba Port transportation.');
    $whatsappUrl = 'https://wa.me/'.$whatsapp.'?text='.rawurlencode($whatsappText);
    $mapsUrl = setting('location.google_maps_url', 'https://maps.app.goo.gl/CmLVRaxZppgpxUoB7?g_st=iw');
    $mapQuery = setting('location.map_query', 'Jama\'at Intersection, 60th Street, Amman, Jordan');
    $mapEmbed = 'https://maps.google.com/maps?q='.rawurlencode($mapQuery).'&output=embed&hl='.app()->getLocale();
    $company = localized_setting('company.name', 'Sahab Logistics');
    $hq = localized_setting('company.headquarters', 'Sahab, Jordan');
    $address = localized_setting('company.contact_address', 'Jama\'at Intersection, 60th Street, Amman, Jordan');
    $heroDesktop = $hero?->mediaPath('desktop', asset('assets/images/hero-aqaba-desktop.webp'));
    $heroMobile = $hero?->mediaPath('mobile', asset('assets/images/hero-aqaba-mobile.webp'));
    $heroAlt = data_get($hero?->media, 'alt.'.app()->getLocale())
        ?: data_get($hero?->media, 'alt.'.default_locale(), $hero?->t('title', 'Sahab Logistics'));
@endphp
@extends('layouts.public')

@section('content')
<header class="site-header">
    <div class="container header-row">
        <a class="brand" href="{{ localized_url() }}" aria-label="{{ $company }}">
            <img src="{{ $logoLight }}" alt="{{ $company }}" width="220" height="58">
        </a>
        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="site-nav">Menu</button>
        <nav id="site-nav" class="site-nav" data-nav>
            <a href="{{ localized_url() }}">{{ $nav?->t('home', 'Home') }}</a>
            <a href="#about">{{ $nav?->t('about', 'About Us') }}</a>
            <a href="#services">{{ $nav?->t('services', 'Services') }}</a>
            <a href="#vision">{{ $nav?->t('vision_mission', 'Vision & Mission') }}</a>
            <a href="#global">{{ $nav?->t('global_reach', 'Global Reach') }}</a>
            <a href="#contact">{{ $nav?->t('contact', 'Contact') }}</a>
        </nav>
        <div class="header-actions">
            <div class="lang-switch" role="navigation" aria-label="Language">
                @foreach ($languages as $language)
                    <a class="{{ $language->code === app()->getLocale() ? 'is-active' : '' }}" href="{{ localized_url($language->code) }}" hreflang="{{ $language->code }}">{{ strtoupper($language->code) }}</a>
                @endforeach
            </div>
            <a class="btn btn-primary header-cta" href="#contact">{{ $nav?->t('quote', 'Request a Quote') }}</a>
        </div>
    </div>
</header>

<main id="main">
    @if ($hero)
        <section class="hero" aria-labelledby="hero-title">
            <div class="hero-media">
                <picture>
                    <source media="(max-width: 768px)" srcset="{{ $heroMobile }}">
                    <img src="{{ $heroDesktop }}" alt="{{ $heroAlt }}" width="1920" height="430" fetchpriority="high">
                </picture>
            </div>
            <div class="hero-overlay"></div>
            <div class="container hero-grid">
                <div class="hero-copy">
                    <p class="eyebrow">{{ $hero->t('eyebrow') }}</p>
                    <h1 id="hero-title">{{ $hero->t('title') }}</h1>
                    <p class="hero-lead">{{ $hero->t('description') }}</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="#contact">{{ $hero->t('primary_cta') }}</a>
                        <a class="btn btn-ghost" href="#services">{{ $hero->t('secondary_cta') }}</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($benefits)
        <section class="benefits" aria-label="{{ $benefits->t('title', 'Benefits') }}">
            <div class="container benefits-grid">
                @foreach ($benefits->items() as $item)
                    <article class="benefit-card">
                        <span class="benefit-icon"><x-site-icon :name="$item['icon'] ?? 'check'" /></span>
                        <div>
                            <h2>{{ $item['title'] ?? '' }}</h2>
                            <p>{{ $item['text'] ?? '' }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if ($about)
        <section id="about" class="about">
            <div class="container about-grid">
                <div class="about-copy">
                    <p class="eyebrow dark">{{ $about->t('eyebrow') }}</p>
                    <h2>{{ $about->t('title') }}</h2>
                    @foreach ((array) $about->t('paragraphs', []) as $paragraph)
                        <p>{{ is_array($paragraph) ? ($paragraph['paragraph'] ?? $paragraph['text'] ?? '') : $paragraph }}</p>
                    @endforeach
                    <a class="btn btn-primary" href="#contact">{{ $about->t('cta', 'Learn More') }}</a>
                    <div class="pillars">
                        @foreach ($about->items('pillars') as $pillar)
                            <article>
                                <span class="mini-icon"><x-site-icon :name="$pillar['icon'] ?? 'check'" /></span>
                                <div>
                                    <h3>{{ $pillar['title'] ?? '' }}</h3>
                                    <p>{{ $pillar['text'] ?? '' }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="about-media">
                    <img src="{{ $about->mediaPath('image', asset('assets/images/aqaba-port.webp')) }}" alt="{{ data_get($about->media, 'alt.'.app()->getLocale()) ?: data_get($about->media, 'alt.'.default_locale(), 'Aqaba Port') }}" width="720" height="460" loading="lazy">
                </div>
            </div>
        </section>
    @endif

    @if ($vision || $mission)
        <section id="vision" class="vision-mission">
            <div class="container vm-grid">
                @if ($vision)
                    <article class="vm-card">
                        <span class="mini-icon"><x-site-icon name="eye" /></span>
                        <div>
                            <h2>{{ $vision->t('title') }}</h2>
                            <p>{{ $vision->t('text') }}</p>
                        </div>
                    </article>
                @endif
                @if ($mission)
                    <article class="vm-card">
                        <span class="mini-icon"><x-site-icon name="target" /></span>
                        <div>
                            <h2>{{ $mission->t('title') }}</h2>
                            <p>{{ $mission->t('text') }}</p>
                        </div>
                    </article>
                @endif
            </div>
        </section>
    @endif

    @if ($service)
        <section id="services" class="service">
            <div class="container service-grid">
                <div class="service-copy">
                    <p class="eyebrow">{{ $service->t('eyebrow') }}</p>
                    <h2>{{ $service->t('title') }}</h2>
                    <p>{{ $service->t('description') }}</p>
                    <ul class="service-benefits">
                        @foreach ($service->items('benefits') as $item)
                            <li>
                                <span class="mini-icon"><x-site-icon :name="$item['icon'] ?? 'check'" /></span>
                                <span>{{ is_array($item) ? ($item['text'] ?? '') : $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="service-media">
                    <img src="{{ $service->mediaPath('image', asset('assets/images/jordan-road-transport.webp')) }}" alt="{{ data_get($service->media, 'alt.'.app()->getLocale()) ?: data_get($service->media, 'alt.'.default_locale(), $service->t('title')) }}" width="760" height="420" loading="lazy">
                </div>
            </div>
        </section>
    @endif

    @if ($howWeWork)
        <section class="process">
            <div class="container">
                <p class="eyebrow">{{ $howWeWork->t('eyebrow') }}</p>
                <h2>{{ $howWeWork->t('title') }}</h2>
                <ol class="steps">
                    @foreach ($howWeWork->items('steps') as $index => $step)
                        <li>
                            <span class="step-num">{{ $index + 1 }}</span>
                            <h3>{{ $step['title'] ?? '' }}</h3>
                            <p>{{ $step['text'] ?? '' }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>
    @endif

    @if ($globalReach)
        <section id="global" class="global">
            <div class="container global-grid">
                <div class="global-media">
                    <img src="{{ $globalReach->mediaPath('image', asset('assets/images/global-network.svg')) }}" alt="{{ data_get($globalReach->media, 'alt.'.app()->getLocale()) ?: data_get($globalReach->media, 'alt.'.default_locale(), $globalReach->t('title')) }}" width="520" height="360" loading="lazy">
                </div>
                <div>
                    <p class="eyebrow">{{ $globalReach->t('eyebrow') }}</p>
                    <h2>{{ $globalReach->t('title') }}</h2>
                    <p>{{ $globalReach->t('text') }}</p>
                </div>
            </div>
        </section>
    @endif

    @if ($contact)
        <section id="contact" class="contact">
            <div class="container contact-grid">
                <div class="contact-details">
                    <p class="eyebrow dark">{{ $contact->t('eyebrow') }}</p>
                    <h2>{{ $contact->t('title') }}</h2>
                    <p>{{ $contact->t('intro') }}</p>
                    <ul class="contact-list">
                        <li><x-site-icon name="phone" /> <a dir="ltr" href="tel:{{ $phoneE164 }}">{{ $phoneDisplay }}</a></li>
                        <li><x-site-icon name="mail" /> <a href="mailto:{{ $publicEmail }}">{{ $publicEmail }}</a></li>
                        <li><x-site-icon name="mail" /> <a href="mailto:{{ $managerEmail }}">{{ $managerEmail }}</a> <span>({{ $managerName }})</span></li>
                        <li><x-site-icon name="location" /> <span>{{ $address }}</span></li>
                        <li><x-site-icon name="map-pin" /> <span>{{ $hq }}</span></li>
                    </ul>
                </div>
                <form class="contact-form" method="post" action="{{ localized_url(app()->getLocale(), '/contact') }}" novalidate>
                    @csrf
                    <div class="hp" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                    </div>
                    @if (session('contact_success'))
                        <p class="form-success" role="status">{{ session('contact_success') }}</p>
                    @endif
                    @if ($errors->any())
                        <p class="form-error" role="alert">{{ $errors->first() }}</p>
                    @endif
                    <div class="form-grid">
                        <label>
                            <span>{{ $contact->t('full_name') }}</span>
                            <input type="text" name="name" value="{{ old('name') }}" required>
                        </label>
                        <label>
                            <span>{{ $contact->t('company') }}</span>
                            <input type="text" name="company" value="{{ old('company') }}">
                        </label>
                        <label>
                            <span>{{ $contact->t('email') }}</span>
                            <input type="email" name="email" value="{{ old('email') }}" required dir="ltr">
                        </label>
                        <label>
                            <span>{{ $contact->t('phone') }}</span>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required dir="ltr">
                        </label>
                        <label class="full">
                            <span>{{ $contact->t('service_direction') }}</span>
                            <select name="direction" required>
                                <option value="">{{ $contact->t('select_direction') }}</option>
                                <option value="to_aqaba" @selected(old('direction') === 'to_aqaba')>{{ $contact->t('to_aqaba') }}</option>
                                <option value="from_aqaba" @selected(old('direction') === 'from_aqaba')>{{ $contact->t('from_aqaba') }}</option>
                                <option value="round_trip" @selected(old('direction') === 'round_trip')>{{ $contact->t('round_trip') }}</option>
                                <option value="general" @selected(old('direction') === 'general')>{{ $contact->t('general') }}</option>
                            </select>
                        </label>
                        <label class="full">
                            <span>{{ $contact->t('message') }}</span>
                            <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
                        </label>
                    </div>
                    <button class="btn btn-primary" type="submit">{{ $contact->t('send') }}</button>
                </form>
                <div class="contact-map">
                    <iframe title="{{ $contact->t('map_title') }}" src="{{ $mapEmbed }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <a class="btn btn-ghost map-link" href="{{ $mapsUrl }}" target="_blank" rel="noopener">{{ $contact->t('directions') }}</a>
                </div>
            </div>
        </section>
    @endif
</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <img src="{{ $logoDark }}" alt="{{ $company }}" width="180" height="48">
            <p>{{ $footer?->t('company', $company) }}</p>
            <p>{{ $footer?->t('company_ar', localized_setting('company.name', $company, 'ar')) }}</p>
        </div>
        <nav aria-label="{{ $footer?->t('quick_links', 'Quick links') }}">
            <a href="{{ localized_url() }}">{{ $nav?->t('home', 'Home') }}</a>
            <a href="#about">{{ $nav?->t('about', 'About Us') }}</a>
            <a href="#services">{{ $nav?->t('services', 'Services') }}</a>
            <a href="#vision">{{ $nav?->t('vision_mission', 'Vision & Mission') }}</a>
            <a href="#global">{{ $nav?->t('global_reach', 'Global Reach') }}</a>
            <a href="#contact">{{ $nav?->t('contact', 'Contact') }}</a>
        </nav>
        <div>
            <p dir="ltr"><a href="tel:{{ $phoneE164 }}">{{ $phoneDisplay }}</a></p>
            <p><a href="mailto:{{ $publicEmail }}">{{ $publicEmail }}</a></p>
            <p><a href="https://{{ setting('company.domain', 'sahablogistics.com') }}">{{ setting('company.domain', 'sahablogistics.com') }}</a></p>
        </div>
    </div>
    <div class="container copyright">
        <p>© {{ date('Y') }} {{ $company }}. {{ $footer?->t('copyright', 'All rights reserved.') }}</p>
    </div>
</footer>

<a class="whatsapp-float" href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 32 32" width="28" height="28" aria-hidden="true"><path fill="#fff" d="M19.1 17.5c-.3-.1-1.6-.8-1.8-.9s-.4-.1-.6.1-.7.9-.8 1.1-.3.2-.6.1a7.6 7.6 0 0 1-2.3-1.4 8.5 8.5 0 0 1-1.6-2c-.2-.3 0-.5.1-.6l.5-.6c.1-.1.2-.3.3-.4s0-.3 0-.4l-.9-2.1c-.2-.6-.5-.5-.6-.5h-.5c-.2 0-.4.1-.6.3s-.8.8-.8 1.9.8 2.2.9 2.4 1.6 2.5 3.9 3.5c.5.2 1 .4 1.3.5.6.2 1.1.2 1.5.1.5-.1 1.6-.6 1.8-1.3s.2-1.1.1-1.2-.2-.2-.5-.3zm-3.1 7.2h-.1A11.7 11.7 0 0 1 8 22.3L7.7 22l-4 1.3 1.3-3.9-.2-.3a11.8 11.8 0 0 1 18.4-13.4 11.8 11.8 0 0 1-7.2 20.9zm10-13.2A13.8 13.8 0 0 0 5.4 23L3 31l8.2-2.1A13.8 13.8 0 1 0 26 11.5z"/></svg>
</a>
@endsection
