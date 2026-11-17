<?php

namespace Tests\Feature;

use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SiteContentSeeder::class);
    }

    public function test_home_page_renders_english_by_default(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Connecting Jordan', false);
        $response->assertSee('Aqaba Port', false);
        $response->assertSee('Beyond', false);
        $response->assertSee('service-truck-reference-1024.webp', false);
        $response->assertSee('about-port-reference-1024.webp', false);
        $response->assertSee('contact-map-preview-reference-1024.webp', false);
        $response->assertSee('global-reach-scene.jpg', false);
        $response->assertSee('https://wa.me/962799248711', false);
        $response->assertSee('Jordan – Aqaba Port Transportation', false);
        $response->assertDontSee('customs clearance', false);
        $response->assertSee('info@sahablogistics.com', false);
        $response->assertSee('images/hero/hero-aqaba-desktop.webp', false);
        $response->assertSee('sahab-logo-light.png', false);
    }

    public function test_arabic_page_renders_translated_content_and_rtl(): void
    {
        $response = $this->get('/ar');

        $response->assertOk();
        $response->assertSee('lang="ar"', false);
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('نربط الأردن بميناء العقبة وما بعده', false);
        $response->assertSee('النقل بين الأردن وميناء العقبة', false);
        $response->assertSee('دوار الجامعة', false);
    }
}
