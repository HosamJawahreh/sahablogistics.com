<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettingService
{
    public const CACHE_KEY = 'cms.site_settings';

    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return SiteSetting::query()
            ->get()
            ->mapWithKeys(fn (SiteSetting $setting) => [$setting->key => $setting->value])
            ->all();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public function put(string $key, string $group, mixed $value): SiteSetting
    {
        $setting = SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            ['group' => $group, 'value' => $value],
        );

        $this->flushCache();

        return $setting;
    }

    /**
     * @param  array<string, array{group: string, value: mixed}>  $items
     */
    public function putMany(array $items): void
    {
        foreach ($items as $key => $item) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['group' => $item['group'], 'value' => $item['value']],
            );
        }

        $this->flushCache();
    }
}
