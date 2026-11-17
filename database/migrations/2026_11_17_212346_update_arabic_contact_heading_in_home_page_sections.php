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
        $this->updateArabicContactTitle('لندفع أعمالك إلى الأمام', 'يسرّنا تواصلك');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->updateArabicContactTitle('يسرّنا تواصلك', 'لندفع أعمالك إلى الأمام');
    }

    private function updateArabicContactTitle(string $currentTitle, string $newTitle): void
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
            || ($translations['ar']['title'] ?? null) !== $currentTitle) {
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
