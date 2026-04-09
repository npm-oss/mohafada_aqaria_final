<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NegativeCertificate;

use Illuminate\Support\Facades\DB;
class NegativeCertificateAdminController extends Controller
{
    // 1️⃣ قائمة جميع الطلبات
    public function index(Request $request)
    {
        $query = NegativeCertificate::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('owner_firstname', 'like', "%{$search}%")
                  ->orWhere('owner_lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('request_number', 'like', "%{$search}%");
            });
        }

        $certificates = $query->paginate(20);
        
        return view('admin.certificates.index', compact('certificates'));
    }

    // 2️⃣ عرض طلب واحد
    public function show($id)
    {
        $certificate = NegativeCertificate::findOrFail($id);
        return view('admin.certificates.show', compact('certificate'));
    }

    // 3️⃣ صفحة معالجة الطلب
    public function process($id)
    {
        try {
            DB::beginTransaction();

            $certificate = NegativeCertificate::findOrFail($id);

            // تغيير الحالة مباشرة عند الدخول لصفحة المعالجة
            if ($certificate->status === 'pending') {
                $certificate->status = 'processing';
                $certificate->save();
            }

            DB::commit();

            return view('admin.certificates.process', compact('certificate'));

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->route('admin.certificates.index')
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    // 3.1️⃣ تحديث بيانات الحقول أثناء المعالجة
    public function updateFields(Request $request, $id)
    {
        $validated = $request->validate([
            'owner_lastname'    => 'required|string|max:255',
            'owner_firstname'   => 'required|string|max:255',
            'owner_father'      => 'nullable|string|max:255',
            'gender'            => 'required|string|in:ذكر,أنثى',
            'owner_birthdate'   => 'nullable|date',
            'owner_birthplace'  => 'nullable|string|max:255',
            'state'             => 'nullable|string|max:255',
            'municipality'      => 'nullable|string|max:255',
        ], [
            'owner_lastname.required' => 'اللقب مطلوب',
            'owner_firstname.required' => 'الاسم مطلوب',
            'gender.required' => 'الجنس مطلوب',
        ]);

        try {
            DB::beginTransaction();

            $certificate = NegativeCertificate::findOrFail($id);
            
            $certificate->update($validated);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', '✓ تم تحديث بيانات المواطن بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠ حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

    // 4️⃣ قبول الطلب
    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $certificate = NegativeCertificate::findOrFail($id);
            $certificate->status = 'approved';
            $certificate->approved_at = now();
            $certificate->approved_by = auth()->id();
            $certificate->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('success', '✓ تم قبول الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    // 5️⃣ رفض الطلب
    public function reject(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $certificate = NegativeCertificate::findOrFail($id);
            $certificate->status = 'rejected';
            $certificate->rejected_at = now();
            $certificate->rejected_by = auth()->id();
            $certificate->rejection_reason = $request->rejection_reason ?? null;
            $certificate->save();

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

    // 6️⃣ استخراج الشهادة
    public function extract($id)
    {
        try {
            DB::beginTransaction();

            $certificate = NegativeCertificate::findOrFail($id);
            
            if ($certificate->status !== 'approved') {
                return redirect()
                    ->back()
                    ->with('error', '⚠ لا يمكن استخراج الشهادة قبل الموافقة عليها');
            }

            $certificate->status = 'extracted';
            $certificate->extracted_at = now();
            $certificate->save();

            DB::commit();

            // يمكن توليد PDF هنا إذا تحبي
            // return PDF::loadView('admin.certificates.pdf', compact('certificate'))->stream();

            return redirect()
                ->back()
                ->with('success', '✓ تم استخراج الشهادة بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    // 7️⃣ إنشاء شهادة جديدة
    public function create()
    {
        return view('admin.certificates.create');
    }

    // 8️⃣ تخزين شهادة جديدة
    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_lastname' => 'required|string|max:255',
            'owner_firstname' => 'required|string|max:255',
            'applicant_lastname' => 'required|string|max:255',
            'applicant_firstname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ], [
            'owner_lastname.required' => 'لقب صاحب الملكية مطلوب',
            'owner_firstname.required' => 'اسم صاحب الملكية مطلوب',
            'applicant_lastname.required' => 'لقب مقدم الطلب مطلوب',
            'applicant_firstname.required' => 'اسم مقدم الطلب مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'phone.required' => 'رقم الهاتف مطلوب',
        ]);

        try {
            DB::beginTransaction();

            NegativeCertificate::create($validated);

            DB::commit();

            return redirect()
                ->route('admin.certificates.index')
                ->with('success', '✓ تمت إضافة الشهادة بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    // 9️⃣ أرشفة الطلب
    public function archive($id)
    {
        try {
            DB::beginTransaction();

            $certificate = NegativeCertificate::findOrFail($id);
            $certificate->status = 'archived';
            $certificate->archived_at = now();
            $certificate->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('success', '✓ تم أرشفة الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    // 🔟 حذف الطلب
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $certificate = NegativeCertificate::findOrFail($id);
            $certificate->delete();

            DB::commit();

            return redirect()
                ->route('admin.certificates.index')
                ->with('success', '✓ تم حذف الطلب بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ أثناء الحذف: ' . $e->getMessage());
        }
    }

    // 1️⃣1️⃣ إحصائيات الشهادات
    public function statistics()
    {
        $stats = [
            'total' => NegativeCertificate::count(),
            'pending' => NegativeCertificate::where('status', 'pending')->count(),
            'processing' => NegativeCertificate::where('status', 'processing')->count(),
            'approved' => NegativeCertificate::where('status', 'approved')->count(),
            'rejected' => NegativeCertificate::where('status', 'rejected')->count(),
            'extracted' => NegativeCertificate::where('status', 'extracted')->count(),
            'archived' => NegativeCertificate::where('status', 'archived')->count(),
            'today' => NegativeCertificate::whereDate('created_at', today())->count(),
            'this_week' => NegativeCertificate::whereBetween('created_at', [
                now()->startOfWeek(), 
                now()->endOfWeek()
            ])->count(),
            'this_month' => NegativeCertificate::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.certificates.statistics', compact('stats'));
    }

    // 1️⃣2️⃣ تصدير إلى Excel
    public function export()
    {
        // TODO: Implement Excel export
        return redirect()->back()->with('info', 'قريباً: تصدير إلى Excel');
    }
    
/**
 * عرض صفحة الاستخراج مع الصورتين
 */
public function showExtractForm($id)
{
    // ⭐ استخدمي NegativeCertificate مش Certificate
    $certificate = NegativeCertificate::findOrFail($id);
    
    return view('admin.certificates.extract', compact('certificate'));
}

/**
 * حفظ البيانات المستخرجة
 */
public function saveExtractedData(Request $request, $id)
{
    // ⭐ استخدمي NegativeCertificate مش Certificate
    $certificate = NegativeCertificate::findOrFail($id);

    // Validation
    $request->validate([
        'certificate_type' => 'required|in:negative,positive',
        'citizen_name' => 'required|string',
        'birth_info' => 'required|string',
        'father_name' => 'required|string',
        'mother_name' => 'required|string',
        'address' => 'required|string',
    ], [
        'certificate_type.required' => 'يجب اختيار نوع الشهادة',
        'citizen_name.required' => 'الاسم الكامل مطلوب',
        'birth_info.required' => 'تاريخ ومكان الميلاد مطلوب',
        'father_name.required' => 'اسم الأب مطلوب',
        'mother_name.required' => 'اسم الأم مطلوب',
        'address.required' => 'العنوان مطلوب',
    ]);

    // تحديث البيانات
    $certificate->update([
        'certificate_type' => $request->certificate_type,
        'citizen_name' => $request->citizen_name,
        'birth_info' => $request->birth_info,
        'father_name' => $request->father_name,
        'mother_name' => $request->mother_name,
        'address' => $request->address,
        'request_number' => $request->request_number,
        'receipt_number' => $request->receipt_number,
        'delivery_date' => $request->delivery_date,
        'notes' => $request->notes,
        'status' => 'معالج',
        
        // حفظ العقارات كـ JSON
        'properties_data' => $request->certificate_type === 'positive' && $request->has('properties')
            ? json_encode($request->properties, JSON_UNESCAPED_UNICODE)
            : null,
    ]);

    return redirect()
        ->route('admin.certificates.index')
        ->with('success', '✅ تم حفظ بيانات الشهادة بنجاح!');
}

};