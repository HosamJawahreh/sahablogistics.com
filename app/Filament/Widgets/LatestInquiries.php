<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactInquiries\ContactInquiryResource;
use App\Models\ContactInquiry;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestInquiries extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => ContactInquiry::query()->latest())
            ->columns([
                TextColumn::make('created_at')->since()->label('When'),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('status')->badge(),
                TextColumn::make('mail_status')->badge(),
            ])
            ->recordActions([
                Action::make('open')
                    ->url(fn (ContactInquiry $record): string => ContactInquiryResource::getUrl('edit', ['record' => $record])),
            ])
            ->paginated([5]);
    }
}
