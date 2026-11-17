<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->updateArabicContactTitle(
            ['لندفع أعمالك إلى الأمام', 'يسرّنا تواصلك'],
            'يسعدنا تواصلكم',
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->updateArabicContactTitle(['يسعدنا تواصلكم'], 'يسرّنا تواصلك');
    }

    /**
     * @param  array<int, string>  $currentTitles
     */
    private function updateArabicContactTitle(array $currentTitles, string $newTitle): void
    {
        $pageId = DB::table('pages')->where('key', 'home')->value('id');

        if (! $pageId) {
            return;
        }

        $section = DB::table('page_sections')
            ->where('page_id', $pageId)
            ->where('key', 'contact')
            ->first();

        if (! $section?->translations) {
            return;
        }

        $translations = json_decode($section->translations, true);

        if (! is_array($translations)
            || ! is_array($translations['ar'] ?? null)
            || ! in_array($translations['ar']['title'] ?? null, $currentTitles, true)) {
            return;
        }

        $translations['ar']['title'] = $newTitle;

        DB::table('page_sections')
            ->where('id', $section->id)
            ->update([
                'translations' => json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
                'updated_at' => now(),
            ]);
    }
};
