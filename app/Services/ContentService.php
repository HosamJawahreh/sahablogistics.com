<?php

namespace App\Services;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ContentService
{
    public const CACHE_KEY = 'cms.home.sections';

    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function homePage(): ?Page
    {
        return Page::query()->where('key', 'home')->first();
    }

    /**
     * @return Collection<string, PageSection>
     */
    public function homeSections(bool $visibleOnly = true): Collection
    {
        $page = $this->homePage();

        if (! $page) {
            return collect();
        }

        $sections = $page->sections()->orderBy('sort_order')->get();

        if ($visibleOnly) {
            $sections = $sections
                ->where('is_enabled', true)
                ->where('is_published', true)
                ->values();
        }

        return $sections->keyBy('key');
    }

    public function section(string $key, bool $visibleOnly = true): ?PageSection
    {
        return $this->homeSections($visibleOnly)->get($key);
    }
}
