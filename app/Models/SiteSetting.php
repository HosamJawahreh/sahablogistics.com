<?php

namespace App\Models;

use App\Services\SiteSettingService;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function (): void {
            app(SiteSettingService::class)->flushCache();
        });

        static::deleted(function (): void {
            app(SiteSettingService::class)->flushCache();
        });
    }
}
