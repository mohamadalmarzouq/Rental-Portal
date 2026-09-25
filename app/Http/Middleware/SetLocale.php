<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->session()->get('locale', $request->cookie('locale', 'en'));
        $locale = $locale === 'ar' ? 'ar' : 'en';
        $request->session()->put('locale', $locale);
        app()->setLocale($locale);

        return $next($request);
    }
}
