<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRequest;
use App\Models\NegativeCertificate;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * =========================
         * 1️⃣ إحصائيات الطلبات
         * =========================
         */
        $newRequests        = NegativeCertificate::where('status', 'pending')->count();
        $processingRequests = NegativeCertificate::where('status', 'processing')->count();
        $approvedRequests   = NegativeCertificate::where('status', 'approved')->count();

        $totalRequests = $newRequests + $processingRequests + $approvedRequests;

        $newPercent        = $totalRequests ? round(($newRequests / $totalRequests) * 100) : 0;
        $processingPercent = $totalRequests ? round(($processingRequests / $totalRequests) * 100) : 0;
        $approvedPercent   = $totalRequests ? round(($approvedRequests / $totalRequests) * 100) : 0;

        /**
         * =========================
         * 2️⃣ عدد المستخدمين
         * =========================
         */
        $usersCount = User::count();

        /**
         * =========================
         * 3️⃣ آخر 5 طلبات للعرض السريع
         * =========================
         */
        $latestRequests = NegativeCertificate::latest()->take(5)->get();

        /**
         * =========================
         * 4️⃣ آخر النشاطات (مثال فارغ حاليًا)
         * =========================
         */
        $activities = collect(); // لو عندك جدول Activities استخدميه هنا

        /**
         * =========================
         * 5️⃣ الرسائل غير المقروءة (مثال)
         * =========================
         */
        $unreadMessages = 0;

        return view('admin.dashboard', compact(
            'newRequests',
            'processingRequests',
            'approvedRequests',
            'usersCount',
            'latestRequests',
            'newPercent',
            'processingPercent',
            'approvedPercent',
            'unreadMessages',
            'activities'
        ));


     
}




    
}