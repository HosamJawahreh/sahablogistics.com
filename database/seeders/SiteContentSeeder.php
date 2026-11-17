<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Page;
use App\Models\PageSection;
use App\Services\SiteSettingService;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/bilingual-site-content.json');
        $data = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
        $sections = $data['sections'];
        $company = $data['company'];

        foreach ($data['languages'] as $language) {
            Language::query()->updateOrCreate(
                ['code' => $language['code']],
                [
                    'name' => $language['name'],
                    'native_name' => $language['native_name'],
                    'direction' => $language['direction'],
                    'is_active' => $language['is_active'],
                    'is_default' => $language['is_default'],
                    'sort_order' => $language['sort_order'],
                ],
            );
        }

        $page = Page::query()->updateOrCreate(
            ['key' => 'home'],
            ['is_published' => true, 'sort_order' => 1],
        );

        $benefitIcons = ['map-pin', 'ship', 'tag', 'shield'];
        $pillarIcons = ['cpu', 'leaf', 'heart'];
        $serviceIcons = ['arrows', 'map-pin', 'tag', 'truck'];
        $stepIcons = ['chat', 'clipboard', 'cog', 'flag'];

        $this->upsertSection($page, 'navigation', 'navigation', 0, [
            'en' => $sections['navigation']['en'],
            'ar' => $sections['navigation']['ar'],
        ]);

        $this->upsertSection($page, 'hero', 'hero', 1, $sections['hero'], [
            'desktop' => '/assets/images/hero/hero-aqaba-desktop.webp',
            'mobile' => '/assets/images/hero-aqaba-mobile.webp',
            'alt' => [
                'en' => 'White freight truck on the road toward Aqaba Port at sunset',
                'ar' => 'شاحنة نقل بيضاء على الطريق باتجاه ميناء العقبة عند الغروب',
            ],
        ]);

        $this->upsertSection($page, 'benefits', 'benefits', 2, [
            'en' => ['items' => $this->withIcons($sections['benefits']['en'], $benefitIcons)],
            'ar' => ['items' => $this->withIcons($sections['benefits']['ar'], $benefitIcons)],
        ]);

        $this->upsertSection($page, 'about', 'about', 3, [
            'en' => [
                ...$sections['about']['en'],
                'cta' => $sections['about']['en']['cta'] ?? 'Learn More',
                'pillars' => $this->withIcons($sections['about']['en']['pillars'], $pillarIcons),
            ],
            'ar' => [
                ...$sections['about']['ar'],
                'cta' => $sections['about']['ar']['cta'] ?? 'اعرف المزيد',
                'pillars' => $this->withIcons($sections['about']['ar']['pillars'], $pillarIcons),
            ],
        ], [
            'image' => '/assets/images/reference-crops/about-port-reference-1024.webp',
            'alt' => [
                'en' => 'Aqaba Port with container ship, cranes and the Jordan flag',
                'ar' => 'ميناء العقبة مع سفينة حاويات ورافعات وعلم الأردن',
            ],
        ]);

        $this->upsertSection($page, 'vision', 'vision', 4, $sections['vision']);
        $this->upsertSection($page, 'mission', 'mission', 5, $sections['mission']);

        $this->upsertSection($page, 'service', 'service', 6, [
            'en' => [
                ...$sections['service']['en'],
                'benefits' => $this->stringListWithIcons($sections['service']['en']['benefits'], $serviceIcons),
            ],
            'ar' => [
                ...$sections['service']['ar'],
                'benefits' => $this->stringListWithIcons($sections['service']['ar']['benefits'], $serviceIcons),
            ],
        ], [
            'image' => '/assets/images/reference-crops/service-truck-reference-1024.webp',
            'alt' => [
                'en' => 'Freight truck used for Jordan to Aqaba Port transportation',
                'ar' => 'شاحنة نقل لخدمة النقل بين الأردن وميناء العقبة',
            ],
        ]);

        $this->upsertSection($page, 'how_we_work', 'process', 7, [
            'en' => [
                ...$sections['how_we_work']['en'],
                'steps' => $this->withIcons($sections['how_we_work']['en']['steps'], $stepIcons),
            ],
            'ar' => [
                ...$sections['how_we_work']['ar'],
                'steps' => $this->withIcons($sections['how_we_work']['ar']['steps'], $stepIcons),
            ],
        ], [], $sections['how_we_work']['en']['approval_note']);

        $this->upsertSection($page, 'global_reach', 'global', 8, $sections['global_reach'], [
            'image' => '/assets/images/global-network.svg',
            'alt' => [
                'en' => 'Abstract global network illustration',
                'ar' => 'رسم تجريدي لشبكة عالمية',
            ],
        ]);

        $this->upsertSection($page, 'contact', 'contact', 9, [
            'en' => [
                ...$sections['contact']['en'],
                'validation_name' => 'Please enter your full name.',
                'validation_email' => 'Please enter a valid email address.',
                'validation_phone' => 'Please enter a phone number.',
                'validation_direction' => 'Please select a transportation direction.',
                'validation_message' => 'Please enter your message.',
                'honeypot_fail' => 'Unable to submit the form.',
            ],
            'ar' => [
                ...$sections['contact']['ar'],
                'validation_name' => 'يرجى إدخال الاسم الكامل.',
                'validation_email' => 'يرجى إدخال بريد إلكتروني صالح.',
                'validation_phone' => 'يرجى إدخال رقم الهاتف.',
                'validation_direction' => 'يرجى اختيار اتجاه النقل.',
                'validation_message' => 'يرجى إدخال رسالتك.',
                'honeypot_fail' => 'تعذر إرسال النموذج.',
            ],
        ]);

        $this->upsertSection($page, 'footer', 'footer', 10, [
            'en' => [
                ...$sections['footer']['en'],
                'quick_links' => 'Quick links',
                'contact' => 'Contact',
            ],
            'ar' => [
                ...$sections['footer']['ar'],
                'quick_links' => 'روابط سريعة',
                'contact' => 'تواصل',
            ],
        ]);

        app(SiteSettingService::class)->putMany([
            'company.name' => ['group' => 'company', 'value' => $company['name']],
            'company.domain' => ['group' => 'company', 'value' => $company['domain']],
            'company.headquarters' => ['group' => 'company', 'value' => $company['headquarters']],
            'company.contact_address' => ['group' => 'company', 'value' => $company['contact_address']],
            'contact.public_email' => ['group' => 'contact', 'value' => $company['public_email']],
            'contact.manager_name' => ['group' => 'contact', 'value' => $company['manager_name']],
            'contact.manager_email' => ['group' => 'contact', 'value' => $company['manager_email']],
            'contact.phone_display' => ['group' => 'contact', 'value' => $company['phone_display']],
            'contact.phone_e164' => ['group' => 'contact', 'value' => $company['phone_e164']],
            'contact.whatsapp_number' => ['group' => 'contact', 'value' => $company['whatsapp_number']],
            'contact.whatsapp_prefill' => ['group' => 'contact', 'value' => [
                'en' => 'Hello Sahab Logistics, I would like to enquire about Jordan – Aqaba Port transportation.',
                'ar' => 'مرحباً شركة سحاب للخدمات اللوجستية، أود الاستفسار عن النقل بين الأردن وميناء العقبة.',
            ]],
            'location.google_maps_url' => ['group' => 'location', 'value' => $company['google_maps_url']],
            'location.map_query' => ['group' => 'location', 'value' => $company['contact_address']['en']],
            'brand.logo_light' => ['group' => 'brand', 'value' => '/assets/brand/sahab-logo-light.png'],
            'brand.logo_dark' => ['group' => 'brand', 'value' => '/assets/brand/sahab-logo-dark.png'],
            'brand.favicon' => ['group' => 'brand', 'value' => '/assets/brand/favicon.ico'],
            'brand.og_image' => ['group' => 'brand', 'value' => '/assets/images/og-sahab.jpg'],
            'seo' => ['group' => 'seo', 'value' => [
                'en' => [
                    'title' => 'Sahab Logistics | Jordan – Aqaba Port Transportation',
                    'description' => 'Reliable, cost-effective transportation from all areas of Jordan to Aqaba Port, and vice versa.',
                    'og_alt' => 'Sahab Logistics transportation to Aqaba Port',
                ],
                'ar' => [
                    'title' => 'سحاب للخدمات اللوجستية | النقل بين الأردن وميناء العقبة',
                    'description' => 'خدمات نقل موثوقة وبتكلفة تنافسية من جميع مناطق الأردن إلى ميناء العقبة، وبالعكس.',
                    'og_alt' => 'شركة سحاب للنقل إلى ميناء العقبة',
                ],
            ]],
        ]);
    }

    /**
     * @param  array<string, array<string, mixed>>  $translations
     * @param  array<string, mixed>  $media
     */
    private function upsertSection(
        Page $page,
        string $key,
        string $type,
        int $order,
        array $translations,
        array $media = [],
        ?string $approvalNote = null,
    ): void {
        PageSection::query()->updateOrCreate(
            ['page_id' => $page->id, 'key' => $key],
            [
                'type' => $type,
                'is_enabled' => true,
                'is_published' => true,
                'sort_order' => $order,
                'translations' => $translations,
                'media' => $media,
                'approval_note' => $approvalNote,
            ],
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @param  array<int, string>  $icons
     * @return array<int, array<string, mixed>>
     */
    private function withIcons(array $items, array $icons): array
    {
        return collect($items)->values()->map(function (array $item, int $index) use ($icons) {
            $item['icon'] = $icons[$index] ?? 'check';

            return $item;
        })->all();
    }

    /**
     * @param  array<int, string>  $items
     * @param  array<int, string>  $icons
     * @return array<int, array{text: string, icon: string}>
     */
    private function stringListWithIcons(array $items, array $icons): array
    {
        return collect($items)->values()->map(fn (string $text, int $index) => [
            'text' => $text,
            'icon' => $icons[$index] ?? 'check',
        ])->all();
    }
}
