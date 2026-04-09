<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // إحصائيات عامة
        $newRequests = DB::table('land_registers')->where('status', 'pending')->count();
        $processingRequests = DB::table('land_registers')->where('status', 'processing')->count();
        $approvedRequests = DB::table('land_registers')->where('status', 'approved')->count();
        $usersCount = DB::table('users')->count();

        // آخر الطلبات
        $latestRequests = DB::table('land_registers')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                $item->type = 'دفتر عقاري';
                $item->user_id = $item->last_name . ' ' . $item->first_name;
                return $item;
            });

        return view('admin.dashboard', compact(
            'newRequests',
            'processingRequests',
            'approvedRequests',
            'usersCount',
            'latestRequests'
        ));
    }
}