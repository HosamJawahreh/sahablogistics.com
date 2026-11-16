<?php

namespace App\Filament\Resources\Languages\Tables;

use App\Models\Language;
use App\Services\LanguageService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LanguagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('native_name')->searchable(),
                TextColumn::make('direction')->badge(),
                IconColumn::make('is_active')->boolean()->label('Active'),
                IconColumn::make('is_default')->boolean()->label('Default'),
                TextColumn::make('sort_order')->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([
                Action::make('makeDefault')
                    ->label('Set as default')
                    ->icon('heroicon-o-star')
                    ->requiresConfirmation()
                    ->modalHeading('Change the website default language?')
                    ->modalDescription('The homepage at / will immediately use this language. Other languages will use /{code}.')
                    ->visible(fn (Language $record): bool => $record->is_active && ! $record->is_default)
                    ->action(function (Language $record): void {
                        app(LanguageService::class)->setDefault($record->code);
                        Notification::make()->title('Default language updated.')->success()->send();
                    }),
                EditAction::make(),
                DeleteAction::make()
                    ->disabled(fn (Language $record): bool => $record->is_default),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
