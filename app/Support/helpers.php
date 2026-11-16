<?php

use App\Services\LanguageService;
use App\Services\SiteSettingService;
use Illuminate\Support\Facades\Storage;

if (! function_exists('default_locale')) {
    function default_locale(): string
    {
        return app(LanguageService::class)->defaultCode();
    }
}

if (! function_exists('current_locale')) {
    function current_locale(): string
    {
        return app()->getLocale();
    }
}

if (! function_exists('localized_url')) {
    function localized_url(?string $locale = null, string $path = '/'): string
    {
        $locale ??= current_locale();
        $path = '/'.ltrim($path, '/');
        if ($path === '/') {
            $path = '';
        }

        if ($locale === default_locale()) {
            return url($path === '' ? '/' : $path);
        }

        return url('/'.$locale.($path === '' ? '' : $path));
    }
}

if (! function_exists('localized_path')) {
    function localized_path(?string $locale = null, string $path = '/'): string
    {
        $locale ??= current_locale();
        $path = '/'.ltrim($path, '/');
        if ($path === '/') {
            $path = '';
        }

        if ($locale === default_locale()) {
            return $path === '' ? '/' : $path;
        }

        return '/'.$locale.($path === '' ? '' : $path);
    }
}

if (! function_exists('media_url')) {
    function media_url(?string $path, string $fallback = ''): string
    {
        if (! filled($path)) {
            return $fallback;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}

if (! function_exists('trans_field')) {
    function trans_field(?array $translations, string $field, mixed $default = '', ?string $locale = null): mixed
    {
        $locale ??= current_locale();
        $fallback = default_locale();

        $value = data_get($translations, $locale.'.'.$field);

        if ($value === null || $value === '') {
            $value = data_get($translations, $fallback.'.'.$field, $default);
        }

        return $value ?? $default;
    }
}

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SiteSettingService::class)->get($key, $default);
    }
}

if (! function_exists('localized_setting')) {
    function localized_setting(string $key, mixed $default = '', ?string $locale = null): mixed
    {
        $value = setting($key, []);

        if (! is_array($value)) {
            return $value ?? $default;
        }

        $locale ??= current_locale();
        $fallback = default_locale();

        if (array_key_exists($locale, $value) && $value[$locale] !== null && $value[$locale] !== '') {
            return $value[$locale];
        }

        if (array_key_exists($fallback, $value) && $value[$fallback] !== null && $value[$fallback] !== '') {
            return $value[$fallback];
        }

        return $default;
    }
}
