<?php

namespace App\Filament\Resources\ContactInquiries\Pages;

use App\Filament\Resources\ContactInquiries\ContactInquiryResource;
use App\Models\ContactInquiry;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactInquiry extends EditRecord
{
    protected static string $resource = ContactInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        /** @var ContactInquiry $inquiry */
        $inquiry = $this->record;

        if ($inquiry->status === 'new') {
            $inquiry->forceFill([
                'status' => 'read',
                'read_at' => now(),
            ])->save();
            $this->record = $inquiry->refresh();
            $this->fillForm();
        }
    }
}
