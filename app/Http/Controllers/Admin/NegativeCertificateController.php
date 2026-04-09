<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\NegativeCertificate;
use Illuminate\Support\Facades\DB;

class NegativeCertificateController extends Controller
{










    /**
     * عرض صفحة طلب شهادة سلبية جديدة
     */
    public function new()
    {
        return view('negative.new');
    }

    /**
     * عرض صفحة إعادة استخراج شهادة سلبية
     */
    public function reprint()
    {
        return view('negative.reprint');
    }

    /**
     * حفظ طلب شهادة سلبية جديدة
     */
    public function store(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            // بيانات صاحب الملكية
            'owner_lastname'      => 'required|string|max:255',
            'owner_firstname'     => 'required|string|max:255',
            'owner_father'        => 'nullable|string|max:255',
            'owner_birthdate'     => 'nullable|date',
            'owner_birthplace'    => 'nullable|string|max:255',
            
            // بيانات مقدم الطلب
            'applicant_lastname'  => 'required|string|max:255',
            'applicant_firstname' => 'required|string|max:255',
            'applicant_father'    => 'nullable|string|max:255',
            
            // معلومات الاتصال
            'email'               => 'required|email|max:255',
            'phone'               => 'required|string|max:20',
        ], [
            // رسائل مخصصة بالعربية
            'owner_lastname.required'      => 'اسم العائلة لصاحب الملكية مطلوب',
            'owner_firstname.required'     => 'الاسم الأول لصاحب الملكية مطلوب',
            'applicant_lastname.required'  => 'اسم العائلة لمقدم الطلب مطلوب',
            'applicant_firstname.required' => 'الاسم الأول لمقدم الطلب مطلوب',
            'email.required'               => 'البريد الإلكتروني مطلوب',
            'email.email'                  => 'صيغة البريد الإلكتروني غير صحيحة',
            'phone.required'               => 'رقم الهاتف مطلوب',
        ]);

        try {
            DB::beginTransaction();

            // إنشاء الطلب
            $certificate = NegativeCertificate::create([
                // بيانات صاحب الملكية
                'owner_lastname'      => $request->owner_lastname,
                'owner_firstname'     => $request->owner_firstname,
                'owner_father'        => $request->owner_father,
                'owner_birthdate'     => $request->owner_birthdate,
                'owner_birthplace'    => $request->owner_birthplace,

                // بيانات مقدم الطلب
                'applicant_lastname'  => $request->applicant_lastname,
                'applicant_firstname' => $request->applicant_firstname,
                'applicant_father'    => $request->applicant_father,

                // معلومات الاتصال
                'email'  => $request->email,
                'phone'  => $request->phone,

                // معلومات الطلب
                'type'   => 'new', // جديدة
                'status' => 'pending', // قيد الانتظار
                'request_number' => $this->generateRequestNumber(),
                'user_id' => auth()->id(), // إذا كان المستخدم مسجل دخول
            ]);

            DB::commit();

            // إرسال إشعار بالبريد (اختياري)
            // Mail::to($request->email)->send(new NegativeCertificateCreated($certificate));

            return redirect()
                ->back()
                ->with('success', '✅ تم إرسال طلبك بنجاح برقم: ' . $certificate->request_number . ' - سيتم معالجته من طرف الإدارة');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠ حدث خطأ أثناء إرسال الطلب: ' . $e->getMessage());
        }
    }

    /**
     * البحث عن شهادة لإعادة استخراجها
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'search_type' => 'required|in:request_number,nin,name',
            'search_value' => 'required|string',
        ], [
            'search_type.required' => 'يجب اختيار نوع البحث',
            'search_value.required' => 'يجب إدخال قيمة البحث',
        ]);

        $query = NegativeCertificate::query();

        switch ($request->search_type) {
            case 'request_number':
                $query->where('request_number', $request->search_value);
                break;
            
            case 'nin':
                $query->where('owner_nin', $request->search_value);
                break;
            
            case 'name':
                $query->where(function($q) use ($request) {
                    $q->where('owner_lastname', 'like', '%' . $request->search_value . '%')
                      ->orWhere('owner_firstname', 'like', '%' . $request->search_value . '%');
                });
                break;
        }

        $certificates = $query->where('status', 'approved')->get();

        if ($certificates->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', '⚠ لم يتم العثور على شهادات');
        }

        return view('negative.reprint', compact('certificates'));
    }

    /**
     * عرض تفاصيل الشهادة
     */
    public function show($id)
    {
        $certificate = NegativeCertificate::findOrFail($id);

        // التحقق من الصلاحية
        if (auth()->check() && auth()->id() !== $certificate->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح لك بعرض هذه الشهادة');
        }

        return view('negative.show', compact('certificate'));
    }

    /**
     * تنزيل الشهادة كـ PDF
     */
    public function download($id)
    {
        $certificate = NegativeCertificate::findOrFail($id);

        // التحقق من أن الشهادة موافق عليها
        if ($certificate->status !== 'approved') {
            return redirect()
                ->back()
                ->with('error', '⚠ لا يمكن تنزيل الشهادة قبل الموافقة عليها');
        }

        // التحقق من الصلاحية
        if (auth()->check() && auth()->id() !== $certificate->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'غير مصرح لك بتنزيل هذه الشهادة');
        }

        // TODO: Generate PDF
        return redirect()->back()->with('info', 'قريباً: تنزيل الشهادة بصيغة PDF');
    }

    /**
     * طباعة الشهادة
     */
    public function print($id)
    {
        $certificate = NegativeCertificate::findOrFail($id);

        // التحقق من أن الشهادة موافق عليها
        if ($certificate->status !== 'approved') {
            return redirect()
                ->back()
                ->with('error', '⚠ لا يمكن طباعة الشهادة قبل الموافقة عليها');
        }

        return view('negative.print', compact('certificate'));
    }

    /**
     * إعادة استخراج شهادة
     */
    public function reprintStore(Request $request)
    {
        $validated = $request->validate([
            'certificate_id' => 'required|exists:negative_certificates,id',
            'email' => 'required|email',
            'phone' => 'required|string',
        ], [
            'certificate_id.required' => 'يجب اختيار الشهادة',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
        ]);

        try {
            $originalCertificate = NegativeCertificate::findOrFail($request->certificate_id);

            // إنشاء طلب إعادة استخراج
            $newCertificate = NegativeCertificate::create([
                'owner_lastname'      => $originalCertificate->owner_lastname,
                'owner_firstname'     => $originalCertificate->owner_firstname,
                'owner_father'        => $originalCertificate->owner_father,
                'owner_birthdate'     => $originalCertificate->owner_birthdate,
                'owner_birthplace'    => $originalCertificate->owner_birthplace,
                'applicant_lastname'  => $originalCertificate->applicant_lastname,
                'applicant_firstname' => $originalCertificate->applicant_firstname,
                'applicant_father'    => $originalCertificate->applicant_father,
                'email'               => $request->email,
                'phone'               => $request->phone,
                'type'                => 'reprint', // إعادة استخراج
                'status'              => 'pending',
                'request_number'      => $this->generateRequestNumber(),
                'original_certificate_id' => $originalCertificate->id,
                'user_id'             => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->with('success', '✅ تم إرسال طلب إعادة الاستخراج برقم: ' . $newCertificate->request_number);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تتبع حالة الطلب
     */
    public function track(Request $request)
    {
        $validated = $request->validate([
            'request_number' => 'required|string',
        ], [
            'request_number.required' => 'رقم الطلب مطلوب',
        ]);

        $certificate = NegativeCertificate::where('request_number', $request->request_number)->first();

        if (!$certificate) {
            return redirect()
                ->back()
                ->with('error', '⚠ لم يتم العثور على طلب بهذا الرقم');
        }

        return view('negative.track', compact('certificate'));
    }

    // ==================== Helper Methods ====================

    /**
     * توليد رقم طلب فريد
     */
    private function generateRequestNumber()
    {
        $year = date('Y');
        $lastCertificate = NegativeCertificate::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastCertificate ? ((int) substr($lastCertificate->request_number, -5)) + 1 : 1;
        
        return sprintf('%s/NC/%05d', $year, $sequence);
    }

    /**
     * الحصول على نص الحالة
     */
    public static function getStatusText($status)
    {
        $statuses = [
            'pending' => 'قيد الانتظار',
            'processing' => 'قيد المعالجة',
            'approved' => 'موافق عليها',
            'rejected' => 'مرفوضة',
            'completed' => 'مكتملة',
        ];
        
        return $statuses[$status] ?? $status;
    }
    

    /**
     * الحصول على نص النوع
     */
    public static function getTypeText($type)
    {
        $types = [
            'new' => 'طلب جديد',
            'reprint' => 'إعادة استخراج',
        ];
        
        return $types[$type] ?? $type;
    }



    
}
