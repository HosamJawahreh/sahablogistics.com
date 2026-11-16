<?php

namespace App\Filament\Pages;

use App\Models\Language;
use App\Services\LanguageService;
use App\Services\SiteSettingService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class ManageSiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Site settings';

    protected static ?string $navigationLabel = 'Site settings';

    protected string $view = 'filament-panels::pages.page';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->formStateFromSettings());
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        $seoTabs = Language::query()->active()->get()->map(function (Language $language) {
            return Tab::make($language->native_name)
                ->schema([
                    TextInput::make("seo.{$language->code}.title")->label('SEO title')->required(),
                    Textarea::make("seo.{$language->code}.description")->label('Meta description')->rows(3),
                    TextInput::make("seo.{$language->code}.og_alt")->label('OG image alt'),
                ]);
        })->all();

        $whatsappTabs = Language::query()->active()->get()->map(function (Language $language) {
            return Tab::make($language->native_name)
                ->schema([
                    Textarea::make("contact.whatsapp_prefill.{$language->code}")
                        ->label('WhatsApp prefilled message')
                        ->rows(2),
                ]);
        })->all();

        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('Company')
                            ->schema([
                                TextInput::make('company.name.en')->label('English name')->required(),
                                TextInput::make('company.name.ar')->label('Arabic name')->required(),
                                TextInput::make('company.domain')->label('Domain')->required(),
                                TextInput::make('company.headquarters.en')->label('Headquarters (EN)'),
                                TextInput::make('company.headquarters.ar')->label('Headquarters (AR)'),
                                TextInput::make('company.contact_address.en')->label('Contact address (EN)'),
                                TextInput::make('company.contact_address.ar')->label('Contact address (AR)'),
                            ]),
                        Tab::make('Contact')
                            ->schema([
                                TextInput::make('contact.public_email')->email()->required(),
                                TextInput::make('contact.manager_name')->required(),
                                TextInput::make('contact.manager_email')->email()->required(),
                                TextInput::make('contact.phone_display')->required()->extraAttributes(['dir' => 'ltr']),
                                TextInput::make('contact.phone_e164')->required()->extraAttributes(['dir' => 'ltr']),
                                TextInput::make('contact.whatsapp_number')->required()->extraAttributes(['dir' => 'ltr']),
                                Tabs::make('WhatsApp message')->tabs($whatsappTabs),
                            ]),
                        Tab::make('Location')
                            ->schema([
                                TextInput::make('location.google_maps_url')->url()->required()->columnSpanFull(),
                                TextInput::make('location.map_query')
                                    ->label('Map search query')
                                    ->helperText('Used for the embedded map. Use the supplied address, not invented coordinates.')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Branding')
                            ->schema([
                                TextInput::make('brand.logo_light')->label('Light logo path')->required(),
                                TextInput::make('brand.logo_dark')->label('Dark logo path')->required(),
                                TextInput::make('brand.favicon')->label('Favicon path')->required(),
                                TextInput::make('brand.og_image')->label('Open Graph image path')->required(),
                            ]),
                        Tab::make('SEO')
                            ->schema([
                                Tabs::make('Localized SEO')->tabs($seoTabs),
                            ]),
                        Tab::make('Localization')
                            ->schema([
                                Select::make('default_language')
                                    ->label('Default language')
                                    ->options(fn () => Language::query()->active()->pluck('native_name', 'code'))
                                    ->helperText('Changing this updates the public homepage at / after save.')
                                    ->required()
                                    ->native(false),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save settings')
                                ->submit('save'),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $settings = app(SiteSettingService::class);

        $settings->putMany([
            'company.name' => ['group' => 'company', 'value' => data_get($state, 'company.name')],
            'company.domain' => ['group' => 'company', 'value' => data_get($state, 'company.domain')],
            'company.headquarters' => ['group' => 'company', 'value' => data_get($state, 'company.headquarters')],
            'company.contact_address' => ['group' => 'company', 'value' => data_get($state, 'company.contact_address')],
            'contact.public_email' => ['group' => 'contact', 'value' => data_get($state, 'contact.public_email')],
            'contact.manager_name' => ['group' => 'contact', 'value' => data_get($state, 'contact.manager_name')],
            'contact.manager_email' => ['group' => 'contact', 'value' => data_get($state, 'contact.manager_email')],
            'contact.phone_display' => ['group' => 'contact', 'value' => data_get($state, 'contact.phone_display')],
            'contact.phone_e164' => ['group' => 'contact', 'value' => data_get($state, 'contact.phone_e164')],
            'contact.whatsapp_number' => ['group' => 'contact', 'value' => data_get($state, 'contact.whatsapp_number')],
            'contact.whatsapp_prefill' => ['group' => 'contact', 'value' => data_get($state, 'contact.whatsapp_prefill')],
            'location.google_maps_url' => ['group' => 'location', 'value' => data_get($state, 'location.google_maps_url')],
            'location.map_query' => ['group' => 'location', 'value' => data_get($state, 'location.map_query')],
            'brand.logo_light' => ['group' => 'brand', 'value' => data_get($state, 'brand.logo_light') ?: setting('brand.logo_light')],
            'brand.logo_dark' => ['group' => 'brand', 'value' => data_get($state, 'brand.logo_dark') ?: setting('brand.logo_dark')],
            'brand.favicon' => ['group' => 'brand', 'value' => data_get($state, 'brand.favicon') ?: setting('brand.favicon')],
            'brand.og_image' => ['group' => 'brand', 'value' => data_get($state, 'brand.og_image') ?: setting('brand.og_image')],
            'seo' => ['group' => 'seo', 'value' => data_get($state, 'seo')],
        ]);

        $default = (string) data_get($state, 'default_language');
        if ($default && $default !== app(LanguageService::class)->defaultCode()) {
            app(LanguageService::class)->setDefault($default);
        }

        Notification::make()->title('Settings saved.')->success()->send();
    }

    /**
     * @return array<string, mixed>
     */
    private function formStateFromSettings(): array
    {
        return [
            'company' => [
                'name' => setting('company.name', []),
                'domain' => setting('company.domain'),
                'headquarters' => setting('company.headquarters', []),
                'contact_address' => setting('company.contact_address', []),
            ],
            'contact' => [
                'public_email' => setting('contact.public_email'),
                'manager_name' => setting('contact.manager_name'),
                'manager_email' => setting('contact.manager_email'),
                'phone_display' => setting('contact.phone_display'),
                'phone_e164' => setting('contact.phone_e164'),
                'whatsapp_number' => setting('contact.whatsapp_number'),
                'whatsapp_prefill' => setting('contact.whatsapp_prefill', []),
            ],
            'location' => [
                'google_maps_url' => setting('location.google_maps_url'),
                'map_query' => setting('location.map_query'),
            ],
            'brand' => [
                'logo_light' => setting('brand.logo_light'),
                'logo_dark' => setting('brand.logo_dark'),
                'favicon' => setting('brand.favicon'),
                'og_image' => setting('brand.og_image'),
            ],
            'seo' => setting('seo', []),
            'default_language' => app(LanguageService::class)->defaultCode(),
        ];
    }
}
