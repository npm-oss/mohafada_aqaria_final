<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    /**
     * الحصول على قيمة إعداد (بدون كاش)
     */
    public static function get($key, $default = null)
    {
        try {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return self::castValue($setting->value, $setting->type);
            
        } catch (\Exception $e) {
            Log::error("Setting error: {$key} - " . $e->getMessage());
            return $default;
        }
    }

    /**
     * تعيين قيمة إعداد
     */
    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        try {
            $setting = self::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => $type,
                    'group' => $group,
                    'updated_at' => now()
                ]
            );

            Log::info("Setting saved: {$key} = {$value}");
            
            return $setting;
        } catch (\Exception $e) {
            Log::error("Setting save error: {$key} - " . $e->getMessage());
            return null;
        }
    }

    /**
     * الحصول على جميع الإعدادات
     */
    public static function getAll()
    {
        try {
            $settings = self::all();
            $result = [];
            
            foreach ($settings as $setting) {
                $result[$setting->key] = self::castValue($setting->value, $setting->type);
            }
            
            return $result;
        } catch (\Exception $e) {
            Log::error("Settings getAll error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * تحويل القيمة حسب النوع
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'number':
                return is_numeric($value) ? (float)$value : $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * مسح الكاش
     */
    public static function clearCache()
    {
        Cache::forget('settings');
        Cache::flush();
        Log::info('Settings cache cleared');
    }
}