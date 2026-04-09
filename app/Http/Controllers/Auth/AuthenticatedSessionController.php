<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\WebsiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // 1️⃣ هل هو أدمن؟
    if (Auth::guard('web')->attempt([
        'email'    => $request->email,
        'password' => $request->password,
    ])) {
        $user = Auth::guard('web')->user();

        if ($user->is_admin == 1) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // ← لوحة الأدمن
        }

        Auth::guard('web')->logout();
        return back()->withErrors([
            'email' => 'ليس لديك صلاحية الدخول'
        ]);
    }

    // 2️⃣ هل هو مستخدم عادي؟
    $websiteUser = \App\Models\WebsiteUser::where('email', $request->email)->first();

    if ($websiteUser && \Illuminate\Support\Facades\Hash::check($request->password, $websiteUser->password)) {
        Auth::guard('website')->login($websiteUser);
        $request->session()->regenerate();
        return redirect()->route('website.home'); // ← صفحة المستخدم
    }

    // 3️⃣ بيانات غلط
    return back()->withErrors([
        'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'
    ])->withInput();
}

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('website')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}