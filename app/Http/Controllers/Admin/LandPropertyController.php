<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LandPropertyController extends Controller
{
    /**
     * البحث في العقارات
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section' => 'required|string|max:10',
            'number' => 'required|string|max:20',
            'location' => 'nullable|string|max:100'
        ], [
            'section.required' => 'القسم مطلوب',
            'number.required' => 'الرقم مطلوب'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'البيانات المدخلة غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        // تنظيف البيانات المدخلة
        $section = trim($request->section);
        $number = trim($request->number);
        $location = trim($request->location);

        // البحث الذكي متعدد المستويات
        $property = $this->smartSearch($section, $number, $location);

        if (!$property) {
            // تسجيل محاولة البحث الفاشلة للمساعدة في التصحيح
            Log::warning('بحث فاشل عن عقار', [
                'section' => $section,
                'number' => $number,
                'location' => $location
            ]);
            
            return response()->json([
                'success' => false,
                'found' => false,
                'message' => '🏠 لا يوجد عقار مطابق لهذه المعطيات في قاعدة البيانات',
                'suggestions' => $this->getSuggestions($section, $number, $location),
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'found' => true,
            'message' => '✅ تم العثور على العقار',
            'data' => $property
        ]);
    }

    /**
     * البحث الذكي بعدة طرق
     */
    private function smartSearch($section, $number, $location = null)
    {
        // المستوى 1: البحث المباشر بالمطابقة التامة
        $property = $this->exactMatchSearch($section, $number, $location);
        if ($property) return $property;

        // المستوى 2: البحث بعد إزالة الأصفار البادئة
        $property = $this->leadingZeroSearch($section, $number, $location);
        if ($property) return $property;

        // المستوى 3: البحث باستخدام LIKE (للحالات التي توجد بها مسافات أو أحرف خفية)
        $property = $this->likeSearch($section, $number, $location);
        if ($property) return $property;

        // المستوى 4: البحث الموسع (إذا كان الموقع موجوداً)
        if ($location) {
            $property = $this->expandedLocationSearch($section, $number, $location);
            if ($property) return $property;
        }

        return null;
    }

    /**
     * البحث بالمطابقة التامة
     */
    private function exactMatchSearch($section, $number, $location)
    {
        $query = LandProperty::query();
        
        $query->where(function($q) use ($section, $number) {
            $q->whereRaw('TRIM(section) = ?', [$section])
              ->whereRaw('TRIM(number) = ?', [$number]);
        });

        if (!empty($location)) {
            $query->where('location', 'LIKE', '%' . $location . '%');
        }

        return $query->first();
    }

    /**
     * البحث بعد إزالة الأصفار البادئة
     */
    private function leadingZeroSearch($section, $number, $location)
    {
        // إزالة الأصفار البادئة للمقارنة
        $sectionNumeric = ltrim($section, '0') ?: '0';
        $numberNumeric = ltrim($number, '0') ?: '0';

        $query = LandProperty::query();
        
        $query->where(function($q) use ($sectionNumeric, $numberNumeric, $section, $number) {
            $q->where(function($subQ) use ($sectionNumeric, $numberNumeric) {
                $subQ->whereRaw('TRIM(section) = ?', [$sectionNumeric])
                     ->whereRaw('TRIM(number) = ?', [$numberNumeric]);
            });
            
            // إذا كانت القيم رقمية، جرب المقارنة الرقمية
            if (is_numeric($sectionNumeric) && is_numeric($numberNumeric)) {
                $q->orWhere(function($subQ) use ($sectionNumeric, $numberNumeric) {
                    $subQ->whereRaw('CAST(TRIM(section) AS UNSIGNED) = ?', [$sectionNumeric])
                         ->whereRaw('CAST(TRIM(number) AS UNSIGNED) = ?', [$numberNumeric]);
                });
            }
        });

        if (!empty($location)) {
            $query->where('location', 'LIKE', '%' . $location . '%');
        }

        return $query->first();
    }

    /**
     * البحث باستخدام LIKE
     */
    private function likeSearch($section, $number, $location)
    {
        $query = LandProperty::query();
        
        $query->where(function($q) use ($section, $number) {
            $q->where('section', 'LIKE', '%' . $section . '%')
              ->where('number', 'LIKE', '%' . $number . '%');
        });

        if (!empty($location)) {
            $query->where('location', 'LIKE', '%' . $location . '%');
        }

        return $query->first();
    }

    /**
     * البحث الموسع مع الموقع
     */
    private function expandedLocationSearch($section, $number, $location)
    {
        $query = LandProperty::query();
        
        $query->where(function($q) use ($section, $number) {
            $q->where('section', 'LIKE', '%' . $section . '%')
              ->where('number', 'LIKE', '%' . $number . '%');
        });

        // البحث في الموقع ومكان الميلاد
        $query->where(function($q) use ($location) {
            $q->where('location', 'LIKE', '%' . $location . '%')
              ->orWhere('birth_place', 'LIKE', '%' . $location . '%')
              ->orWhere('owner_name', 'LIKE', '%' . $location . '%');
        });

        return $query->first();
    }

    /**
     * الحصول على اقتراحات للبحث
     */
    private function getSuggestions($section, $number, $location)
    {
        $suggestions = [];
        
        // اقتراحات بناءً على القسم
        $sectionSuggestions = LandProperty::where('section', 'LIKE', '%' . $section . '%')
            ->limit(3)
            ->get(['section', 'number', 'location', 'owner_name']);
        
        if ($sectionSuggestions->count() > 0) {
            $suggestions['section'] = $sectionSuggestions;
        }
        
        // اقتراحات بناءً على الرقم
        $numberSuggestions = LandProperty::where('number', 'LIKE', '%' . $number . '%')
            ->limit(3)
            ->get(['section', 'number', 'location', 'owner_name']);
        
        if ($numberSuggestions->count() > 0) {
            $suggestions['number'] = $numberSuggestions;
        }
        
        // اقتراحات بناءً على الموقع
        if (!empty($location)) {
            $locationSuggestions = LandProperty::where('location', 'LIKE', '%' . $location . '%')
                ->orWhere('birth_place', 'LIKE', '%' . $location . '%')
                ->limit(3)
                ->get(['section', 'number', 'location', 'owner_name']);
            
            if ($locationSuggestions->count() > 0) {
                $suggestions['location'] = $locationSuggestions;
            }
        }
        
        return $suggestions;
    }

    /**
     * جلب تفاصيل عقار محدد
     */
    public function getDetails($id)
    {
        try {
            $property = LandProperty::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $property
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'العقار غير موجود'
            ], 404);
        }
    }

    /**
     * إضافة عقار جديد (اختياري)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'national_id' => 'required|string|size:16',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:100',
            'property_type' => 'required|in:ممسوح,غير ممسوح',
            'register_number' => 'required|string|max:50',
            'section' => 'required|string|max:10',
            'number' => 'required|string|max:20',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:100',
            'area' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'البيانات المدخلة غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $property = LandProperty::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة العقار بنجاح',
            'data' => $property
        ], 201);
    }

    /**
     * تحديث عقار (اختياري)
     */
    public function update(Request $request, $id)
    {
        $property = LandProperty::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'owner_name' => 'sometimes|required|string|max:255',
            'father_name' => 'sometimes|required|string|max:255',
            'national_id' => 'sometimes|required|string|size:16',
            'birth_date' => 'sometimes|required|date',
            'birth_place' => 'sometimes|required|string|max:100',
            'property_type' => 'sometimes|required|in:ممسوح,غير ممسوح',
            'register_number' => 'sometimes|required|string|max:50',
            'section' => 'sometimes|required|string|max:10',
            'number' => 'sometimes|required|string|max:20',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:100',
            'area' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'البيانات المدخلة غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $property->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث العقار بنجاح',
            'data' => $property
        ]);
    }

    /**
     * حذف عقار (اختياري)
     */
    public function destroy($id)
    {
        $property = LandProperty::findOrFail($id);
        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف العقار بنجاح'
        ]);
    }
}