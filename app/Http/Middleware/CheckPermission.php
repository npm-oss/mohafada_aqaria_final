<?php
// app/Http/Middleware/CheckPermission.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = Auth::guard('web')->user();

        if (!$user || !$user->is_admin) {
            return redirect('/')->with('error', 'غير مصرح');
        }

        if ($user->hasPermission($permission)) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')
            ->with('error', '⛔ ليس لديك صلاحية للوصول لهذه الصفحة');
    }
}