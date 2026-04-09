<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NegativeCertificate;
use Illuminate\Support\Facades\DB;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Log;

class NegativeCertificateController extends Controller
{
    public function new()
    {
        return view('negative.new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_lastname' => 'required',
            'owner_firstname' => 'required',
            'email' => 'required|email',
        ]);

        NegativeCertificate::create([
            'owner_lastname' => $request->owner_lastname,
            'owner_firstname' => $request->owner_firstname,
            'owner_father' => $request->owner_father,
            'owner_birthdate' => $request->owner_birthdate,
            'owner_birthplace' => $request->owner_birthplace,
            'applicant_lastname' => $request->applicant_lastname,
            'applicant_firstname' => $request->applicant_firstname,
            'applicant_father' => $request->applicant_father,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type ?? 'جديدة',
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success','تم إرسال طلبك وسيتم معالجته من طرف الإدارة');
    }
    
    /**
     * استقبال طلب من تطبيق Flutter
     */
    public function apiStore(Request $request)
    {
         Log::info('🔍 Headers: ' . json_encode($request->header()));
    Log::info('🔍 التوكن المرسل: ' . $request->bearerToken());
    Log::info('🔍 هل المستخدم مسجل؟ ' . (auth()->check() ? 'نعم' : 'لا'));
        $validated = $request->validate([
            'owner_lastname'      => 'required|string|max:255',
            'owner_firstname'     => 'required|string|max:255',
            'owner_father'        => 'nullable|string|max:255',
            'owner_birthdate'     => 'nullable|date',
            'owner_birthplace'    => 'nullable|string|max:255',
            'applicant_lastname'  => 'nullable|string|max:255',
            'applicant_firstname' => 'nullable|string|max:255',
            'applicant_father'    => 'nullable|string|max:255',
            'email'               => 'required|email|max:255',
            'phone'               => 'required|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            $certificate = NegativeCertificate::create([
                'owner_lastname'      => $request->owner_lastname,
                'owner_firstname'     => $request->owner_firstname,
                'owner_father'        => $request->owner_father,
                'owner_birthdate'     => $request->owner_birthdate,
                'owner_birthplace'    => $request->owner_birthplace,
                'applicant_lastname'  => $request->applicant_lastname,
                'applicant_firstname' => $request->applicant_firstname,
                'applicant_father'    => $request->applicant_father,
                'email'               => $request->email,
                'phone'               => $request->phone,
                'status'              => 'pending',
            ]);

            // ✅ تسجيل معلومات للمساعدة في التصحيح
            Log::info('محاولة حفظ الطلب في user_requests', [
                'user_check' => auth()->check(),
                'user_id' => auth()->id(),
                'certificate_id' => $certificate->id
            ]);

            // ✅ حفظ في جدول user_requests إذا كان المستخدم مسجل دخول
            // ✅ حفظ في جدول user_requests إذا كان المستخدم مسجل دخول
if (auth()->check()) {
    Log::info('🔍 user_id: ' . auth()->id());
    Log::info('📝 بيانات الطلب: ' . json_encode($certificate->toArray()));
    
    // ✅ حفظ في جدول user_requests (المستخدم مسجل أكيد)
// ✅ حفظ في جدول user_requests
if (auth()->check()) {
    UserRequest::create([
        'user_id' => auth()->id(),
        'type' => 'negative_certificate',
        'status' => 'pending',
        'data' => json_encode($certificate->toArray())
    ]);
    
    Log::info('✅ تم حفظ الطلب في user_requests للمستخدم ' . auth()->id());
}
    
            } else {
                Log::warning('⚠️ المستخدم غير مسجل دخول، لم يتم حفظ الطلب في user_requests');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الطلب بنجاح',
                'certificate' => $certificate
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🔥 خطأ في حفظ الطلب: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * جلب كل الطلبات لتطبيق Flutter
     */
    public function apiIndex()
    {
        $certificates = NegativeCertificate::orderBy('created_at', 'desc')->get();
        return response()->json($certificates);
    }

    /**
     * جلب طلب واحد لتطبيق Flutter
     */
    public function apiShow($id)
    {
        $certificate = NegativeCertificate::findOrFail($id);
        return response()->json($certificate);
    }
}