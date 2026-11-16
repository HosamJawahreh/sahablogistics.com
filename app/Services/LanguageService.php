<?php

namespace App\Services;

use App\Models\Language;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class LanguageService
{
    public const CACHE_KEY = 'cms.languages';

    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        app(ContentService::class)->flushCache();
        app(SiteSettingService::class)->flushCache();
    }

    /**
     * @return Collection<int, Language>
     */
    public function all(): Collection
    {
        return Language::query()->orderBy('sort_order')->orderBy('name')->get();
    }

    /**
     * @return Collection<int, Language>
     */
    public function active(): Collection
    {
        return $this->all()->where('is_active', true)->values();
    }

    public function default(): Language
    {
        $language = $this->all()->firstWhere('is_default', true)
            ?? $this->active()->first();

        if (! $language) {
            throw new RuntimeException('No active language is configured.');
        }

        return $language;
    }

    public function defaultCode(): string
    {
        return $this->default()->code;
    }

    public function findActive(string $code): ?Language
    {
        return $this->active()->firstWhere('code', strtolower($code));
    }

    public function apply(string $code): Language
    {
        $language = $this->findActive($code) ?? $this->default();
        app()->setLocale($language->code);

        return $language;
    }

    public function setDefault(string $code): Language
    {
        $language = Language::query()->where('code', strtolower($code))->firstOrFail();

        if (! $language->is_active) {
            throw ValidationException::withMessages([
                'is_default' => 'Only an active language can be set as default.',
            ]);
        }

        DB::transaction(function () use ($language): void {
            Language::query()->where('is_default', true)->update(['is_default' => false]);
            $language->forceFill(['is_default' => true, 'is_active' => true])->save();
        });

        $this->flushCache();

        return $language->refresh();
    }
}
