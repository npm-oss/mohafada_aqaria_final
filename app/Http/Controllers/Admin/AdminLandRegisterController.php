<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LandRegisterStatusMail;

class AdminLandRegisterController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('land_registers')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('request_type')) {
            $query->where('request_type', $request->request_type);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('national_id', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('full_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('register_number', 'LIKE', '%' . $request->search . '%');
            });
        }

        $registers = $query->paginate(20);

        $stats = [
            'total' => DB::table('land_registers')->count(),
            'new_requests' => DB::table('land_registers')->where('request_type', 'طلب جديد')->count(),
            'copy_requests' => DB::table('land_registers')->where('request_type', 'نسخة دفتر')->count(),
            'pending' => DB::table('land_registers')->where('status', 'pending')->count(),
            'approved' => DB::table('land_registers')->where('status', 'approved')->count(),
        ];

        return view('admin.land-registers.index', compact('registers', 'stats'));
    }

    public function show($id)
    {
        $register = DB::table('land_registers')->where('id', $id)->first();

        if (!$register) {
            return redirect()->route('admin.land.registers.index')
                ->with('error', 'الطلب غير موجود');
        }

        $documents = [];
        if (!empty($register->documents)) {
            try {
                $documents = json_decode($register->documents, true);
                if (!is_array($documents)) {
                    $documents = [];
                }
            } catch (\Exception $e) {
                $documents = [];
            }
        }

        return view('admin.land-registers.show', compact('register', 'documents'));
    }

    public function processView($id)
    {
        $register = DB::table('land_registers')->where('id', $id)->first();

        if (!$register) {
            return redirect()->route('admin.land.registers.index')
                ->with('error', 'الطلب غير موجود');
        }

        if ($register->request_type != 'طلب جديد') {
            return redirect()->route('admin.land.registers.show', $id)
                ->with('error', 'هذا الطلب ليس طلب جديد');
        }

        return view('admin.land-registers.process-view', compact('register'));
    }

    public function processRequest(Request $request, $id)
    {
        $register = DB::table('land_registers')->where('id', $id)->first();

        if (!$register) {
            return redirect()->back()->with('error', 'الطلب غير موجود');
        }

        $decision = $request->input('decision');

        if (!in_array($decision, ['accept', 'reject', 'incomplete'])) {
            return redirect()->back()->with('error', 'قرار غير صحيح');
        }

        switch ($decision) {
            case 'accept':
                return $this->handleAccept($request, $register);
            
            case 'reject':
                return $this->handleReject($request, $register);
            
            case 'incomplete':
                return $this->handleIncomplete($request, $register);
            
            default:
                return redirect()->back()->with('error', 'قرار غير صحيح');
        }
    }

    private function handleAccept($request, $register)
    {
        $acceptNotes = $request->input('accept_notes', '');
        
        $message = "السيد(ة) {$register->last_name} {$register->first_name}،\n\n";
        $message .= "نتشرف بإبلاغكم بأنه تم قبول طلبكم رقم #{$register->id} لإنشاء دفتر عقاري جديد.\n\n";
        $message .= "✅ تم اعتماد جميع الوثائق المرفوعة\n";
        $message .= "✅ سيتم إنشاء الدفتر العقاري خلال الأيام القادمة\n";
        $message .= "✅ سيتم إشعاركم عند اكتمال الإجراءات\n\n";
        
        if (!empty($acceptNotes)) {
            $message .= "📝 ملاحظات إضافية:\n{$acceptNotes}\n\n";
        }
        
        $message .= "شكراً لثقتكم بخدماتنا.\n\n";
        $message .= "مع خالص التحيات،\n";
        $message .= "المحافظة العقارية";

        DB::table('land_registers')->where('id', $register->id)->update([
            'status' => 'approved',
            'admin_notes' => $message,
            'updated_at' => now()
        ]);

        try {
            $updatedRegister = DB::table('land_registers')->where('id', $register->id)->first();
            Mail::to($register->email)->send(new LandRegisterStatusMail($updatedRegister, 'approved'));
            
            return redirect()->route('admin.land.registers.show', $register->id)
                ->with('success', '✅ تم قبول الطلب بنجاح وإرسال إشعار للمواطن');
        } catch (\Exception $e) {
            return redirect()->route('admin.land.registers.show', $register->id)
                ->with('warning', 'تم قبول الطلب ولكن فشل إرسال البريد: ' . $e->getMessage());
        }
    }

    private function handleReject($request, $register)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'سبب الرفض مطلوب',
            'rejection_reason.min' => 'سبب الرفض يجب أن يكون 10 أحرف على الأقل',
        ]);

        $rejectionReason = $request->input('rejection_reason');
        $rejectionDetails = $request->input('rejection_details', '');
        $allowResubmission = $request->input('allow_resubmission', '1');

        $message = "السيد(ة) {$register->last_name} {$register->first_name}،\n\n";
        $message .= "نأسف لإبلاغكم بأنه تم رفض طلبكم رقم #{$register->id} لإنشاء دفتر عقاري.\n\n";
        $message .= "❌ سبب الرفض:\n{$rejectionReason}\n\n";
        
        if (!empty($rejectionDetails)) {
            $message .= "📋 تفاصيل إضافية:\n{$rejectionDetails}\n\n";
        }
        
        if ($allowResubmission == '1') {
            $message .= "ℹ️ يمكنكم التقديم مرة أخرى بعد معالجة أسباب الرفض.\n\n";
        } else {
            $message .= "⚠️ الرفض نهائي.\n\n";
        }
        
        $message .= "مع خالص التحيات،\n";
        $message .= "المحافظة العقارية";

        DB::table('land_registers')->where('id', $register->id)->update([
            'status' => 'rejected',
            'admin_notes' => $message,
            'updated_at' => now()
        ]);

        try {
            $updatedRegister = DB::table('land_registers')->where('id', $register->id)->first();
            Mail::to($register->email)->send(new LandRegisterStatusMail($updatedRegister, 'rejected'));
            
            return redirect()->route('admin.land.registers.show', $register->id)
                ->with('success', '❌ تم رفض الطلب وإرسال إشعار للمواطن');
        } catch (\Exception $e) {
            return redirect()->route('admin.land.registers.show', $register->id)
                ->with('warning', 'تم رفض الطلب ولكن فشل إرسال البريد: ' . $e->getMessage());
        }
    }

    private function handleIncomplete($request, $register)
    {
        $request->validate([
            'missing_docs' => 'required|array|min:1',
            'completion_deadline' => 'required|integer|min:1',
            'completion_notes' => 'required|string|min:10',
        ], [
            'missing_docs.required' => 'يجب اختيار وثيقة واحدة على الأقل',
            'missing_docs.min' => 'يجب اختيار وثيقة واحدة على الأقل',
            'completion_deadline.required' => 'المهلة الممنوحة مطلوبة',
            'completion_notes.required' => 'تعليمات الاستكمال مطلوبة',
            'completion_notes.min' => 'تعليمات الاستكمال يجب أن تكون 10 أحرف على الأقل',
        ]);

        $missingDocs = $request->input('missing_docs');
        $deadline = $request->input('completion_deadline');
        $completionNotes = $request->input('completion_notes');
        
        $deadlineDate = now()->addDays($deadline)->format('Y-m-d');

        $message = "السيد(ة) {$register->last_name} {$register->first_name}،\n\n";
        $message .= "نشكركم على طلبكم رقم #{$register->id} لإنشاء دفتر عقاري.\n\n";
        $message .= "⚠️ طلبكم بحاجة إلى استكمال الوثائق التالية:\n\n";
        
        foreach ($missingDocs as $index => $doc) {
            $message .= ($index + 1) . ". {$doc}\n";
        }
        
        $message .= "\n📋 تعليمات الاستكمال:\n{$completionNotes}\n\n";
        $message .= "⏰ المهلة الممنوحة: {$deadline} يوم (حتى تاريخ {$deadlineDate})\n\n";
        $message .= "ℹ️ يرجى استكمال الوثائق الناقصة خلال المهلة المحددة.\n\n";
        $message .= "مع خالص التحيات،\n";
        $message .= "المحافظة العقارية";

        DB::table('land_registers')->where('id', $register->id)->update([
            'status' => 'incomplete',
            'admin_notes' => $message,
            'updated_at' => now()
        ]);

        try {
            $updatedRegister = DB::table('land_registers')->where('id', $register->id)->first();
            Mail::to($register->email)->send(new LandRegisterStatusMail($updatedRegister, 'incomplete'));
            
            return redirect()->route('admin.land.registers.show', $register->id)
                ->with('success', '⚠️ تم إرسال طلب استكمال الوثائق للمواطن');
        } catch (\Exception $e) {
            return redirect()->route('admin.land.registers.show', $register->id)
                ->with('warning', 'تم تحديث الطلب ولكن فشل إرسال البريد: ' . $e->getMessage());
        }
    }

    public function processCopyView($id)
    {
        $register = DB::table('land_registers')->where('id', $id)->first();

        if (!$register) {
            return redirect()->route('admin.land.registers.index')
                ->with('error', 'الطلب غير موجود');
        }

        if ($register->request_type != 'نسخة دفتر') {
            return redirect()->route('admin.land.registers.show', $id)
                ->with('error', 'هذا الطلب ليس طلب نسخة');
        }

        return view('admin.land-registers.process-copy', compact('register'));
    }

    public function searchProperty(Request $request)
    {
        try {
            $registerNumber = $request->input('register_number');
            
            $register = DB::table('land_registers')
                ->where('register_number', $registerNumber)
                ->where('request_type', 'طلب جديد')
                ->where('status', 'approved')
                ->first();
            
            if ($register) {
                return response()->json([
                    'found' => true,
                    'register' => $register
                ]);
            }
            
            return response()->json(['found' => false]);
            
        } catch (\Exception $e) {
            return response()->json([
                'found' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id)
{
    DB::table('land_registers')->where('id', $id)->delete();
    return redirect()->route('admin.land.registers.index')
        ->with('success', 'تم الحذف');
}

    public function processCopy(Request $request, $id)
    {
        $validated = $request->validate([
            'is_verified' => 'required|boolean',
            'copy_type' => 'required|string',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $register = DB::table('land_registers')->where('id', $id)->first();

        if (!$register) {
            return redirect()->back()->with('error', 'الطلب غير موجود');
        }

        $notes = "🔍 نتيجة التحقق من الدفتر العقاري:\n";
        $notes .= $validated['is_verified'] ? "✅ الدفتر موجود والبيانات صحيحة\n" : "❌ الدفتر غير موجود\n";
        $notes .= "\n📑 نوع النسخة: " . $validated['copy_type'] . "\n\n";
        $notes .= "✅ تم قبول الطلب\n\n";
        $notes .= "📋 الخطوات القادمة:\n";
        $notes .= "1. زيارة المحافظة العقارية لاستلام النسخة\n";
        $notes .= "2. إحضار بطاقة التعريف الوطنية\n";
        $notes .= "3. استلام " . $validated['copy_type'] . "\n\n";
        $notes .= "⏰ أوقات الدوام: الأحد - الخميس (8:00 ص - 4:00 م)";

        if (!empty($validated['admin_notes'])) {
            $notes .= "\n\n📝 ملاحظات: " . $validated['admin_notes'];
        }

        $processingData = [
            'is_verified' => $validated['is_verified'],
            'copy_type' => $validated['copy_type'],
            'processed_at' => now()->toDateTimeString(),
        ];

        DB::table('land_registers')->where('id', $id)->update([
            'status' => 'approved',
            'admin_notes' => $notes,
            'processing_data' => json_encode($processingData),
            'updated_at' => now()
        ]);

        try {
            $updatedRegister = DB::table('land_registers')->where('id', $id)->first();
            Mail::to($register->email)->send(new LandRegisterStatusMail($updatedRegister, 'approved'));
            return redirect()->route('admin.land.registers.show', $id)->with('success', "✅ تم إصدار النسخة بنجاح");
        } catch (\Exception $e) {
            return redirect()->route('admin.land.registers.show', $id)->with('warning', 'تم إصدار النسخة (فشل البريد)');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,approved,rejected,incomplete',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $register = DB::table('land_registers')->where('id', $id)->first();

        if (!$register) {
            return redirect()->back()->with('error', 'الطلب غير موجود');
        }

        DB::table('land_registers')->where('id', $id)->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'updated_at' => now()
        ]);

        if (in_array($validated['status'], ['approved', 'rejected', 'incomplete'])) {
            try {
                $updatedRegister = DB::table('land_registers')->where('id', $id)->first();
                Mail::to($register->email)->send(new LandRegisterStatusMail($updatedRegister, $validated['status']));
                return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح ✓');
            } catch (\Exception $e) {
                return redirect()->back()->with('success', 'تم تحديث الطلب (فشل البريد)');
            }
        }

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح ✓');
    }



    

    /**
 * البحث المتقدم في العقارات بالقسم والرقم
 */
public function advancedSearchProperty(Request $request)
{
    try {
        $section = $request->query('section');
        $number  = $request->query('number');
        $location = $request->query('location');

        if (!$section || !$number) {
            return response()->json(['success' => false, 'message' => 'القسم والرقم مطلوبان'], 400);
        }

        // البحث في جدول العقارات land_properties
        $properties = DB::table('land_properties')
            ->where('section', $section)
            ->where('number', $number)
            ->when($location, function($q) use ($location) {
                return $q->where('location', 'LIKE', '%' . $location . '%');
            })
            ->get();

        // تحويل البيانات لتناسب الواجهة (Mapping)
        $data = $properties->map(function($p) {
            return [
                'id'              => $p->id,
                'full_owner_name' => $p->owner_name,
                'father_name'     => $p->father_name,
                'national_id'     => $p->national_id,
                'birth_date'      => $p->birth_date,
                'birth_place'     => $p->birth_place,
                'property_type'   => $p->property_type,
                'register_number' => $p->register_number,
                'section'         => $p->section,
                'number'          => $p->number,
                'location'        => $p->location,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $data,
            'count'   => $data->count()
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'message' => 'خطأ في السيرفر: ' . $e->getMessage()
        ], 500);
    }
}
























    /**
     * معالجة طلب نسخة (الدالة الجديدة المطلوبة)
     */
    public function processCopySubmit(Request $request, $id)
    {
        $register = DB::table('land_registers')->where('id', $id)->first();

        if (!$register) {
            return redirect()->back()->with('error', 'الطلب غير موجود');
        }

        // التحقق من البيانات
        $validated = $request->validate([
            'notification_type' => 'required|in:in_progress,new_register',
            'selected_property_id' => 'nullable|exists:land_properties,id',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        // تحضير الملاحظات
        $notes = "";
        
        if ($validated['notification_type'] === 'in_progress') {
            $notes .= "⚙️ إشعار: النسخة قيد الإنجاز\n";
            $notes .= "تم إشعار المواطن بأن طلب النسخة قيد المعالجة\n";
        } else {
            $notes .= "📄 إشعار: طلب دفتر عقاري جديد\n";
            $notes .= "تم إشعار المواطن بضرورة التقدم بطلب دفتر عقاري جديد\n";
        }
        
        if (!empty($validated['admin_notes'])) {
            $notes .= "\n📝 ملاحظات إضافية: " . $validated['admin_notes'];
        }

        // تحديث حالة الطلب
        DB::table('land_registers')->where('id', $id)->update([
            'status' => 'processing',
            'admin_notes' => $notes,
          'property_id' => $validated['selected_property_id'] ?? null,
            'updated_at' => now()
        ]);

        // إرسال الإيميل
        try {
            $this->sendCopyNotificationEmail($register, $validated['notification_type'], $validated['selected_property_id']);
            return redirect()->route('admin.land.registers.show', $id)
                ->with('success', '✅ تم إرسال الإشعار بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.land.registers.show', $id)
                ->with('warning', '⚠️ تم تحديث الطلب ولكن فشل إرسال البريد: ' . $e->getMessage());
        }
    }

    /**
     * إرسال إشعار البريد الإلكتروني لطلبات النسخ
     */
    private function sendCopyNotificationEmail($register, $type, $propertyId = null)
    {
        if (empty($register->email)) {
            return;
        }

        $subject = '';
        $body = '';
        
        // الحصول على بيانات العقار إذا وجد
        $property = null;
        if ($propertyId) {
            $property = DB::table('land_properties')->where('id', $propertyId)->first();
        }

        if ($type === 'in_progress') {
            $subject = '⚙️ طلب نسخة الدفتر العقاري قيد الإنجاز';
            $body = $this->getInProgressEmailBody($register, $property);
        } else {
            $subject = '📄 طلب دفتر عقاري جديد';
            $body = $this->getNewRegisterEmailBody($register);
        }

        // إرسال الإيميل
        Mail::send([], [], function ($message) use ($register, $subject, $body) {
            $message->to($register->email)
                    ->subject($subject)
                    ->setBody($body, 'text/html');
        });
    }

    /**
     * محتوى إيميل النسخة قيد الإنجاز
     */
    private function getInProgressEmailBody($register, $property = null)
    {
        $fullName = ($register->first_name ?? '') . ' ' . ($register->last_name ?? '');
        if (empty(trim($fullName))) {
            $fullName = $register->full_name ?? 'المواطن';
        }

        $propertyDetails = '';
        if ($property) {
            $propertyDetails = "
                <div style='background: #e8f5e9; padding: 15px; border-radius: 10px; margin: 15px 0; border-right: 4px solid #28a745;'>
                    <strong style='color: #1a5632;'>📋 تفاصيل العقار:</strong><br>
                    المالك: {$property->owner_name}<br>
                    رقم الدفتر: {$property->register_number}<br>
                    الموقع: {$property->location}
                </div>
            ";
        }

        return "
            <div style='font-family: Cairo, sans-serif; line-height: 1.8; padding: 20px;'>
                <h2 style='color: #1a5632; text-align: center;'>المحافظة العقارية</h2>
                <p><strong>السيد(ة) {$fullName}،</strong></p>
                <p>نود إعلامك بأن طلبك للحصول على نسخة من الدفتر العقاري قيد المعالجة.</p>
                {$propertyDetails}
                <p><strong>📌 حالة الطلب:</strong> قيد الإنجاز</p>
                <p>سيتم إشعارك فور جاهزية النسخة عبر البريد الإلكتروني أو رسالة نصية.</p>
                <p>مع جزيل الشكر،<br>المحافظة العقارية</p>
            </div>
        ";
    }

    /**
     * محتوى إيميل طلب دفتر عقاري جديد
     */
    private function getNewRegisterEmailBody($register)
    {
        $fullName = ($register->first_name ?? '') . ' ' . ($register->last_name ?? '');
        if (empty(trim($fullName))) {
            $fullName = $register->full_name ?? 'المواطن';
        }

        return "
            <div style='font-family: Cairo, sans-serif; line-height: 1.8; padding: 20px;'>
                <h2 style='color: #1a5632; text-align: center;'>المحافظة العقارية</h2>
                <p><strong>السيد(ة) {$fullName}،</strong></p>
                <p>بالإشارة إلى طلبك للحصول على نسخة من الدفتر العقاري،</p>
                <p><strong style='color: #dc3545;'>❌ لا توجد نسخة متاحة للعقار المطلوب.</strong></p>
                <p>للاستفادة من الخدمة، عليك التقدم بطلب للحصول على دفتر عقاري جديد.</p>
                <p><strong>📌 الإجراءات المطلوبة:</strong></p>
                <ul>
                    <li>تعبئة استمارة طلب دفتر عقاري جديد</li>
                    <li>إرفاق المستندات التالية:
                        <ul>
                            <li>عقد الملكية</li>
                            <li>بطاقة التعريف الوطنية</li>
                            <li>شهادة الإقامة</li>
                            <li>رسوم التسجيل</li>
                        </ul>
                    </li>
                    <li>تقديم الملف إلى مصالح المحافظة العقارية</li>
                </ul>
                <p>لمزيد من المعلومات، يرجى الاتصال بنا.</p>
                <p>مع جزيل الشكر،<br>المحافظة العقارية</p>
            </div>
        ";
    }

    

}