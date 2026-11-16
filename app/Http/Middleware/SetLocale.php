<?php

namespace App\Http\Middleware;

use App\Services\LanguageService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function __construct(private LanguageService $languages) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        $code = $request->route('locale');

        if (! filled($code)) {
            $language = $this->languages->apply($this->languages->defaultCode());
            $this->share($language->code, $language->direction);

            return $next($request);
        }

        $language = $this->languages->findActive((string) $code);

        if (! $language) {
            abort(404);
        }

        if ($language->is_default) {
            $path = '/'.ltrim(str_replace($code, '', (string) $request->path()), '/');

            return redirect($path === '/' ? '/' : $path, 301);
        }

        $this->languages->apply($language->code);
        $this->share($language->code, $language->direction);

        return $next($request);
    }

    private function shouldSkip(Request $request): bool
    {
        return $request->is('admin')
            || $request->is('admin/*')
            || $request->is('livewire/*')
            || $request->is('filament/*')
            || $request->is('storage/*')
            || $request->is('up');
    }

    private function share(string $code, string $direction): void
    {
        view()->share('currentLocale', $code);
        view()->share('currentDirection', $direction);
        view()->share('activeLanguages', $this->languages->active());
        view()->share('defaultLocale', $this->languages->defaultCode());
    }
}
