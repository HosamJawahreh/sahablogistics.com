<?php

namespace App\Http\Controllers;

use App\Services\ContentService;
use App\Services\LanguageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show(Request $request, ContentService $content, LanguageService $languages): View
    {
        $locale = $languages->findActive(app()->getLocale()) ?? $languages->default();
        $sections = $content->homeSections();

        return view('site.home', [
            'locale' => $locale,
            'languages' => $languages->active(),
            'sections' => $sections,
            'nav' => $sections->get('navigation'),
            'hero' => $sections->get('hero'),
            'benefits' => $sections->get('benefits'),
            'about' => $sections->get('about'),
            'vision' => $sections->get('vision'),
            'mission' => $sections->get('mission'),
            'service' => $sections->get('service'),
            'howWeWork' => $sections->get('how_we_work'),
            'globalReach' => $sections->get('global_reach'),
            'contact' => $sections->get('contact'),
            'footer' => $sections->get('footer'),
        ]);
    }
}
