<?php

namespace Tests\Unit;

use App\Models\Language;
use App\Services\LanguageService;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LanguageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SiteContentSeeder::class);
    }

    public function test_set_default_is_exclusive(): void
    {
        $service = app(LanguageService::class);
        $service->setDefault('ar');

        $this->assertSame('ar', $service->defaultCode());
        $this->assertEquals(1, Language::query()->where('is_default', true)->count());
        $this->assertTrue(Language::query()->where('code', 'en')->first()->is_active);
    }

    public function test_inactive_language_cannot_become_default(): void
    {
        Language::query()->where('code', 'ar')->update(['is_active' => false]);
        app(LanguageService::class)->flushCache();

        $this->expectException(ValidationException::class);
        app(LanguageService::class)->setDefault('ar');
    }
}
