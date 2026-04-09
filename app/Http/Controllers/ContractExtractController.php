<?php

namespace App\Http\Controllers;

use App\Models\ContractExtract;
use App\Models\UserRequest; // ✅ إضافة هذا
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // ✅ للتسجيل

class ContractExtractController extends Controller
{
    // ═══════════════════════════════════════════════════════════
    // 📋 User Methods (للمستخدمين)
    // ═══════════════════════════════════════════════════════════

    /**
     * عرض صفحة تقديم الطلب
     */
    public function create()
    {
        return view('contracts.extract');
    }

    /**
     * تخزين الطلب
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'extract_type' => 'required|string|in:حجز,بيع,هبة,رهن_او_امتياز,تشطيب,عريضة,وثيقة_ناقلة_للملكية',
            'applicant_lastname' => 'required|string|max:255',
            'applicant_firstname' => 'required|string|max:255',
            'applicant_father' => 'required|string|max:255',
            'volume_number' => 'required|string|max:255',
            'publication_number' => 'required|string|max:255',
            'publication_date' => 'nullable|date',
            'applicant_nin' => 'nullable|string|max:20',
            'applicant_email' => 'nullable|email|max:255',
            'applicant_phone' => 'nullable|string|max:20',
        ], [
            'extract_type.required' => 'نوع المستخرج مطلوب',
            'extract_type.in' => 'نوع المستخرج غير صالح',
            'applicant_lastname.required' => 'اللقب مطلوب',
            'applicant_firstname.required' => 'الاسم مطلوب',
            'applicant_father.required' => 'اسم الأب مطلوب',
            'volume_number.required' => 'رقم المجلد مطلوب',
            'publication_number.required' => 'رقم النشر مطلوب',
        ]);

        // إضافة الحالة الافتراضية
        $validated['status'] = 'قيد المعالجة';

        ContractExtract::create($validated);

        return back()->with('success', '✅ تم تسجيل طلب المستخرج بنجاح');
    }

    /**
     * عرض طلب محدد (للمستخدم)
     */
    public function userShow($id)
    {
        $extract = ContractExtract::findOrFail($id);
        return view('contracts.show', compact('extract'));
    }

    // ═══════════════════════════════════════════════════════════
    // 👨‍💼 Admin Methods (للإدارة)
    // ═══════════════════════════════════════════════════════════

    /**
     * عرض قائمة الطلبات (Admin)
     */
    public function index(Request $request)
    {
        $query = ContractExtract::query();

        // البحث برقم المجلد
        if ($request->filled('volume_number')) {
            $query->where('volume_number', 'like', '%' . $request->volume_number . '%');
        }

        // البحث برقم النشر
        if ($request->filled('publication_number')) {
            $query->where('publication_number', 'like', '%' . $request->publication_number . '%');
        }

        // التصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // التصفية حسب نوع المستخرج
        if ($request->filled('extract_type')) {
            $query->where('extract_type', $request->extract_type);
        }

        // البحث بالاسم أو رقم التعريف
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('applicant_firstname', 'like', '%' . $request->search . '%')
                  ->orWhere('applicant_lastname', 'like', '%' . $request->search . '%')
                  ->orWhere('applicant_nin', 'like', '%' . $request->search . '%');
            });
        }

        $extracts = $query->latest()->paginate(20);

        return view('admin.extracts.index', compact('extracts'));
    }

    /**
     * عرض تفاصيل الطلب (Admin)
     */
    public function show($id)
    {
        $extract = ContractExtract::findOrFail($id);
        return view('admin.extracts.show', compact('extract'));
    }

    /**
     * تحديث الحالة
     */
    public function updateStatus(Request $request, $id)
{
    try {
        DB::beginTransaction();

        $extract = ContractExtract::findOrFail($id);

        $extract->status = $request->status;
        $extract->save();

        DB::commit();

        return redirect()
            ->back()
            ->with('success', '✓ تم تحديث الحالة بنجاح');

    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()
            ->back()
            ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
    }
}

    /**
     * الموافقة على الطلب
     */
    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $extract = ContractExtract::findOrFail($id);
            
            $extract->update([
                'status' => 'مقبول',
                'processed_at' => now(),
                'processed_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.extracts.show', $id)
                ->with('success', '✓ تم قبول الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * رفض الطلب
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ], [
            'reason.required' => 'سبب الرفض مطلوب',
            'reason.min' => 'سبب الرفض يجب أن يكون 10 أحرف على الأقل',
        ]);

        try {
            DB::beginTransaction();

            $extract = ContractExtract::findOrFail($id);
            
            $extract->update([
                'status' => 'مرفوض',
                'processed_at' => now(),
                'processed_by' => auth()->id(),
                'rejection_reason' => $request->reason,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.extracts.show', $id)
                ->with('success', '✓ تم رفض الطلب');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف الطلب
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $extract = ContractExtract::findOrFail($id);
            $extract->delete();

            DB::commit();

            return redirect()
                ->route('admin.extracts.index')
                ->with('success', '✓ تم حذف الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    // ═══════════════════════════════════════════════════════════
    // 📄 PDF Method (للجميع)
    // ═══════════════════════════════════════════════════════════

    /**
     * توليد PDF
     */
    public function pdf($id)
    {
        $extract = ContractExtract::findOrFail($id);
        
        $pdf = Pdf::loadView('contracts.pdf', compact('extract'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('مستخرج_عقد_' . $extract->id . '.pdf');
    }
    
    // ═══════════════════════════════════════════════════════════
    // 📱 API Methods (لـ Flutter)
    // ═══════════════════════════════════════════════════════════

    /**
     * استقبال طلب مستخرج عقد من تطبيق Flutter
     */
    public function apiStore(Request $request)
    {
        try {
            // قواعد التحقق
            $validated = $request->validate([
                // معلومات مقدم الطلب
                'applicant_nin' => 'nullable|string|max:20',
                'applicant_lastname' => 'required|string|max:255',
                'applicant_firstname' => 'required|string|max:255',
                'applicant_father' => 'required|string|max:255',
                'applicant_email' => 'nullable|email|max:255',
                'applicant_phone' => 'nullable|string|max:20',
                
                // معلومات العقد
                'extract_type' => 'required|string|in:حجز,بيع,هبة,رهن_او_امتياز,تشطيب,عريضة,وثيقة_ناقلة_للملكية',
                'volume_number' => 'required|string|max:255',
                'publication_number' => 'required|string|max:255',
                'publication_date' => 'nullable|date',
            ]);

            DB::beginTransaction();

            // إضافة الحالة الافتراضية
            $validated['status'] = 'قيد المعالجة';

            // ✅ حفظ في جدول contract_extracts
            $extract = ContractExtract::create($validated);

            // ✅ حفظ في جدول user_requests (ربط مع المستخدم)
            if (auth()->check()) {
                UserRequest::create([
                    'user_id' => auth()->id(),
                    'type' => 'contract_extract',
                    'status' => 'pending',
                    'data' => json_encode($extract->toArray())
                ]);
                
                Log::info('✅ تم حفظ طلب مستخرج العقد في user_requests للمستخدم ' . auth()->id());
            } else {
                Log::warning('⚠️ المستخدم غير مسجل دخول، لم يتم حفظ طلب مستخرج العقد في user_requests');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلب المستخرج بنجاح',
                'extract' => $extract,
                'extract_id' => $extract->id,
                'created_at' => $extract->created_at->format('Y-m-d H:i:s')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🔥 خطأ في حفظ طلب مستخرج العقد: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * جلب كل طلبات مستخرجات العقود (لتطبيق Flutter)
     */
    public function apiIndex()
    {
        try {
            $extracts = ContractExtract::latest()->get();
            
            return response()->json([
                'success' => true,
                'extracts' => $extracts
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * جلب طلب واحد (لتطبيق Flutter)
     */
    public function apiShow($id)
    {
        try {
            $extract = ContractExtract::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'extract' => $extract
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}