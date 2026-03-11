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

        // Share active semester with all views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $semesterId = session('active_semester_id');
                if ($semesterId) {
                    $activeSemester = \App\Models\AcademicYear::find($semesterId);
                }
                if (empty($activeSemester)) {
                    $activeSemester = \App\Models\AcademicYear::where('is_active', true)->first();
                    if ($activeSemester) {
                        session(['active_semester_id' => $activeSemester->id]);
                    }
                }
                $allSemesters = \App\Models\AcademicYear::orderByDesc('year')->orderByDesc('semester')->get();
                $view->with('activeSemester', $activeSemester);
                $view->with('allSemesters', $allSemesters);
            } catch (\Exception $e) {
                // Table may not exist yet
            }
        });
    }
}
