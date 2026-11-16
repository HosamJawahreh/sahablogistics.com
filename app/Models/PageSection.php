<?php

namespace App\Models;

use App\Services\ContentService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'key',
        'type',
        'is_enabled',
        'is_published',
        'sort_order',
        'translations',
        'media',
        'approval_note',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'translations' => 'array',
            'media' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function (): void {
            app(ContentService::class)->flushCache();
        });

        static::deleted(function (): void {
            app(ContentService::class)->flushCache();
        });
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_enabled', true)->where('is_published', true)->orderBy('sort_order');
    }

    public function t(string $field, mixed $default = '', ?string $locale = null): mixed
    {
        return trans_field($this->translations ?? [], $field, $default, $locale);
    }

    public function items(?string $field = 'items', ?string $locale = null): array
    {
        $value = $this->t($field, [], $locale);

        return is_array($value) ? $value : [];
    }

    public function mediaPath(string $key, string $fallback = ''): string
    {
        return media_url(data_get($this->media, $key), $fallback);
    }
}
