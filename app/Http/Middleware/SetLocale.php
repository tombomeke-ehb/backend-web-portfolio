<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request and set the application locale.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Determine language from multiple sources (in order of priority)
        $lang = $this->getPreferredLanguage($request);

        // Set application locale
        app()->setLocale($lang);

        return $next($request);
    }

    /**
     * Get the preferred language from request, cookie, or user preference.
     */
    private function getPreferredLanguage(Request $request): string
    {
        // 1. Check query parameter (?lang=en) - always has highest priority for debugging
        $queryLang = $request->query('lang');
        if (in_array($queryLang, ['nl', 'en'], true)) {
            return $queryLang;
        }

        // 2. For authenticated users, check their saved preference (from settings/language toggle)
        //    This now has priority because the language toggle updates the DB preference
        if ($request->user()?->preferred_language) {
            $userLang = $request->user()->preferred_language;
            if (in_array($userLang, ['nl', 'en'], true)) {
                return $userLang;
            }
        }

        // 3. Check cookie set by JavaScript language toggle (portfolio_lang)
        //    Used as fallback for guests or when DB is not synced
        $cookieLang = $request->cookie('portfolio_lang');
        if (in_array($cookieLang, ['nl', 'en'], true)) {
            return $cookieLang;
        }

        // 4. Fallback to default (Dutch)
        return 'nl';
    }
}
