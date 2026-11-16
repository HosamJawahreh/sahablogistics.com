<?php

namespace App\Filament\Resources\ContactInquiries\Tables;

use App\Models\ContactInquiry;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactInquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->dateTime()->sortable()->label('Received'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('direction')
                    ->formatStateUsing(fn (string $state): string => ContactInquiry::DIRECTIONS[$state] ?? $state)
                    ->badge(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('mail_status')->badge()->sortable(),
                TextColumn::make('locale')->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options(array_combine(ContactInquiry::STATUSES, ContactInquiry::STATUSES)),
                SelectFilter::make('direction')->options(ContactInquiry::DIRECTIONS),
                SelectFilter::make('mail_status')->options(array_combine(ContactInquiry::MAIL_STATUSES, ContactInquiry::MAIL_STATUSES)),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export CSV')
                    ->action(fn (): StreamedResponse => self::export()),
            ])
            ->recordActions([
                EditAction::make()->label('Manage'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function export(): StreamedResponse
    {
        $filename = 'inquiries-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['id', 'created_at', 'name', 'company', 'email', 'phone', 'direction', 'message', 'locale', 'status', 'mail_status']);

            ContactInquiry::query()->orderBy('id')->chunk(200, function (Collection $rows) use ($handle): void {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->id,
                        $row->created_at,
                        $row->name,
                        $row->company,
                        $row->email,
                        $row->phone,
                        $row->direction,
                        $row->message,
                        $row->locale,
                        $row->status,
                        $row->mail_status,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
