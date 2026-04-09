<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * الحصول على قيمة إعداد
     */
    function setting($key, $default = null)
    {
        try {
            return Setting::get($key, $default);
        } catch (\Exception $e) {
            \Log::error("Helper setting error: {$key} - " . $e->getMessage());
            return $default;
        }
    }
}

if (!function_exists('settings')) {
    /**
     * الحصول على جميع الإعدادات
     */
    function settings()
    {
        try {
            return Setting::getAll();
        } catch (\Exception $e) {
            \Log::error("Helper settings error: " . $e->getMessage());
            return [];
        }
    }
}