<?php

namespace App\Models;

use App\Services\LanguageService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Language extends Model
{
    protected $fillable = [
        'code',
        'name',
        'native_name',
        'direction',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Language $language): void {
            $language->code = strtolower(trim($language->code));
            $language->direction = in_array($language->direction, ['ltr', 'rtl'], true)
                ? $language->direction
                : 'ltr';

            if ($language->is_default && ! $language->is_active) {
                throw ValidationException::withMessages([
                    'is_active' => 'The default language must remain active.',
                ]);
            }

            $activeCount = static::query()
                ->where('is_active', true)
                ->when($language->exists, fn (Builder $query) => $query->whereKeyNot($language->getKey()))
                ->count();

            if ($language->exists && ! $language->is_active && $activeCount < 1) {
                throw ValidationException::withMessages([
                    'is_active' => 'At least one language must remain active.',
                ]);
            }

            if ($language->exists && $language->getOriginal('is_default') && ! $language->is_default) {
                $otherDefault = static::query()
                    ->where('is_default', true)
                    ->whereKeyNot($language->getKey())
                    ->exists();

                if (! $otherDefault) {
                    throw ValidationException::withMessages([
                        'is_default' => 'Choose another default language before unsetting this one.',
                    ]);
                }
            }
        });

        static::saved(function (Language $language): void {
            if ($language->is_default) {
                static::query()->whereKeyNot($language->getKey())->where('is_default', true)->update(['is_default' => false]);
            }

            app(LanguageService::class)->flushCache();
        });

        static::deleted(function (): void {
            app(LanguageService::class)->flushCache();
        });

        static::deleting(function (Language $language): void {
            if ($language->is_default) {
                throw ValidationException::withMessages([
                    'is_default' => 'Choose another default language before deleting this one.',
                ]);
            }

            $activeCount = static::query()
                ->where('is_active', true)
                ->whereKeyNot($language->getKey())
                ->count();

            if ($activeCount < 1) {
                throw ValidationException::withMessages([
                    'is_active' => 'At least one language must remain active.',
                ]);
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }

    public function isRtl(): bool
    {
        return $this->direction === 'rtl';
    }
}
