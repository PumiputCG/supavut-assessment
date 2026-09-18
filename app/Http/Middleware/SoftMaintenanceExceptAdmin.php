<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoftMaintenanceExceptAdmin
{
    private function isEnabled(): bool
    {
        $v = config('soft_maintenance.enabled', 0);

        if (is_bool($v)) return $v;
        if (is_int($v)) return $v === 1;

        $s = strtolower(trim((string) $v));
        return in_array($s, ['1', 'true', 'yes', 'on'], true);
    }

    private function retryAfter(): int
    {
        $n = (int) config('soft_maintenance.retry_after', 60);
        return $n > 0 ? $n : 60;
    }

    private function isAdminUser($user): bool
    {
        if (!$user) return false;
        $role = strtolower((string) ($user->role ?? ''));
        return $role === 'admin';
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$this->isEnabled()) {
            return $next($request);
        }

        $route = $request->route();
        $name  = $route ? (string) $route->getName() : '';
        $path  = $request->path();

        // ยังให้สลับภาษาได้บนหน้า maintenance
        if ($name === 'locale.switch') {
            return $next($request);
        }

        // ยังให้ทุกคนเข้าหน้า login ได้ (เพื่อให้ admin เข้าได้แน่นอน)
        // แต่ user ล็อกอินแล้วจะโดนบล็อกทุกหน้าถัดไป
        if (in_array($name, ['login', 'login.submit', 'login.employee.preview'], true)) {
            return $next($request);
        }

        // ให้กดออกจากระบบได้
        if ($name === 'logout') {
            return $next($request);
        }

        // health check
        if ($path === 'up') {
            return $next($request);
        }

        $user = Auth::user();
        if ($this->isAdminUser($user)) {
            return $next($request);
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'ok' => false,
                'message' => app()->getLocale() === 'en'
                    ? 'Closed for maintenance.'
                    : 'ปิดปรับปรุงระบบชั่วคราว',
            ], 503);
        }

        return response()
            ->view('maintenance', [], 503)
            ->header('Retry-After', (string) $this->retryAfter());
    }
}
