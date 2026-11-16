<?php

namespace App\Filament\Resources\PageSections\Schemas;

use App\Filament\Support\CmsFields;
use App\Models\Page;
use App\Models\PageSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PageSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('page_id')
                    ->label('Page')
                    ->options(fn () => Page::query()->pluck('key', 'id'))
                    ->required()
                    ->native(false),
                TextInput::make('key')
                    ->required()
                    ->maxLength(80)
                    ->helperText('Stable key such as hero, about, or contact.'),
                TextInput::make('type')->required()->default('content'),
                TextInput::make('sort_order')->numeric()->default(0),
                Toggle::make('is_enabled')->default(true),
                Toggle::make('is_published')->default(true),
                Textarea::make('approval_note')
                    ->rows(2)
                    ->columnSpanFull()
                    ->helperText('Use this for draft copy that still needs client approval.'),
                CmsFields::translationTabs(function (string $locale): array {
                    return [
                        TextInput::make("translations.{$locale}.title")->hidden(),
                    ];
                })->hidden(),
                Section::make('Localized content')
                    ->schema(function (Get $get, ?PageSection $record): array {
                        $key = $record?->key ?: (string) $get('key');

                        return [
                            CmsFields::translationTabs(
                                fn (string $locale): array => CmsFields::forSection($key, $locale)
                            ),
                        ];
                    })
                    ->columnSpanFull(),
                Section::make('Media')
                    ->schema(function (Get $get, ?PageSection $record): array {
                        $key = $record?->key ?: (string) $get('key');

                        return CmsFields::mediaFields($key);
                    })
                    ->columnSpanFull()
                    ->visible(function (Get $get, ?PageSection $record): bool {
                        $key = $record?->key ?: (string) $get('key');

                        return CmsFields::mediaFields($key) !== [];
                    }),
            ]);
    }
}
