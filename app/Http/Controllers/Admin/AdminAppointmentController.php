<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Mail\AppointmentStatusMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminAppointmentController extends Controller
{
    /**
     * عرض قائمة جميع المواعيد
     */
    public function index()
    {
        $appointments = Appointment::with('user')
            ->orderBy('booking_date', 'desc')
            ->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * عرض تفاصيل موعد محدد
     */
    public function show($id)
    {
        $appointment = Appointment::with('user')->findOrFail($id);
        
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * عرض صفحة معالجة الموعد
     */
    public function process($id)
    {
        $appointment = Appointment::with('user')->findOrFail($id);
        
        // التحقق من أن الموعد في حالة pending
        if ($appointment->status != 'pending') {
            return redirect()->route('admin.appointments.show', $id)
                ->with('error', 'هذا الموعد تمت معالجته مسبقاً');
        }
        
        return view('admin.appointments.process', compact('appointment'));
    }

    /**
     * تحديث حالة الموعد (من صفحة المعالجة)
     */
   public function updateStatus(Request $request, $id)
{
    $request->validate([
        'decision' => 'required|in:confirmed,cancelled',
        'admin_notes' => 'nullable|string|max:1000',
        'confirmation_message' => 'nullable|string'
    ]);

    $appointment = Appointment::findOrFail($id);
$generatedMessage = $request->decision == 'confirmed'
    ? "تم تأكيد موعدك بتاريخ " . $appointment->booking_date->format('Y/m/d')
    : "تم إلغاء موعدك بتاريخ " . $appointment->booking_date->format('Y/m/d');

$appointment->update([
    'status' => $request->decision,
    'admin_notes' => $request->admin_notes,
    'confirmation_message' => $generatedMessage
]);

    $adminNotes = $request->admin_notes ?? null;

    $this->sendEmail(
        $appointment,
        $request->decision,
        $adminNotes
    );

    $message = $request->decision == 'confirmed'
        ? 'تم تأكيد الموعد وإرسال إيميل للعميل ✅'
        : 'تم إلغاء الموعد وإرسال إيميل للعميل ❌';

    return redirect()->route('admin.appointments.show', $id)
        ->with('success', $message);
}
    /**
     * تأكيد الموعد (مباشرة من القائمة)
     */
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'confirmed']);
        
        $this->sendEmail($appointment, 'confirmed', 'تم تأكيد موعدك بنجاح');
        
        return redirect()->back()->with('success', 'تم تأكيد الموعد وإرسال إيميل للعميل ✅');
    }

    /**
     * إلغاء الموعد (مباشرة من القائمة)
     */
    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'cancelled']);
        
        $adminNotes = $request->input('cancellation_reason', null);
        $this->sendEmail($appointment, 'cancelled', $adminNotes);
        
        return redirect()->back()->with('success', 'تم إلغاء الموعد وإرسال إيميل للعميل ❌');
    }

    /**
     * إتمام الموعد
     */
    public function complete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => 'completed']);
        
        $this->sendEmail($appointment, 'completed', 'تم إتمام معاملتك بنجاح');
        
        return redirect()->back()->with('success', 'تم إتمام الموعد وإرسال إيميل للعميل ✓');
    }

    /**
     * حذف الموعد
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        
        return redirect()->route('admin.appointments.index')
            ->with('success', 'تم حذف الموعد بنجاح 🗑️');
    }

    /**
     * دالة مساعدة لإرسال الإيميلات
     */
    private function sendEmail($appointment, $status, $adminNotes = null)
    {
        try {
            // الحصول على اسم المستخدم
            $userName = $appointment->user 
                ? $appointment->user->name 
                : $appointment->firstname . ' ' . $appointment->lastname;
                
            // الحصول على الإيميل
            $email = $appointment->user 
                ? $appointment->user->email 
                : $appointment->email;
            
            // إرسال الإيميل
            if ($email) {
                Mail::to($email)->send(new AppointmentStatusMail(
                    $appointment, 
                    $status, 
                    $userName, 
                    $adminNotes
                ));
                
                \Log::info("Email sent successfully to: {$email} for appointment #{$appointment->id}");
            }
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }
    }

    /**
     * إحصائيات المواعيد (اختياري - للاستخدام المستقبلي)
     */
    public function statistics()
    {
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'today' => Appointment::whereDate('booking_date', today())->count(),
            'this_week' => Appointment::whereBetween('booking_date', [
                now()->startOfWeek(), 
                now()->endOfWeek()
            ])->count(),
            'this_month' => Appointment::whereMonth('booking_date', now()->month)
                ->whereYear('booking_date', now()->year)
                ->count(),
        ];

        return response()->json($stats);
    }
}