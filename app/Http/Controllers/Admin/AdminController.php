<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // لو تحتاجي بيانات المستخدمين
use App\Models\Contact; // اذا عندك موديل للرسائل
use App\Models\Appointment; // اذا عندك موديل للمواعيد
use App\Models\documentsRequest;
class AdminController extends Controller
{
    public function index()
    {
        // احضري إحصائيات بسيطة
        $usersCount = \DB::table('users')->count();
        $messagesCount = \DB::table('contact_messages')->count() ?? 0;
        $appointmentsCount = \DB::table('appointments')->count() ?? 0;

        return view('admin.dashboard', compact('usersCount','messagesCount','appointmentsCount'));
    }

    public function messages()
    {
        $messages = \DB::table('contact_messages')->orderBy('created_at','desc')->get();
        return view('admin.messages', compact('messages'));
    }

    public function appointments()
    {
        $appointments = \DB::table('appointments')->orderBy('created_at','desc')->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function certificates()
    {
        $certificates = \DB::table('certificates')->orderBy('created_at','desc')->get();
        return view('admin.certificates', compact('certificates'));
    }

    public function settings()
    {
        // ممكن تجيبي من DB أو config
        $settings = session('admin_settings', []);
        return view('admin.settings', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        // تحفظ مؤقتاً في session
        session(['admin_settings' => $request->only(['site_name','contact_email'])]);
        return back()->with('success','تم تحديث الإعدادات');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        // مثال: حفظ عنصر بسيط في جدول generic_items
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        \DB::table('generic_items')->insert(array_merge($data, ['created_at' => now(), 'updated_at' => now()]));
        return redirect()->route('admin.items')->with('success','تمت الإضافة');
    }

    public function items()
    {
        $items = \DB::table('generic_items')->orderBy('created_at','desc')->get();
        return view('admin.items', compact('items'));
    }

    public function changePasswordForm()
    {
        return view('admin.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // إذا الأدمن ثابت، نتحقق من كلمة المرور المباشرة (session-stored original)
        $current = $request->current_password;
        $staticAdmins = [
            'admin1@system.com' => 'admin123',
            'admin2@system.com' => 'admin456',
        ];

        $email = session('admin_email');
        if (! $email || ! isset($staticAdmins[$email]) || $staticAdmins[$email] !== $current) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية خاطئة']);
        }

        // لتبسيط: نخزن كلمة مرور جديدة في session (تبقى حتى logout)
        session(['static_admin_password_'.$email => $request->password]);

        return back()->with('success','تم تغيير كلمة المرور (تأثير للجلسة الحالية).');
    }







    public function negativeRequests()
{
    return view('admin.negative-requests');
}

public function documentRequests()
{
    return view('admin.document-requests');
}

public function paymentRequests()
{
    return view('admin.payment-requests');
}

public function topographicRequests()
{
    return view('admin.topographic-requests');
}

}
