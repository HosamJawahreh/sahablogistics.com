<?php

namespace App\Filament\Resources\Languages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LanguageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->maxLength(12)
                    ->unique(ignoreRecord: true)
                    ->helperText('ISO-style code such as en, ar, or fr.'),
                TextInput::make('name')->required()->maxLength(80),
                TextInput::make('native_name')->required()->maxLength(80),
                Select::make('direction')
                    ->options(['ltr' => 'LTR', 'rtl' => 'RTL'])
                    ->required()
                    ->native(false),
                TextInput::make('sort_order')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
                Toggle::make('is_default')
                    ->helperText('Use the table action to change the site default language with confirmation.'),
            ]);
    }
}
