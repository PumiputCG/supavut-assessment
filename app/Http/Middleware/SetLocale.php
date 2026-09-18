<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ดึง locale จาก session ถ้าไม่มีใช้ 'th'
        $locale = session('locale', 'th');

        if (! in_array($locale, ['th', 'en', 'my'], true)) {
            $locale = 'th';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
