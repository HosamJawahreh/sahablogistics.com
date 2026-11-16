<?php

namespace App\Http\Controllers;

use App\Services\LanguageService;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $sitemap = url('/sitemap.xml');

        $body = <<<TXT
User-agent: *
Allow: /
Disallow: /admin
Disallow: /admin/

Sitemap: {$sitemap}

TXT;

        return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function sitemap(LanguageService $languages): Response
    {
        $urls = $languages->active()->map(function ($language) use ($languages) {
            $loc = $language->is_default
                ? url('/')
                : url('/'.$language->code);

            return [
                'loc' => $loc,
                'hreflang' => $language->code,
                'default' => $language->code === $languages->defaultCode(),
            ];
        });

        $xml = view('seo.sitemap', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
