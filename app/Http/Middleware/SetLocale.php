<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->session()->get('locale', 'en');
        app()->setLocale($locale === 'ar' ? 'ar' : 'en');

        return $next($request);
    }
}
