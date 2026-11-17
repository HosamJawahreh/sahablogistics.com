<?php

namespace Tests\Feature;

use App\Models\Language;
use App\Services\LanguageService;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleRoutingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SiteContentSeeder::class);
    }

    public function test_default_locale_path_redirects_to_root(): void
    {
        $this->get('/en')->assertRedirect('/');
    }

    public function test_unknown_locale_returns_not_found(): void
    {
        $this->get('/zz')->assertNotFound();
    }

    public function test_disabled_locale_returns_not_found(): void
    {
        Language::query()->where('code', 'ar')->update(['is_active' => false]);
        app(LanguageService::class)->flushCache();

        $this->get('/ar')->assertNotFound();
    }

    public function test_switching_default_language_changes_the_homepage(): void
    {
        app(LanguageService::class)->setDefault('ar');

        $this->get('/')->assertOk()->assertSee('نربط الأردن بميناء العقبة وما بعده', false);
        $this->get('/ar')->assertRedirect('/');
        $this->get('/en')->assertOk()
            ->assertSee('Connecting Jordan', false)
            ->assertSee('Aqaba Port', false)
            ->assertSee('Beyond', false);
    }

    public function test_sitemap_lists_active_locales(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertSee('hreflang="en"', false)
            ->assertSee('hreflang="ar"', false);
    }
}
