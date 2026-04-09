<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\WebsiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255',
                          'unique:website_users'],  // ← جدول website_users
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ✅ يحفظ في website_users مش users
        $user = WebsiteUser::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ يسجل دخول بـ guard website مش web
        Auth::guard('website')->login($user);

        // ✅ يروح لصفحة المستخدم مش لوحة الأدمن
        return redirect()->route('website.home');
    }
}