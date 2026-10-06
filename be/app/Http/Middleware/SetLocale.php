<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bahasa tampilan mobile (ID/EN) dari session `locale`.
 * Default Inggris. Juga mengatur locale Carbon agar tanggal ikut.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', 'en');
        if (! in_array($locale, ['id', 'en'], true)) {
            $locale = 'en';
        }

        app()->setLocale($locale);
        \Carbon\Carbon::setLocale($locale === 'id' ? 'id' : 'en');

        return $next($request);
    }
}
