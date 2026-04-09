<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\UserRequest; // ✅ إضافة هذا
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // ✅ للتسجيل

class ContactController extends Controller
{
    /**
     * عرض صفحة اتصل بنا
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * إرسال رسالة جديدة
     */
    public function send(Request $request)
    {
        // التحقق من البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|in:inquiry,complaint,suggestion,support,other',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'subject.required' => 'يجب اختيار الموضوع',
            'message.required' => 'الرسالة مطلوبة',
            'message.max' => 'الرسالة طويلة جداً (الحد الأقصى 1000 حرف)',
        ]);

        try {
            DB::beginTransaction();

            // حفظ الرسالة
            ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', '✅ تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠ حدث خطأ أثناء إرسال الرسالة: ' . $e->getMessage());
        }
    }

    /**
     * عرض صفحة تتبع الرسالة
     */
    public function track()
    {
        return view('contact.track');
    }

    /**
     * البحث عن رسالة
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'message_id' => 'nullable|integer',
        ]);

        $query = ContactMessage::where('email', $request->email);

        if ($request->filled('message_id')) {
            $query->where('id', $request->message_id);
        }

        $messages = $query->orderBy('created_at', 'desc')->get();

        if ($messages->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', '⚠ لم يتم العثور على رسائل بهذا البريد الإلكتروني');
        }

        return view('contact.track', compact('messages'));
    }
    
    // ═══════════════════════════════════════════════════════════
    // 📱 API Methods (لـ Flutter)
    // ═══════════════════════════════════════════════════════════

    /**
     * استقبال رسالة اتصال من تطبيق Flutter
     */
    public function apiStore(Request $request)
    {
        try {
            // التحقق من البيانات
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'required|in:inquiry,complaint,suggestion,support,other',
                'message' => 'required|string|max:1000',
            ], [
                'name.required' => 'الاسم مطلوب',
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
                'subject.required' => 'يجب اختيار الموضوع',
                'message.required' => 'الرسالة مطلوبة',
                'message.max' => 'الرسالة طويلة جداً (الحد الأقصى 1000 حرف)',
            ]);

            DB::beginTransaction();

            // حفظ الرسالة
            $contact = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // ✅ حفظ في جدول user_requests (ربط مع المستخدم)
            if (auth()->check()) {
                UserRequest::create([
                    'user_id' => auth()->id(),
                    'type' => 'contact',
                    'status' => 'pending',
                    'data' => json_encode($contact->toArray())
                ]);
                
                Log::info('✅ تم حفظ رسالة الاتصال في user_requests للمستخدم ' . auth()->id());
            } else {
                Log::warning('⚠️ المستخدم غير مسجل دخول، لم يتم حفظ رسالة الاتصال في user_requests');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '✅ تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.',
                'contact_id' => $contact->id,
                'created_at' => $contact->created_at->format('Y-m-d H:i:s')
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
            
            Log::error('🔥 خطأ في حفظ رسالة الاتصال: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => '⚠ حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * جلب كل الرسائل (للإدارة)
     */
    public function apiIndex(Request $request)
    {
        try {
            $query = ContactMessage::latest();

            // فلترة حسب الحالة
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }

            // بحث
            if ($request->has('search') && $request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%")
                      ->orWhere('email', 'like', "%{$request->search}%")
                      ->orWhere('phone', 'like', "%{$request->search}%")
                      ->orWhere('message', 'like', "%{$request->search}%");
                });
            }

            $messages = $query->paginate(20);

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '⚠ حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * جلب رسالة واحدة
     */
    public function apiShow($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            
            // تحديث الحالة إلى مقروءة إذا كانت جديدة
            if ($message->status === 'new') {
                $message->update(['status' => 'read']);
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '⚠ حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث حالة الرسالة
     */
    public function apiUpdateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:new,read,replied,closed',
            ]);

            $message = ContactMessage::findOrFail($id);
            $message->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => '✅ تم تحديث الحالة بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '⚠ حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف رسالة
     */
    public function apiDestroy($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            $message->delete();

            return response()->json([
                'success' => true,
                'message' => '✅ تم حذف الرسالة بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '⚠ حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * البحث عن رسالة (للمستخدم)
     */
    public function apiSearch(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'message_id' => 'nullable|integer',
            ]);

            $query = ContactMessage::where('email', $request->email);

            if ($request->filled('message_id')) {
                $query->where('id', $request->message_id);
            }

            $messages = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'messages' => $messages,
                'count' => $messages->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '⚠ حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على إحصائيات الرسائل
     */
    public function apiStatistics()
    {
        try {
            $stats = [
                'total' => ContactMessage::count(),
                'new' => ContactMessage::where('status', 'new')->count(),
                'read' => ContactMessage::where('status', 'read')->count(),
                'replied' => ContactMessage::where('status', 'replied')->count(),
                'closed' => ContactMessage::where('status', 'closed')->count(),
                'today' => ContactMessage::whereDate('created_at', today())->count(),
                'this_week' => ContactMessage::whereBetween('created_at', [
                    now()->startOfWeek(), 
                    now()->endOfWeek()
                ])->count(),
                'this_month' => ContactMessage::whereMonth('created_at', now()->month)->count(),
            ];

            return response()->json([
                'success' => true,
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '⚠ حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}