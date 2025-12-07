<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set application locale from settings
        try {
            $locale = \App\Models\Setting::get('app_language', config('app.locale'));
            if (in_array($locale, ['id', 'en'])) {
                app()->setLocale($locale);
                \Illuminate\Support\Facades\Config::set('app.locale', $locale);
            }
        } catch (\Exception $e) {
            // If settings table doesn't exist yet (during migration), use default
        }

        // Set timezone from settings
        try {
            $timezone = \App\Models\Setting::get('app_timezone', config('app.timezone'));
            if ($timezone) {
                date_default_timezone_set($timezone);
                \Illuminate\Support\Facades\Config::set('app.timezone', $timezone);
            }
        } catch (\Exception $e) {
            // If settings table doesn't exist yet (during migration), use default
        }
    }
}
