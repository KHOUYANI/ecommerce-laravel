<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['ar', 'en', 'fr'];

        if (Session::has('locale') && in_array(Session::get('locale'), $supportedLocales)) {
            $locale = Session::get('locale');
        } else {
            // Auto-detect mn browser
            $browserLang = substr($request->server('HTTP_ACCEPT_LANGUAGE', 'ar'), 0, 2);
            $locale = in_array($browserLang, $supportedLocales) ? $browserLang : 'ar';
            Session::put('locale', $locale);
        }

        App::setLocale($locale);

        return $next($request);
    }
}