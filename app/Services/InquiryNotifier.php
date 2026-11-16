<?php

namespace App\Services;

use App\Mail\InquiryReceived;
use App\Models\ContactInquiry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class InquiryNotifier
{
    public function notify(ContactInquiry $inquiry): ContactInquiry
    {
        $recipient = (string) setting('contact.public_email', 'info@sahablogistics.com');
        $mailer = (string) config('mail.default');

        try {
            Mail::to($recipient)->send(new InquiryReceived($inquiry));

            $inquiry->forceFill([
                'mail_status' => in_array($mailer, ['log', 'array'], true) ? 'logged' : 'sent',
                'mail_error' => null,
            ])->save();
        } catch (Throwable $exception) {
            Log::warning('Contact inquiry email failed.', [
                'inquiry_id' => $inquiry->id,
                'mailer' => $mailer,
                'error' => $exception->getMessage(),
            ]);

            $inquiry->forceFill([
                'mail_status' => 'failed',
                'mail_error' => $exception->getMessage(),
            ])->save();
        }

        return $inquiry->refresh();
    }
}
