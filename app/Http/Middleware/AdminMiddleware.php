<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // إذا كان الطلب API (Flutter)
        if ($request->is('api/*')) {

            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تسجيل الدخول أولاً'
                ], 401);
            }

            if (!Auth::user()->is_admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذه العملية خاصة بالأدمن فقط'
                ], 403);
            }

        } else {
            // إذا كان الطلب Web (لوحة التحكم)

            if (!Auth::guard('web')->check() || !Auth::guard('web')->user()->is_admin) {
                return redirect('/admin/login');
            }

        }

        return $next($request);
    }
}