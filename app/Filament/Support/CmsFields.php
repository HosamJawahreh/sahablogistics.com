<?php

namespace App\Filament\Support;

use App\Models\Language;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class CmsFields
{
    /**
     * @return array<string, string>
     */
    public static function icons(): array
    {
        return [
            'map-pin' => 'Map pin',
            'ship' => 'Ship',
            'tag' => 'Price tag',
            'shield' => 'Shield',
            'cpu' => 'Technology',
            'leaf' => 'Sustainability',
            'heart' => 'Customer service',
            'arrows' => 'Two-way arrows',
            'truck' => 'Truck',
            'chat' => 'Message',
            'clipboard' => 'Plan',
            'cog' => 'Coordinate',
            'flag' => 'Deliver',
            'eye' => 'Vision',
            'target' => 'Mission',
            'globe' => 'Globe',
            'check' => 'Check',
        ];
    }

    /**
     * @param  array<int, \Filament\Schemas\Components\Component>|\Closure  $fields
     */
    public static function translationTabs(callable $fieldsForLocale): Tabs
    {
        $languages = Language::query()->active()->get();

        if ($languages->isEmpty()) {
            $languages = collect([
                (object) ['code' => 'en', 'native_name' => 'English'],
            ]);
        }

        return Tabs::make('Translations')
            ->tabs(
                $languages->map(function ($language) use ($fieldsForLocale) {
                    return Tab::make($language->native_name)
                        ->schema($fieldsForLocale($language->code));
                })->all()
            )
            ->columnSpanFull();
    }

    public static function iconSelect(string $name = 'icon'): Select
    {
        return Select::make($name)
            ->options(self::icons())
            ->searchable()
            ->native(false);
    }

    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function forSection(string $key, string $locale): array
    {
        $prefix = "translations.{$locale}.";

        return match ($key) {
            'navigation' => [
                TextInput::make($prefix.'home')->label('Home'),
                TextInput::make($prefix.'about')->label('About'),
                TextInput::make($prefix.'services')->label('Services'),
                TextInput::make($prefix.'vision_mission')->label('Vision & Mission'),
                TextInput::make($prefix.'global_reach')->label('Global Reach'),
                TextInput::make($prefix.'contact')->label('Contact'),
                TextInput::make($prefix.'quote')->label('Quote button'),
            ],
            'hero' => [
                TextInput::make($prefix.'eyebrow')->label('Eyebrow'),
                TextInput::make($prefix.'title')->label('Headline')->required(),
                Textarea::make($prefix.'description')->label('Description')->rows(3)->columnSpanFull(),
                TextInput::make($prefix.'primary_cta')->label('Primary CTA'),
                TextInput::make($prefix.'secondary_cta')->label('Secondary CTA'),
            ],
            'benefits' => [
                Repeater::make($prefix.'items')
                    ->label('Benefit items')
                    ->schema([
                        TextInput::make('title')->required(),
                        Textarea::make('text')->rows(2),
                        self::iconSelect(),
                    ])
                    ->reorderable()
                    ->collapsible()
                    ->columnSpanFull(),
            ],
            'about' => [
                TextInput::make($prefix.'eyebrow')->label('Eyebrow'),
                TextInput::make($prefix.'title')->label('Title'),
                Repeater::make($prefix.'paragraphs')
                    ->simple(Textarea::make('paragraph')->rows(3))
                    ->label('Paragraphs')
                    ->columnSpanFull(),
                Repeater::make($prefix.'pillars')
                    ->label('Pillars')
                    ->schema([
                        TextInput::make('title')->required(),
                        Textarea::make('text')->rows(2),
                        self::iconSelect(),
                    ])
                    ->reorderable()
                    ->columnSpanFull(),
                TextInput::make($prefix.'cta')->label('Learn more label'),
            ],
            'vision', 'mission' => [
                TextInput::make($prefix.'title')->label('Title'),
                Textarea::make($prefix.'text')->label('Body')->rows(5)->columnSpanFull(),
            ],
            'service' => [
                TextInput::make($prefix.'eyebrow')->label('Eyebrow'),
                TextInput::make($prefix.'title')->label('Title'),
                Textarea::make($prefix.'description')->rows(4)->columnSpanFull(),
                Repeater::make($prefix.'benefits')
                    ->schema([
                        TextInput::make('text')->required(),
                        self::iconSelect(),
                    ])
                    ->reorderable()
                    ->columnSpanFull(),
            ],
            'how_we_work' => [
                TextInput::make($prefix.'eyebrow')->label('Eyebrow'),
                TextInput::make($prefix.'title')->label('Title'),
                Repeater::make($prefix.'steps')
                    ->schema([
                        TextInput::make('title')->required(),
                        Textarea::make('text')->rows(2),
                        self::iconSelect(),
                    ])
                    ->reorderable()
                    ->columnSpanFull(),
            ],
            'global_reach' => [
                TextInput::make($prefix.'eyebrow')->label('Eyebrow'),
                TextInput::make($prefix.'title')->label('Title'),
                Textarea::make($prefix.'text')->rows(4)->columnSpanFull(),
            ],
            'contact' => [
                TextInput::make($prefix.'eyebrow'),
                TextInput::make($prefix.'title'),
                Textarea::make($prefix.'intro')->rows(2)->columnSpanFull(),
                TextInput::make($prefix.'full_name'),
                TextInput::make($prefix.'company'),
                TextInput::make($prefix.'email'),
                TextInput::make($prefix.'phone'),
                TextInput::make($prefix.'service_direction'),
                TextInput::make($prefix.'select_direction'),
                TextInput::make($prefix.'to_aqaba'),
                TextInput::make($prefix.'from_aqaba'),
                TextInput::make($prefix.'round_trip'),
                TextInput::make($prefix.'general'),
                TextInput::make($prefix.'message'),
                TextInput::make($prefix.'send'),
                TextInput::make($prefix.'map_title'),
                TextInput::make($prefix.'map_address'),
                TextInput::make($prefix.'directions'),
                TextInput::make($prefix.'success')->label('Success message')->columnSpanFull(),
                TextInput::make($prefix.'validation_name'),
                TextInput::make($prefix.'validation_email'),
                TextInput::make($prefix.'validation_phone'),
                TextInput::make($prefix.'validation_direction'),
                TextInput::make($prefix.'validation_message'),
            ],
            'footer' => [
                TextInput::make($prefix.'company'),
                TextInput::make($prefix.'company_ar')->label('Arabic company name'),
                TextInput::make($prefix.'copyright'),
                TextInput::make($prefix.'quick_links'),
                TextInput::make($prefix.'contact'),
            ],
            default => [
                TextInput::make($prefix.'title')->label('Title'),
                Textarea::make($prefix.'text')->label('Body')->rows(4)->columnSpanFull(),
            ],
        };
    }

    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function mediaFields(string $key): array
    {
        $upload = fn (string $name, string $label) => TextInput::make("media.{$name}")
            ->label($label)
            ->helperText('Public path such as /assets/images/file.webp or /storage/cms/file.webp after upload.');

        return match ($key) {
            'hero' => [
                $upload('desktop', 'Desktop hero image'),
                $upload('mobile', 'Mobile hero image'),
            ],
            'about' => [$upload('image', 'About / port image')],
            'service' => [$upload('image', 'Service image')],
            'global_reach' => [$upload('image', 'Global reach image')],
            default => [],
        };
    }
}
