<?php

namespace App\Http\Requests;

use App\Models\ContactInquiry;
use App\Services\ContentService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (filled($this->input('website'))) {
            abort(422, $this->message('honeypot_fail', 'Unable to submit the form.'));
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'email:rfc', 'max:160'],
            'phone' => ['required', 'string', 'max:40'],
            'direction' => ['required', 'string', Rule::in(array_keys(ContactInquiry::DIRECTIONS))],
            'message' => ['required', 'string', 'max:5000'],
            'website' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => $this->message('validation_name', 'Please enter your full name.'),
            'email.required' => $this->message('validation_email', 'Please enter a valid email address.'),
            'email.email' => $this->message('validation_email', 'Please enter a valid email address.'),
            'phone.required' => $this->message('validation_phone', 'Please enter a phone number.'),
            'direction.required' => $this->message('validation_direction', 'Please select a transportation direction.'),
            'message.required' => $this->message('validation_message', 'Please enter your message.'),
        ];
    }

    public function successMessage(): string
    {
        return $this->message('success', 'Thank you. Your inquiry has been received.');
    }

    private function message(string $key, string $fallback): string
    {
        $section = app(ContentService::class)->section('contact', false);

        if (! $section) {
            return $fallback;
        }

        return (string) $section->t($key, $fallback);
    }
}
