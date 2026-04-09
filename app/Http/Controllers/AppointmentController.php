<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\UserRequest; // ✅ إضافة هذا
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // ✅ للتسجيل

class AppointmentController extends Controller
{
    /**
     * عرض صفحة حجز الموعد
     */
    public function index()
    {
        // ✅ استخدام appointment.blade.php (مفرد)
        return view('appointment');
    }

    /**
     * حفظ موعد جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'service_type' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $bookingDate = \Carbon\Carbon::parse($validated['booking_date']);
        if ($bookingDate->dayOfWeek !== 1 && $bookingDate->dayOfWeek !== 3) {
            return response()->json([
                'success' => false,
                'message' => 'الحجز متاح فقط يومي الاثنين والأربعاء'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // إضافة user_id إذا كان المستخدم مسجل دخول
            if (auth()->check()) {
                $validated['user_id'] = auth()->id();
            }

            // ✅ حفظ في جدول appointments
            $appointment = Appointment::create($validated);

            // ✅ حفظ في جدول user_requests (ربط مع المستخدم)
            if (auth()->check()) {
                UserRequest::create([
                    'user_id' => auth()->id(),
                    'type' => 'appointment',
                    'status' => 'pending',
                    'data' => json_encode($appointment->toArray())
                ]);
                
                Log::info('✅ تم حفظ طلب الموعد في user_requests للمستخدم ' . auth()->id());
            } else {
                Log::warning('⚠️ المستخدم غير مسجل دخول، لم يتم حفظ طلب الموعد في user_requests');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم الحجز بنجاح',
                'appointment' => $appointment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🔥 خطأ في حفظ طلب الموعد: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}