<?php
// app/Http/Controllers/Auth/WebsiteRegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\WebsiteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WebsiteRegisterController extends Controller
{
    // عرض صفحة التسجيل
    public function showForm()
    {
        return view('auth.website_register');
    }

    // معالجة التسجيل
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:website_users,email',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);

        $user = WebsiteUser::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'status'   => 1,
        ]);

        // تسجيل دخول تلقائي بعد الإنشاء
        Auth::guard('website')->login($user);

        return redirect()->route('website.dashboard');
    }
}
