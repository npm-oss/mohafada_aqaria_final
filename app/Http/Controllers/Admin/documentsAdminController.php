<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserRequest;

class DocumentsAdminController extends Controller
{
    /**
     * عرض قائمة جميع الطلبات
     */
    public function index(Request $request)
    {
        $query = DocumentsRequest::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('applicant_firstname', 'like', "%{$search}%")
                  ->orWhere('applicant_lastname', 'like', "%{$search}%")
                  ->orWhere('applicant_email', 'like', "%{$search}%")
                  ->orWhere('applicant_phone', 'like', "%{$search}%");
            });
        }

        $requests = $query->paginate(20);
        
        return view('admin.documents.index', compact('requests'));
    }
    

    /**
     * عرض طلب واحد بالتفصيل
     */
    public function show($id)
    {
        $request = DocumentsRequest::findOrFail($id);
        
        return view('admin.documents.show', compact('request'));
    }

    /**
     * صفحة معالجة الطلب
     */
    public function process($id)
    {
        try {
            $request = DocumentsRequest::findOrFail($id);
            
            return view('admin.documents.process', compact('request'));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.documents.index')
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

            $request = DocumentsRequest::findOrFail($id);
            
            $request->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', '✓ تمت الموافقة على الطلب بنجاح');

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
        try {
            DB::beginTransaction();

            $document = DocumentsRequest::findOrFail($id);
            
            $document->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'rejected_by' => auth()->id(),
                'rejection_reason' => $request->rejection_reason ?? null,
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', '✓ تم رفض الطلب');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف طلب
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $documentRequest = DocumentsRequest::findOrFail($id);
            $documentRequest->delete();

            DB::commit();

            return redirect()
                ->route('admin.documents.index')
                ->with('success', '✓ تم حذف الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ أثناء الحذف: ' . $e->getMessage());
        }
    }

    /**
     * إحصائيات الطلبات
     */
    public function statistics()
    {
        $stats = [
            'total' => DocumentsRequest::count(),
            'pending' => DocumentsRequest::where('status', 'pending')->count(),
            'approved' => DocumentsRequest::where('status', 'approved')->count(),
            'rejected' => DocumentsRequest::where('status', 'rejected')->count(),
            'today' => DocumentsRequest::whereDate('created_at', today())->count(),
            'this_week' => DocumentsRequest::whereBetween('created_at', [
                now()->startOfWeek(), 
                now()->endOfWeek()
            ])->count(),
            'this_month' => DocumentsRequest::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.documents.statistics', compact('stats'));
    }

    /**
     * تصدير إلى Excel
     */
    public function export()
    {
        // TODO: Implement Excel export
        return redirect()->back()->with('info', 'قريباً: تصدير إلى Excel');
    }

    /**
     * حفظ طلب جديد (من المواطنين - يمكن نقله لـ Controller منفصل)
     */
    public function store(Request $request)
    {
        // التحقق الأساسي من البيانات
        $request->validate([
            'applicant_type' => 'required|string',
            'owner_type' => 'required|string',
            'card_type' => 'required|string',
            'property_status' => 'required|string',
        ], [
            'applicant_type.required' => 'نوع الطالب مطلوب',
            'owner_type.required' => 'نوع صاحب الملكية مطلوب',
            'card_type.required' => 'نوع البطاقة مطلوب',
            'property_status.required' => 'حالة العقار مطلوبة',
        ]);

        try {
            DB::beginTransaction();

            // تجهيز بيانات الطالب
            if ($request->applicant_type === 'person') {
                $applicant_nin = $request->applicant_nin ?? '-';
                $applicant_lastname = $request->applicant_lastname ?? '-';
                $applicant_firstname = $request->applicant_firstname ?? '-';
                $applicant_father = $request->applicant_father ?? '-';
                $applicant_email = $request->applicant_email ?? '-';
                $applicant_phone = $request->applicant_phone ?? '-';
            } else {
                $applicant_nin = $request->company_nin ?? '-';
                $applicant_lastname = $request->company_name ?? '-';
                $applicant_firstname = $request->company_representative ?? '-';
                $applicant_father = '-';
                $applicant_email = $request->company_email ?? '-';
                $applicant_phone = $request->company_phone ?? '-';
            }

            // تجهيز بيانات صاحب الملكية
            if ($request->owner_type === 'person') {
                $owner_nin = $request->owner_nin ?? '-';
                $owner_lastname = $request->owner_lastname ?? '-';
                $owner_firstname = $request->owner_firstname ?? '-';
                $owner_father = $request->owner_father ?? '-';
                $owner_birthdate = $request->owner_birthdate ?? null;
                $owner_birthplace = $request->owner_birthplace ?? '-';
            } else {
                $owner_nin = $request->owner_company_nin ?? '-';
                $owner_lastname = $request->owner_company_name ?? '-';
                $owner_firstname = $request->owner_company_representative ?? '-';
                $owner_father = $request->owner_company_email ?? '-';
                $owner_birthdate = null;
                $owner_birthplace = $request->owner_company_phone ?? '-';
            }

            // تجهيز بيانات العقار
            if ($request->property_status === 'surveyed') {
                $section = $request->section ?? null;
                $municipality = $request->municipality ?? null;
                $plan_number = $request->plan_number ?? null;
                $parcel_number = $request->parcel_number ?? null;
                $municipality_ns = null;
                $subdivision_number = null;
                $parcel_number_ns = null;
            } else {
                $section = null;
                $municipality = null;
                $plan_number = null;
                $parcel_number = null;
                $municipality_ns = $request->municipality_ns ?? null;
                $subdivision_number = $request->subdivision_number ?? null;
                $parcel_number_ns = $request->parcel_number_ns ?? null;
            }

            // إنشاء الطلب
            DocumentsRequest::create([
                'applicant_type' => $request->applicant_type,
                'owner_type' => $request->owner_type,
                'type' => $request->applicant_type,
                'request_type' => $request->owner_type,
                'status' => 'pending',
                'card_type' => $request->card_type,
                'property_status' => $request->property_status,

                'section' => $section,
                'municipality' => $municipality,
                'plan_number' => $plan_number,
                'parcel_number' => $parcel_number,
                'municipality_ns' => $municipality_ns,
                'subdivision_number' => $subdivision_number,
                'parcel_number_ns' => $parcel_number_ns,

                'applicant_nin' => $applicant_nin,
                'applicant_lastname' => $applicant_lastname,
                'applicant_firstname' => $applicant_firstname,
                'applicant_father' => $applicant_father,
                'applicant_email' => $applicant_email,
                'applicant_phone' => $applicant_phone,

                'owner_nin' => $owner_nin,
                'owner_lastname' => $owner_lastname,
                'owner_firstname' => $owner_firstname,
                'owner_father' => $owner_father,
                'owner_birthdate' => $owner_birthdate,
                'owner_birthplace' => $owner_birthplace,
            ]);

            DB::commit();

            return redirect()->back()->with('success', '✓ تم تسجيل الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠ حدث خطأ أثناء حفظ الطلب: ' . $e->getMessage());
        }
    }
        // ========== دوال API لـ Flutter ==========
    
    /**
     * استقبال طلب بطاقة عقارية من تطبيق Flutter
     */
    public function apiStore(Request $request)
{
    try {
        $validated = $request->validate([
            'applicant_type' => 'required|string',
            'owner_type' => 'required|string',
            'card_type' => 'required|string',
            'property_status' => 'required|string',
            
            // معلومات مقدم الطلب (كلها nullable)
            'applicant_nin' => 'nullable|string',
            'applicant_lastname' => 'nullable|string',
            'applicant_firstname' => 'nullable|string',
            'applicant_father' => 'nullable|string',
            'applicant_email' => 'nullable|email',
            'applicant_phone' => 'nullable|string',
            
            // معلومات صاحب الملكية (شخص)
            'owner_nin' => 'nullable|string',
            'owner_lastname' => 'nullable|string',
            'owner_firstname' => 'nullable|string',
            'owner_father' => 'nullable|string',
            'owner_birthdate' => 'nullable|date',
            'owner_birthplace' => 'nullable|string',
            
            // معلومات صاحب الملكية (مؤسسة)
            'owner_company_name' => 'nullable|string',
            'owner_company_nin' => 'nullable|string',
            'owner_company_representative' => 'nullable|string',
            'owner_company_email' => 'nullable|email',
            'owner_company_phone' => 'nullable|string',
            
            // معلومات العقار
            'section' => 'nullable|string',
            'municipality' => 'nullable|string',
            'plan_number' => 'nullable|string',
            'parcel_number' => 'nullable|string',
            'municipality_ns' => 'nullable|string',
            'subdivision_number' => 'nullable|string',
            'parcel_number_ns' => 'nullable|string',
        ]);

        DB::beginTransaction();

        // تجهيز بيانات الطالب (بنفس طريقة دالة store)
        if ($request->applicant_type === 'person') {
            $applicant_nin = $request->applicant_nin ?? '-';
            $applicant_lastname = $request->applicant_lastname ?? '-';
            $applicant_firstname = $request->applicant_firstname ?? '-';
            $applicant_father = $request->applicant_father ?? '-';
            $applicant_email = $request->applicant_email ?? '-';
            $applicant_phone = $request->applicant_phone ?? '-';
        } else {
            $applicant_nin = $request->company_nin ?? '-';
            $applicant_lastname = $request->company_name ?? '-';
            $applicant_firstname = $request->company_representative ?? '-';
            $applicant_father = '-';
            $applicant_email = $request->company_email ?? '-';
            $applicant_phone = $request->company_phone ?? '-';
        }

        // تجهيز بيانات صاحب الملكية
        if ($request->owner_type === 'person') {
            $owner_nin = $request->owner_nin ?? '-';
            $owner_lastname = $request->owner_lastname ?? '-';
            $owner_firstname = $request->owner_firstname ?? '-';
            $owner_father = $request->owner_father ?? '-';
            $owner_birthdate = $request->owner_birthdate ?? null;
            $owner_birthplace = $request->owner_birthplace ?? '-';
        } else {
            $owner_nin = $request->owner_company_nin ?? '-';
            $owner_lastname = $request->owner_company_name ?? '-';
            $owner_firstname = $request->owner_company_representative ?? '-';
            $owner_father = $request->owner_company_email ?? '-';
            $owner_birthdate = null;
            $owner_birthplace = $request->owner_company_phone ?? '-';
        }

        // تجهيز بيانات العقار
        if ($request->property_status === 'surveyed') {
            $section = $request->section ?? null;
            $municipality = $request->municipality ?? null;
            $plan_number = $request->plan_number ?? null;
            $parcel_number = $request->parcel_number ?? null;
            $municipality_ns = null;
            $subdivision_number = null;
            $parcel_number_ns = null;
        } else {
            $section = null;
            $municipality = null;
            $plan_number = null;
            $parcel_number = null;
            $municipality_ns = $request->municipality_ns ?? null;
            $subdivision_number = $request->subdivision_number ?? null;
            $parcel_number_ns = $request->parcel_number_ns ?? null;
        }

        // إنشاء الطلب
        $documentsRequest = DocumentsRequest::create([
            'applicant_type' => $request->applicant_type,
            'owner_type' => $request->owner_type,
            'type' => $request->applicant_type,
            'request_type' => $request->owner_type,
            'status' => 'pending',
            'card_type' => $request->card_type,
            'property_status' => $request->property_status,

            'section' => $section,
            'municipality' => $municipality,
            'plan_number' => $plan_number,
            'parcel_number' => $parcel_number,
            'municipality_ns' => $municipality_ns,
            'subdivision_number' => $subdivision_number,
            'parcel_number_ns' => $parcel_number_ns,

            'applicant_nin' => $applicant_nin,
            'applicant_lastname' => $applicant_lastname,
            'applicant_firstname' => $applicant_firstname,
            'applicant_father' => $applicant_father,
            'applicant_email' => $applicant_email,
            'applicant_phone' => $applicant_phone,

            'owner_nin' => $owner_nin,
            'owner_lastname' => $owner_lastname,
            'owner_firstname' => $owner_firstname,
            'owner_father' => $owner_father,
            'owner_birthdate' => $owner_birthdate,
            'owner_birthplace' => $owner_birthplace,
        ]);

        // ✅ حفظ في جدول user_requests (ربط مع المستخدم)
        if (auth()->check()) {
            \App\Models\UserRequest::create([
                'user_id' => auth()->id(),
                'type' => 'real_estate_card',
                'status' => 'pending',
                'data' => json_encode($documentsRequest->toArray())
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال طلب البطاقة العقارية بنجاح',
            'request' => $documentsRequest
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'خطأ في البيانات',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        \Illuminate\Support\Facades\Log::error('🔥 خطأ في حفظ طلب البطاقة العقارية: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * جلب كل طلبات البطاقات العقارية لتطبيق Flutter
     */
    public function apiIndex()
    {
        $requests = DocumentsRequest::orderBy('created_at', 'desc')->get();
        return response()->json($requests);
    }

    /**
     * جلب طلب واحد لتطبيق Flutter
     */
    public function apiShow($id)
    {
        $request = DocumentsRequest::findOrFail($id);
        return response()->json($request);
    }
    
}