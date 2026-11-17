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
    $whatsappUrl = 'https://wa.me/962799248711';
    $mapsUrl = setting('location.google_maps_url', 'https://maps.app.goo.gl/CmLVRaxZppgpxUoB7?g_st=iw');
    $mapQuery = setting('location.map_query', 'Jama\'at Intersection, 60th Street, Amman, Jordan');
    $mapEmbed = 'https://maps.google.com/maps?q='.rawurlencode($mapQuery).'&output=embed&hl='.app()->getLocale();
    $company = localized_setting('company.name', 'Sahab Logistics');
    $hq = localized_setting('company.headquarters', 'Sahab, Jordan');
    $address = localized_setting('company.contact_address', 'Jama\'at Intersection, 60th Street, Amman, Jordan');
    $heroDesktop = asset('assets/images/hero/hero-aqaba-desktop.webp');
    $heroMobile = asset('assets/images/hero/hero-aqaba-mobile.webp');
    $heroAlt = data_get($hero?->media, 'alt.'.app()->getLocale())
        ?: data_get($hero?->media, 'alt.'.default_locale(), $hero?->t('title', 'Sahab Logistics'));
@endphp
@extends('layouts.public')

@section('content')
@php
    $isHome = request()->routeIs('home') || request()->routeIs('home.locale');
@endphp
<header class="site-header" data-site-header>
    <div class="header-inner header-row">
        <a class="brand" href="{{ localized_url() }}" aria-label="{{ $company }}">
            <img src="{{ $logoLight }}?v=3" alt="{{ $company }}" width="220" height="58">
        </a>
        <span class="header-divider" aria-hidden="true"></span>
        <nav id="site-nav" class="site-nav" data-nav aria-label="{{ $nav?->t('quick_links', 'Primary') }}">
            <div class="site-nav__links">
                <a href="{{ localized_url() }}" @if ($isHome) aria-current="page" @endif>{{ $nav?->t('home', 'Home') }}</a>
                <a href="#about">{{ $nav?->t('about', 'About') }}</a>
                <a href="#services">{{ $nav?->t('services', 'Services') }}</a>
                <a href="#vision">{{ $nav?->t('vision_mission', 'Vision & Mission') }}</a>
                <a href="#global">{{ $nav?->t('global_reach', 'Global Reach') }}</a>
                <a href="#contact">{{ $nav?->t('contact', 'Contact') }}</a>
                <div class="lang-switch lang-switch--desktop" role="group" aria-label="Language">
                    @foreach ($languages as $language)
                        <a class="lang-switch__option {{ $language->code === app()->getLocale() ? 'is-active' : '' }}"
                           href="{{ localized_url($language->code) }}"
                           hreflang="{{ $language->code }}"
                           lang="{{ $language->code }}"
                           data-locale-link>{{ strtoupper($language->code) }}</a>
                    @endforeach
                </div>
            </div>
            <a class="btn btn-primary btn-sm mobile-nav-cta" href="#contact"><x-site-icon name="send" />{{ $nav?->t('quote', 'Request a Quote') }}</a>
        </nav>
        <div class="lang-switch lang-switch--mobile-bar" role="group" aria-label="Language">
            @foreach ($languages as $language)
                <a class="lang-switch__option {{ $language->code === app()->getLocale() ? 'is-active' : '' }}"
                   href="{{ localized_url($language->code) }}"
                   hreflang="{{ $language->code }}"
                   lang="{{ $language->code }}"
                   data-locale-link>{{ strtoupper($language->code) }}</a>
            @endforeach
        </div>
        <a class="btn btn-primary btn-sm header-cta header-cta--desktop" href="#contact"><x-site-icon name="send" />{{ $nav?->t('quote', 'Request a Quote') }}</a>
        <a class="btn btn-primary btn-sm header-cta header-cta--compact" href="#contact" title="{{ $nav?->t('quote', 'Request a Quote') }}"><x-site-icon name="send" /><span class="header-cta__label">{{ $nav?->t('quote', 'Request a Quote') }}</span></a>
        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="site-nav">{{ $nav?->t('menu', 'Menu') }}</button>
    </div>
</header>

    @if ($hero)
        <section class="hero" aria-labelledby="hero-title">
            <div class="hero-visual">
                <picture>
                    <source media="(max-width: 768px)" srcset="{{ $heroMobile }}">
                    <img class="hero-photo" src="{{ $heroDesktop }}" alt="{{ $heroAlt }}" width="2172" height="724" fetchpriority="high">
                </picture>
            </div>
            <svg class="hero-curve" viewBox="0 0 1024 48" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0 30C140 8 280 42 430 22C620 0 780 36 1024 14V48H0Z" fill="#EFF6FE"/>
            </svg>
            <div class="site-wrap hero-stage">
                <div class="hero-copy">
                    <p class="eyebrow">{{ $hero->t('eyebrow') }}</p>
                    <h1 id="hero-title" class="hero-title">
                        @if ($hero->t('title') === 'Connecting Jordan with Aqaba Port and Beyond')
                            <span class="hero-line">Connecting Jordan with</span>
                            <span class="hero-line"><span class="accent">Aqaba Port and Beyond</span></span>
                        @else
                            {{ $hero->t('title') }}
                        @endif
                    </h1>
                    <p class="hero-lead">{{ $hero->t('description') }}</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary btn-sm" href="#contact"><x-site-icon name="send" />{{ $hero->t('primary_cta') }}</a>
                        <a class="btn btn-light btn-sm" href="#services"><x-site-icon name="play" />{{ $hero->t('secondary_cta') }}</a>
                    </div>
                </div>
            </div>
        </section>
    @endif

<main id="main">
    @if ($benefits)
        <section class="benefits" aria-label="{{ $benefits->t('title', 'Benefits') }}">
            <div class="site-wrap wrap-benefits">
                <div class="benefits-bar">
                    @foreach ($benefits->items() as $index => $item)
                        @php $barIcons = ['coverage', 'port', 'pricing', 'reliable']; @endphp
                        <article class="benefit-card">
                            <span class="benefit-icon"><x-site-icon :name="$barIcons[$index] ?? 'coverage'" /></span>
                            <div>
                                <h2>{{ $item['title'] ?? '' }}</h2>
                                <p>{{ $item['text'] ?? '' }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($about)
        <section id="about" class="about">
            <div class="site-wrap about-grid">
                <div class="about-copy">
                    <p class="eyebrow dark">{{ $about->t('eyebrow') }}</p>
                    <h2>{{ $about->t('title') }}</h2>
                    @foreach ((array) $about->t('paragraphs', []) as $paragraph)
                        <p>{{ is_array($paragraph) ? ($paragraph['paragraph'] ?? $paragraph['text'] ?? '') : $paragraph }}</p>
                    @endforeach
                    <a class="link-more" href="#services">{{ $about->t('cta', 'Learn More') }} <span aria-hidden="true">→</span></a>
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
                <div class="about-frame">
                    <img src="{{ asset('assets/images/sections/aqaba-port.webp') }}" alt="{{ data_get($about->media, 'alt.'.app()->getLocale()) ?: data_get($about->media, 'alt.'.default_locale(), 'Aqaba Port') }}" width="1600" height="700" loading="lazy">
                </div>
            </div>
        </section>
    @endif

    @if ($vision || $mission)
        <section id="vision" class="vision-mission">
            <div class="site-wrap vm-grid">
                @if ($vision)
                    <article class="vm-card">
                        <span class="vm-icon"><x-site-icon name="eye" /></span>
                        <div>
                            <h2>{{ $vision->t('title') }}</h2>
                            <p>{{ $vision->t('text') }}</p>
                        </div>
                    </article>
                @endif
                @if ($mission)
                    <article class="vm-card">
                        <span class="vm-icon"><x-site-icon name="target" /></span>
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
            <div class="site-wrap service-grid">
                <div class="service-copy">
                    <p class="eyebrow">{{ $service->t('eyebrow') }}</p>
                    <h2>{{ $service->t('title') }}</h2>
                    <p>{{ $service->t('description') }}</p>
                    <ul class="service-benefits">
                        @foreach ($service->items('benefits') as $index => $item)
                            @php $benefitIcons = ['two-way', 'location', 'layers', 'truck']; @endphp
                            <li>
                                <span class="mini-icon"><x-site-icon :name="$benefitIcons[$index] ?? 'truck'" /></span>
                                <span>{{ is_array($item) ? ($item['text'] ?? '') : $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="service-media">
                    <img src="{{ asset('assets/images/sections/jordan-road-transport-branded.webp') }}" alt="{{ data_get($service->media, 'alt.'.app()->getLocale()) ?: data_get($service->media, 'alt.'.default_locale(), $service->t('title')) }}" width="830" height="650" loading="lazy">
                </div>
            </div>
        </section>
    @endif

    <section class="work-global">
        @if ($howWeWork)
            <div class="site-wrap process-row process">
                <div>
                    <p class="eyebrow">{{ $howWeWork->t('eyebrow') }}</p>
                    <h2>
                        @if ($howWeWork->t('title') === 'A Simple & Reliable Process')
                            <span class="process-line">A Simple &amp; Reliable</span>
                            <span class="process-line">Process</span>
                        @else
                            {{ $howWeWork->t('title') }}
                        @endif
                    </h2>
                </div>
                <ol class="steps">
                    @foreach ($howWeWork->items('steps') as $index => $step)
                        @php $processIcons = ['clipboard', 'route', 'truck', 'check-mark']; @endphp
                        <li>
                            <span class="step-num">{{ $index + 1 }}</span>
                            <span class="step-bubble"><x-site-icon :name="$processIcons[$index] ?? 'check'" /></span>
                            <h3>{{ ($index + 1) }}. {{ $step['title'] ?? '' }}</h3>
                            <p>{{ $step['text'] ?? '' }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif

        @if ($globalReach)
            <div class="global-stage">
                <div class="global-media" aria-hidden="true">
                    <img src="{{ asset('assets/images/sections/global-reach-hemisphere.png') }}" alt="" width="852" height="296">
                </div>
                <div id="global" class="site-wrap wrap-global global-grid global">
                    <div class="global-copy">
                        <p class="eyebrow">{{ $globalReach->t('eyebrow') }}</p>
                        <h2>{{ $globalReach->t('title') }}</h2>
                        <p>{{ $globalReach->t('text') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </section>

    @if ($contact)
        <section id="contact" class="contact">
            <div class="site-wrap wrap-contact contact-grid">
                <div class="contact-details">
                    <h2>{{ $contact->t('title', 'Get in Touch') }}</h2>
                    <p>{{ $contact->t('intro') }}</p>
                    <ul class="contact-list">
                        <li><x-site-icon name="phone" /> <a dir="ltr" href="tel:{{ $phoneE164 }}">{{ $phoneDisplay }}</a></li>
                        <li><x-site-icon name="email" /> <a class="nowrap" dir="ltr" href="mailto:{{ $publicEmail }}">{{ $publicEmail }}</a></li>
                        <li><x-site-icon name="user" /> <a class="nowrap" dir="ltr" href="mailto:{{ $managerEmail }}">{{ $managerEmail }}</a> <span>({{ $managerName }})</span></li>
                        <li><x-site-icon name="location" /> <span>{{ $address }}</span></li>
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
                    <input type="hidden" name="direction" value="{{ old('direction', 'general') }}">
                    <div class="form-grid">
                        <label class="field">
                            <x-site-icon name="chat" />
                            <span class="sr-only">{{ $contact->t('full_name') }}</span>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ $contact->t('full_name') }} *" required>
                        </label>
                        <label class="field">
                            <x-site-icon name="cpu" />
                            <span class="sr-only">{{ $contact->t('company') }}</span>
                            <input type="text" name="company" value="{{ old('company') }}" placeholder="{{ $contact->t('company') }}">
                        </label>
                        <label class="field">
                            <x-site-icon name="mail" />
                            <span class="sr-only">{{ $contact->t('email') }}</span>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ $contact->t('email') }} *" required dir="ltr">
                        </label>
                        <label class="field">
                            <x-site-icon name="phone" />
                            <span class="sr-only">{{ $contact->t('phone') }}</span>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="{{ $contact->t('phone') }} *" required dir="ltr">
                        </label>
                        <label class="field full">
                            <x-site-icon name="chat" />
                            <span class="sr-only">{{ $contact->t('message') }}</span>
                            <textarea name="message" rows="3" placeholder="{{ $contact->t('message') }}" required>{{ old('message') }}</textarea>
                        </label>
                    </div>
                    <button class="btn btn-primary btn-md" type="submit"><x-site-icon name="send" />{{ $contact->t('send') }}</button>
                </form>
                <div class="contact-map">
                    <a class="map-illustration" href="{{ $mapsUrl }}" target="_blank" rel="noopener" aria-label="{{ $contact->t('directions') }}">
                        <img src="{{ asset('assets/images/reference-crops/contact-map-preview-reference-1024.webp') }}" alt="" width="200" height="118" loading="lazy">
                    </a>
                    <iframe class="map-embed-fallback" title="{{ $contact->t('map_title') }}" src="{{ $mapEmbed }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" tabindex="-1" hidden></iframe>
                    <div class="map-caption">
                        <strong>{{ $contact->t('map_title', $company) }}</strong>
                        <p>{{ $contact->t('map_address', $address) }}</p>
                        <a class="btn btn-ghost map-link" href="{{ $mapsUrl }}" target="_blank" rel="noopener">{{ $contact->t('directions') }} <x-site-icon name="external-link" /></a>
                    </div>
                </div>
            </div>
        </section>
    @endif
</main>

<footer class="site-footer">
    <div class="site-wrap footer-grid">
        <div class="footer-brand">
            <img src="{{ $logoDark }}" alt="{{ $company }}" width="180" height="48">
            <div class="footer-names">
                <p>{{ $footer?->t('company', $company) }}</p>
                <p>{{ $footer?->t('company_ar', localized_setting('company.name', $company, 'ar')) }}</p>
            </div>
        </div>
        <nav aria-label="{{ $footer?->t('quick_links', 'Quick links') }}">
            <a href="{{ localized_url() }}">{{ $nav?->t('home', 'Home') }}</a>
            <a href="#about">{{ $nav?->t('about', 'About') }}</a>
            <a href="#services">{{ $nav?->t('services', 'Services') }}</a>
            <a href="#vision">{{ $nav?->t('vision_mission', 'Vision & Mission') }}</a>
            <a href="#global">{{ $nav?->t('global_reach', 'Global Reach') }}</a>
            <a href="#contact">{{ $nav?->t('contact', 'Contact') }}</a>
        </nav>
    </div>
    <div class="site-wrap copyright">
        <p>© {{ date('Y') }} {{ $company }}. {{ $footer?->t('copyright', 'All rights reserved.') }}</p>
        <a href="https://{{ setting('company.domain', 'sahablogistics.com') }}">{{ setting('company.domain', 'sahablogistics.com') }}</a>
    </div>
</footer>

<a class="whatsapp-float" href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="WhatsApp">
    <img src="{{ asset('assets/icons/whatsapp.svg') }}" alt="" width="54" height="54">
</a>
@endsection
