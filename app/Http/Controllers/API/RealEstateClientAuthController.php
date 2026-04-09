<?php
// app/Http/Controllers/API/RealEstateClientAuthController.php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RealEstateClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\UserRequest;
use App\Models\User; // 👈 أضيفي هذا السطر

class RealEstateClientAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:real_estate_clients',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string',
        ]);

        $client = RealEstateClient::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'status' => 'active',
        ]);

        $token = $client->createToken('auth_token')->plainTextToken;

        return response()->json([
            'client' => [
                'id' => $client->id,
                'full_name' => $client->full_name,
                'email' => $client->email,
                'phone' => $client->phone,
            ],
            'token' => $token,
            'message' => 'تم إنشاء الحساب بنجاح'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $client = RealEstateClient::where('email', $request->email)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            throw ValidationException::withMessages([
                'email' => ['البيانات المدخلة غير صحيحة.'],
            ]);
        }

        if ($client->status !== 'active') {
            return response()->json([
                'message' => 'هذا الحساب غير نشط. يرجى التواصل مع الإدارة.'
            ], 403);
        }

        $token = $client->createToken('auth_token')->plainTextToken;

        return response()->json([
            'client' => [
                'id' => $client->id,
                'full_name' => $client->full_name,
                'email' => $client->email,
                'phone' => $client->phone,
            ],
            'token' => $token,
            'message' => 'تم تسجيل الدخول بنجاح'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }

    public function user(Request $request)
    {
        return response()->json([
            'id' => $request->user()->id,
            'full_name' => $request->user()->full_name,
            'email' => $request->user()->email,
            'phone' => $request->user()->phone,
        ]);
    }

   public function getNewUsers(Request $request)
{
    $filter = $request->get('filter', 'week');
    
    // إذا filter = 'all' أو مفيش تصفية، رجع الكل
    if ($filter === 'all') {
        $users = RealEstateClient::orderBy('id', 'desc')->get();
    } else {
        $query = RealEstateClient::query();
        
        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today())
                      ->orWhereNull('created_at'); // ✅ يشمل اللي created_at = null
                break;
            case 'week':
                $query->where(function($q) {
                    $q->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->orWhereNull('created_at'); // ✅ يشمل القديمين
                });
                break;
           case 'month':
    $query->where('created_at', '>=', Carbon::now()->subDays(60)); // ← 60 يوم
    break;
        }
        
        $users = $query->orderBy('id', 'desc')->get();
    }

    $usersWithCounts = $users->map(function($user) {
        $userData = $user->toArray();
        $userData['requests_count'] = $user->requests()->count();
        return $userData;
    });
    
   return response()->json([
    'success' => true,
    'data' => $usersWithCounts
]);
}

    public function getStats()
    {
        $stats = [
            'today' => RealEstateClient::whereDate('created_at', Carbon::today())->count(),
            'week' => RealEstateClient::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'month' => RealEstateClient::whereMonth('created_at', Carbon::now()->month)
                                      ->whereYear('created_at', Carbon::now()->year)
                                      ->count(),
            'total' => RealEstateClient::count(),
        ];
        
        return response()->json($stats);
    }

    public function getUserRequests($userId)
    {
        $user = RealEstateClient::find($userId);
        
        if (!$user) {
            return response()->json(['message' => 'المستخدم غير موجود'], 404);
        }
        
        $requests = UserRequest::where('user_id', $userId)
                              ->orderBy('created_at', 'desc')
                              ->get();
        
        return response()->json($requests);
    }
       /* ✅ دالة جديدة: تسجيل دخول الأدمن (تستخدم جدول users)
     */
 


    /**
     * ✅ دالة جديدة: تسجيل دخول الأدمن (تستخدم جدول users)
     */
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 👈 نستخدم جدول users (الخاص بالأدمن)
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'البريد الإلكتروني أو كلمة السر غير صحيحة'
            ], 401);
        }

        // ✅ نتحقق أنه أدمن
        if (!$user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'هذا الحساب ليس لديه صلاحيات الأدمن'
            ], 403);
        }

        // إنشاء توكن
        $token = $user->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
            ]
        ]);
    }

public function getAllUsers()
{
    $users = RealEstateClient::orderBy('id', 'desc')->get();
    return response()->json(['success' => true, 'data' => $users]);
}
}