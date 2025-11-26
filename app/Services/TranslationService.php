<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\File;

class TranslationService
{
    /**
     * ✅ إضافة المفتاح لكل اللغات إذا مش موجود
     */
    public function storeIfNotExists($key, $locales)
    {
        foreach ($locales as $locale) {
            Translation::firstOrCreate(
                ['key' => $key, 'locale' => $locale],
                ['value' => $key] // القيمة الافتراضية = نفس الكي
            );
        }
    }

    /**
     * ✅ جلب الترجمة للعرض
     */
    public function get($key, $locale)
    {
        $translation = Translation::where('key', $key)
            ->where('locale', $locale)
            ->first();

        return $translation?->value ?? $key;
    }

    /**
     * ✅ تصدير لغة واحدة إلى JSON
     */
    public function exportToJson($locale)
    {
        $translations = Translation::where('locale', $locale)
            ->pluck('value', 'key')
            ->toArray();

        $path = base_path("lang/{$locale}.json");

        File::put(
            $path,
            json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * ✅ تصدير جميع اللغات
     */
    public function exportAll()
    {
        $locales = Translation::select('locale')->distinct()->pluck('locale');

        foreach ($locales as $locale) {
            $this->exportToJson($locale);
        }
    }

    /**
     * ✅ المزامنة الكاملة (استخراج المفاتيح + إدخال + تصدير)
     */



    public function sync()
    {
        $keys = [];

        // 1. Scan views (Blade files)
        $files = File::allFiles(resource_path('views'));

        foreach ($files as $file) {
            $content = File::get($file->getPathname());

            preg_match_all("/__\(['\"](.*?)['\"]\)/", $content, $matches1);
            preg_match_all("/@lang\(['\"](.*?)['\"]\)/", $content, $matches2);

            $keys = array_merge($keys, $matches1[1], $matches2[1]);
        }

        // 2. Scan PHP files (Controllers, Services)
        $phpFiles = File::allFiles(app_path());

        foreach ($phpFiles as $file) {
            $content = File::get($file->getPathname());

            preg_match_all("/__\(['\"](.*?)['\"]\)/", $content, $matches);
            $keys = array_merge($keys, $matches[1]);
        }

        $keys = array_unique($keys);

        // 3. Insert into DB
        $locales = Language::pluck('code'); // حط كل لغاتك هون
        foreach ($keys as $key) {
            $this->storeIfNotExists($key, $locales);
        }

        // 4. Export to JSON
        $this->exportAll();
    }
}
