<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
        ], [
            'site_name.required' => 'اسم الموقع مطلوب',
            'contact_email.required' => 'البريد الإلكتروني مطلوب',
            'contact_email.email' => 'البريد الإلكتروني غير صحيح',
            'contact_phone.required' => 'رقم الهاتف مطلوب',
        ]);

        try {
            Log::info('بدء تحديث الإعدادات');

            // رفع الشعار إذا وُجد
            if ($request->hasFile('site_logo')) {
                $logoPath = $request->file('site_logo')->store('settings', 'public');
                Setting::set('site_logo', $logoPath, 'text', 'general');
                Log::info('تم رفع الشعار: ' . $logoPath);
            }

            // الإعدادات النصية
            $textSettings = [
                'site_name' => 'general',
                'site_url' => 'general',
                'site_description' => 'general',
                'site_keywords' => 'general',
                'contact_email' => 'contact',
                'contact_phone' => 'contact',
                'contact_fax' => 'contact',
                'emergency_phone' => 'contact',
                'contact_address' => 'contact',
                'working_hours' => 'contact',
                'gps_longitude' => 'contact',
                'gps_latitude' => 'contact',
                'mail_host' => 'email',
                'mail_port' => 'email',
                'mail_username' => 'email',
                'mail_encryption' => 'email',
                'mail_from_address' => 'email',
                'mail_from_name' => 'email',
                'primary_color' => 'system',
                'secondary_color' => 'system',
                'per_page' => 'system',
                'session_lifetime' => 'system',
                'max_file_size' => 'system',
                'daily_request_limit' => 'system',
                'social_facebook' => 'social',
                'social_twitter' => 'social',
                'social_instagram' => 'social',
                'social_linkedin' => 'social',
                'social_youtube' => 'social',
                'social_whatsapp' => 'social',
                'admin_notification_email' => 'notifications',
                'daily_stats_report' => 'notifications',
                'report_time' => 'notifications',
                'min_password_length' => 'security',
                'max_login_attempts' => 'security',
                'backup_frequency' => 'security',
            ];

            foreach ($textSettings as $key => $group) {
                if ($request->has($key) && $request->input($key) !== null) {
                    $value = $request->input($key);
                    Setting::set($key, $value, 'text', $group);
                    Log::info("تحديث {$key} = {$value}");
                }
            }

            // كلمة مرور SMTP (فقط إذا تم إدخالها)
            if ($request->filled('mail_password')) {
                Setting::set('mail_password', $request->input('mail_password'), 'text', 'email');
                Log::info('تحديث mail_password');
            }

            // الإعدادات المنطقية (Boolean)
            $booleanSettings = [
                'site_active' => 'system',
                'allow_registration' => 'system',
                'maintenance_mode' => 'system',
                'notify_new_requests' => 'notifications',
                'sms_notifications' => 'notifications',
                'notify_certificate_ready' => 'notifications',
                'two_factor_auth' => 'security',
                'auto_backup' => 'security',
            ];

            foreach ($booleanSettings as $key => $group) {
                $value = $request->has($key) ? '1' : '0';
                Setting::set($key, $value, 'boolean', $group);
                Log::info("تحديث {$key} = {$value}");
            }

            // مسح الكاش
            Setting::clearCache();
            Cache::flush();

            Log::info('تم تحديث الإعدادات بنجاح');

            return redirect()
                ->route('admin.settings')
                ->with('success', '✅ تم حفظ الإعدادات بنجاح! قد تحتاج لتحديث الصفحة لرؤية التغييرات.');

        } catch (\Exception $e) {
            Log::error('خطأ في تحديث الإعدادات: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()
                ->back()
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }
}