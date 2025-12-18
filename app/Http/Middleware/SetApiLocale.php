<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SetApiLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language', config('app.locale'));

        if (in_array($locale, array_keys(LaravelLocalization::getSupportedLocales()))) {
            app()->setLocale($locale);
        }

        return $next($request);
    }


}
