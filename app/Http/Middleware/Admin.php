<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        // مسجل دخول كأدمن وعنده is_admin = 1
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->is_admin == 1) {
            return $next($request);
        }

        // مستخدم عادي حاول يدخل لوحة الأدمن
        return redirect('/')->with('error', 'غير مصرح لك بالدخول');
    }
}