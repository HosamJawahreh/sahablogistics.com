<?php

namespace Tests\Feature;

use App\Mail\InquiryReceived;
use App\Models\ContactInquiry;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactInquiryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SiteContentSeeder::class);
    }

    public function test_contact_form_persists_an_inquiry(): void
    {
        Mail::fake();

        $response = $this->from('/#contact')->post('/contact', [
            'name' => 'Test User',
            'company' => 'Acme',
            'email' => 'test@example.com',
            'phone' => '+962799000000',
            'direction' => 'to_aqaba',
            'message' => 'Need transport from Amman to Aqaba Port.',
            'website' => '',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_inquiries', [
            'email' => 'test@example.com',
            'direction' => 'to_aqaba',
            'name' => 'Test User',
        ]);

        $inquiry = ContactInquiry::query()->first();
        $this->assertContains($inquiry->mail_status, ['sent', 'logged', 'failed']);
        Mail::assertSent(InquiryReceived::class);
    }

    public function test_contact_form_requires_core_fields(): void
    {
        $this->from('/')->post('/contact', [])->assertSessionHasErrors(['name', 'email', 'phone', 'direction', 'message']);
        $this->assertDatabaseCount('contact_inquiries', 0);
    }

    public function test_honeypot_rejects_bots_without_saving(): void
    {
        $this->from('/')->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'phone' => '123',
            'direction' => 'general',
            'message' => 'spam',
            'website' => 'http://spam.test',
        ])->assertStatus(422);

        $this->assertDatabaseCount('contact_inquiries', 0);
    }
}
