<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactInquiryRequest;
use App\Models\ContactInquiry;
use App\Services\InquiryNotifier;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(StoreContactInquiryRequest $request, InquiryNotifier $notifier): RedirectResponse
    {
        $inquiry = ContactInquiry::query()->create([
            ...$request->safe()->only(['name', 'company', 'email', 'phone', 'direction', 'message']),
            'locale' => app()->getLocale(),
            'status' => 'new',
            'mail_status' => 'pending',
        ]);

        $notifier->notify($inquiry);

        $message = (string) ($request->successMessage() ?: 'Thank you. Your inquiry has been received.');

        return redirect()
            ->to(localized_url(app()->getLocale()).'#contact')
            ->with('contact_success', $message);
    }
}
