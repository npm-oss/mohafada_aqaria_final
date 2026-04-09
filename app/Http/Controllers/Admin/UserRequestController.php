<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRequest; // ✅ تغيير هنا (بدون alias)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRequestController extends Controller
{
    /**
     * عرض قائمة جميع الطلبات
     */
    public function index()
    {
        $requests = UserRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // للـ Dashboard - إحصائيات
        $stats = [
            'new' => UserRequest::where('status', 'new')->count(),
            'processing' => UserRequest::where('status', 'processing')->count(),
            'approved' => UserRequest::where('status', 'approved')->count(),
            'rejected' => UserRequest::where('status', 'rejected')->count(),
        ];
        
        // إذا كان الطلب عبر AJAX
        if (request()->ajax()) {
            return view('admin.pages.requests-content', compact('requests', 'stats'));
        }
        
        return view('admin.requests.index', compact('requests', 'stats'));
    }

    /**
     * عرض طلب واحد بالتفصيل
     */
    public function show($id)
    {
        $request = UserRequest::with('user')->findOrFail($id);
        
        if (request()->ajax()) {
            return view('admin.pages.requests-show-content', compact('request'));
        }
        
        return view('admin.requests.show', compact('request'));
    }

    // ... باقي الدوال كما هي مع تغيير كل `UserRequest` بدل `Request as UserRequest`


    /**
     * عرض طلب واحد بالتفصيل
     */
  
    /**
     * عرض صفحة إنشاء طلب جديد
     */
    public function create()
    {
        if (request()->ajax()) {
            return view('admin.pages.requests-create-content');
        }
        
        return view('admin.requests.create');
    }

    /**
     * حفظ طلب جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'request_type' => 'required|string',
            'description' => 'nullable|string|max:1000',
        ], [
            'user_id.required' => 'يجب اختيار المستخدم',
            'type.required' => 'يجب اختيار نوع الطلب',
            'request_type.required' => 'يجب اختيار نوع الخدمة',
        ]);

        try {
            DB::beginTransaction();

            $userRequest = UserRequest::create([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'request_type' => $request->request_type,
                'status' => 'new',
                'description' => $request->description,
                'request_number' => $this->generateRequestNumber(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.requests.show', $userRequest->id)
                ->with('success', '✓ تم إنشاء الطلب بنجاح برقم: ' . $userRequest->request_number);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠ حدث خطأ أثناء الحفظ: ' . $e->getMessage());
        }
    }

    /**
     * عرض صفحة تعديل الطلب
     */
    public function edit($id)
    {
        $request = UserRequest::with('user')->findOrFail($id);
        
        if (request()->ajax()) {
            return view('admin.pages.requests-edit-content', compact('request'));
        }
        
        return view('admin.requests.edit', compact('request'));
    }

    /**
     * تحديث حالة الطلب
     */
    public function update(Request $request, $id)
    {
        $userRequest = UserRequest::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:new,processing,approved,rejected,completed',
            'notes' => 'nullable|string|max:1000',
        ], [
            'status.required' => 'يجب اختيار حالة الطلب',
        ]);

        try {
            $updateData = [
                'status' => $request->status,
                'notes' => $request->notes,
                'updated_by' => auth()->id(),
            ];

            // إذا تمت الموافقة
            if ($request->status === 'approved') {
                $updateData['approved_at'] = now();
                $updateData['approved_by'] = auth()->id();
            }

            // إذا تم الرفض
            if ($request->status === 'rejected') {
                $updateData['rejected_at'] = now();
                $updateData['rejected_by'] = auth()->id();
                $updateData['rejection_reason'] = $request->rejection_reason;
            }

            // إذا تم الإكمال
            if ($request->status === 'completed') {
                $updateData['completed_at'] = now();
            }

            $userRequest->update($updateData);

            return redirect()
                ->route('admin.requests.show', $id)
                ->with('success', '✓ تم تحديث حالة الطلب بنجاح');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

    /**
     * حذف طلب
     */
    public function destroy($id)
    {
        try {
            $userRequest = UserRequest::findOrFail($id);
            $userRequest->delete();

            return redirect()
                ->route('admin.requests.index')
                ->with('success', '✓ تم حذف الطلب بنجاح');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ أثناء الحذف: ' . $e->getMessage());
        }
    }

    /**
     * الموافقة السريعة على الطلب
     */
    public function approve($id)
    {
        try {
            $userRequest = UserRequest::findOrFail($id);
            
            $userRequest->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->with('success', '✓ تمت الموافقة على الطلب بنجاح');

        } catch (\Exception $e) {
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
            'rejection_reason' => 'required|string|max:500',
        ], [
            'rejection_reason.required' => 'يجب إدخال سبب الرفض',
        ]);

        try {
            $userRequest = UserRequest::findOrFail($id);
            
            $userRequest->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'rejected_by' => auth()->id(),
                'rejection_reason' => $request->rejection_reason,
            ]);

            return redirect()
                ->back()
                ->with('success', '✓ تم رفض الطلب');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تغيير الحالة إلى "قيد المعالجة"
     */
    public function process($id)
    {
        try {
            $userRequest = UserRequest::findOrFail($id);
            
            $userRequest->update([
                'status' => 'processing',
                'processing_at' => now(),
                'processing_by' => auth()->id(),
            ]);

            return redirect()
                ->back()
                ->with('success', '✓ تم تحويل الطلب لقيد المعالجة');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تغيير الحالة إلى "مكتمل"
     */
    public function complete($id)
    {
        try {
            $userRequest = UserRequest::findOrFail($id);
            
            $userRequest->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            return redirect()
                ->back()
                ->with('success', '✓ تم إكمال الطلب بنجاح');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * البحث في الطلبات
     */
    public function search(Request $request)
    {
        $query = UserRequest::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);

        if (request()->ajax()) {
            return view('admin.pages.requests-content', compact('requests'));
        }

        return view('admin.requests.index', compact('requests'));
    }

    /**
     * فلترة الطلبات حسب الحالة
     */
    public function filterByStatus($status)
    {
        $requests = UserRequest::with('user')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        if (request()->ajax()) {
            return view('admin.pages.requests-content', compact('requests'));
        }
        
        return view('admin.requests.index', compact('requests'));
    }

    /**
     * إحصائيات الطلبات
     */
    public function statistics()
    {
        $stats = [
            'total' => UserRequest::count(),
            'new' => UserRequest::where('status', 'new')->count(),
            'processing' => UserRequest::where('status', 'processing')->count(),
            'approved' => UserRequest::where('status', 'approved')->count(),
            'rejected' => UserRequest::where('status', 'rejected')->count(),
            'completed' => UserRequest::where('status', 'completed')->count(),
            'today' => UserRequest::whereDate('created_at', today())->count(),
            'this_week' => UserRequest::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => UserRequest::whereMonth('created_at', now()->month)->count(),
            'this_year' => UserRequest::whereYear('created_at', now()->year)->count(),
        ];

        if (request()->ajax()) {
            return response()->json($stats);
        }

        return view('admin.requests.statistics', compact('stats'));
    }

    /**
     * طباعة الطلب
     */
    public function print($id)
    {
        $request = UserRequest::with('user')->findOrFail($id);
        return view('admin.requests.print', compact('request'));
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
     * تنزيل PDF
     */
    public function downloadPdf($id)
    {
        // TODO: Implement PDF generation
        return redirect()->back()->with('info', 'قريباً: تنزيل PDF');
    }

    // ==================== Helper Methods ====================

    /**
     * توليد رقم طلب فريد
     */
    private function generateRequestNumber()
    {
        $year = date('Y');
        $lastRequest = UserRequest::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastRequest ? ((int) substr($lastRequest->request_number, -5)) + 1 : 1;
        
        return sprintf('%s/REQ/%05d', $year, $sequence);
    }

    /**
     * الحصول على نص الحالة بالعربي
     */
    public static function getStatusText($status)
    {
        $statuses = [
            'new' => 'جديد',
            'processing' => 'قيد المعالجة',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            'completed' => 'مكتمل',
        ];
        
        return $statuses[$status] ?? $status;
    }

    /**
     * الحصول على لون الحالة
     */
    public static function getStatusColor($status)
    {
        $colors = [
            'new' => 'info',
            'processing' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'completed' => 'primary',
        ];
        
        return $colors[$status] ?? 'secondary';
    }
}