<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NegativeCertificateSearch;
use Illuminate\Http\Request;

class NegativeCertificateSearchController extends Controller
{
    /**
     * بحث مرن في الشهادات السلبية
     */
    public function search(Request $request)
    {
        try {
            $query = NegativeCertificateSearch::query();

            // دالة تنظيف النص العربي
            $normalize = function ($value) {
                $value = trim($value);
                $value = preg_replace('/\s+/', ' ', $value); // حذف المسافات الزائدة
                $value = str_replace(['أ','إ','آ'], 'ا', $value);
                $value = str_replace('ى', 'ي', $value);
                return $value;
            };

            // 🔎 البحث باللقب
            if ($request->filled('owner_lastname')) {
                $lastname = $normalize($request->owner_lastname);
                $query->whereRaw(
                    "REPLACE(REPLACE(REPLACE(owner_lastname,'أ','ا'),'إ','ا'),'آ','ا') LIKE ?",
                    ["%$lastname%"]
                );
            }

            // 🔎 البحث بالاسم
            if ($request->filled('owner_firstname')) {
                $firstname = $normalize($request->owner_firstname);
                $query->whereRaw(
                    "REPLACE(REPLACE(REPLACE(owner_firstname,'أ','ا'),'إ','ا'),'آ','ا') LIKE ?",
                    ["%$firstname%"]
                );
            }

            // 🔎 البحث باسم الأب
            if ($request->filled('owner_father')) {
                $father = $normalize($request->owner_father);
                $query->whereRaw(
                    "REPLACE(REPLACE(REPLACE(owner_father,'أ','ا'),'إ','ا'),'آ','ا') LIKE ?",
                    ["%$father%"]
                );
            }

            // 🔎 تاريخ الميلاد
            if ($request->filled('birth_date')) {
                $query->whereDate('birth_date', $request->birth_date);
            }

        // 🔎 مكان الميلاد
if ($request->filled('birth_place')) {
    $birthplace = $normalize($request->birth_place);
    $query->whereRaw(
        "REPLACE(REPLACE(REPLACE(REPLACE(birth_place,'أ','ا'),'إ','ا'),'آ','ا'),'ى','ي') LIKE ?",
        ["%$birthplace%"]
    );
}

            // 🔎 رقم القطعة
            if ($request->filled('plot_number')) {
                $query->where('plot_number', trim($request->plot_number));
            }

            // تنفيذ البحث مع حد أقصى 50 نتيجة
            $results = $query->limit(50)->get();

            return response()->json([
                'success' => true,
                'count'   => $results->count(),
                'data'    => $results,
                'message' => $results->isEmpty()
                    ? 'لا توجد شهادات مطابقة'
                    : 'تم العثور على ' . $results->count() . ' نتيجة'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * استرجاع بيانات شهادة سلبية محددة
     */
    public function show($id)
    {
        try {
            $search = NegativeCertificateSearch::findOrFail($id);
            return response()->json([
                'success' => true,
                'data'    => $search
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'السجل غير موجود'
            ], 404);
        }
    }
}
