<?php
use Illuminate\Http\Request; // 👈 أضيفي هذا السطر في البداية
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RealEstateClientAuthController;
use App\Http\Controllers\NegativeCertificateController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\Admin\DocumentsAdminController;
use App\Http\Controllers\ContractExtractController;
use App\Http\Controllers\LandRegisterController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;

// Test route
Route::get('/test', function() {
    return response()->json([
        'message' => 'API is working!',
        'status' => 'success',
        'time' => now()->toDateTimeString()
    ]);
});

// ✅ Routes عامة (بدون مصادقة)
Route::post('/register', [RealEstateClientAuthController::class, 'register']);
Route::post('/login', [RealEstateClientAuthController::class, 'login']);

// ✅ Route خاصة بتسجيل دخول الأدمن (عامة - بدون مصادقة)
// ✅ Route خاصة بتسجيل دخول الأدمن (خارج أي middleware)
Route::post('/admin/login', [RealEstateClientAuthController::class, 'adminLogin']);

// Protected routes (محمية بالمصادقة - تحتاج توكن)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RealEstateClientAuthController::class, 'logout']);
    Route::get('/user', [RealEstateClientAuthController::class, 'user']);
    
    // ✅ Routes للأدمن فقط (بالميدلوير 'admin')
    Route::middleware('admin')->group(function () {
        Route::get('/users/new', [RealEstateClientAuthController::class, 'getNewUsers']);
        Route::get('/users/stats', [RealEstateClientAuthController::class, 'getStats']);
        Route::get('/users/{userId}/requests', [RealEstateClientAuthController::class, 'getUserRequests']);
        Route::get('/users/all', [RealEstateClientAuthController::class, 'getAllUsers']);
    });
    
    // ✅ شهادة سلبية
    Route::post('/negative-certificate', [NegativeCertificateController::class, 'apiStore']);
    Route::get('/negative-certificates', [NegativeCertificateController::class, 'apiIndex']);
    Route::get('/negative-certificate/{id}', [NegativeCertificateController::class, 'apiShow']);
    
    // ✅ بطاقات عقارية
    Route::post('/documents-request', [DocumentsAdminController::class, 'apiStore']);
    Route::get('/documents-requests', [DocumentsAdminController::class, 'apiIndex']);
    Route::get('/documents-request/{id}', [DocumentsAdminController::class, 'apiShow']);
    
    // ✅ مستخرجات العقود
    Route::post('/contract-extract', [ContractExtractController::class, 'apiStore']);
    Route::get('/contract-extracts', [ContractExtractController::class, 'apiIndex']);
    Route::get('/contract-extract/{id}', [ContractExtractController::class, 'apiShow']);
    
    // ✅ الدفتر العقاري
    Route::post('/property-book', [LandRegisterController::class, 'apiStore']);
    Route::post('/property-book-copy', [LandRegisterController::class, 'apiStoreCopy']);
    Route::post('/property-book-with-files', [LandRegisterController::class, 'apiStoreWithFiles']);
    Route::get('/property-books', [LandRegisterController::class, 'apiIndex']);
    Route::get('/property-book/{id}', [LandRegisterController::class, 'apiShow']);
    
    // ✅ المواعيد
    Route::post('/appointment', [AppointmentController::class, 'store']);
    
    // ✅ اتصل بنا
    Route::post('/contact', [ContactController::class, 'apiStore']);
    Route::get('/contacts', [ContactController::class, 'apiIndex']);
    Route::get('/contact/{id}', [ContactController::class, 'apiShow']);
    Route::put('/contact/{id}/status', [ContactController::class, 'apiUpdateStatus']);
    Route::delete('/contact/{id}', [ContactController::class, 'apiDestroy']);
    Route::post('/contact/search', [ContactController::class, 'apiSearch']);
    Route::get('/contact-statistics', [ContactController::class, 'apiStatistics']);
});
// routes/api.php - أضيفي هذا في نهاية الملف

// Route للاختبار المباشر (بدون أي تعقيدات)
Route::get('/admin-test', function(Request $request) {
    $email = $request->query('email', 'admin2@gmail.com');
    $password = $request->query('password', 'admin123');
    
    // نجيب المستخدم من قاعدة البيانات
    $user = \App\Models\User::where('email', $email)->first();
    
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'المستخدم غير موجود',
            'email' => $email
        ]);
    }
    
    // نتحقق من كلمة السر
    if (!\Hash::check($password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'كلمة السر غير صحيحة',
            'password_hash' => $user->password
        ]);
    }
    
    // نتحقق من is_admin
    if (!$user->is_admin) {
        return response()->json([
            'success' => false,
            'message' => 'المستخدم ليس أدمن',
            'is_admin' => $user->is_admin
        ]);
    }
    
    return response()->json([
        'success' => true,
        'message' => 'تم التحقق بنجاح',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->is_admin,
        ]
    ]);
});