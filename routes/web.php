<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NegativeCertificateController; 
use App\Http\Controllers\Admin\NegativeCertificateAdminController;
use App\Http\Controllers\Admin\documentsAdminController;
use App\Http\Controllers\RequestController;

use App\Http\Controllers\DocumentSearchController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\ContractExtractController;

use App\Http\Controllers\LandRegisterController;
use App\Http\Controllers\Admin\AdminLandRegisterController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\PropertyOwnerController;
use App\Http\Controllers\Admin\LandPropertyController;
use App\Http\Controllers\Admin\NegativeCertificateSearchController;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminManagerController;


/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/
Route::view('/', 'home')->name('home');

/*
|--------------------------------------------------------------------------
| صفحات عامة
|--------------------------------------------------------------------------
*/
Route::view('/appointment', 'appointment')->name('appointment');
Route::view('/extract-documents', 'extract-documents')->name('extract.documents');
Route::view('/extract-topographic', 'extract-topographic')->name('extract.topographic');

/*
|--------------------------------------------------------------------------
| شهادة سلبية (Front)
|--------------------------------------------------------------------------
*/
Route::prefix('negative-certificate')->group(function () {

    // القائمة
    Route::get('/', function () {
        return view('negative.index');
    })->name('negative.index');

    // طلب جديد
    Route::get('/new', [NegativeCertificateController::class, 'new'])
        ->name('negative.new');

    // حفظ الطلب
    Route::post('/store', [NegativeCertificateController::class, 'store'])
        ->name('negative.store');

    // إعادة استخراج
    Route::get('/reprint', [NegativeCertificateController::class, 'reprint'])
        ->name('negative.reprint');
});

/*
|--------------------------------------------------------------------------
| اتصل بنا
|--------------------------------------------------------------------------
*/
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| Dashboard المستخدم (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| لوحة تحكم الأدمن
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);

        Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
        Route::get('/certificates', [AdminController::class, 'certificates'])->name('certificates');

        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');

        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');

        Route::get('/items', [AdminController::class, 'items'])->name('items');

        Route::get('/change-password', [AdminController::class, 'changePasswordForm'])
            ->name('change-password.form');
        Route::post('/change-password', [AdminController::class, 'changePassword'])
            ->name('change-password');

        Route::get('/negative-requests', [AdminController::class, 'negativeRequests'])
            ->name('negative.requests');
        Route::get('/document-requests', [AdminController::class, 'documentRequests'])
            ->name('document.requests');
        Route::get('/payment-requests', [AdminController::class, 'paymentRequests'])
            ->name('payment.requests');
        Route::get('/topographic-requests', [AdminController::class, 'topographicRequests'])
            ->name('topographic.requests');

            

    });

require __DIR__.'/auth.php';






Route::get('/negative-certificate', function () {
    return view('negative.index');
})->name('negative.certificate');




Route::get('/negative-certificate/new', function () {
    return view('negative.new');
})->name('negative.new');





// ✅ روت الوثائق (حطيه في آخر الملف أو مع راوتات الأدمن)
Route::get('/document/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    
    if (!file_exists($fullPath)) {
        abort(404, 'الملف غير موجود');
    }
    
    return response()->file($fullPath);
})->where('path', '.*')->name('document.view');

// routes/web.php أو routes/admin.php
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    // الروت الحالي
    Route::get('land-registers/{register}/process', [LandRegisterController::class, 'process'])
         ->name('land.registers.process');
    
    // أضف هذا الروت الجديد
    Route::get('land-registers/{register}/manual-process', [LandRegisterController::class, 'manualProcess'])
         ->name('land.registers.manual-process');
});








/* الصفحة الرئيسية */
Route::get('/', fn () => view('home'))->name('home');

/* شهادة سلبية */
Route::get('/negative/new', fn () => view('negative.new'))->name('negative.new');
Route::get('/negative/reprint', fn () => view('negative.reprint'))->name('negative.reprint');

/* البطاقات */
Route::get('/cards/personal', fn () => view('cards.personal'))->name('cards.personal');
Route::get('/cards/alpha', fn () => view('cards.alpha'))->name('cards.alpha');
Route::get('/cards/rural_card', fn () => view('cards.rural_card'))->name('cards.rural_card');


/* صفحات عامة */
Route::get('/contact', fn () => view('contact'))->name('contact');
Route::get('/login', fn () => view('auth.login'))->name('login');




Route::middleware(['admin', 'admin'])->group(function() {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});


Route::get('/cards/personal', fn () => view('cards.personal'))->name('cards.personal');
Route::get('/cards/alphabetical', fn () => view('cards.alphabetical'))->name('cards.alphabetical');
Route::get('/cards/rural', fn () => view('cards.rural'))->name('cards.rural');

Route::get('/extract-documents', function () {
    return view('extract-documents');
})->name('extract.documents');




// في web.php
Route::post('/negative-certificate/reprint/search', 
    [NegativeCertificateController::class, 'reprintSearch']
)->name('negative.reprint.search');








/*
|--------------------------------------------------------------------------
| مستخرجات العقود - Contract Extracts Routes
|--------------------------------------------------------------------------
*/

Route::prefix('contracts')->name('contracts.')->group(function () {
    
    // صفحة مستخرجات العقود
    Route::get('/extracts', function () {
        return view('contracts.extracts');
    })->name('extracts');
    
    // حفظ طلب مستخرج
    Route::post('/extract/store', [ContractExtractController::class, 'store'])
        ->name('extract.store');
    
    // عرض طلب معين
    Route::get('/extract/{id}', [ContractExtractController::class, 'show'])
        ->name('extract.show');
    
    // تحميل المستخرج
    Route::get('/extract/{id}/download', [ContractExtractController::class, 'download'])
        ->name('extract.download');
});



//مستخرجات العقود جهة الادمن
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('document_searches', DocumentSearchController::class);
});





/*
|--------------------------------------------------------------------------
| البطاقات العقارية
|--------------------------------------------------------------------------
*/

Route::get('/cards/natural', function () {
    return view('cards.natural');
})->name('card.natural');

Route::get('/cards/moral', function () {
    return view('cards.moral');
})->name('card.moral');

Route::get('/cards/rural_card', function () {
    return view('cards.rural_card');
})->name('card.rural_card');

Route::get('/cards/urban_private', function () {
    return view('cards.urban_private');
})->name('card.urban_private');

Route::post('/documents/store', [DocumentsAdminController::class, 'store'])
    ->name('admin.documents.store');
    Route::get('/admin/documents/{id}', [DocumentRequestController::class, 'show'])
    ->name('admin.documents.show');

Route::delete('/admin/documents/{id}', 
    [App\Http\Controllers\Admin\DocumentController::class, 'destroy']
)->name('admin.documents.destroy');

Route::prefix('admin')->group(function() {

    // فتح صفحة المعالجة
    Route::get('documents/{id}/process', [RequestController::class, 'process'])
         ->name('admin.documents.process'); // ← اسم route صحيح

    // البحث عبر AJAX
    Route::post('search-card', [RequestController::class, 'searchCard'])
         ->name('search.card');
});

/*
|--------------------------------------------------------------------------
| مستخرجات العقود
|--------------------------------------------------------------------------
*/

Route::get('/contracts/extracts', function () {
    return view('contracts.extracts');
});
Route::get('/contracts/extracts', function () {
    return view('contracts.extracts');
});


Route::get('/dashboard/extracts', [ContractExtractController::class, 'index'])
    ->name('admin.extracts.index');


        // تغيير حالة المستخرج (قبول / رفض)
        Route::post('/dashboard/extracts/{extract}/status', [ContractExtractController::class, 'updateStatus'])
            ->name('extracts.updateStatus');

        // تحميل PDF للمستخرج
        Route::get('/dashboard/extracts/{extract}/pdf', [ContractExtractController::class, 'pdf'])
            ->name('extracts.pdf');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/extracts', [ContractExtractController::class, 'index'])->name('extracts.index');
    Route::post('/extracts/{extract}/status', [ContractExtractController::class, 'updateStatus'])->name('extracts.updateStatus');
    Route::get('/extracts/{extract}/pdf', [ContractExtractController::class, 'pdf'])->name('extracts.pdf');
});






/*
|--------------------------------------------------------------------------
| الوثائق المسحية
|--------------------------------------------------------------------------
*/
Route::prefix('topographic')->group(function () {

    Route::get('/scanned', function () {
        return view('topographic.scanned');
    })->name('topographic.scanned');

    Route::get('/unscanned', function () {
        return view('topographic.unscanned');
    })->name('topographic.unscanned');

    Route::get('/rural', function () {
        return view('topographic.rural');
    })->name('topographic.rural');

});



Route::get('/extract/unscanned', function () {
    return view('topographic.unscanned');
})->name('extract.unscanned');


Route::get('/extract/topographic/rural', function () {
    return view('topographic.rural');
})->name('extract.rural');






/*
|--------------------------------------------------------------------------
| Public Routes (المواطن)
|--------------------------------------------------------------------------
*/

Route::prefix('negative-certificate')->group(function () {
    Route::get('/new', [NegativeCertificateController::class, 'new'])
        ->name('negative.new');

    Route::post('/store', [NegativeCertificateController::class, 'store'])
        ->name('negative.store');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (الأدمن فقط – بدون فورم إنشاء)
|--------------------------------------------------------------------------
*/
//الشهادة السلبسة
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['admin', 'admin'])
    ->group(function () {



// ✅ الجديد
Route::get('/certificates/{id}/extract', [NegativeCertificateAdminController::class, 'showExtractForm'])
    ->name('certificates.extract');  // ⭐ غيّرنا الاسم

Route::post('/certificates/{id}/extract', [NegativeCertificateAdminController::class, 'saveExtractedData'])
    ->name('certificates.extract.save');







        // قائمة الطلبات
        Route::get('/certificates',
            [NegativeCertificateAdminController::class, 'index']
        )->name('certificates.index');

        // عرض طلب واحد
        Route::get('/certificates/{id}',
            [NegativeCertificateAdminController::class, 'show']
        )->name('certificates.show');

        // تغيير الحالة
        Route::post('/certificates/{id}/approve',
            [NegativeCertificateAdminController::class, 'approve']
        )->name('certificates.approve');

        Route::post('/certificates/{id}/reject',
            [NegativeCertificateAdminController::class, 'reject']
        )->name('certificates.reject');

       

        // صفحة المعالجة
Route::get('/certificates/{id}/process',
    [NegativeCertificateAdminController::class, 'process']
)->name('certificates.process');

Route::post('/certificates/{id}/update-fields', 
    [NegativeCertificateAdminController::class, 'updateFields']
)->name('certificates.updateFields');







});




Route::prefix('admin')->middleware(['admin','admin'])->name('admin.')->group(function () {

    Route::get('/documents', [documentsAdminController::class,'index'])
        ->name('documents.index');

    Route::get('/documents/{id}', [documentsAdminController::class,'show'])
        ->name('documents.show');

    Route::post('/documents/store', [documentsAdminController::class,'store'])
        ->name('documents.store');

    Route::post('/documents/{id}/approve', [documentsAdminController::class,'approve'])
        ->name('documents.approve');

    Route::post('/documents/{id}/reject', [documentsAdminController::class,'reject'])
        ->name('documents.reject');

    Route::post('/documents/{id}/extract', [documentsAdminController::class,'extract'])
        ->name('documents.extract');


      
});


// صفحة البطاقة الشخصية


// Route لحفظ الطلبات عبر documentsAdminController
Route::post('/documents/store', [documentsAdminController::class, 'store'])->name('admin.documents.store');




























// إذا لم يكن لديك Controller لطلبات المستخدمين
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/requests/create', [UserRequestController::class, 'create'])->name('requests.create');
    Route::get('/requests', [UserRequestController::class, 'index'])->name('requests.index');
    Route::post('/requests', [UserRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{id}/edit', [UserRequestController::class, 'edit'])->name('requests.edit');
    Route::put('/requests/{id}', [UserRequestController::class, 'update'])->name('requests.update');
    Route::get('/requests/{id}', [UserRequestController::class, 'show'])->name('requests.show');
});












Route::prefix('admin')->name('admin.')->group(function() {
    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
});


























 Route::get('/contact', [ContactController::class, 'index'])->name('contact');
   Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');






















;

// Routes كاملة لإدارة الرسائل في Dashboard
Route::prefix('admin')->middleware(['admin', 'admin'])->name('admin.')->group(function () {
    
    Route::prefix('messages')->name('messages.')->group(function () {
        
        // الصفحة الرئيسية
        Route::get('/', [MessageController::class, 'index'])->name('index');
        
        // عرض رسالة واحدة
        Route::get('/{id}', [MessageController::class, 'show'])->name('show');
        
        // حذف رسالة
        Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy');
        
        // الرد على الرسائل
        Route::get('/{id}/reply', [MessageController::class, 'replyForm'])->name('reply');
        Route::post('/{id}/reply', [MessageController::class, 'sendReply'])->name('reply.send');
        
        // تغيير الحالة
        Route::post('/{id}/mark-read', [MessageController::class, 'markAsRead'])->name('mark-read');
        Route::post('/{id}/mark-unread', [MessageController::class, 'markAsUnread'])->name('mark-unread');
        Route::post('/{id}/close', [MessageController::class, 'close'])->name('close');
        Route::post('/{id}/reopen', [MessageController::class, 'reopen'])->name('reopen');
        
        // عمليات جماعية
        Route::post('/bulk/delete', [MessageController::class, 'bulkDelete'])->name('bulk.delete');
        Route::post('/bulk/mark-read', [MessageController::class, 'bulkMarkAsRead'])->name('bulk.mark-read');
        
        // البحث والفلترة
        Route::get('/search/results', [MessageController::class, 'search'])->name('search');
        Route::get('/filter/status/{status}', [MessageController::class, 'filterByStatus'])->name('filter.status');
        Route::get('/filter/subject/{subject}', [MessageController::class, 'filterBySubject'])->name('filter.subject');
        
        // صفحات خاصة
        Route::get('/list/new', [MessageController::class, 'newMessages'])->name('new');
        Route::get('/list/read', [MessageController::class, 'readMessages'])->name('read');
        Route::get('/list/replied', [MessageController::class, 'repliedMessages'])->name('replied');
        
        // إحصائيات وتصدير
        Route::get('/stats/overview', [MessageController::class, 'statistics'])->name('statistics');
        Route::get('/export/excel', [MessageController::class, 'export'])->name('export');
        
        // طباعة
        Route::get('/{id}/print', [MessageController::class, 'print'])->name('print');
        
    });
    
});
























// ══════════════════════════════════════════════════════════════
// في ملف routes/web.php
// ══════════════════════════════════════════════════════════════



// ──────────────────────────────────────────────────────────────
// 📋 User Routes (للمستخدمين العاديين)
// ──────────────────────────────────────────────────────────────

Route::middleware(['admin'])->group(function () {
    
    // صفحة تقديم الطلب
    Route::get('/extracts/create', [ContractExtractController::class, 'create'])->name('extracts.create');
    
    // حفظ الطلب
    Route::post('/extracts', [ContractExtractController::class, 'store'])->name('extracts.store');
    
    // عرض تفاصيل الطلب (للمستخدم)
    Route::get('/my-extracts/{id}', [ContractExtractController::class, 'userShow'])->name('extracts.user.show');
    
});


// ──────────────────────────────────────────────────────────────
// 👨‍💼 Admin Routes (للإدارة) - نفس الـ Controller
// ──────────────────────────────────────────────────────────────

Route::prefix('admin/extracts')->middleware(['admin', 'admin'])->name('admin.extracts.')->group(function () {
    
    // القائمة (مع البحث والتصفية)
    Route::get('/', [ContractExtractController::class, 'index'])->name('index');
    
    // عرض التفاصيل (للأدمن)
    Route::get('/{id}', [ContractExtractController::class, 'show'])->name('show');
    
    // تحديث الحالة
    Route::post('/{id}/update-status', [ContractExtractController::class, 'updateStatus'])->name('updateStatus');
    
    // الموافقة
    Route::post('/{id}/approve', [ContractExtractController::class, 'approve'])->name('approve');
    
    // الرفض
    Route::post('/{id}/reject', [ContractExtractController::class, 'reject'])->name('reject');
    
    // الحذف
    Route::delete('/{id}', [ContractExtractController::class, 'destroy'])->name('destroy');
    
});


// ──────────────────────────────────────────────────────────────
// 📄 PDF Route (للجميع)
// ──────────────────────────────────────────────────────────────

Route::middleware(['admin'])->group(function () {
    
    // تحميل PDF
    Route::get('/extracts/{id}/pdf', [ContractExtractController::class, 'pdf'])->name('extracts.pdf');
    
});


// ══════════════════════════════════════════════════════════════
// ✅ ملاحظات:
// ══════════════════════════════════════════════════════════════
// 
// 1. كل الـ Methods في نفس الـ Controller
// 2. /admin/extracts → للإدارة
// 3. /extracts/create → للمستخدمين
// 4. /my-extracts/{id} → عرض للمستخدم
// 5. /admin/extracts/{id} → عرض للأدمن
// 
// ══════════════════════════════════════════════════════════════
















// الدفتر العقاري
Route::get('/land-register/create', [LandRegisterController::class, 'create'])->name('land.register.create');
Route::post('/land-register/store', [LandRegisterController::class, 'store'])->name('land.register.store');
Route::get('/land-register/copy', [LandRegisterController::class, 'copyRequest'])->name('land.register.copy');
Route::post('/land-register/copy/store', [LandRegisterController::class, 'storeCopy'])->name('land.register.copy.store');
















// الدفتر العقاري
Route::get('/land-register/create', [LandRegisterController::class, 'create'])->name('land.register.create');
Route::post('/land-register/store', [LandRegisterController::class, 'store'])->name('land.register.store');
Route::get('/land-register/copy', [LandRegisterController::class, 'copyRequest'])->name('land.register.copy');
Route::post('/land-register/copy/store', [LandRegisterController::class, 'storeCopy'])->name('land.register.copy.store');




// في قسم routes الخاص بالأدمن
Route::middleware(['admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... باقي الـ routes
    
    // تفاصيل طلب الدفتر العقاري
    Route::get('/land-registers', [AdminLandRegisterController::class, 'index'])->name('land.registers.index');
    Route::get('/land-registers/{id}', [AdminLandRegisterController::class, 'show'])->name('land.registers.show');
    Route::post('/land-registers/{id}/update-status', [AdminLandRegisterController::class, 'updateStatus'])->name('land.registers.updateStatus');
});









    // Land Registers (الدفتر العقاري)
    Route::get('/land-registers', [AdminLandRegisterController::class, 'index'])->name('land.registers.index');
    Route::get('/land-registers/{id}', [AdminLandRegisterController::class, 'show'])->name('land.registers.show');
    Route::post('/land-registers/{id}/update-status', [AdminLandRegisterController::class, 'updateStatus'])->name('land.registers.updateStatus');
    





    // في قسم admin routes
Route::post('/land-registers/{id}/process', [AdminLandRegisterController::class, 'processRequest'])->name('land.registers.process');



Route::get('/admin/land-register/all', [LandRegisterController::class, 'allRequests'])->name('land-register.all');














Route::prefix('admin')->name('admin.')->group(function () {

    // عرض الطلب
    Route::get('/land-registers/{id}',
        [AdminLandRegisterController::class, 'show']
    )->name('land.registers.show');

    // صفحة المعالجة (GET)
    Route::get('/land-registers/{id}/process',
        [AdminLandRegisterController::class, 'processView']
    )->name('land.registers.process.view');

    // تنفيذ المعالجة (POST)
    Route::post('/land-registers/{id}/process',
        [AdminLandRegisterController::class, 'processRequest']
    )->name('land.registers.process');
});




















   Route::get('/land-register/create', [LandRegisterController::class, 'create'])
       ->name('land.register.create');

   Route::post('/land-register/store', [LandRegisterController::class, 'store'])

       ->name('land.register.store');






       // الدفتر العقاري (للمستخدمين - المواطنين)
Route::prefix('land-register')->name('land.register.')->group(function () {
    Route::get('/create', [LandRegisterController::class, 'create'])->name('create');
    Route::post('/store', [LandRegisterController::class, 'store'])->name('store');
    Route::get('/copy', [LandRegisterController::class, 'copyRequest'])->name('copy');
    Route::post('/copy/store', [LandRegisterController::class, 'storeCopy'])->name('copy.store');
});






    // Land Registers (الدفتر العقاري - الأدمن) ✅ المسار الصحيح
    Route::prefix('land-registers')->name('land.registers.')->group(function () {
      Route::get('/', [AdminLandRegisterController::class, 'index'])->name('index');
      Route::get('/advanced-search-property', [AdminLandRegisterController::class, 'advancedSearchProperty'])->name('advancedSearchProperty');
        Route::get('/{id}', [AdminLandRegisterController::class, 'show'])->name('show');
        Route::post('/{id}/update-status', [AdminLandRegisterController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/process-view', [AdminLandRegisterController::class, 'processView'])->name('processView');
        Route::post('/{id}/process', [AdminLandRegisterController::class, 'processRequest'])->name('process');
          Route::post('/{id}/process-copy', [AdminLandRegisterController::class, 'processCopy'])->name('processCopy');
        Route::prefix('land-registers')->name('land.registers.')->group(function () {
            Route::get('/advanced-search-property', [AdminLandRegisterController::class, 'advancedSearchProperty'])->name('advancedSearchProperty');
    });
    });







    Route::get(
    '/admin/land-registers/{id}/process-view',
    [AdminLandRegisterController::class, 'processView']
)->name('admin.land.registers.processView');









// صفحة عرض معالجة طلب النسخة
Route::get(
    '/admin/land-registers/{id}/process-copy',
    [AdminLandRegisterController::class, 'processCopyView']
)->name('admin.land.registers.processCopyPage');

// حفظ / معالجة طلب النسخة
Route::post(
    '/admin/land-registers/{id}/process-copy',
    [AdminLandRegisterController::class, 'processCopy']
)->name('admin.land.registers.processCopy');

 // البحث المتقدم (المستخدم في صفحة المعالجة)
    Route::post('/property-owners/advanced-search', [PropertyOwnerController::class, 'advancedSearch'])
        ->name('property_owners.advanced_search');
    
    // البحث السريع AJAX
    Route::get('/property-owners/search-ajax', [PropertyOwnerController::class, 'searchAjax'])
        ->name('property_owners.search_ajax');
    
    // CRUD أساسي
    Route::resource('property_owners', PropertyOwnerController::class);












Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('land-registers')->name('land.registers.')->group(function () {
        
        // 1. مسار البحث (وضعه في الأعلى ضروري)
        Route::get('/advanced-search-property', [AdminLandRegisterController::class, 'advancedSearchProperty'])->name('advancedSearchProperty');

        // 2. المسارات الأخرى
        Route::get('/', [AdminLandRegisterController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminLandRegisterController::class, 'show'])->name('show');
        Route::get('/{id}/process-view', [AdminLandRegisterController::class, 'processView'])->name('processView');
        Route::post('/{id}/process', [AdminLandRegisterController::class, 'processRequest'])->name('process');
        Route::post('/{id}/process-copy', [AdminLandRegisterController::class, 'processCopy'])->name('processCopy');
    });
});



































Route::prefix('land-registers')->name('land.registers.')->group(function () {
    Route::get('/', [AdminLandRegisterController::class, 'index'])->name('index');
    Route::get('/{id}', [AdminLandRegisterController::class, 'show'])->name('show');
    Route::post('/{id}/update-status', [AdminLandRegisterController::class, 'updateStatus'])->name('updateStatus');
    
    // معالجة الطلبات الجديدة
    Route::get('/{id}/process-view', [AdminLandRegisterController::class, 'processView'])->name('processView');
    Route::post('/{id}/process', [AdminLandRegisterController::class, 'processRequest'])->name('process');
    
    // معالجة طلبات النسخ
    Route::get('/{id}/process-copy', [AdminLandRegisterController::class, 'processCopyView'])->name('processCopyView');
    Route::post('/{id}/process-copy', [AdminLandRegisterController::class, 'processCopy'])->name('processCopy');
    Route::post('/search-property', [AdminLandRegisterController::class, 'searchProperty'])->name('searchProperty');
    
    // توليد PDF
    Route::get('/{id}/generate-copy-pdf', [AdminLandRegisterController::class, 'generateCopyPDF'])->name('generateCopyPDF');
});




















Route::post('/admin/land-registers/search-property',
    [AdminLandRegisterController::class, 'searchProperty']
)->name('admin.land.registers.searchProperty');

















// الصفحة الرئيسية
Route::get('/', function () {
    return view('home');
})->name('home');

// صفحة من نحن
Route::get('/about', function () {
    return view('about');
})->name('about');

// صفحة اتصل بنا  
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// باقي الـ routes موجودة...













Route::get('/land-register/create', [LandRegisterController::class, 'create'])->name('land.register.create');
Route::post('/land-register/store', [LandRegisterController::class, 'store'])->name('land.register.store');

// للنسخة
Route::get('/land-register/copy', [LandRegisterController::class, 'createCopy'])->name('land.register.copy');






Route::get('/land-register/create', [LandRegisterController::class, 'create'])->name('land.register.create');
Route::post('/land-register/store', [LandRegisterController::class, 'store'])->name('land.register.store');

Route::get('/land-register/copy', [LandRegisterController::class, 'createCopy'])->name('land.register.copy');
Route::post('/land-register/copy/store', [LandRegisterController::class, 'storeCopy'])->name('land.register.copy.store');


// Routes الأدمن
Route::middleware(['admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // ========== Land Registers Routes ==========
    Route::prefix('land/registers')->name('land.registers.')->group(function () {
        // عرض صفحة معالجة النسخة
        Route::get('{id}/process-copy', [LandRegisterController::class, 'showProcessCopy'])
            ->name('processCopy');
        
        // معالجة النسخة
        Route::post('{id}/process-copy', [LandRegisterController::class, 'processCopy'])
            ->name('processCopy');
                    // أضف هاد الراوت الجديد
              Route::get('/advanced-search-property', 
            [App\Http\Controllers\Admin\AdminLandRegisterController::class, 'advancedSearchProperty']
        )->name('advanced-search-property');
    });
    
    // ========== Land Properties Routes ==========
    Route::prefix('land/properties')->name('land.properties.')->group(function () {
        // CRUD Routes
        Route::get('/', [LandPropertyController::class, 'index'])->name('index');
        Route::get('create', [LandPropertyController::class, 'create'])->name('create');
        Route::post('/', [LandPropertyController::class, 'store'])->name('store');
        Route::get('{id}', [LandPropertyController::class, 'show'])->name('show');
        Route::get('{id}/edit', [LandPropertyController::class, 'edit'])->name('edit');
        Route::put('{id}', [LandPropertyController::class, 'update'])->name('update');
        Route::delete('{id}', [LandPropertyController::class, 'destroy'])->name('destroy');
        
        // AJAX Routes
        Route::get('search/basic', [LandPropertyController::class, 'search'])->name('search');
        Route::get('search/advanced', [LandPropertyController::class, 'advancedSearch'])->name('search.advanced');
        Route::get('{id}/details', [LandPropertyController::class, 'getDetails'])->name('details');
        
        // Extra Routes
        Route::get('statistics/all', [LandPropertyController::class, 'statistics'])->name('statistics');
        Route::get('export/csv', [LandPropertyController::class, 'export'])->name('export');
        Route::post('import/csv', [LandPropertyController::class, 'import'])->name('import');
    });
});
// ✅ يجب أن تكون هكذا:
// ✅ Route في أعلى الملف - بدون أي prefix أو middleware
Route::get('/search-cert', [NegativeCertificateSearchController::class, 'search']);
Route::get('/get-cert/{id}', [NegativeCertificateSearchController::class, 'show']);

// بقية routesك...
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // routes الأخرى
});



















Route::prefix('admin')->middleware(['admin'])->name('admin.')->group(function() {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});













    // Users Management
    // ========================================
    Route::prefix('users')->name('users.')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });











// ... باقي الـ Routes

// Public Appointment Routes
Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment');
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');


















// Routes للإدارة
Route::prefix('admin')->name('admin.')->middleware(['admin', 'admin'])->group(function () {
    
    // ... الـ routes الأخرى ...
    
    // ======= حجز المواعيد =======
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    
});





















// في مجموعة الـ admin routes
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    
    // ... routes أخرى ...
    
    // ======= حجز المواعيد =======
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{id}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{id}/confirm', [AdminAppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::post('/appointments/{id}/cancel', [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{id}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');
    Route::delete('/appointments/{id}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');
    
});









Route::prefix('admin')->middleware(['admin'])->name('admin.')->group(function() {
    
    Route::prefix('appointments')->name('appointments.')->group(function() {
        Route::get('/', [AdminAppointmentController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminAppointmentController::class, 'show'])->name('show');
        Route::get('/{id}/process', [AdminAppointmentController::class, 'process'])->name('process');
        Route::post('/{id}/update-status', [AdminAppointmentController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [AdminAppointmentController::class, 'destroy'])->name('destroy');
    });
});






// ═══════════════════════════════════════════════════════════
// راوتات الجمهور (Public)
// ═══════════════════════════════════════════════════════════

// صفحة حجز الموعد
Route::get('/appointment', [AppointmentController::class, 'index'])
    ->name('appointment');


// حفظ الحجز (AJAX)
Route::post('/appointment/store', [AppointmentController::class, 'store'])
    ->name('appointment.store');


// ═══════════════════════════════════════════════════════════
// راوتات الأدمن (Admin)
// ═══════════════════════════════════════════════════════════

Route::prefix('admin')->middleware(['admin', 'admin'])->group(function () {
    
    // إدارة المواعيد
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])
        ->name('admin.appointments.index');
    
    Route::get('/appointments/{id}', [AdminAppointmentController::class, 'show'])
        ->name('admin.appointments.show');
    
    Route::post('/appointments/{id}/confirm', [AdminAppointmentController::class, 'confirm'])
        ->name('admin.appointments.confirm');
    
    Route::post('/appointments/{id}/cancel', [AdminAppointmentController::class, 'cancel'])
        ->name('admin.appointments.cancel');
    
    Route::post('/appointments/{id}/complete', [AdminAppointmentController::class, 'complete'])
        ->name('admin.appointments.complete');
    
    Route::delete('/appointments/{id}', [AdminAppointmentController::class, 'destroy'])
        ->name('admin.appointments.destroy');
        
});




































Route::get('/', function () {
    return view('home');
})->name('home');

// ═══════════════════════════════════════════════════════════
// راوتات الجمهور
// ═══════════════════════════════════════════════════════════

Route::get('/appointment', [AppointmentController::class, 'index'])
    ->name('appointment');

Route::post('/appointment/store', [AppointmentController::class, 'store'])
    ->name('appointment.store');

// ═══════════════════════════════════════════════════════════
// راوتات الأدمن
// ═══════════════════════════════════════════════════════════

Route::prefix('admin')->middleware(['admin', 'admin'])->group(function () {
    
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])
        ->name('admin.appointments.index');
    
    Route::get('/appointments/{id}', [AdminAppointmentController::class, 'show'])
        ->name('admin.appointments.show');
    
    Route::post('/appointments/{id}/confirm', [AdminAppointmentController::class, 'confirm'])
        ->name('admin.appointments.confirm');
    
    Route::post('/appointments/{id}/cancel', [AdminAppointmentController::class, 'cancel'])
        ->name('admin.appointments.cancel');
    
    Route::post('/appointments/{id}/complete', [AdminAppointmentController::class, 'complete'])
        ->name('admin.appointments.complete');
    
    Route::delete('/appointments/{id}', [AdminAppointmentController::class, 'destroy'])
        ->name('admin.appointments.destroy');
});





















// Admin Appointments Routes
Route::prefix('admin')->middleware(['admin'])->name('admin.')->group(function() {
    
    Route::prefix('appointments')->name('appointments.')->group(function() {
        // قائمة المواعيد
        Route::get('/', [AdminAppointmentController::class, 'index'])->name('index');
        
        // عرض التفاصيل
        Route::get('/{id}', [AdminAppointmentController::class, 'show'])->name('show');
        
        // صفحة المعالجة
        Route::get('/{id}/process', [AdminAppointmentController::class, 'process'])->name('process');
        
        // تحديث الحالة (من صفحة المعالجة)
        Route::post('/{id}/update-status', [AdminAppointmentController::class, 'updateStatus'])->name('updateStatus');
        
        // تأكيد مباشر
        Route::post('/{id}/confirm', [AdminAppointmentController::class, 'confirm'])->name('confirm');
        
        // إلغاء مباشر
        Route::post('/{id}/cancel', [AdminAppointmentController::class, 'cancel'])->name('cancel');
        
        // إتمام
        Route::post('/{id}/complete', [AdminAppointmentController::class, 'complete'])->name('complete');
        
        // حذف
        Route::delete('/{id}', [AdminAppointmentController::class, 'destroy'])->name('destroy');
        
        // إحصائيات (اختياري)
        Route::get('/stats/data', [AdminAppointmentController::class, 'statistics'])->name('statistics');
    });
});



//تسجيل الدخووووول
// صفحة المستخدم العادي (محمية)
// صفحة المستخدم العادي بعد التسجيل
Route::middleware(['website.auth'])->group(function () {
    Route::get('/my-account', function () {
        return view('website.profile'); // ← غيّرنا home إلى profile
    })->name('website.home');
});
// dashboard للأدمن فقط
Route::get('/dashboard', function () {
    if (Auth::guard('web')->check() && Auth::guard('web')->user()->is_admin == 1) {
        return redirect()->route('admin.dashboard');
    }
    if (Auth::guard('website')->check()) {
        return redirect()->route('website.home');
    }
    return redirect()->route('login');
})->name('dashboard');
Route::prefix('admin')->middleware(['admin'])->name('admin.')->group(function () {

    // الرئيسية - للجميع
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // الشهادات السلبية
    Route::middleware('permission:certificates')->group(function () {
        Route::get('/certificates', [NegativeCertificateAdminController::class, 'index'])->name('certificates.index');
        Route::get('/certificates/{id}', [NegativeCertificateAdminController::class, 'show'])->name('certificates.show');
        Route::get('/certificates/{id}/process', [NegativeCertificateAdminController::class, 'process'])->name('certificates.process');
        // باقي routes الشهادات...
    });

    // البطاقات العقارية والوثائق
    Route::middleware('permission:documents')->group(function () {
        Route::get('/documents', [documentsAdminController::class, 'index'])->name('documents.index');
        Route::get('/documents/{id}', [documentsAdminController::class, 'show'])->name('documents.show');
        // باقي routes الوثائق...

        Route::get('/extracts', [ContractExtractController::class, 'index'])->name('extracts.index');
        // باقي routes المستخرجات...
    });

    // الدفتر العقاري
    Route::middleware('permission:land_registers')->group(function () {
        Route::get('/land-registers', [AdminLandRegisterController::class, 'index'])->name('land.registers.index');
        Route::get('/land-registers/{id}', [AdminLandRegisterController::class, 'show'])->name('land.registers.show');
        // باقي routes الدفتر...
    });

    // المواعيد
    Route::middleware('permission:appointments')->group(function () {
        Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{id}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
        // باقي routes المواعيد...
    });

    // الرسائل
    Route::middleware('permission:messages')->group(function () {
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
        // باقي routes الرسائل...
    });

    // المستخدمين
    Route::middleware('permission:users')->group(function () {
        Route::resource('users', UserController::class);
    });

    // الإعدادات
    Route::middleware('permission:settings')->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    // إدارة المشرفين - المدير العام فقط (بدون permission middleware لأن isSuperAdmin يتحقق منه)
    Route::prefix('managers')->name('managers.')->group(function () {
        Route::get('/',          [AdminManagerController::class, 'index'])  ->name('index');
        Route::get('/create',    [AdminManagerController::class, 'create']) ->name('create');
        Route::post('/',         [AdminManagerController::class, 'store'])  ->name('store');
        Route::get('/{id}/edit', [AdminManagerController::class, 'edit'])   ->name('edit');
        Route::put('/{id}',      [AdminManagerController::class, 'update']) ->name('update');
        Route::delete('/{id}',   [AdminManagerController::class, 'destroy'])->name('destroy');
    });

});


// ===== المسارات التي تتطلب تسجيل الدخول =====
// ===== المسارات التي تتطلب تسجيل الدخول =====
Route::middleware('auth:website')->group(function () {
    
    // الملف الشخصي - المهم: استخدم website.profile
    Route::get('/profile', function () {
        return view('website.profile'); // لأن الملف في مجلد website
    })->name('profile');

Route::middleware('auth:website')->group(function () {
    // ... المسارات الموجودة
    
    // مسار حذف الحساب
    Route::delete('/profile/delete', function () {
        $user = Auth::guard('website')->user();
        
        // تسجيل الخروج أولاً
        Auth::guard('website')->logout();
        
        // حذف المستخدم
        $user->delete();
        
        // إنهاء الجلسة
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect('/')->with('success', 'تم حذف الحساب بنجاح');
    })->name('profile.delete');
});
});
























;

// Admin Settings Routes
Route::prefix('admin')->middleware(['admin'])->name('admin.')->group(function() {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/reset', [SettingsController::class, 'reset'])->name('settings.reset');
});



















//Route::get('/dashboard', [DashboardController::class, 'index']) ->middleware(['admin'])
// ->name('dashboard');

















   
Route::get('/admin/land-registers/{id}/process', 
    [LandRegisterController::class, 'process']
)->name('admin.land.registers.process-view');



















Route::prefix('admin')
->middleware(['admin','admin'])
->name('admin.')
->group(function () {

    Route::prefix('land-registers')->name('land.registers.')->group(function () {

        Route::get('/', [AdminLandRegisterController::class,'index'])
            ->name('index');

    });

});














Route::middleware(['admin','admin'])
->prefix('admin')
->name('admin.')
->group(function(){

    Route::prefix('land-registers')->name('land.registers.')->group(function(){

        // ✅ قائمة الدفتر العقاري
        Route::get('/', 
            [App\Http\Controllers\Admin\AdminLandRegisterController::class,'index']
        )->name('index');

        // ✅ عرض طلب واحد
        Route::get('{id}', 
            [App\Http\Controllers\Admin\AdminLandRegisterController::class,'show']
        )->name('show');

        // ✅ المعالجة
        Route::get('{id}/process-view', 
            [App\Http\Controllers\Admin\AdminLandRegisterController::class,'processView']
        )->name('processView');

        Route::post('{id}/process', 
            [App\Http\Controllers\Admin\AdminLandRegisterController::class,'processRequest']
        )->name('process');

    });

});














Route::middleware(['admin','admin'])
->prefix('admin')
->name('admin.land.registers.')
->group(function(){

    Route::get('land-registers/{id}/process-copy',
        [App\Http\Controllers\Admin\AdminLandRegisterController::class,'processCopyView']
    )->name('processCopyView');

});





















// routes للعقارات (Properties)
Route::middleware(['admin'])
    ->prefix('admin')
    ->name('admin.land.properties.')
    ->group(function(){
        Route::post('properties/search', [LandPropertyController::class, 'search'])->name('search');
    });

// routes لطلبات النسخ (Registers) - بنفس Controller
Route::middleware(['admin'])
    ->prefix('admin')
    ->name('admin.land.registers.')
    ->group(function(){
        // عرض صفحة المعالجة
        Route::get('land-registers/{id}/process-copy',
            [AdminLandRegisterController::class, 'processCopyView']
        )->name('processCopyView');
        
        // معالجة إرسال الإشعار
        Route::post('land-registers/{id}/process-copy-submit', 
            [AdminLandRegisterController::class, 'processCopySubmit']
        )->name('process-copy-submit');
        
        // رفض الطلب
        Route::post('land-registers/{id}/reject', 
            [AdminLandRegisterController::class, 'reject']
        )->name('reject');
    });

// يمكنك أيضاً إضافتها بشكل منفصل إذا أردت
// Route::post('/admin/land-registers/{id}/process-copy-submit', [AdminLandRegisterController::class, 'processCopySubmit'])->name('admin.land.registers.process-copy-submit');
// Route::post('/admin/land-registers/{id}/reject', [AdminLandRegisterController::class, 'reject'])->name('admin.land.registers.reject');


Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('/appointments/{id}', [AdminAppointmentController::class, 'show'])
        ->name('admin.appointments.show');

    // استخدم الكونترولر الصحيح
    Route::delete('certificates/{id}', [NegativeCertificateAdminController::class, 'destroy'])
        ->name('admin.certificates.destroy');

        // أو يدوياً:
Route::delete('documents/{id}', [DocumentsAdminController::class, 'destroy'])
    ->name('admin.documents.destroy');
Route::delete('/admin/land-registers/{id}', [AdminLandRegisterController::class, 'destroy'])
    ->name('admin.land.registers.destroy');
});

