<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Available languages
     */
    protected $availableLocales = ['en', 'id'];

    /**
     * Switch application language
     *
     * @param Request $request
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(Request $request, string $locale)
    {
        // Validate locale
        if (!in_array($locale, $this->availableLocales)) {
            $locale = config('app.locale', 'id');
        }

        // Store in session
        Session::put('locale', $locale);
        
        // Set application locale
        App::setLocale($locale);

        return redirect()->back();
    }

    /**
     * Get current locale
     *
     * @return string
     */
    public static function getCurrentLocale(): string
    {
        return Session::get('locale', config('app.locale', 'id'));
    }

    /**
     * Get available locales with labels
     *
     * @return array
     */
    public static function getAvailableLocales(): array
    {
        return [
            'id' => [
                'name' => 'Indonesia',
                'flag' => '🇮🇩',
                'native' => 'Bahasa Indonesia',
            ],
            'en' => [
                'name' => 'English',
                'flag' => '🇬🇧',
                'native' => 'English',
            ],
        ];
    }
}
