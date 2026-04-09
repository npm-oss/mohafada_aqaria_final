<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // إذا أدمن مسجل دخول → لوحة الأدمن
        if (Auth::guard('web')->check()) {
            if (Auth::guard('web')->user()->is_admin == 1) {
                return redirect()->route('admin.dashboard');
            }
        }

        // إذا مستخدم عادي مسجل دخول → صفحته
        if (Auth::guard('website')->check()) {
            return redirect()->route('website.home');
        }

        return $next($request);
    }
}