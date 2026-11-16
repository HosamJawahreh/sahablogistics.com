<?php

namespace App\Filament\Resources\ContactInquiries\Schemas;

use App\Models\ContactInquiry;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactInquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Enquiry')
                    ->schema([
                        TextInput::make('name')->disabled(),
                        TextInput::make('company')->disabled(),
                        TextInput::make('email')->disabled(),
                        TextInput::make('phone')->disabled()->extraAttributes(['dir' => 'ltr']),
                        TextInput::make('direction')->disabled(),
                        TextInput::make('locale')->disabled(),
                        Textarea::make('message')->disabled()->rows(6)->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Management')
                    ->schema([
                        Select::make('status')
                            ->options(array_combine(ContactInquiry::STATUSES, ContactInquiry::STATUSES))
                            ->required()
                            ->native(false),
                        Select::make('mail_status')
                            ->options(array_combine(ContactInquiry::MAIL_STATUSES, ContactInquiry::MAIL_STATUSES))
                            ->disabled()
                            ->native(false),
                        Textarea::make('mail_error')->disabled()->rows(2)->columnSpanFull(),
                        Textarea::make('admin_notes')->rows(4)->columnSpanFull(),
                    ]),
            ]);
    }
}
