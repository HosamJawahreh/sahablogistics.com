<?php

namespace App\Providers;

use App\Models\User;
use App\Services\ContentService;
use App\Services\LanguageService;
use App\Services\SiteSettingService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LanguageService::class);
        $this->app->singleton(SiteSettingService::class);
        $this->app->singleton(ContentService::class);
    }

    public function boot(): void
    {
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        Gate::define('access-admin', fn (User $user) => $user->is_admin);

        View::composer('site.*', function ($view): void {
            $view->with('siteName', localized_setting('company.name', 'Sahab Logistics'));
        });
    }
}
